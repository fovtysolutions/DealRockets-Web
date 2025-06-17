<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AdminWalletRepositoryInterface;
use App\Contracts\Repositories\BrandRepositoryInterface;
use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Contracts\Repositories\DeliveryManRepositoryInterface;
use App\Contracts\Repositories\OrderDetailRepositoryInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Repositories\OrderTransactionRepositoryInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Contracts\Repositories\VendorWalletRepositoryInterface;
use App\Enums\ViewPaths\Admin\Dashboard;
use App\Http\Controllers\BaseController;
use App\Models\Country;
use App\Models\DealAssist;
use App\Models\JobAppliers;
use App\Models\Membership;
use App\Models\Review;
use App\Models\SupportTicket;
use App\Models\TableJobProfile;
use App\Models\Vacancies;
use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\alert;

class DashboardController extends BaseController
{
    public function __construct(
        private readonly AdminWalletRepositoryInterface      $adminWalletRepo,
        private readonly CustomerRepositoryInterface         $customerRepo,
        private readonly OrderTransactionRepositoryInterface $orderTransactionRepo,
        private readonly ProductRepositoryInterface          $productRepo,
        private readonly DeliveryManRepositoryInterface      $deliveryManRepo,
        private readonly OrderRepositoryInterface            $orderRepo,
        private readonly OrderDetailRepositoryInterface      $orderDetailRepo,
        private readonly BrandRepositoryInterface            $brandRepo,
        private readonly VendorRepositoryInterface           $vendorRepo,
        private readonly VendorWalletRepositoryInterface     $vendorWalletRepo,
        private readonly DashboardService     $dashboardService,

    ) {}

    /**
     * @param Request|null $request
     * @param string|null $type
     * @return View|Collection|LengthAwarePaginator|callable|RedirectResponse|null
     * Index function is the starting point of a controller
     */
    public function index(Request|null $request, string $type = null): View|Collection|LengthAwarePaginator|null|callable|RedirectResponse
    {
        return $this->dashboard();
    }

    public function dashboard(): View
    {
        $mostRatedProducts = $this->productRepo->getTopRatedList()->take(DASHBOARD_DATA_LIMIT);
        $topSellProduct = $this->productRepo->getTopSellList(relations: ['orderDetails'])->take(DASHBOARD_TOP_SELL_DATA_LIMIT);
        $topCustomer = $this->orderRepo->getTopCustomerList(relations: ['customer'], dataLimit: 'all')->take(DASHBOARD_DATA_LIMIT);
        $topRatedDeliveryMan = $this->deliveryManRepo->getTopRatedList(filters: ['seller_id' => 0], relations: ['deliveredOrders'], dataLimit: 'all')->take(DASHBOARD_DATA_LIMIT);
        $topVendorByEarning = $this->vendorWalletRepo->getListWhere(orderBy: ['total_earning' => 'desc'], relations: ['seller.shop'])->take(DASHBOARD_DATA_LIMIT);
        $topVendorByOrderReceived = $this->orderRepo->getTopVendorListByOrderReceived(relations: ['seller.shop'], dataLimit: 'all')->take(DASHBOARD_DATA_LIMIT);

        $data = self::getOrderStatusData();
        $admin_wallet = $this->adminWalletRepo->getFirstWhere(params: ['admin_id' => 1]);

        $from = now()->startOfYear()->format('Y-m-d');
        $to = now()->endOfYear()->format('Y-m-d');
        $range = range(1, 12);
        $label = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $inHouseOrderEarningArray = $this->getOrderStatisticsData(from: $from, to: $to, range: $range, type: 'month', userType: 'admin');
        $vendorOrderEarningArray = $this->getOrderStatisticsData(from: $from, to: $to, range: $range, type: 'month', userType: 'seller');
        $inHouseEarning = $this->getEarning(from: $from, to: $to, range: $range, type: 'month', userType: 'admin');
        $vendorEarning = $this->getEarning(from: $from, to: $to, range: $range, type: 'month', userType: 'seller');
        $commissionEarn = $this->getAdminCommission(from: $from, to: $to, range: $range, type: 'month');
        $dateType = 'yearEarn';
        $jobapplications = JobAppliers::count();
        $jobpostings = Vacancies::count();
        $jobseekers = TableJobProfile::count();
        $memberships = Membership::count();
        $tickets = SupportTicket::count();
        $reviews = Review::count();
        $data += [
            'jobApplicationsCount' => $jobapplications,
            'jobPostingsCount' => $jobpostings,
            'jobSeekerCount' => $jobseekers,
            'membershipCount' => $memberships,
            'openTickets' => $tickets,
            'totalReviews' => $reviews,
            'order' => $this->orderRepo->getListWhere(dataLimit: 'all')->count(),
            'brand' => $this->brandRepo->getListWhere(dataLimit: 'all')->count(),
            'topSellProduct' => $topSellProduct,
            'mostRatedProducts' => $mostRatedProducts,
            'topVendorByEarning' => $topVendorByEarning,
            'top_customer' => $topCustomer,
            'top_store_by_order_received' => $topVendorByOrderReceived,
            'topRatedDeliveryMan' => $topRatedDeliveryMan,
            'inhouse_earning' => $admin_wallet['inhouse_earning'] ?? 0,
            'commission_earned' => $admin_wallet['commission_earned'] ?? 0,
            'delivery_charge_earned' => $admin_wallet['delivery_charge_earned'] ?? 0,
            'pending_amount' => $admin_wallet['pending_amount'] ?? 0,
            'total_tax_collected' => $admin_wallet['total_tax_collected'] ?? 0,
            'getTotalCustomerCount' => $this->customerRepo->getList(dataLimit: 'all')->count(),
            'getTotalVendorCount' => $this->vendorRepo->getListWhere(dataLimit: 'all')->count(),
            'getTotalDeliveryManCount' => $this->deliveryManRepo->getListWhere(filters: ['seller_id' => 0], dataLimit: 'all')->count(),
        ];
        return view(Dashboard::VIEW[VIEW], compact('data', 'inHouseEarning', 'vendorEarning', 'commissionEarn', 'inHouseOrderEarningArray', 'vendorOrderEarningArray', 'label', 'dateType'));
    }

    public function getOrderStatus(Request $request): JsonResponse
    {
        session()->put('statistics_type', $request['statistics_type']);
        $data = self::getOrderStatusData();
        return response()->json(['view' => view('admin-views.partials._dashboard-order-status', compact('data'))->render()], 200);
    }

    public function getOrderStatusData(): array
    {
        $orderQuery = $this->orderRepo->getListWhere(dataLimit: 'all');
        $storeQuery = $this->vendorRepo->getListWhere(dataLimit: 'all');
        $productQuery = $this->productRepo->getListWhere(dataLimit: 'all');
        $customerQuery = $this->customerRepo->getListWhere(dataLimit: 'all');
        $failedQuery = $this->orderRepo->getListWhere(filters: ['order_status' => 'failed'], dataLimit: 'all');
        $pendingQuery = $this->orderRepo->getListWhere(filters: ['order_status' => 'pending'], dataLimit: 'all');
        $returnedQuery = $this->orderRepo->getListWhere(filters: ['order_status' => 'returned'], dataLimit: 'all');
        $canceledQuery = $this->orderRepo->getListWhere(filters: ['order_status' => 'canceled'], dataLimit: 'all');
        $confirmedQuery = $this->orderRepo->getListWhere(filters: ['order_status' => 'confirmed'], dataLimit: 'all');
        $deliveredQuery = $this->orderRepo->getListWhere(filters: ['order_status' => 'delivered'], dataLimit: 'all');
        $processingQuery = $this->orderRepo->getListWhere(filters: ['order_status' => 'processing'], dataLimit: 'all');
        $outForDeliveryQuery = $this->orderRepo->getListWhere(filters: ['order_status' => 'out_for_delivery'], dataLimit: 'all');

        return [
            'order' => self::getCommonQueryOrderStatus($orderQuery),
            'store' => self::getCommonQueryOrderStatus($storeQuery),
            'failed' => self::getCommonQueryOrderStatus($failedQuery),
            'pending' => self::getCommonQueryOrderStatus($pendingQuery),
            'product' => self::getCommonQueryOrderStatus($productQuery),
            'customer' => self::getCommonQueryOrderStatus($customerQuery),
            'returned' => self::getCommonQueryOrderStatus($returnedQuery),
            'canceled' => self::getCommonQueryOrderStatus($canceledQuery),
            'confirmed' => self::getCommonQueryOrderStatus($confirmedQuery),
            'delivered' => self::getCommonQueryOrderStatus($deliveredQuery),
            'processing' => self::getCommonQueryOrderStatus($processingQuery),
            'out_for_delivery' => self::getCommonQueryOrderStatus($outForDeliveryQuery),
        ];
    }

    public function getCommonQueryOrderStatus($query)
    {
        $today = session()->has('statistics_type') && session('statistics_type') == 'today' ? 1 : 0;
        $this_month = session()->has('statistics_type') && session('statistics_type') == 'this_month' ? 1 : 0;

        return $query->when($today, function ($query) {
            return $query->where('created_at', '>=', now()->startOfDay())
                ->where('created_at', '<', now()->endOfDay());
        })->when($this_month, function ($query) {
            return $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
        })->count();
    }
    public function getOrderStatistics(Request $request): JsonResponse
    {
        $dateType = $request['type'];
        $dateTypeArray = $this->dashboardService->getDateTypeData(dateType: $dateType);
        $from = $dateTypeArray['from'];
        $to = $dateTypeArray['to'];
        $type = $dateTypeArray['type'];
        $range = $dateTypeArray['range'];
        $inHouseOrderEarningArray = $this->getOrderStatisticsData(from: $from, to: $to, range: $range, type: $type, userType: 'admin');
        $vendorOrderEarningArray = $this->getOrderStatisticsData(from: $from, to: $to, range: $range, type: $type, userType: 'seller');
        $label = $dateTypeArray['keyRange'] ?? [];
        $inHouseOrderEarningArray = array_values($inHouseOrderEarningArray);
        $vendorOrderEarningArray = array_values($vendorOrderEarningArray);
        return response()->json([
            'view' => view(Dashboard::ORDER_STATISTICS[VIEW], compact('inHouseOrderEarningArray', 'vendorOrderEarningArray', 'label', 'dateType'))->render(),
        ]);
    }
    public function getEarningStatistics(Request $request): JsonResponse
    {
        $dateType = $request['type'];
        $dateTypeArray = $this->dashboardService->getDateTypeData(dateType: $dateType);
        $from = $dateTypeArray['from'];
        $to = $dateTypeArray['to'];
        $type = $dateTypeArray['type'];
        $range = $dateTypeArray['range'];
        $inHouseEarning = $this->getEarning(from: $from, to: $to, range: $range, type: $type, userType: 'admin');
        $vendorEarning = $this->getEarning(from: $from, to: $to, range: $range, type: $type, userType: 'seller');
        $commissionEarn = $this->getAdminCommission(from: $from, to: $to, range: $range, type: $type);
        $membershipEarning = $this->getMembershipEarning(from: $from, to: $to, range: $range, type: $type);
        $label = $dateTypeArray['keyRange'] ?? [];
        $inHouseEarning = array_values($inHouseEarning);
        $vendorEarning = array_values($vendorEarning);
        $commissionEarn = array_values($commissionEarn);
        $membershipEarning = array_values($membershipEarning);
        return response()->json([
            'view' => view(Dashboard::EARNING_STATISTICS[VIEW], compact('inHouseEarning', 'vendorEarning', 'membershipEarning', 'commissionEarn', 'label', 'dateType'))->render(),
        ]);
    }
    protected function getOrderStatisticsData($from, $to, $range, $type, $userType): array
    {
        $orderEarnings = $this->orderRepo->getListWhereBetween(
            filters: [
                'seller_is' => $userType,
                'payment_status' => 'paid'
            ],
            selectColumn: 'order_amount',
            whereBetween: 'created_at',
            whereBetweenFilters: [$from, $to],
        );
        $orderEarningArray = [];
        foreach ($range as $value) {
            $matchingEarnings = $orderEarnings->where($type, $value);
            if ($matchingEarnings->count() > 0) {
                $orderEarningArray[$value] = usdToDefaultCurrency($matchingEarnings->sum('sums'));
            } else {
                $orderEarningArray[$value] = 0;
            }
        }
        return $orderEarningArray;
    }

    protected function getEarning(string|Carbon $from, string|Carbon $to, array $range, string $type, $userType): array
    {
        $earning = $this->orderTransactionRepo->getListWhereBetween(
            filters: [
                'seller_is' => $userType,
                'status' => 'disburse',
            ],
            selectColumn: 'seller_amount',
            whereBetween: 'created_at',
            whereBetweenFilters: [$from, $to],
            groupBy: $type,
        );
        return $this->dashboardService->getDateWiseAmount(range: $range, type: $type, amountArray: $earning);
    }

    /**
     * @param string|Carbon $from
     * @param string|Carbon $to
     * @param array $range
     * @param string $type
     * @return array
     */
    protected function getAdminCommission(string|Carbon $from, string|Carbon $to, array $range, string $type): array
    {
        $commissionGiven = $this->orderTransactionRepo->getListWhereBetween(
            filters: [
                'seller_is' => 'seller',
                'status' => 'disburse',
            ],
            selectColumn: 'admin_commission',
            whereBetween: 'created_at',
            whereBetweenFilters: [$from, $to],
            groupBy: $type,
        );
        return $this->dashboardService->getDateWiseAmount(range: $range, type: $type, amountArray: $commissionGiven);
    }

    private function getMembershipEarning($from = null, $to = null, $range = 'monthly', $type = 'month')
    {
        $query = DB::table('memberships')
            ->where('membership_status', 'active')
            ->where('paymentstatus', 'Approved');

        switch ($type) {
            case 'WeekEarn':
                if (!$from || !$to) {
                    $from = now()->startOfYear()->toDateString();
                    $to = now()->endOfYear()->toDateString();
                }

                $query->whereBetween('created_at', [$from, $to])
                    ->select(
                        DB::raw("WEEK(created_at, 1) as week"),
                        DB::raw("SUM(amount) as total")
                    )
                    ->groupBy(DB::raw("WEEK(created_at, 1)"));

                $results = $query->get();

                $weeksInYear = now()->endOfYear()->isoWeek();
                $earnings = array_fill(1, $weeksInYear, 0.0);

                foreach ($results as $row) {
                    $earnings[(int) $row->week] = round($row->total, 2);
                }

                break;

            case 'MonthEarn':
                $from = now()->startOfMonth()->toDateString();
                $to = now()->endOfMonth()->toDateString();

                $query->whereBetween('created_at', [$from, $to])
                    ->select(
                        DB::raw("DAY(created_at) as day"),
                        DB::raw("SUM(amount) as total")
                    )
                    ->groupBy(DB::raw("DAY(created_at)"));

                $results = $query->get();

                $daysInMonth = now()->daysInMonth;
                $earnings = array_fill(1, $daysInMonth, 0.0);

                foreach ($results as $row) {
                    $earnings[(int) $row->day] = round($row->total, 2);
                }

                break;

            case 'yearEarn':
                // Total earnings for the current year only
                $from = now()->startOfYear()->toDateString();
                $to = now()->endOfYear()->toDateString();

                $query->whereBetween('created_at', [$from, $to]);

                $total = $query->sum('amount');

                $earnings = ['total' => round($total, 2)];
                break;

            case 'month':
            default:
                if (!$from || !$to) {
                    $from = now()->startOfYear()->toDateString();
                    $to = now()->endOfYear()->toDateString();
                }

                $query->whereBetween('created_at', [$from, $to])
                    ->select(
                        DB::raw("MONTH(created_at) as month"),
                        DB::raw("SUM(amount) as total")
                    )
                    ->groupBy(DB::raw("MONTH(created_at)"));

                $results = $query->get();

                $earnings = array_fill(1, 12, 0.0);

                foreach ($results as $row) {
                    $earnings[(int) $row->month] = round($row->total, 2);
                }

                break;
        }

        return $earnings;
    }

    private function groupCountByCountry(string $table, string $countryColumn = 'country', array $filters = [], array $notNull = [])
    {
        $query = DB::table($table)
            ->select($countryColumn, DB::raw('COUNT(*) as total'))
            ->groupBy($countryColumn);

        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                $query->whereIn($column, $value);
            } else {
                $query->where($column, $value);
            }
        }

        foreach ($notNull as $column) {
            $query->whereNotNull($column);
        }

        return $query->pluck('total', $countryColumn)->toArray();
    }

    private function mapCountryIdsToNames(array $data): array
    {
        if (empty($data)) {
            return ['No Data' => 1];
        }

        $countryNames = Country::pluck('name', 'id')->toArray();

        $mapped = [];

        foreach ($data as $countryId => $value) {
            $name = $countryNames[$countryId] ?? 'Unknown';
            $mapped[$name] = $value;
        }

        return $mapped;
    }


    private function getVendorByCountry()
    {
        return $this->groupCountByCountry('sellers', 'country', ['status' => 'approved']);
    }

    private function getProductCategoryByCountry()
    {
        return $this->groupCountByCountry('products', 'origin');
    }

    private function buyleadsFromRFQ()
    {
        return $this->groupCountByCountry('leads', 'country', ['type' => 'buyer'], ['quotation_id']);
    }

    private function sellofferCreated()
    {
        return $this->groupCountByCountry('leads', 'country', ['type' => 'seller']);
    }

    private function dealAssist()
    {
        $dealAssists = DealAssist::with(['user_id', 'seller'])->get();

        $grouped = [];

        foreach ($dealAssists as $item) {
            if ($item->role === 'seller') {
                $country = $item->seller->country ?? 'Unknown';
            } elseif ($item->role === 'customer') {
                $country = $item->user->country ?? 'Unknown';
            } else {
                $country = 'Unknown';
            }

            $grouped[$country] = ($grouped[$country] ?? 0) + 1;
        }

        return $grouped;
    }

    private function tradeShowsCount()
    {
        return DB::table('tradeshows')
            ->select('country', DB::raw('SUM(clicks) as total'))
            ->groupBy('country')
            ->pluck('total', 'country')
            ->toArray();
    }

    private function totalBuyers()
    {
        return $this->groupCountByCountry('users', 'country', ['typerole' => 'jobseeker']);
    }

    private function postedJobs()
    {
        return $this->groupCountByCountry('vacancies', 'country');
    }

    private function jobSearch()
    {
        return DB::table('job_search_logs')
            ->join('users', 'job_search_logs.user_id', '=', 'users.id')
            ->select('users.country', DB::raw('SUM(job_search_logs.count) as total'))
            ->groupBy('users.country')
            ->pluck('total', 'users.country')
            ->toArray();
    }

    private function pagewiseVendorReport()
    {
        // Need Analytics for this
        return $this->groupCountByCountry('vendor_ads', 'country');
    }

    private function branchPerformance()
    {
        // Need Logic for this 
        return $this->groupCountByCountry('branches', 'country');
    }

    public function OtherAnalytics()
    {
        $mostRatedProducts = $this->productRepo->getTopRatedList()->take(DASHBOARD_DATA_LIMIT);
        $topSellProduct = $this->productRepo->getTopSellList(relations: ['orderDetails'])->take(DASHBOARD_TOP_SELL_DATA_LIMIT);
        $topCustomer = $this->orderRepo->getTopCustomerList(relations: ['customer'], dataLimit: 'all')->take(DASHBOARD_DATA_LIMIT);
        $topRatedDeliveryMan = $this->deliveryManRepo->getTopRatedList(filters: ['seller_id' => 0], relations: ['deliveredOrders'], dataLimit: 'all')->take(DASHBOARD_DATA_LIMIT);
        $topVendorByEarning = $this->vendorWalletRepo->getListWhere(orderBy: ['total_earning' => 'desc'], relations: ['seller.shop'])->take(DASHBOARD_DATA_LIMIT);
        $topVendorByOrderReceived = $this->orderRepo->getTopVendorListByOrderReceived(relations: ['seller.shop'], dataLimit: 'all')->take(DASHBOARD_DATA_LIMIT);

        $data = self::getOrderStatusData();
        $admin_wallet = $this->adminWalletRepo->getFirstWhere(params: ['admin_id' => 1]);

        $from = now()->startOfYear()->format('Y-m-d');
        $to = now()->endOfYear()->format('Y-m-d');
        $range = range(1, 12);
        $label = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $inHouseOrderEarningArray = $this->getOrderStatisticsData(from: $from, to: $to, range: $range, type: 'month', userType: 'admin');
        $vendorOrderEarningArray = $this->getOrderStatisticsData(from: $from, to: $to, range: $range, type: 'month', userType: 'seller');
        $inHouseEarning = $this->getEarning(from: $from, to: $to, range: $range, type: 'month', userType: 'admin');
        $vendorEarning = $this->getEarning(from: $from, to: $to, range: $range, type: 'month', userType: 'seller');
        $commissionEarn = $this->getAdminCommission(from: $from, to: $to, range: $range, type: 'month');
        $membershipEarning = $this->getMembershipEarning(from: $from, to: $to, range: $range, type: 'month');
        $vendorByCountry = $this->getVendorByCountry();
        $productCategoryPerformance = $this->getProductCategoryByCountry();
        $buyLeadsFromRFQ = $this->buyleadsFromRFQ();
        $sellOfferCreated = $this->sellofferCreated();
        $dealAssist = $this->dealAssist();
        $tradeShowsCount =  $this->tradeShowsCount();
        $totalBuyers = $this->totalBuyers();
        $postedJobs = $this->postedJobs();
        $jobSearch = $this->jobSearch();
        $customStats = [
            "Vendor By Country" => $this->mapCountryIdsToNames($vendorByCountry),
            "Product Performance" => $this->mapCountryIdsToNames($productCategoryPerformance),
            "Buyer Leads from RFQ" => $this->mapCountryIdsToNames($buyLeadsFromRFQ),
            "Sale Offer Created" => $this->mapCountryIdsToNames($sellOfferCreated),
            "Deal Assist By Country" => $this->mapCountryIdsToNames($dealAssist),
            "Trade Show Count" => $this->mapCountryIdsToNames($tradeShowsCount),
            "Total Buyers" => $this->mapCountryIdsToNames($totalBuyers),
            "Posted Jobs" => $this->mapCountryIdsToNames($postedJobs),
            "Job Search" => $this->mapCountryIdsToNames($jobSearch),
        ];
        // $vendorads = $this->pagewiseVendorReport();
        // $branchPerformance = $this->branchPerformance();
        $dateType = 'yearEarn';
        $jobapplications = JobAppliers::count();
        $jobpostings = Vacancies::count();
        $jobseekers = TableJobProfile::count();
        $memberships = Membership::count();
        $tickets = SupportTicket::count();
        $reviews = Review::count();
        $data += [
            'jobApplicationsCount' => $jobapplications,
            'jobPostingsCount' => $jobpostings,
            'jobSeekerCount' => $jobseekers,
            'membershipCount' => $memberships,
            'openTickets' => $tickets,
            'totalReviews' => $reviews,
            'order' => $this->orderRepo->getListWhere(dataLimit: 'all')->count(),
            'brand' => $this->brandRepo->getListWhere(dataLimit: 'all')->count(),
            'topSellProduct' => $topSellProduct,
            'mostRatedProducts' => $mostRatedProducts,
            'topVendorByEarning' => $topVendorByEarning,
            'top_customer' => $topCustomer,
            'top_store_by_order_received' => $topVendorByOrderReceived,
            'topRatedDeliveryMan' => $topRatedDeliveryMan,
            'inhouse_earning' => $admin_wallet['inhouse_earning'] ?? 0,
            'commission_earned' => $admin_wallet['commission_earned'] ?? 0,
            'delivery_charge_earned' => $admin_wallet['delivery_charge_earned'] ?? 0,
            'pending_amount' => $admin_wallet['pending_amount'] ?? 0,
            'total_tax_collected' => $admin_wallet['total_tax_collected'] ?? 0,
            'getTotalCustomerCount' => $this->customerRepo->getList(dataLimit: 'all')->count(),
            'getTotalVendorCount' => $this->vendorRepo->getListWhere(dataLimit: 'all')->count(),
            'getTotalDeliveryManCount' => $this->deliveryManRepo->getListWhere(filters: ['seller_id' => 0], dataLimit: 'all')->count(),
        ];

        return view('admin-views.system.partials.analytics_dash', compact('data', 'customStats', 'inHouseEarning', 'vendorEarning', 'commissionEarn', 'membershipEarning', 'inHouseOrderEarningArray', 'vendorOrderEarningArray', 'label', 'dateType'));
    }

    // Sub Cards Functions
    public function subCardData($slug)
    {
        $title = '';
        $cardData = [];

        switch ($slug) {
            case 'analytics':
                $title = 'Analytics';
                $cardData = [
                    ['link' => route('admin.other-analytics'), 'title' => 'Analytics', 'value' => 'Yes'],
                    ['link' => route('admin.report.admin-earning'), 'title' => 'Earning', 'value' => 'Yes'],
                    ['link' => route('admin.report.inhouse-product-sale'), 'title' => 'In House Sale', 'value' => 'Yes'],
                    ['link' => route('admin.report.vendor-report'), 'title' => 'Vendor Report', 'value' => 'Yes'],
                    ['link' => route('admin.transaction.order-transaction-list'), 'title' => 'Order Transaction List', 'value' => 'Yes'],
                    ['link' => route('admin.report.all-product'), 'title' => 'Product Report', 'value' => 'Yes'],
                ];
                break;

            case 'product-approval':
                $title = 'Product Approval';
                $cardData = [
                    ['link' => route('admin.products.list', ['vendor', 'status' => '0']), 'title' => 'New Product Requests', 'value' => 'Yes'],
                    ['link' => route('admin.products.updated-product-list'), 'title' => 'Update Product List', 'value' => 'Yes'],
                    ['link' => route('admin.products.list', ['vendor', 'status' => '1']), 'title' => 'Approved Products', 'value' => 'Yes'],
                    ['link' => route('admin.products.list', ['vendor', 'status' => '2']), 'title' => 'Denied Products', 'value' => 'Yes'],
                ];
                break;

            case 'vendor-approval':
                $title = 'Vendor Approval';
                $cardData = [
                    ['link' => route('admin.vendors.vendor-list'), 'title' => 'Vendor Approval', 'value' => 'Yes'],
                    ['link' => route('admin.vendors.get-vendor-register-view'), 'title' => 'Vendor Register Forms', 'value' => 'Yes'],
                ];
                break;

            case 'leads':
                $title = 'Leads';
                $cardData = [
                    ['link' => route('admin.leads.list'), 'title' => 'Manage Lead', 'value' => 'Yes'],
                ];
                break;

            case 'leads':
                $title = 'Leads';
                $cardData = [
                    ['link' => route('admin.leads.list'), 'title' => 'Manage Leads', 'value' => 'Yes'],
                ];
                break;

            case 'sell-offer':
                $title = 'Sell Offers';
                $cardData = [
                    ['link' => route('admin.leads.list'), 'title' => 'Manage Sell Offer', 'value' => 'Yes'],
                    ['link' => route('admin.add-new-leads'), 'title' => 'Add Sell Offer', 'value' => 'Yes'],
                    ['link' => route('admin.bulk-import-leads'), 'title' => 'Import Sell Offer', 'value' => 'Yes'],
                ];
                break;

            case 'buy-leads':
                $title = 'Buy Leads';
                $cardData = [
                    ['link' => route('admin.leads.list'), 'title' => 'Manage Buy Leads', 'value' => 'Yes'],
                    ['link' => route('admin.add-new-leads'), 'title' => 'Add Buy Lead', 'value' => 'Yes'],
                    ['link' => route('admin.bulk-import-leads'), 'title' => 'Import Buy Lead', 'value' => 'Yes'],
                ];
                break;

            case 'marketplace':
                $title = 'Marketplace';
                $cardData = [
                    ['link' => route('admin.category.view'), 'title' => 'Categories', 'value' => 'Yes'],
                    ['link' => route('admin.sub-category.view'), 'title' => 'Sub Categories', 'value' => 'Yes'],
                    ['link' => route('admin.sub-sub-category.view'), 'title' => 'Sub Sub Categories', 'value' => 'Yes'],
                    ['link' => route('admin.brand.add-new'), 'title' => 'Add Brand', 'value' => 'Yes'],
                    ['link' => route('admin.brand.list'), 'title' => 'Manage Brand', 'value' => 'Yes'],
                    ['link' => route('admin.products.list', ['in-house']), 'title' => 'Products List', 'value' => 'Yes'],
                    ['link' => route('admin.products.add'), 'title' => 'Products Add', 'value' => 'Yes'],
                    ['link' => route('admin.products.bulk-import'), 'title' => 'Bulk Import Products', 'value' => 'Yes'],
                ];
                break;

            case 'stock-sell':
                $title = 'Stock Sell';
                $cardData = [
                    ['link' => route('admin.stock.create'), 'title' => 'Add Stock Sale', 'value' => 'Yes'],
                    ['link' => route('admin.stock.index'), 'title' => 'Stock Sale List', 'value' => 'Yes'],
                    ['link' => route('admin.stock.category.list'), 'title' => 'Manage Stock Category', 'value' => 'Yes'],
                    ['link' => route('admin.stock.category.create'), 'title' => 'Add Stock Category', 'value' => 'Yes'],
                ];
                break;


            case 'tradeshow':
                $title = 'Tradeshows';
                $cardData = [
                    ['link' => route('admin.tradeshow.list'), 'title' => 'Trade Show List', 'value' => 'Yes'],
                    ['link' => route('admin.add-new-tradeshow'), 'title' => 'Manage Trade Show', 'value' => 'Yes'],
                ];
                break;

            case 'vendor':
                $title = 'Vendor';
                $cardData = [
                    ['link' => route('admin.vendors.vendor-list'), 'title' => 'Vendor List', 'value' => 'Yes'],
                    ['link' => route('admin.vendors.add'), 'title' => 'Add Vendors', 'value' => 'Yes'],
                ];
                break;

            case 'buyer':
                $title = 'Buyer';
                $cardData = [
                    ['link' => route('admin.customer.list'), 'title' => 'Buyers', 'value' => 'Yes'],
                ];
                break;

            case 'consultant':
                $title = 'Consultant';
                $cardData = [
                    ['link' => route('admin.jobvacancy.consultant-membership'), 'title' => 'Consultant Membership', 'value' => 'Yes'],
                ];
                break;

            case 'industry-jobs':
                $title = 'Consultant';
                $cardData = [
                    ['link' => route('admin.cv.list'), 'title' => 'CV List', 'value' => 'Yes'],
                    ['link' => route('admin.jobvacancy.category.list'), 'title' => 'Vacancy Category', 'value' => 'Yes'],
                    ['link' => route('admin.jobvacancy.list'), 'title' => 'Vacancy List', 'value' => 'Yes'],
                    ['link' => route('admin.jobvacancy.create'), 'title' => 'Vacancy Create', 'value' => 'Yes'],
                    ['link' => route('admin.jobvacancy.registered-candidates'), 'title' => 'Registered Candidates', 'value' => 'Yes'],
                    ['link' => route('admin.jobvacancy.job-applications'), 'title' => 'Job Applications', 'value' => 'Yes'],
                ];
                break;

            case 'graphics':
                $title = 'Graphics';
                $cardData = [
                    ['link' => route('admin.business-settings.web-config.index'), 'title' => 'Business Settings', 'value' => 'Yes'],
                    ['link' => route('admin.business-settings.terms-condition'), 'title' => 'Business Pages', 'value' => 'Yes'],
                    ['link' => route('admin.webtheme.index'), 'title' => 'Website Settings', 'value' => 'Yes'],
                ];
                break;

            case 'deal-assist':
                $title = 'Deal Assist';
                $cardData = [
                    ['link' => route('dealassist.index'), 'title' => 'Deal Assist', 'value' => 'Yes'],
                ];
                break;

            case 'inbox':
                $title = 'Inbox';
                $cardData = [
                    ['link' => route('admin.get-chat-lists'), 'title' => 'Inbox', 'value' => 'Yes'],
                ];
                break;

            case 'membership':
                $title = 'Membership';
                $cardData = [
                    ['link' => route('admin.membershiptier'), 'title' => 'Membership Settings', 'value' => 'Yes'],
                ];
                break;

            default:
                $title = 'Unknown';
                $cardData = [['link' => '#', 'title' => 'No Data Found', 'value' => 0]];
                break;
        }

        return view('admin-views.system..subcards.subcard', compact('title', 'cardData', 'slug'));
    }
}
