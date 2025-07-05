<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StockCategory;
use App\Models\StockSell;
use App\Models\Product;
use App\Models\User;
use App\Models\Admin;
use App\Utils\ChatManager;
use App\Models\Seller;
use App\Utils\CategoryManager;
use App\Models\BusinessSetting;
use App\Models\Country;
use Illuminate\Http\Request;

class StocksalewebController extends Controller
{
    private function totalquotescountry()
    {
        $totquotesrecieved = StockSell::all();
        return count($totquotesrecieved);
    }

    private function totalquotescountryt($country)
    {
        $totquotesrecieved = StockSell::where('country', $country)->get();
        return count($totquotesrecieved);
    }

    public function index(Request $request)
    {
        // Initialize the query for StockSell
        $query = StockSell::query();
        $categoriesn = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();

        $location = $request->get('country');
        $time = $request->get('time');
        $categoryId = $request->get('categoryid');

        // Always filter by active status
        $query->where('status', 'active');
        $query->whereHas('countryRelation', function ($query) {
            $query->whereRaw('blacklist = ?', ['no']);
        });

        // Filter by text search if available
        if ($request->filled('search_query')) {
            $search = $request->input('search_query');

            $query->where(function ($q) use ($search) {
                // Match directly if user saved a product name
                $q->where('name', 'LIKE', '%' . $search . '%');

                // Or if product_id is an actual product reference
                $q->orWhereHas('product', function ($sub) use ($search) {
                    $sub->where('name', 'LIKE', '%' . $search . '%');
                });
            });
        }

        // Apply filters based on URL parameters
        if ($categoryId) {
            $query->where('industry', $categoryId);
        }

        if ($time) {
            $date = now()->subDays($time); // Subtract days based on time range
            $query->whereDate('created_at', '>=', $date);
        }

        if ($request->has('country') && is_array($request->country)) {
            $query->whereIn('origin', $request->country);
        }

        // Date range filter
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('deadline', [$request->input('from'), $request->input('to')]);
        } elseif ($request->filled('from')) {
            $query->whereDate('deadline', '>=', $request->input('from'));
        } elseif ($request->filled('to')) {
            $query->whereDate('deadline', '<=', $request->input('to'));
        }

        // Quantity range filter
        if ($request->filled('minqty') && $request->filled('maxqty')) {
            $query->whereBetween('quantity', [$request->input('minqty'), $request->input('maxqty')]);
        } elseif ($request->filled('minqty')) {
            $query->where('quantity', '>=', $request->input('minqty'));
        } elseif ($request->filled('maxqty')) {
            $query->where('quantity', '<=', $request->input('maxqty'));
        }

        // Paginate the filtered results
        $items = $query->paginate(6);
        $firstId = optional($items->first())->id;

        // Get stocksell and other data (eager loading if necessary)
        $setting = BusinessSetting::where('type', 'stocksale')->first();
        $adimages = $setting ? json_decode($setting->value, true) : [];

        // $stocksalebanner = BusinessSetting::where('type', 'stocksalebanner')->first();
        // $stocksalebanner = json_decode($stocksalebanner->value, true);

        // Top 20 Countries by quotes received
        $countries = StockSell::orderBy('quote_recieved', 'DESC')
            ->select('country')
            ->distinct()
            ->pluck('country');

        // Retrieve distinct locations and times
        $locations = StockSell::distinct()->pluck('country');
        $times = StockSell::distinct()->pluck('created_at');

        // Trending products
        $trending = ChatManager::GetTrendingProducts();

        // Get industries for the dropdown
        $industries = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();

        // Quotation banner
        $quotationdata = optional(BusinessSetting::where('type', 'quotation')->first())
            ->value ? (json_decode(optional(BusinessSetting::where('type', 'quotation')->first())->value, true)['banner'] ?? '') : '';

        // Get active stock categories
        $stocktype = StockCategory::where('active', 1)->get();

        if (Auth('customer')->check()) {
            $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
            if (isset($membership['error'])) {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
            }
        } else {
            $membership = ['status' => 'NotMade', 'message' => 'Membership Not Avaliable'];
        }

        // Return the view with compacted data
        return view('web.stocksale', compact(
            'industries',
            'stocktype',
            'membership',
            'items',
            'categoriesn',
            'adimages',
            'locations',
            'times',
            'countries',
            'trending',
        ));
    }

    public function stockSaleDynamic(Request $request)
    {
        $query = StockSell::query();

        // Always filter by active status
        $query->where('status', 'active');

        // Filter by country if necessary
        $query->whereHas('countryRelation', function ($query) {
            $query->whereRaw('blacklist = ?', ['no']);
        });

        if ($request->filled('specific_id')) {
            $query->where('id', $request->input('specific_id'));
        }

        // Text search
        if ($request->filled('search_query')) {
            $search = $request->input('search_query');

            $query->where(function ($q) use ($search) {
                // Match directly if user saved a product name
                $q->where('name', 'LIKE', '%' . $search . '%');

                // Or if product_id is an actual product reference
                $q->orWhereHas('product', function ($sub) use ($search) {
                    $sub->where('name', 'LIKE', '%' . $search . '%');
                });
            });
        }

        // Filter by industry if it's an array of selected industries
        if ($request->has('industry') && is_array($request->industry)) {
            $query->whereIn('industry', $request->industry);
        }

        // Filter by country if it's an array of selected countries
        if ($request->has('country') && is_array($request->country)) {
            $query->whereIn('origin', $request->country);
        }

        $page = $request->get('page', 1);

        // Paginate the filtered results
        $items = $query->paginate(6, ['*'], 'page', $page);

        // If it's an AJAX request, return only the partial view with trade show cards
        if ($request->ajax()) {
            return response()->json([
                'html' => view('web.dynamic-partials.dynamic-stocksell', compact('items'))->render(),
                'pagination' => $items->links('custom-paginator.custom')->render(),
            ]);
        }

        // Otherwise, return the full page
        return response()->json([
            'html' => view('web.dynamic-partials.dynamic-stocksell', compact('items'))->render(),
            'pagination' => $items->links('custom-paginator.custom')->render(),
        ]);
    }

    public function stocksaleDynamicView(Request $request)
    {
        $stocksell_id = $request->input('id');
        if ($stocksell_id) {
            $stocksell = StockSell::where('id', $stocksell_id)->first();
            if (Auth('customer')->check()) {
                $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
                if (isset($membership['error'])) {
                    $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
                }
            } else {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Avaliable'];
            }
            if ($stocksell) {
                return response()->json([
                    'status' => 'success',
                    'html' => view('web.dynamic-partials.dynamic-stocksellview', compact('stocksell', 'membership'))->render(),
                ]);
            }
            return response()->json([
                'status' => 'fail',
            ]);
        }
        return response()->json([
            'status' => 'fail',
        ]);
    }

    public function stocksaleview(Request $request)
    {
        // Get Lead by Id
        $leadrequest = StockSell::where('id', $request->id)->first();

        // Total RFQ
        $totalrfq = StockSell::all();
        $length = count($totalrfq);
        $i = 0;
        $counttotal = 0;
        while ($i < $length) {
            $counttotal += $totalrfq[$i]['quote_recieved'];
            $i++;
        }

        // Shop Details for Chat
        $addedby = $leadrequest->added_by;
        $role = $leadrequest->role;
        if ($role == 'seller') {
            $shopName = Shop::where('seller_id', $addedby)->first()->name;
        }
        if ($role == 'admin') {
            $shopName = 'XYZ Store';
        }

        // Ad Images
        $adimages = BusinessSetting::where('type', 'stocksale')->first();
        $adimages = json_decode($adimages['value'], true);

        // Banner Images
        $stocksalebanner = BusinessSetting::where('type', 'stocksalebanner')->first();
        $stocksalebanner = json_decode($stocksalebanner['value'], true);

        $quotationbanner =  BusinessSetting::where('type', 'quotation')->first()->value;
        $quotationdata = json_decode($quotationbanner, true)['banner'] ?? '';

        // Return Buyer View Page
        return view('web.stocksaleview', compact('adimages', 'quotationdata', 'stocksalebanner', 'counttotal', 'leadrequest', 'shopName', 'role'));
    }

    public function getDataOfStock($id)
    {
        $data = StockSell::where('id', $id)->first();
        $data->industry = StockCategory::where('id', $data->industry)->first()->name;
        $stockdata = Product::where('id', $data->product_id)->first();
        $stockdata->origin = Country::where('id', $stockdata->origin)->first()->name;
        if ($data->role == 'admin') {
            $userdata = Admin::where('id', $data->user_id)->first();
        } else if ($data->role == 'seller') {
            $userdata = Seller::where('id', $data->user_id)->first();
        } else {
            $userdata = User::where('id', $data->user_id)->first();
        }
        $response = [
            'job_data' => $data,
            'stock_data' => $stockdata,
            'user_data' => $userdata,
        ];
        return response()->json($response);
    }
}
