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

    )
    {
    }

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
            'getTotalDeliveryManCount' => $this->deliveryManRepo->getListWhere(filters:['seller_id' => 0],dataLimit: 'all')->count(),
        ];
        return view(Dashboard::VIEW[VIEW], compact('data', 'inHouseEarning', 'vendorEarning', 'commissionEarn','inHouseOrderEarningArray','vendorOrderEarningArray','label','dateType'));
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
    public function getOrderStatistics(Request $request):JsonResponse
    {
        $dateType = $request['type'];
        $dateTypeArray = $this->dashboardService->getDateTypeData(dateType:$dateType);
        $from = $dateTypeArray['from']; $to = $dateTypeArray['to']; $type = $dateTypeArray['type']; $range = $dateTypeArray['range'];
        $inHouseOrderEarningArray = $this->getOrderStatisticsData(from: $from, to: $to, range: $range, type: $type,userType:'admin');
        $vendorOrderEarningArray = $this->getOrderStatisticsData(from: $from, to: $to, range: $range, type: $type,userType:'seller');
        $label = $dateTypeArray['keyRange'] ?? [];
        $inHouseOrderEarningArray = array_values($inHouseOrderEarningArray);
        $vendorOrderEarningArray = array_values($vendorOrderEarningArray);
        return response()->json([
            'view' => view(Dashboard::ORDER_STATISTICS[VIEW], compact('inHouseOrderEarningArray','vendorOrderEarningArray','label','dateType'))->render(),
        ]);
    }
    public function getEarningStatistics(Request $request):JsonResponse
    {
        $dateType = $request['type'];
        $dateTypeArray = $this->dashboardService->getDateTypeData(dateType:$dateType);
        $from = $dateTypeArray['from']; $to = $dateTypeArray['to']; $type = $dateTypeArray['type']; $range = $dateTypeArray['range'];
        $inHouseEarning = $this->getEarning(from: $from, to: $to, range: $range, type: $type,userType: 'admin');
        $vendorEarning = $this->getEarning(from: $from, to: $to, range: $range, type: $type,userType: 'seller');
        $commissionEarn = $this->getAdminCommission(from: $from, to: $to, range: $range, type: $type);
        $label = $dateTypeArray['keyRange'] ?? [];
        $inHouseEarning = array_values($inHouseEarning);
        $vendorEarning = array_values($vendorEarning);
        $commissionEarn = array_values($commissionEarn);
        return response()->json([
            'view' => view(Dashboard::EARNING_STATISTICS[VIEW], compact('inHouseEarning','vendorEarning','commissionEarn','label','dateType'))->render(),
        ]);
    }
    protected function getOrderStatisticsData($from,$to,$range,$type,$userType):array
    {
        $orderEarnings = $this->orderRepo->getListWhereBetween(
            filters:  [
                'seller_is'=>$userType,
                'payment_status' => 'paid'
            ],
            selectColumn: 'order_amount',
            whereBetween: 'created_at',
            whereBetweenFilters: [$from, $to],
        );
        $orderEarningArray = [];
        foreach ($range as $value){
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
            groupBy:  $type,
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
            groupBy:  $type,
        );
        return $this->dashboardService->getDateWiseAmount(range: $range, type: $type, amountArray: $commissionGiven);
    }

    public function AnalyticsOptions(){
        return view('admin-views.system.subcards.AnalyticsOptions');
    }

    // Sub Cards Functions
    public function subCardData($slug)
    {
        $title = '';
        $cardData = [];

        switch ($slug) {
            case 'profile':
                $title = 'Profile Settings';
                $cardData = [
                    ['link' => route('vendor.profile.update', [auth('seller')->id()]), 'title' => 'Manage Profile', 'value' => 'Yes'],
                ];
                break;

            case 'analytics':
                $title = 'Analytics';
                $cardData = [
                    ['link' => route('vendor.report.all-product'), 'title' => 'Product', 'value' => 'Yes'],
                    ['link' => route('vendor.otherDashboard'), 'title' => 'Other Analytics', 'value' => 'Yes'],
                ];
                break;

            case 'deal-assist':
                $title = 'Deal Assist';
                $cardData = [
                    ['link' => route('vendor.dealassist.index'), 'title' => 'Manage Deal Assist', 'value' => 'Yes'],
                ];
                break;

            case 'upload-banner':
                $title = 'Banners Setup';
                $cardData = [
                    ['link' => route('vendor.bannersetup', ['slug' => 'marketplace']), 'title' => 'Marketplace', 'value' => 'Yes'],
                    ['link' => route('vendor.bannersetup', ['slug' => 'buyleads']), 'title' => 'Buy Leads', 'value' => 'Yes'],
                    ['link' => route('vendor.bannersetup', ['slug' => 'selloffer']), 'title' => 'Sell Offer', 'value' => 'Yes'],
                    ['link' => route('vendor.bannersetup', ['slug' => 'tradeshows']), 'title' => 'Tradeshows', 'value' => 'Yes'],
                ];
                break;

            case 'vendor-inbox':
                $title = 'Inbox';
                $cardData = [
                    ['link' => route('vendor.get-chat-lists'), 'title' => 'Inbox', 'value' => 'Yes'],
                ];
                break;

            case 'product-upload':
                $title = 'Product Upload';
                $cardData = [
                    ['link' => route('vendor.products.add'), 'title' => 'Upload Products', 'value' => 'Yes'],
                    ['link' => route('vendor.products.bulk-import'), 'title' => 'Bulk Import', 'value' => 'Yes'],
                ];
                break;

            case 'stock-sell':
                $title = 'Stock Sell';
                $cardData = [
                    ['link' => route('vendor.stock.index'), 'title' => 'Manage Stock Sales', 'value' => 'Yes'],
                    ['link' => route('vendor.stock.create'), 'title' => 'Add Stock Sales', 'value' => 'Yes'],
                ];
                break;

            case 'sell-offer':
                $title = 'Sell Offer';
                $cardData = [
                    ['link' => route('vendor.leads.list'), 'title' => 'Manage Sell Offer', 'value' => 'Yes'],
                    ['link' => route('vendor.add-new-leads'), 'title' => 'Add Sell Offer', 'value' => 'Yes'],
                ];
                break;

            case 'buy-leads':
                return redirect()->route('buyer');
                break;

            case 'marketplace':
                $title = 'Marketplace';
                $cardData = [
                    ['link' => route('vendor.products.list', ['type' => 'all']), 'title' => 'Manage Products', 'value' => 'Yes'],
                    ['link' => route('vendor.products.list', ['type' => 'approved']), 'title' => 'Approved Products', 'value' => 'Yes'],
                    ['link' => route('vendor.products.list', ['type' => 'denied']), 'title' => 'Denied Products', 'value' => 'Yes'],
                    ['link' => route('vendor.products.list', ['type' => 'new-request']), 'title' => 'New Product Request', 'value' => 'Yes'],
                ];
                break;

            case 'post-rfq':
                $title = 'Post RFQ';
                $cardData = [
                    ['link' => route('quotationweb'), 'title' => 'Go to RFQ Page', 'value' => 'Yes'],
                ];
                break;

            case 'post-job':
                $title = 'Post a Job';
                $cardData = [
                    ['link' => route('vendor.jobvacancy.list'), 'title' => 'Manage Jobs', 'value' => 'Yes'],
                    ['link' => route('vendor.jobvacancy.create'), 'title' => 'Add Job', 'value' => 'Yes'],
                ];
                break;

            case 'hire-employee':
                $title = 'Hire an Employee';
                $cardData = [
                    ['link' => route('vendor.jobvacancy.job-applications'), 'title' => 'Applications', 'value' => 'Yes'],
                ];
                break;

            case 'trade-shows':
                return redirect()->route('tradeshow');
                break;

            case 'clearing-forwarding':
                $title = 'Clearing and Forwarding Services';
                $cardData = [
                    ['link' => '#', 'title' => 'Clearing Service', 'value' => 'No'],
                    ['link' => '#', 'title' => 'Forwarding Service', 'value' => 'No'],
                ];
                break;

            case 'settings':
                $title = 'Settings';
                $cardData = [
                    ['link' => route('vendor.shop.index'), 'title' => 'Shop Settings', 'value' => 'Yes'],
                ];
                break;

            case 'membership':
                $title = 'Membership';
                $cardData = [
                    ['link' => route('membership-vendor'), 'title' => 'Membership', 'value' => 'Yes'],
                ];
                break;

            case 'faq':
                $title = 'FAQ';
                $cardData = [
                    ['link' => route('vendor.managefaq'), 'title' => 'Manage FAQ', 'value' => 'Yes'],
                    ['link' => route('vendor.createfaq'), 'title' => 'Add FAQ', 'value' => 'Yes'],
                ];
                break;

            case 'logout':
                return redirect()->route('vendor.auth.logout');

            default:
                $title = 'Unknown';
                $cardData = [['link' => '#', 'title' => 'No Data Found', 'value' => 0]];
                break;
        }

        return view('admin-views.system..subcards.subcard', compact('title', 'cardData', 'slug'));
    }
}
