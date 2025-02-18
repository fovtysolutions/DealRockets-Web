<?php

namespace App\Http\Controllers\Web;

use App\Contracts\Repositories\AttributeRepositoryInterface;
use App\Contracts\Repositories\AuthorRepositoryInterface;
use App\Contracts\Repositories\BannerRepositoryInterface;
use App\Contracts\Repositories\BrandRepositoryInterface;
use App\Contracts\Repositories\CartRepositoryInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\ColorRepositoryInterface;
use App\Contracts\Repositories\DealOfTheDayRepositoryInterface;
use App\Contracts\Repositories\DigitalProductAuthorRepositoryInterface;
use App\Contracts\Repositories\DigitalProductVariationRepositoryInterface;
use App\Contracts\Repositories\FlashDealProductRepositoryInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\ProductSeoRepositoryInterface;
use App\Contracts\Repositories\PublishingHouseRepositoryInterface;
use App\Contracts\Repositories\ReviewRepositoryInterface;
use App\Contracts\Repositories\TranslationRepositoryInterface;
use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Contracts\Repositories\WishlistRepositoryInterface;
use App\Models\Author;
use App\Models\BusinessSetting;
use App\Models\DigitalProductAuthor;
use App\Models\DigitalProductPublishingHouse;
use App\Models\PublishingHouse;
use App\Utils\BrandManager;
use App\Utils\CategoryManager;
use App\Utils\Helpers;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Models\Shop;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Models\Product;
use App\Models\Translation;
use App\Models\Wishlist;
use App\Utils\ProductManager;
use Brian2694\Toastr\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ProductService;
use App\Repositories\DigitalProductPublishingHouseRepository;
use App\Models\Supplier;
use App\Services\SupplierService;
use App\Models\Admin;
use App\Models\Seller;
use App\Models\Order;
use App\Utils\ChatManager;


class SupplierController extends Controller
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepo,
        private readonly DigitalProductAuthorRepositoryInterface $digitalProductAuthorRepo,
        private readonly DigitalProductPublishingHouseRepository $digitalProductPublishingHouseRepo,
        private readonly PublishingHouseRepositoryInterface $publishingHouseRepo,
        private readonly CategoryRepositoryInterface $categoryRepo,
        private readonly BrandRepositoryInterface $brandRepo,
        private readonly ProductRepositoryInterface $productRepo,
        private readonly DigitalProductVariationRepositoryInterface $digitalProductVariationRepo,
        private readonly ProductSeoRepositoryInterface $productSeoRepo,
        private readonly VendorRepositoryInterface $sellerRepo,
        private readonly ColorRepositoryInterface $colorRepo,
        private readonly AttributeRepositoryInterface $attributeRepo,
        private readonly TranslationRepositoryInterface $translationRepo,
        private readonly CartRepositoryInterface $cartRepo,
        private readonly WishlistRepositoryInterface $wishlistRepo,
        private readonly FlashDealProductRepositoryInterface $flashDealProductRepo,
        private readonly DealOfTheDayRepositoryInterface $dealOfTheDayRepo,
        private readonly ReviewRepositoryInterface $reviewRepo,
        private readonly BannerRepositoryInterface $bannerRepo,
        private readonly ProductService $productService,
    ) {
    }
    public function getShopCategoriesList($products)
    {
        $categoryInfoDecoded = [];
        foreach ($products->pluck('category_ids')->toArray() as $info) {
            $categoryInfoDecoded[] = json_decode($info, true);
        }

        $categoryIds = [];
        foreach ($categoryInfoDecoded as $decoded) {
            foreach ($decoded as $info) {
                $categoryIds[] = $info['id'];
            }
        }

        $categories = Category::with(['childes.childes'])->where('position', 0)->whereIn('id', $categoryIds)->get();
        return CategoryManager::getPriorityWiseCategorySortQuery(query: $categories);
    }

    public function getShopBrandsList($products, $sellerType, $sellerId)
    {
        $brandIds = $products->pluck('brand_id')->toArray();
        $brands = Brand::active()->whereIn('id', $brandIds)->with(['brandProducts' => function ($query) use ($sellerType, $sellerId) {
            return $query->active()->when($sellerType == 'admin', function ($query) use ($sellerType) {
                return $query->where(['added_by' => $sellerType]);
            })
                ->when($sellerId && $sellerType == 'seller', function ($query) use ($sellerId, $sellerType) {
                    return $query->where(['added_by' => $sellerType, 'user_id' => $sellerId]);
                })->withCount(['orderDetails']);
        }])
            ->withCount(['brandProducts' => function ($query) use ($sellerType, $sellerId) {
                return $query->active()->when($sellerType == 'admin', function ($query) use ($sellerType) {
                    return $query->where(['added_by' => $sellerType]);
                })
                    ->when($sellerId && $sellerType == 'seller', function ($query) use ($sellerId, $sellerType) {
                        return $query->where(['added_by' => $sellerType, 'user_id' => $sellerId]);
                    });
            }])->get();

        $brandProductSortBy = getWebConfig(name: 'brand_list_priority');
        if ($brandProductSortBy && ($brandProductSortBy['custom_sorting_status'] == 1)) {
            if ($brandProductSortBy['sort_by'] == 'most_order') {
                $brands = $brands->map(function ($brand) {
                    $brand['order_count'] = $brand->brandProducts->sum('order_details_count');
                    return $brand;
                })->sortByDesc('order_count');
            } elseif ($brandProductSortBy['sort_by'] == 'latest_created') {
                $brands = $brands->sortByDesc('id');
            } elseif ($brandProductSortBy['sort_by'] == 'first_created') {
                $brands = $brands->sortBy('id');
            } elseif ($brandProductSortBy['sort_by'] == 'a_to_z') {
                $brands = $brands->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);
            } elseif ($brandProductSortBy['sort_by'] == 'z_to_a') {
                $brands = $brands->sortByDesc('name', SORT_NATURAL | SORT_FLAG_CASE);
            }
        }
        return $brands;
    }

    public function getShopInfoArray($shopId, $shopProducts, $sellerType, $sellerId): array
    {
        $totalOrder = Order::when($sellerType == 'admin', function ($query) {
            return $query->where(['seller_is' => 'admin']);
        })->when($sellerType == 'seller', function ($query) use ($sellerId) {
            return $query->where(['seller_is' => 'seller', 'seller_id' => $sellerId]);
        })->where('order_type', 'default_type')->count();

        $inhouseVacation = getWebConfig(name: 'vacation_add');
        $temporaryClose = getWebConfig(name: 'temporary_close');

        if ($shopId == 0) {
            $shop = ['id' => 0, 'name' => getWebConfig(name: 'company_name')];
        } else {
            $shop = Shop::where('id', $shopId)->first();
        }

        $getProductIDs = $shopProducts->pluck('id')->toArray();
        return [
            'id' => $shopId,
            'name' => $shopId == 0 ? getWebConfig(name: 'company_name') : Shop::where('id', $shopId)->first()->name,
            'seller_id' => $shopId == 0 ? 0 : $shop?->seller_id,
            'average_rating' => Review::active()->where('status', 1)->whereIn('product_id', $getProductIDs)->avg('rating'),
            'total_review' => Review::active()->where('status', 1)->whereIn('product_id', $getProductIDs)->count(),
            'total_order' => $totalOrder,
            'current_date' => date('Y-m-d'),
            'vacation_start_date' => $shopId == 0 ? $inhouseVacation['vacation_start_date'] : date('Y-m-d', strtotime($shop->vacation_start_date)),
            'vacation_end_date' => $shopId == 0 ? $inhouseVacation['vacation_end_date'] : date('Y-m-d', strtotime($shop->vacation_end_date)),
            'temporary_close' => $shopId == 0 ? $temporaryClose['status'] : $shop->temporary_close,
            'vacation_status' => $shopId == 0 ? $inhouseVacation['status'] : $shop->vacation_status,
            'banner_full_url' => $shopId == 0 ? $inhouseVacation['status'] : $shop->banner_full_url,
            'bottom_banner' => $shopId == 0 ? getWebConfig(name: 'bottom_banner') : $shop->bottom_banner,
            'bottom_banner_full_url' => $shopId == 0 ? getWebConfig(name: 'bottom_banner') : $shop->bottom_banner_full_url,
            'image_full_url' => $shopId == 0 ? $inhouseVacation['status'] : $shop->image_full_url,
            'minimum_order_amount' => $shopId == 0 ? getWebConfig(name: 'minimum_order_amount') : $shop->seller->minimum_order_amount ?? '0',
        ];
    }

    public function supplier(Request $request)
    {
        $themeName = theme_root_path();

        return match ($themeName) {
            'default' => self::default_theme($request),
            'theme_aster' => self::theme_aster($request),
            'theme_fashion' => self::theme_fashion($request),
            'theme_all_purpose' => self::theme_all_purpose($request),
        };
    }

    public function default_theme($request): View|JsonResponse|Redirector|RedirectResponse
    {
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $activeBrands = BrandManager::getActiveBrandWithCountingAndPriorityWiseSorting();

        $data = self::getProductListRequestData(request: $request);
        if ($request['data_from'] == 'category' && $request['category_id']) {
            $data['brand_name'] = Category::find((int) $request['category_id'])->name;
        }
        if ($request['data_from'] == 'brand') {
            $brand_data = Brand::active()->find((int) $request['brand_id']);
            if ($brand_data) {
                $data['brand_name'] = $brand_data->name;
            } else {
                Toastr::warning(translate('not_found'));
                return redirect('/');
            }
        }

        $productListData = ProductManager::getProductListData(request: $request);
        $products = $productListData->paginate(20)->appends($data);
        
        $supplierQuery = Supplier::query();
        
        $name = $request->searchInput;
        if($name){
            $supplierQuery->where('name','like','%'.$name.'%');
        }
        $suppliers = $supplierQuery->paginate(20);
        $totalsuppliers = $suppliers->total();
        $combinedSuppliers = [];
        foreach($suppliers as $supplier){
            $addedby = $supplier->added_by;
            $role = $supplier->role;
            if($role == 'seller'){
                $shopName = Shop::where('seller_id',$addedby)->first()->name;
            }
            if($role == 'admin'){
                $shopName = "XYZ Store";
            }
            $combinedSuppliers[] = [
                'suppliers' => $supplier,
                'shop' => [
                    'added_by' => $addedby, 
                    'role' => $role,
                    'shop_name' => $shopName,
                ]
            ];
        }
        if ($request->ajax()) {
            return response()->json([
                'total_product' => $products->total(),
                'view' => view('web-views.products._ajax-products', compact('products'))->render()
            ], 200);
        }

        return view(VIEW_FILE_NAMES['supplier_view_page'], [
            'products' => $products,
            'data' => $data,
            'activeBrands' => $activeBrands,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'combinedSuppliers' => $combinedSuppliers,
            'totalsuppliers' => $totalsuppliers
        ]);
    }

    public function theme_aster($request): View|JsonResponse|Redirector|RedirectResponse
    {
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $activeBrands = BrandManager::getActiveBrandWithCountingAndPriorityWiseSorting();

        $data = self::getProductListRequestData(request: $request);
        if ($request['data_from'] == 'category' && $request['category_id']) {
            $data['brand_name'] = Category::find((int) $request['category_id'])->name;
        }
        if ($request['data_from'] == 'brand') {
            $brandData = Brand::active()->find((int) $request['brand_id']);
            if ($brandData) {
                $data['brand_name'] = $brandData->name;
            } else {
                if ($request->ajax()) {
                    return response()->json(['message' => translate('not_found')], 200);
                }
                Toastr::warning(translate('not_found'));
                return redirect('/');
            }
        }

        $productListData = ProductManager::getProductListData(request: $request);
        $ratings = self::getProductsRatingOneToFiveAsArray(productQuery: $productListData);
        $products = $productListData->paginate(20)->appends($data);
        $getProductIds = $products->pluck('id')->toArray();

        if ($request['ratings'] != null) {
            $products = $products->map(function ($product) use ($request) {
                $product->rating = $product->rating->pluck('average')[0];
                return $product;
            });
            $products = $products->where('rating', '>=', $request['ratings'])
                ->where('rating', '<', $request['ratings'] + 1)
                ->paginate(20)->appends($data);
        }

        if ($request->ajax()) {
            return response()->json([
                'total_product' => $products->total(),
                'view' => view(VIEW_FILE_NAMES['products__ajax_partials'], ['products' => $products, 'product_ids' => $getProductIds])->render(),
            ], 200);
        }

        return view(VIEW_FILE_NAMES['supplier_view_page'], [
            'products' => $products,
            'data' => $data,
            'ratings' => $ratings,
            'product_ids' => $getProductIds,
            'activeBrands' => $activeBrands,
            'categories' => $categories,
        ]);
    }

    public function theme_fashion(Request $request): View|JsonResponse|Redirector|RedirectResponse
    {
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $activeBrands = BrandManager::getActiveBrandWithCountingAndPriorityWiseSorting();
        $banner = BusinessSetting::where(['type' => 'banner_product_list_page'])->whereJsonContains('value', ['status' => '1'])->first();

        $data = self::getProductListRequestData(request: $request);
        if ($request['data_from'] == 'brand') {
            $brand_data = Brand::active()->find((int) $request['brand_id']);
            if (!$brand_data) {
                Toastr::warning(translate('not_found'));
                return redirect('/');
            }
        }

        $tagCategory = [];
        if ($request['data_from'] == 'category' && $request['category_id']) {
            $tagCategory = Category::where('id', $request['category_id'])->select('id', 'name')->get();
        }

        $tagPublishingHouse = [];
        if (($request->has('publishing_house_id')) && !empty($request['publishing_house_id'])) {
            $tagPublishingHouse = PublishingHouse::where('id', $request['publishing_house_id'])->select('id', 'name')->get();
        }

        $tagProductAuthors = [];
        if (($request->has('author_id')) && !empty($request['author_id'])) {
            $tagProductAuthors = Author::where('id', $request['author_id'])->select('id', 'name')->get();
        }

        $tagBrand = [];
        if ($request['data_from'] == 'brand') {
            $tagBrand = Brand::where('id', $request['brand_id'])->select('id', 'name')->get();
        }

        $productListData = ProductManager::getProductListData(request: $request);
        $products = $productListData->paginate(25)->appends($data);
        $paginate_count = ceil(($products->total() / 25));
        $getProductIds = $products->pluck('id')->toArray();

        if ($request['ratings'] != null) {
            $products = $products->map(function ($product) use ($request) {
                $product->rating = $product->rating->pluck('average')[0];
                return $product;
            });
            $products = $products->where('rating', '>=', $request['ratings'])
                ->where('rating', '<', $request['ratings'] + 1)
                ->paginate(25)->appends($data);
        }

        $allProductsColorList = ProductManager::getProductsColorsArray();

        if ($request->ajax()) {
            return response()->json([
                'total_product' => $products->total(),
                'view' => view(VIEW_FILE_NAMES['products__ajax_partials'], [
                    'products' => $products,
                    'product_ids' => $getProductIds,
                    'paginate_count' => $paginate_count,
                ])->render(),
            ], 200);
        }

        return view(VIEW_FILE_NAMES['supplier_view_page'], [
            'products' => $products,
            'tag_category' => $tagCategory,
            'tagPublishingHouse' => $tagPublishingHouse,
            'tagProductAuthors' => $tagProductAuthors,
            'tag_brand' => $tagBrand,
            'activeBrands' => $activeBrands,
            'categories' => $categories,
            'allProductsColorList' => $allProductsColorList,
            'banner' => $banner,
            'product_ids' => $getProductIds,
            'paginate_count' => $paginate_count,
            'data' => $data
        ]);
    }

    public function theme_all_purpose(Request $request): View|JsonResponse|Redirector|RedirectResponse
    {
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $banner = BusinessSetting::where('type', 'banner_product_list_page')->whereJsonContains('value', ['status' => '1'])->first();

        $data = self::getProductListRequestData(request: $request);
        $productListData = ProductManager::getProductListData(request: $request);
        $ratings = self::getProductsRatingOneToFiveAsArray(productQuery: $productListData);
        $products = $productListData->paginate(20)->appends($data);
        $getProductIds = $products->pluck('id')->toArray();
        $allProductsColorList = ProductManager::getProductsColorsArray();

        if ($request->ajax()) {
            return response()->json([
                'total_product' => $products->total(),
                'view' => view(VIEW_FILE_NAMES['products__ajax_partials'], compact('products', 'getProductIds'))->render(),
            ], 200);
        }
        return view(
            VIEW_FILE_NAMES['supplier_view_page'],
            compact(
                'products',
                'getProductIds',
                'categories',
                'allProductsColorList',
                'banner',
                'ratings'
            )
        );
    }

    function getProductsRatingOneToFiveAsArray($productQuery): array
    {
        $rating_1 = 0;
        $rating_2 = 0;
        $rating_3 = 0;
        $rating_4 = 0;
        $rating_5 = 0;

        foreach ($productQuery as $rating) {
            if (isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] > 0 && $rating->rating[0]['average'] < 2)) {
                $rating_1 += 1;
            } elseif (isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >= 2 && $rating->rating[0]['average'] < 3)) {
                $rating_2 += 1;
            } elseif (isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >= 3 && $rating->rating[0]['average'] < 4)) {
                $rating_3 += 1;
            } elseif (isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >= 4 && $rating->rating[0]['average'] < 5)) {
                $rating_4 += 1;
            } elseif (isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] == 5)) {
                $rating_5 += 1;
            }
        }

        return [
            'rating_1' => $rating_1,
            'rating_2' => $rating_2,
            'rating_3' => $rating_3,
            'rating_4' => $rating_4,
            'rating_5' => $rating_5,
        ];
    }

    public static function getProductListRequestData($request): array
    {
        return [
            'id' => $request['id'],
            'name' => $request['name'],
            'brand_id' => $request['brand_id'],
            'category_id' => $request['category_id'],
            'data_from' => $request['data_from'],
            'sort_by' => $request['sort_by'],
            'page_no' => $request['page'],
            'min_price' => $request['min_price'],
            'max_price' => $request['max_price'],
            'product_type' => $request['product_type'],
            'shop_id' => $request['shop_id'],
            'author_id' => $request['author_id'],
            'publishing_house_id' => $request['publishing_house_id'],
        ];
    }

    public function add_new()
    {
        $categories = $this->categoryRepo->getListWhere(filters: ['position' => 0], dataLimit: 'all');
        $brands = $this->brandRepo->getListWhere(dataLimit: 'all');
        $brandSetting = getWebConfig(name: 'product_brand');
        $digitalProductSetting = getWebConfig(name: 'digital_product');
        $colors = $this->colorRepo->getList(orderBy: ['name' => 'desc'], dataLimit: 'all');
        $attributes = $this->attributeRepo->getList(orderBy: ['name' => 'desc'], dataLimit: 'all');
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        $digitalProductFileTypes = ['audio', 'video', 'document', 'software'];
        $digitalProductAuthors = $this->authorRepo->getListWhere(dataLimit: 'all');
        $publishingHouseList = $this->publishingHouseRepo->getListWhere(dataLimit: 'all');

        return view('admin-views.supplier.add-new', compact('categories', 'brands', 'brandSetting', 'digitalProductSetting', 'colors', 'attributes', 'languages', 'defaultLanguage', 'digitalProductFileTypes', 'digitalProductAuthors', 'publishingHouseList'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'business_type' => 'required|string', // Assuming this is necessary for the supplier
            'main_products' => 'required|string|max:255',
            'management_certification' => 'string|max:255',
            'city_province' => 'required|string|max:255',
            'image1' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image2' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image3' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $userdata = ChatManager::getRoleDetail();
        $userId = $userdata['user_id'];
        $role = $userdata['role'];

        $validatedData['added_by'] = $userId;
        $validatedData['role'] = $role;

        $business_type = Category::find($validatedData['business_type']);

        if ($business_type) {
            $validatedData['business_type'] = $business_type->name;
        } else {
            return response()->json(['message' => 'businees_type not found'], 404);
        }

        // Handle image uploads if applicable
        $images = [];
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("image{$i}")) {
                $images["image{$i}"] = $request->file("image{$i}")->store('suppliers/images', 'public');
            }
        }

        // Create a new supplier record
        Supplier::create(array_merge($validatedData, $images));

        // Redirect or return response
        return redirect()->route('admin.suppliers.list', )->with('success', 'Supplier added successfully.');
    }

    public function getBulkImportView(): View
    {
        return view('admin-views.supplier.bulk-import');
    }

    public function importBulkSupplier(Request $request, SupplierService $service): RedirectResponse
    {
        $userdata = ChatManager::getRoleDetail();
        $user_id = $userdata['user_id'];
        $user_role = $userdata['role'];

        $dataArray = $service->getImportBulkSupplierData(request: $request, addedBy:$user_id,role:$user_role);
        if (!$dataArray['status']) {
            toastr()->error('Check',$dataArray['message']);
            return back();
        }

        // DB::table('suppliers')->insert($dataArray['suppliers']);
        toastr()->success('Successfully Added Suppliers');
        return back();
    }

    public function list(Request $request)
    {
        // Start with the query
        $query = Supplier::query();

        // Apply filters based on the request
        if ($request->filled('business_type')) {
            $query->where('business_type', $request->business_type);
        }

        if ($request->filled('main_products')) {
            $query->where('main_products', 'LIKE', '%' . $request->main_products . '%');
        }

        if ($request->filled('management_certification')) {
            $query->where('management_certification', 'LIKE', '%' . $request->management_certification . '%');
        }

        if ($request->filled('city_province')) {
            $query->where('city_province', 'LIKE', '%' . $request->city_province . '%');
        }

        if ($request->filled('searchValue')) {
            $query->where('name','LIKE','%'.$request->searchValue. '%');
        }

        $suppliers = $query->get();
        $totalsuppliers = $suppliers->count();
        $business_type = Supplier::select('business_type')->distinct()->pluck('business_type');

        // Similar to your original code
        $main_products = Supplier::pluck('main_products')->map(function ($item) {
            return explode(',', $item);
        })->flatten()->unique()->values();

        $management_certification = Supplier::pluck('management_certification')->map(function ($item) {
            return explode(',', $item);
        })->flatten()->unique()->values();

        $city_province = Supplier::pluck('city_province')->map(function ($item) {
            return explode(',', $item);
        })->flatten()->unique()->values();

        $totsupplierspage = Supplier::paginate(10);

        return view(
            'admin-views.supplier.list',
            compact(
                'suppliers',
                'totalsuppliers',
                'main_products',
                'business_type',
                'management_certification',
                'city_province',
                'totsupplierspage'
            )
        );
    }

    public function view($id): View
    {
        $supplier = Supplier::findOrFail($id); // Fetch supplier or throw 404
        return view('admin-views.supplier.view', compact('supplier'));
    }

    public function edit($id): View
    {
        $supplier = Supplier::findOrFail($id); // Fetch supplier or throw 404
        $categories = Category::all(); // Get categories for the edit form
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        $selected_businesstype = Category::where('name', $supplier['business_type'])->first();
        if ($selected_businesstype) {
            $supplier['business_type'] = $selected_businesstype->id;
        }
        return view('admin-views.supplier.edit', compact('supplier', 'categories', 'languages', 'defaultLanguage'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'business_type' => 'required|string',
            'main_products' => 'required|string|max:255',
            'management_certification' => 'nullable|string|max:255',
            'city_province' => 'required|string|max:255',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $business_type = Category::find($validatedData['business_type']);
        if ($business_type) {
            $validatedData['business_type'] = $business_type->name;
        } else {
            return response()->json(['message' => 'business_type not found'], 404);
        }

        // Handle image uploads if applicable
        $images = [];
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("image{$i}")) {
                $images["image{$i}"] = $request->file("image{$i}")->store('suppliers/images', 'public');
            }
        }

        // Update the supplier record
        $supplier = Supplier::findOrFail($id);
        $supplier->update(array_merge($validatedData, $images));

        return redirect()->route('admin.suppliers.view', ['id' => $id])->with('success', 'Supplier updated successfully.');
    }

    public function delete($id): RedirectResponse
    {
        $supplier = Supplier::findOrFail($id); // Fetch supplier or throw 404
        $supplier->delete(); // Delete the supplier

        return redirect()->route('admin.suppliers.list')->with('success', 'Supplier deleted successfully.');
    }
}
