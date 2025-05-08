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
    private function totalquotescountry(){
        $totquotesrecieved = StockSell::all();
        return count($totquotesrecieved);
    }

    private function totalquotescountryt($country){
        $totquotesrecieved = StockSell::where('country',$country)->get();
        return count($totquotesrecieved);
    }

    public function index(Request $request)
    {
        $query = StockSell::query();
        $categoriesn = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();

        $location = $request->get('country');
        $time = $request->get('time');
        $categoryId = $request->get('categoryid');

        // Always filter by active status
        $query->where('status', 'active');

        // Filter by country if necessary
        $query->whereHas('countryRelation', function($query) {
            $query->whereRaw('blacklist = ?', ['no']);
        });

        // Text search
        if ($request->filled('search_query')) {
            $query->where('name', 'LIKE', '%' . $request->input('search_query') . '%');
        }

        // Apply filters based on URL parameters

        if ($categoryId){
            $query->where('industry',$categoryId);
        }

        if ($time) {
            // Time filter logic
            $date = now()->subDays($time); // Subtract the number of days based on the selected time range
            $query->whereDate('created_at', '>=', $date);
        }

        if ($request->has('country') && $request->country) {
            $query->whereIn('country', [(int) $request->country]);
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

        $stocksell = StockSell::where('id',$firstId)->first();

        // Ad Images
        $adimages = BusinessSetting::where('type', 'stocksale')->first();
        $adimages = json_decode($adimages['value'], true);

        // Banner Images
        $stocksalebanner = BusinessSetting::where('type', 'stocksalebanner')->first();
        $stocksalebanner = json_decode($stocksalebanner['value'], true);

        $counttotal = self::totalquotescountry();

        $totalrfq = StockSell::all();
        $length = count($totalrfq);
        $i = 0;
        $countrykeyvalue = [];
        while($i < $length){
            $counttotal += $totalrfq[$i]['quotes_recieved'];
            $countrykeyvalue[] = [
                'countryid' => $totalrfq[$i]['country'],
                'totquotes' => self::totalquotescountryt($totalrfq[$i]['country']),
            ];
            $i++;
        }

        // Top 20 Countries by quotes recieved
        $countries = StockSell::orderBy('quote_recieved','DESC')->select('country')->distinct()->pluck('country');

        $locations = StockSell::distinct()->pluck('country');
        $times = StockSell::distinct()->pluck('created_at');

        $trending = ChatManager::GetTrendingProducts();

        $industries =  CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();

        $quotationbanner =  BusinessSetting::where('type','quotation')->first()->value;
        $quotationdata = json_decode($quotationbanner,true)['banner'] ?? '';
        $stocktype = StockCategory::where('active',1)->get();
        return view('web.stocksale', compact('industries','stocktype','items','categoriesn','adimages','locations','times','stocksalebanner','counttotal','countrykeyvalue','countries','trending','stocksell'));
    }

    public function stockSaleDynamic(Request $request){
        $query = StockSell::query();

        // Always filter by active status
        $query->where('status', 'active');

        // Filter by country if necessary
        $query->whereHas('countryRelation', function($query) {
            $query->whereRaw('blacklist = ?', ['no']);
        });

        // Text search
        if ($request->filled('search_query')) {
            $query->where('name', 'LIKE', '%' . $request->input('search_query') . '%');
        }

        // Filter by industry if it's an array of selected industries
        if ($request->has('industry') && is_array($request->industry)) {
            $query->whereIn('industry', $request->industry);
        }

        // Filter by country if it's an array of selected countries
        if ($request->has('country') && is_array($request->country)) {
            $query->whereIn('country', $request->country);
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

    public function stocksaleDynamicView(Request $request){
        $stocksell_id = $request->input('id');
        if($stocksell_id){
            $stocksell = StockSell::where('id',$stocksell_id)->first();
            if($stocksell){
                return response()->json([
                    'status' => 'success',
                    'html' => view('web.dynamic-partials.dynamic-stocksellview', compact('stocksell'))->render(),
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

    public function stocksaleview(Request $request){
        // Get Lead by Id
        $leadrequest = StockSell::where('id',$request->id)->first();

        // Total RFQ
        $totalrfq = StockSell::all();
        $length = count($totalrfq);
        $i = 0;
        $counttotal = 0;
        while($i < $length){
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

        $quotationbanner =  BusinessSetting::where('type','quotation')->first()->value;
        $quotationdata = json_decode($quotationbanner,true)['banner'] ?? '';
        
        // Return Buyer View Page
        return view('web.stocksaleview',compact('adimages','quotationdata','stocksalebanner','counttotal','leadrequest','shopName','role'));
    }

    public function getDataOfStock($id){
        $data = StockSell::where('id',$id)->first();
        $data->industry = StockCategory::where('id',$data->industry)->first()->name;
        $stockdata = Product::where('id',$data->product_id)->first();
        $stockdata->origin = Country::where('id',$stockdata->origin)->first()->name;
        if ($data->role == 'admin'){
            $userdata = Admin::where('id',$data->user_id)->first();
        } else if ($data->role == 'seller') {
            $userdata = Seller::where('id',$data->user_id)->first();
        } else {
            $userdata = User::where('id',$data->user_id)->first();
        }
        $response = [
            'job_data' => $data,
            'stock_data' => $stockdata,
            'user_data' => $userdata,
        ];
        return response()->json($response);
    }   
}
