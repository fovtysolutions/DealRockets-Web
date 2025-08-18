<?php

namespace App\Http\Controllers\Vendor;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Contracts\Repositories\DeliveryManRepositoryInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\VendorWalletRepositoryInterface;
use App\Contracts\Repositories\WithdrawalMethodRepositoryInterface;
use App\Contracts\Repositories\WithdrawRequestRepositoryInterface;
use App\Enums\OrderStatus;
use App\Enums\ViewPaths\Vendor\Dashboard;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Vendor\WithdrawRequest;
use App\Models\faq;
use App\Models\Seller;
use App\Repositories\BrandRepository;
use App\Repositories\OrderTransactionRepository;
use App\Services\DashboardService;
use App\Services\VendorWalletService;
use App\Services\WithdrawRequestService;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends BaseController
{
    public function __construct(
        private readonly OrderTransactionRepository $orderTransactionRepo,
        private readonly ProductRepositoryInterface $productRepo,
        private readonly DeliveryManRepositoryInterface $deliveryManRepo,
        private readonly OrderRepositoryInterface $orderRepo,
        private readonly CustomerRepositoryInterface $customerRepo,
        private readonly BrandRepository $brandRepo,
        private readonly VendorWalletRepositoryInterface $vendorWalletRepo,
        private readonly VendorWalletService $vendorWalletService,
        private readonly WithdrawalMethodRepositoryInterface $withdrawalMethodRepo,
        private readonly WithdrawRequestRepositoryInterface $withdrawRequestRepo,
        private readonly WithdrawRequestService $withdrawRequestService,
        private readonly DashboardService $dashboardService,
    ) {}

    /**
     * @param Request|null $request
     * @param string|null $type
     * @return View|Collection|LengthAwarePaginator|callable|RedirectResponse|null
     */
    public function index(?Request $request, string $type = null): View|Collection|LengthAwarePaginator|null|callable|RedirectResponse
    {
        return $this->getView();
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        $vendorId = auth('seller')->id();
        $topSell = $this->productRepo->getTopSellList(
            filters: [
                'added_by' => 'seller',
                'seller_id' => $vendorId,
                'request_status' => 1
            ],
            relations: ['orderDetails']
        )->take(DASHBOARD_TOP_SELL_DATA_LIMIT);
        $topRatedProducts = $this->productRepo->getTopRatedList(
            filters: [
                'user_id' => $vendorId,
                'added_by' => 'seller',
                'request_status' => 1
            ],
            relations: ['reviews'],
        )->take(DASHBOARD_DATA_LIMIT);
        $topRatedDeliveryMan = $this->deliveryManRepo->getTopRatedList(
            orderBy: ['delivered_orders_count' => 'desc'],
            filters: [
                'seller_id' => $vendorId
            ],
            whereHasFilters: [
                'seller_is' => 'seller',
                'seller_id' => $vendorId
            ],
            relations: ['deliveredOrders'],
        )->take(DASHBOARD_DATA_LIMIT);

        $from = now()->startOfYear()->format('Y-m-d');
        $to = now()->endOfYear()->format('Y-m-d');
        $range = range(1, 12);
        $vendorEarning = $this->getVendorEarning(from: $from, to: $to, range: $range, type: 'month');
        $commissionEarn = $this->getAdminCommission(from: $from, to: $to, range: $range, type: 'month');
        $vendorWallet = $this->vendorWalletRepo->getFirstWhere(params: ['seller_id' => $vendorId]);
        $label = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $dateType = 'yearEarn';
        $dashboardData = [
            'orderStatus' => $this->getOrderStatusArray(type: 'overall'),
            'customers' => $this->customerRepo->getList(dataLimit: 'all')->count(),
            'products' => $this->productRepo->getListWhere(filters: ['seller_id' => $vendorId, 'added_by' => 'seller'])->count(),
            'orders' => $this->orderRepo->getListWhere(filters: ['seller_id' => $vendorId, 'seller_is' => 'seller'])->count(),
            'brands' => $this->brandRepo->getListWhere(dataLimit: 'all')->count(),
            'topSell' => $topSell,
            'topRatedProducts' => $topRatedProducts,
            'topRatedDeliveryMan' => $topRatedDeliveryMan,
            'totalEarning' => $vendorWallet->total_earning ?? 0,
            'withdrawn' => $vendorWallet->withdrawn ?? 0,
            'pendingWithdraw' => $vendorWallet->pending_withdraw ?? 0,
            'adminCommission' => $vendorWallet->commission_given ?? 0,
            'deliveryManChargeEarned' => $vendorWallet->delivery_charge_earned ?? 0,
            'collectedCash' => $vendorWallet->collected_cash ?? 0,
            'collectedTotalTax' => $vendorWallet->total_tax_collected ?? 0,
        ];
        $withdrawalMethods = $this->withdrawalMethodRepo->getListWhere(filters: ['is_active' => 1], dataLimit: 'all');
        return view(Dashboard::INDEX[VIEW], compact('dashboardData', 'vendorEarning', 'commissionEarn', 'withdrawalMethods', 'dateType', 'label'));
    }

    /**
     * @param string $type
     * @return JsonResponse
     */
    public function getOrderStatus(string $type): JsonResponse
    {
        $orderStatus = $this->getOrderStatusArray($type);
        return response()->json([
            'view' => view(Dashboard::ORDER_STATUS[VIEW], compact('orderStatus'))->render()
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getEarningStatistics(Request $request): JsonResponse
    {
        $dateType = $request['type'];
        $dateTypeArray = $this->dashboardService->getDateTypeData(dateType: $dateType);
        $from = $dateTypeArray['from'];
        $to = $dateTypeArray['to'];
        $type = $dateTypeArray['type'];
        $range = $dateTypeArray['range'];
        $vendorEarning = $this->getVendorEarning(from: $from, to: $to, range: $range, type: $type);
        $commissionEarn = $this->getAdminCommission(from: $from, to: $to, range: $range, type: $type);
        $vendorEarning = array_values($vendorEarning);
        $commissionEarn = array_values($commissionEarn);
        $label = $dateTypeArray['keyRange'] ?? [];
        return response()->json([
            'view' => view(Dashboard::EARNING_STATISTICS[VIEW], compact('vendorEarning', 'commissionEarn', 'label', 'dateType'))->render(),
        ]);
    }

    /**
     * @param WithdrawRequest $request
     * @return RedirectResponse
     */
    public function getWithdrawRequest(WithdrawRequest $request): RedirectResponse
    {
        $vendorId = auth('seller')->id();
        $withdrawMethod = $this->withdrawalMethodRepo->getFirstWhere(params: ['id' => $request['withdraw_method']]);
        $wallet = $this->vendorWalletRepo->getFirstWhere(params: ['seller_id' => auth('seller')->id()]);
        if (($wallet['total_earning']) >= currencyConverter($request['amount']) && $request['amount'] > 1) {
            $this->withdrawRequestRepo->add($this->withdrawRequestService->getWithdrawRequestData(
                withdrawMethod: $withdrawMethod,
                request: $request,
                addedBy: 'vendor',
                vendorId: $vendorId
            ));
            $totalEarning = $wallet['total_earning'] - currencyConverter($request['amount']);
            $pendingWithdraw = $wallet['pending_withdraw'] + currencyConverter($request['amount']);
            $this->vendorWalletRepo->update(
                id: $wallet['id'],
                data: $this->vendorWalletService->getVendorWalletData(totalEarning: $totalEarning, pendingWithdraw: $pendingWithdraw)
            );
            Toastr::success(translate('withdraw_request_has_been_sent'));
        } else {
            Toastr::error(translate('invalid_request') . '!');
        }
        return redirect()->back();
    }

    /**
     * @param string $type
     * @return array
     */
    protected function getOrderStatusArray(string $type): array
    {
        $vendorId = auth('seller')->id();
        $status = OrderStatus::LIST;
        $statusWiseOrders = [];
        foreach ($status as $key) {
            $count = $this->orderRepo->getListWhereDate(
                filters: [
                    'seller_is' => 'seller',
                    'seller_id' => $vendorId,
                    'order_status' => $key
                ],
                dateType: $type == 'overall' ? 'overall' : ($type == 'today' ? 'today' : 'thisMonth'),
            )->count();
            $statusWiseOrders[$key] = $count;
        }
        return $statusWiseOrders;
    }

    /**
     * @param string|Carbon $from
     * @param string|Carbon $to
     * @param array $range
     * @param string $type
     * @return array
     */
    protected function getVendorEarning(string|Carbon $from, string|Carbon $to, array $range, string $type): array
    {
        $vendorId = auth('seller')->id();
        $vendorEarnings = $this->orderTransactionRepo->getListWhereBetween(
            filters: [
                'seller_is' => 'seller',
                'seller_id' => $vendorId,
                'status' => 'disburse',
            ],
            selectColumn: 'seller_amount',
            whereBetween: 'created_at',
            whereBetweenFilters: [$from, $to],
            groupBy: $type,
        );
        return $this->dashboardService->getDateWiseAmount(range: $range, type: $type, amountArray: $vendorEarnings);
    }

    /**
     * @param string|Carbon $from
     * @param string|Carbon $to
     * @param array $range
     * @param string $type
     * @return array
     */
    protected function getAdminCommission(string|Carbon $from, string|Carbon $to, array $range, string $type): array
    {;
        $vendorId = auth('seller')->id();
        $commissionGiven = $this->orderTransactionRepo->getListWhereBetween(
            filters: [
                'seller_is' => 'seller',
                'seller_id' => $vendorId,
                'status' => 'disburse',
            ],
            selectColumn: 'admin_commission',
            whereBetween: 'created_at',
            whereBetweenFilters: [$from, $to],
            groupBy: $type,
        );
        return $this->dashboardService->getDateWiseAmount(range: $range, type: $type, amountArray: $commissionGiven);;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getMethodList(Request $request): JsonResponse
    {
        $method = $this->withdrawalMethodRepo->getFirstWhere(params: ['id' => $request['method_id'], 'is_active' => 1]);
        return response()->json(['content' => $method], 200);
    }

    public function otherDashboard(Request $request)
    {
        $vendorId = auth('seller')->id();
        $topSell = $this->productRepo->getTopSellList(
            filters: [
                'added_by' => 'seller',
                'seller_id' => $vendorId,
                'request_status' => 1
            ],
            relations: ['orderDetails']
        )->take(DASHBOARD_TOP_SELL_DATA_LIMIT);
        $topRatedProducts = $this->productRepo->getTopRatedList(
            filters: [
                'user_id' => $vendorId,
                'added_by' => 'seller',
                'request_status' => 1
            ],
            relations: ['reviews'],
        )->take(DASHBOARD_DATA_LIMIT);
        $topRatedDeliveryMan = $this->deliveryManRepo->getTopRatedList(
            orderBy: ['delivered_orders_count' => 'desc'],
            filters: [
                'seller_id' => $vendorId
            ],
            whereHasFilters: [
                'seller_is' => 'seller',
                'seller_id' => $vendorId
            ],
            relations: ['deliveredOrders'],
        )->take(DASHBOARD_DATA_LIMIT);

        $from = now()->startOfYear()->format('Y-m-d');
        $to = now()->endOfYear()->format('Y-m-d');
        $range = range(1, 12);
        $vendorEarning = $this->getVendorEarning(from: $from, to: $to, range: $range, type: 'month');
        $commissionEarn = $this->getAdminCommission(from: $from, to: $to, range: $range, type: 'month');
        $vendorWallet = $this->vendorWalletRepo->getFirstWhere(params: ['seller_id' => $vendorId]);
        $label = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $dateType = 'yearEarn';
        $dashboardData = [
            'orderStatus' => $this->getOrderStatusArray(type: 'overall'),
            'customers' => $this->customerRepo->getList(dataLimit: 'all')->count(),
            'products' => $this->productRepo->getListWhere(filters: ['seller_id' => $vendorId, 'added_by' => 'seller'])->count(),
            'orders' => $this->orderRepo->getListWhere(filters: ['seller_id' => $vendorId, 'seller_is' => 'seller'])->count(),
            'brands' => $this->brandRepo->getListWhere(dataLimit: 'all')->count(),
            'topSell' => $topSell,
            'topRatedProducts' => $topRatedProducts,
            'topRatedDeliveryMan' => $topRatedDeliveryMan,
            'totalEarning' => $vendorWallet->total_earning ?? 0,
            'withdrawn' => $vendorWallet->withdrawn ?? 0,
            'pendingWithdraw' => $vendorWallet->pending_withdraw ?? 0,
            'adminCommission' => $vendorWallet->commission_given ?? 0,
            'deliveryManChargeEarned' => $vendorWallet->delivery_charge_earned ?? 0,
            'collectedCash' => $vendorWallet->collected_cash ?? 0,
            'collectedTotalTax' => $vendorWallet->total_tax_collected ?? 0,
        ];
        $withdrawalMethods = $this->withdrawalMethodRepo->getListWhere(filters: ['is_active' => 1], dataLimit: 'all');
        return view('vendor-views.dashboard.subcards.dashboard-analytics', compact('dashboardData', 'vendorEarning', 'commissionEarn', 'withdrawalMethods', 'dateType', 'label'));
    }

    public function bannerDataPage($slug)
    {
        $validSlugs = ['marketplace', 'buyleads', 'selloffer', 'tradeshows'];
        $userId = auth('seller')->id();
        $seller = Seller::find($userId);
        $banner_images = $seller->ad_banners;
        $decodedArray = json_decode($banner_images, true);
        if (isset($decodedArray[$slug])) {
            $banner_images = $decodedArray[$slug];
        } else {
            $banner_images = [];
        }

        if (!in_array($slug, $validSlugs)) {
            abort(404);
        }

        return view('vendor-views.banner.banner', compact('slug', 'banner_images'));
    }

    public function storeBannerData(Request $request)
    {
        $slug = $request->input('slug');
        $userId = auth('seller')->id();
        $seller = Seller::find($userId);

        // Ensure ad_banners is initialized
        $existingBanners = json_decode($seller->ad_banners, true) ?? [];
        $currentBannerSet = $existingBanners[$slug] ?? [];

        // Convert to associative array [index => image_path] for easy merging
        $indexedBanners = collect($currentBannerSet)->keyBy('index')->toArray();

        // Define required dimensions for each banner
        $requiredDimensions = [
            1 => ['width' => 300, 'height' => 250], // Medium Rectangle
            2 => ['width' => 728, 'height' => 90],  // Leaderboard
            3 => ['width' => 160, 'height' => 600], // Wide Skyscraper
        ];

        for ($i = 1; $i <= 3; $i++) {
            $inputName = "banner_{$slug}{$i}";

            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);

                // Get uploaded image dimensions
                [$width, $height] = getimagesize($file);

                // Validate dimensions
                if (
                    $width != $requiredDimensions[$i]['width'] ||
                    $height != $requiredDimensions[$i]['height']
                ) {
                    return redirect()->back()->withErrors([
                        $inputName => "Banner {$i} must be exactly {$requiredDimensions[$i]['width']}x{$requiredDimensions[$i]['height']} pixels."
                    ]);
                }

                // Store valid image
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads/banners', $filename, 'public');

                // Replace or insert uploaded banner
                $indexedBanners[$i] = [
                    'slug' => $slug,
                    'index' => $i,
                    'image_path' => $path
                ];
            }
        }

        // Re-index as numerically ordered array
        $finalBanners = collect($indexedBanners)->sortKeys()->values()->all();

        // Save updated banners
        $existingBanners[$slug] = $finalBanners;
        $seller->ad_banners = json_encode($existingBanners);
        $seller->save();

        return redirect()->back()->with('success', 'Images Added Successfully');
    }
    
    public function seefaqs(){
        $faqs = faq::where('type','vendor')->get();
        $vendorCategories = [
            'analytics' => 'Analytics',
            'inbox' => 'Inbox',
            'notifications' => 'Notifications',
            'marketplace' => 'Marketplace',
            'profile' => 'My Profile',
            'advertise' => 'Advertise',
            'stocksell' => 'Stock Sell',
            'buyleads' => 'Buy Leads',
            'saleoffer' => 'Sale Offer',
            'dealassist' => 'Deal Assist',
            'postrfq' => 'RFQ',
            'industryjobs' => 'Industry Jobs',
            'tradeshow' => 'Tradeshow',
            'membership' => 'Membership',
            'clearingforwarding' => 'Clearing & Forwarding',
        ];
        return view('vendor-views.faq.seefaqs',compact('faqs','vendorCategories'));
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
                    ['link' => route('register-form-vendor'), 'title' => 'Register Form', 'value' => 'Yes'],
                    ['link' => route('vendor-form-vendor'), 'title' => 'Supplier Form', 'value' => 'Yes'],
                    ['link' => route('editprofile-form-vendor'), 'title' => 'Edit Login', 'value' => 'Yes'],
                    // ['link' => route('vendor.profile.update', [auth('seller')->id()]), 'title' => 'Manage Profile', 'value' => 'Yes'],
                ];
                break;

            case 'analytics':
                $title = 'Analytics';
                $cardData = [
                    ['link' => route('vendor.report.all-product'), 'title' => 'Product Analytics', 'value' => 'Yes'],
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
                    // ['link' => route('vendor.products.bulk-import'), 'title' => 'Bulk Import', 'value' => 'Yes'],
                    ['link' => route('vendor.products.list', ['type' => 'all']), 'title' => 'Manage Products', 'value' => 'Yes'],
                    ['link' => route('vendor.products.list', ['type' => 'approved']), 'title' => 'Approved Products', 'value' => 'Yes'],
                    ['link' => route('vendor.products.list', ['type' => 'denied']), 'title' => 'Denied Products', 'value' => 'Yes'],
                    ['link' => route('vendor.products.list', ['type' => 'new-request']), 'title' => 'New Product Request', 'value' => 'Yes'],
                ];
                break;

            case 'stock-sell':
                $title = 'Stock Sell';
                $cardData = [
                    ['link' => route('vendor.stock.create'), 'title' => 'Add Stock Sales', 'value' => 'Yes'],
                    ['link' => route('vendor.stock.index'), 'title' => 'Manage Stock Sales', 'value' => 'Yes'],
                ];
                break;

            case 'sell-offer':
                $title = 'Sell Offer';
                $cardData = [
                    ['link' => route('vendor.add-new-leads'), 'title' => 'Add Sell Offer', 'value' => 'Yes'],
                    ['link' => route('vendor.leads.list'), 'title' => 'Manage Sell Offer', 'value' => 'Yes'],
                ];
                break;

            case 'buy-leads':
                return redirect()->route('buyer');
                // $title = 'Buy Leads';
                // $cardData = [
                //     ['link' => route('vendor.leads.buyers'), 'title' => 'Go To Buy Leads', 'value' => 'Yes'],
                // ];
                break;

            case 'marketplace':
                $title = 'Marketplace';
                $cardData = [
                    ['link' => route('vendor.products.add'), 'title' => 'Upload Products', 'value' => 'Yes'],
                    // ['link' => route('vendor.products.bulk-import'), 'title' => 'Bulk Import', 'value' => 'Yes'],
                    ['link' => route('vendor.products.list', ['type' => 'all']), 'title' => 'Manage Products', 'value' => 'Yes'],
                    // ['link' => route('vendor.products.list', ['type' => 'new-request']), 'title' => 'New Product Request', 'value' => 'Yes'],
                    // ['link' => route('vendor.products.list', ['type' => 'approved']), 'title' => 'Approved Products', 'value' => 'Yes'],
                    // ['link' => route('vendor.products.list', ['type' => 'denied']), 'title' => 'Denied Products', 'value' => 'Yes'],
                ];
                break;

            case 'post-rfq':
                return redirect()->route('quotationweb');
                // $title = 'Post RFQ';
                // $cardData = [
                //     ['link' => route('quotationweb'), 'title' => 'Go to RFQ Page', 'value' => 'Yes'],
                // ];
                break;

            case 'post-job':
                $title = 'Post a Job';
                $cardData = [
                    ['link' => route('vendor.jobvacancy.create'), 'title' => 'Add Job', 'value' => 'Yes'],
                    ['link' => route('vendor.jobvacancy.list'), 'title' => 'Manage Jobs', 'value' => 'Yes'],
                    ['link' => route('vendor.jobvacancy.job-applications'), 'title' => 'Applications', 'value' => 'Yes'],
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
                // $title = 'Trade Shows';
                // $cardData = [
                //     ['link' => '#', 'title' => 'Upcoming Shows', 'value' => 2],
                //     ['link' => '#', 'title' => 'Ongoing Shows', 'value' => 2],
                //     ['link' => '#', 'title' => 'Past Shows', 'value' => 2],
                // ];
                break;

            case 'clearing-forwarding':
                return redirect("/marketplace-categories/88");
                // $title = 'Clearing and Forwarding Services';
                // $cardData = [
                //     ['link' => '#', 'title' => 'Clearing Service', 'value' => 'No'],
                //     ['link' => '#', 'title' => 'Forwarding Service', 'value' => 'No'],
                // ];
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
                    ['link' => route('vendor.seefaqs'), 'title' => 'FAQ', 'value' => 'Yes'],
                ];
                break;

            case 'logout':
                return redirect()->route('vendor.auth.logout');

            default:
                $title = 'Unknown';
                $cardData = [['link' => '#', 'title' => 'No Data Found', 'value' => 0]];
                break;
        }

        return view('vendor-views.dashboard.subcards.subcard', compact('title', 'cardData', 'slug'));
    }
}
