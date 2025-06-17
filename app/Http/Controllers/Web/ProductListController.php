<?php

namespace App\Http\Controllers\Web;

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
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\Leads;
use App\Models\SearchHistUsers;

class ProductListController extends Controller
{
    private function add_user_search($tag)
    {
        $existing_search = SearchHistUsers::where('user_id', auth('customer')->id())->where('tag', $tag)->first();
        if ($existing_search) {
            $existing_search->count = $existing_search->count + 1;
            $existing_search->save();
            return [
                'status' => 'success'
            ];
        } else {
            $search = new SearchHistUsers();
            // Add Details
            $search->count = 1;
            $search->tag = $tag;
            $search->user_id = auth('customer')->id();
            $search->save();
            return [
                'status' => 'success',
            ];
        }
        return [
            'status' => 'failure',
        ];
    }

    public function getProductsOnSearch(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        if ($type == 'products') {
            $data = Product::where('name', 'LIKE', '%' . $search . '%')->limit(10)->get();
        } else if ($type == 'buyer') {
            $data = Leads::where('type', 'buyer')->where('name', 'LIKE', '%' . $search . '%')->limit(10)->get();
        } else if ($type == 'seller') {
            $data = Leads::where('type', 'seller')->where('name', 'LIKE', '%' . $search . '%')->limit(10)->get();
        } else {
            $data = collect();
        }

        return $data;
    }

    public function search(Request $request)
    {
        $search = $request->q;
        $products = Product::where('name', 'LIKE', "%$search%")
            ->select('id', 'name')
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    public function products(Request $request)
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
            $category = Category::find((int)$request['category_id']);

            if ($category) {
                $data['brand_name'] = $category->name;

                // Load parent category name safely
                $parentCategory = Category::find((int) $category->parent_id);
                $data['cate_name'] = $parentCategory ? $parentCategory->name : null;
            } else {
                $data['brand_name'] = null;
                $data['cate_name'] = null;
            }
        }
        if ($request['data_from'] == 'brand') {
            $brand_data = Brand::active()->find((int)$request['brand_id']);
            if ($brand_data) {
                $data['brand_name'] = $brand_data->name;
            } else {
                Toastr::warning(translate('not_found'));
                return redirect('/');
            }
        }

        $productListData = ProductManager::getProductListData(request: $request);
        $products = $productListData->paginate(20)->appends($data);

        if (auth('customer')->check() && isset($request->searchInput)) {
            self::add_user_search($request->searchInput);
        }

        if ($request->ajax()) {
            return response()->json([
                'total_product' => $products->total(),
                'view' => view('web-views.products._ajax-products', compact('products'))->render()
            ], 200);
        }
        $productsCountries = Product::select('origin')->distinct()->pluck('origin');

        $countries = Country::whereIn('id', $productsCountries)->get();
        if ($request['country']) {
            $products = Product::where('origin', $request['country'])->get();
            $products = $products->paginate(20);
        }

        return view(VIEW_FILE_NAMES['products_view_page'], [
            'products' => $products,
            'data' => $data,
            'activeBrands' => $activeBrands,
            'categories' => $categories,
            'countries' => $countries,
        ]);
    }

    public function dynamicProduct(Request $request, $productAddedBy = null)
    {
        $query = Product::query();

        // Hard Filters

        // Always fetch only active products
        $query->where('status', 1);

        if ($request->filled('productAddedBy')) {
            $query->where('added_by', 'seller');
            $query->where('user_id', $request->input('productAddedBy')); // Use your actual column name here
        }

        // Filter by searchInput (e.g. top search bar)
        if ($request->filled('searchInput')) {
            $query->where('name', 'LIKE', '%' . $request->input('searchInput') . '%');
        }

        // Filter by specific category if explicitly provided
        if ($request->filled('category_id') && is_numeric($request->input('category_id'))) {
            $query->where('category_id', (int) $request->input('category_id'));
        }

        // Ensure only non-blacklisted countries are used
        $query->whereHas('countryRelation', function ($query) {
            $query->where('blacklist', 'no');
        });

        // Soft Filters

        // Text search
        if ($request->filled('search_query')) {
            $query->where('name', 'LIKE', '%' . $request->input('search_query') . '%');
        }

        // Filter by industry if it's an array of selected industries
        if (!$request->filled('category_id') && $request->has('industry') && is_array($request->industry)) {
            $query->whereIn('category_id', $request->industry);
        }

        // Filter by country if it's an array of selected countries
        if ($request->has('country') && is_array($request->country)) {
            $query->whereIn('origin', $request->country);
        }

        $page = $request->get('page', 1);

        // Paginate the filtered results
        $products = $query->paginate(6, ['*'], 'page', $page);

        // If it's an AJAX request, return only the partial view with trade show cards
        if ($request->ajax()) {
            return response()->json([
                'html' => view('web-views.products.partials.dynamic-product-grid', compact('products'))->render(),
                'html2' => view('web-views.products.partials.dynamic-product-list', compact('products'))->render(),
                'pagination' => $products->links('custom-paginator.custom')->render(),
            ]);
        }

        // Otherwise, return the full page
        return response()->json([
            'html' => view('web-views.products.partials.dynamic-product-grid', compact('products'))->render(),
            'html2' => view('web-views.products.partials.dynamic-product-list', compact('products'))->render(),
            'pagination' => $products->links('custom-paginator.custom')->render(),
        ]);
    }

    public function theme_aster($request): View|JsonResponse|Redirector|RedirectResponse
    {
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $activeBrands = BrandManager::getActiveBrandWithCountingAndPriorityWiseSorting();

        $data = self::getProductListRequestData(request: $request);
        if ($request['data_from'] == 'category' && $request['category_id']) {
            $data['brand_name'] = Category::find((int)$request['category_id'])->name;
        }
        if ($request['data_from'] == 'brand') {
            $brandData = Brand::active()->find((int)$request['brand_id']);
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

        return view(VIEW_FILE_NAMES['products_view_page'], [
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
            $brand_data = Brand::active()->find((int)$request['brand_id']);
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

        return view(VIEW_FILE_NAMES['products_view_page'], [
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
            VIEW_FILE_NAMES['products_view_page'],
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
}
