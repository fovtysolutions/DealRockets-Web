<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use App\Utils\CategoryManager;
use Illuminate\Http\Request;
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
use App\Http\Controllers\Admin\Settings\CountrySetupController;
use App\Models\Leads;
use App\Services\LeadService;
use App\Services\ComplianceService; // Import the ComplianceService
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Category;
use App\Models\Admin;
use App\Models\Seller;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Review;
use App\Utils\ProductManager;
use App\Models\Brand;
use App\Models\BusinessSetting;
use App\Utils\ChatManager;
use App\Models\Country;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class LeadsController extends Controller
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepo,
        private readonly DigitalProductAuthorRepositoryInterface $digitalProductAuthorRepo,
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
    ) {
    }

    private function totalquotescountry($type,$country){
        $totquotesrecieved = Leads::where('type',$type)->where('country',$country)->get();
        return count($totquotesrecieved);
    }

    public function buyer(Request $request)
    {
        $categoriesn = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        // Filter Countries
        $leadsQuery = Leads::where('type', 'buyer')->whereHas('countryRelation', function ($query) {
            $query->where('blacklist', 'no');
        });

        // Filter Section
        if ($request->has('from') && $request->from) {
            $leadsQuery->where('posted_date', '>=', $request->from);
        }
        if ($request->has('to') && $request->to) {
            $leadsQuery->where('posted_date', '<=', $request->to);
        }
        if ($request->has('countries') && $request->countries) {
            $leadsQuery->whereIn('country', $request->countries);
        }
        if ($request->has('country') && $request->country) {
            $leadsQuery->whereIn('country', [(int) $request->country]);
        }
        if ($request->has('search_query') && $request->search_query) {
            $leadsQuery->where('name', 'LIKE', '%' . $request->search_query . '%');
        }
        if ($request->has('industry') && $request->industry){
            $leadsQuery->where('industry',$request->industry);
        }
        $leads = $leadsQuery->paginate(10);
        $combinedLeads = [];
        foreach ($leads as $lead) {
            $addedby = $lead->added_by;
            $role = $lead->role;
            if ($role == 'seller') {
                $shopName = Shop::where('seller_id', $addedby)->first()->name;
            }
            if ($role == 'admin') {
                $shopName = 'XYZ Store';
            }
            $combinedLeads[] = [
                'leads' => $lead,
                'shop' => [
                    'added_by' => $addedby,
                    'role' => $role,
                    'shop_name' => $shopName,
                ],
            ];
        }

        // Make a Paginator
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $itemsForCurrentPage = array_slice($combinedLeads, $offset, $perPage);

        $combinedLeadsPaginator = new LengthAwarePaginator($itemsForCurrentPage, count($combinedLeads), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Top 20 Countries by quotes recieved
        $countries = Leads::where('type', 'buyer')->orderBy('quotes_recieved','DESC')->select('country')->distinct()->pluck('country');

        // Trending Section
        $trending = ChatManager::GetTrendingProducts();

        // Ad Images
        $adimages = BusinessSetting::where('type', 'buyer')->first();
        $adimages = json_decode($adimages['value'], true);

        // Banner Images
        $buyerbanner = BusinessSetting::where('type', 'buyerbanner')->first();
        $buyerbanner = json_decode($buyerbanner['value'], true);

        // Banner Buyers
        $buyerbanner = BusinessSetting::where('type', 'banners_buyers')->first();
        $bannerimages = $buyerbanner ? json_decode($buyerbanner->value, true) : [];

        $quotationbanner =  BusinessSetting::where('type','quotation')->first()->value;
        $quotationdata = json_decode($quotationbanner,true)['banner'] ?? '';

        $items = Leads::where('type','buyer')->get();

        // Return the Data to Frontend Page
        return view('leads.buyer', compact('categoriesn', 'leads', 'items', 'combinedLeads', 'countries', 'adimages', 'buyerbanner','combinedLeadsPaginator','trending','bannerimages','quotationdata'));
    }

    public function leadsDynamic(Request $request){
        $query = Leads::query();

        // Always filter by active status
        $query->where('type','buyer');

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
                'html' => view('leads.partials.dynamic-buyers', compact('items'))->render(),
                'pagination' => $items->links('custom-paginator.custom')->render(),
            ]);
        }
    
        // Otherwise, return the full page
        return response()->json([
            'html' => view('leads.partials.dynamic-buyers', compact('items'))->render(),
            'pagination' => $items->links('custom-paginator.custom')->render(),
        ]);
    }

    public function buyerview(Request $request){
        // Get Lead by Id
        $leadrequest = Leads::where('id',$request->id)->first();

        // Total RFQ
        $totalrfq = Leads::where('type','buyer')->get();
        $length = count($totalrfq);
        $i = 0;
        $counttotal = 0;
        while($i < $length){
            $counttotal += $totalrfq[$i]['quotes_recieved'];
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
        $adimages = BusinessSetting::where('type', 'buyer')->first();
        $adimages = json_decode($adimages['value'], true);

        // Banner Images
        $buyerbanner = BusinessSetting::where('type', 'buyerbanner')->first();
        $buyerbanner = json_decode($buyerbanner['value'], true);

        // Banner Buyers
        $buyerbanner = BusinessSetting::where('type', 'banners_buyers')->first();
        $bannerimages = $buyerbanner ? json_decode($buyerbanner->value, true) : [];
        
        $quotationbanner =  BusinessSetting::where('type','quotation')->first()->value;
        $quotationdata = json_decode($quotationbanner,true)['banner'] ?? '';

        // Return Buyer View Page
        return view('leads.buyerview',compact('adimages','buyerbanner','counttotal','leadrequest','shopName','role','bannerimages'));
    }

    public function seller(Request $request)
    {
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        // Filter Countries
        $leadsQuery = Leads::where('type', 'seller');
        // Filter Section
        if ($request->has('from') && $request->from) {
            $leadsQuery->where('posted_date', '>=', $request->from);
        }
        if ($request->has('to') && $request->to) {
            $leadsQuery->where('posted_date', '<=', $request->to);
        }
        if ($request->has('countries') && $request->countries) {
            $leadsQuery->whereIn('country', $request->countries);
        }
        if ($request->has('country') && $request->country) {
            $leadsQuery->whereIn('country', [(int) $request->country]);
        }
        if ($request->has('search_query') && $request->search_query) {
            $leadsQuery->where('name', 'LIKE', '%' . $request->search_query . '%');
        }
        if ($request->has('industry') && $request->industry){
            $leadsQuery->where('industry',$request->industry);
        }
        $leads = $leadsQuery->paginate(10);
        $combinedLeads = [];
        foreach ($leads as $lead) {
            $addedby = $lead->added_by;
            $role = $lead->role;
            if ($role == 'seller') {
                $shopName = Shop::where('seller_id', $addedby)->first()->name;
            }
            if ($role == 'admin') {
                $shopName = 'XYZ Store';
            }
            $combinedLeads[] = [
                'leads' => $lead,
                'shop' => [
                    'added_by' => $addedby,
                    'role' => $role,
                    'shop_name' => $shopName,
                ],
            ];
        }

        // Make a Paginator
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $itemsForCurrentPage = array_slice($combinedLeads, $offset, $perPage);

        $combinedLeadsPaginator = new LengthAwarePaginator($itemsForCurrentPage, count($combinedLeads), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Top 20 Countries by quotes recieved
        $countries = Leads::where('type', 'seller')->orderBy('quotes_recieved','DESC')->select('country')->distinct()->pluck('country');

        // All Industry
        $industries =  CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();

        // Trending Section
        $trending = ChatManager::GetTrendingProducts();

        // Total RFQ
        $totalrfq = Leads::where('type','seller')->get();
        $length = count($totalrfq);
        $i = 0;
        $counttotal = 0;
        $countrykeyvalue = [];
        while($i < $length){
            $counttotal += $totalrfq[$i]['quotes_recieved'];
            $countrykeyvalue[] = [
                'countryid' => $totalrfq[$i]['country'],
                'totquotes' => self::totalquotescountry('seller',$totalrfq[$i]['country']),
            ];
            $i++;
        }

        // Ad Images
        $adimages = BusinessSetting::where('type', 'seller')->first();
        $adimages = json_decode($adimages['value'], true);

        // Banner Images
        $buyerbanner = BusinessSetting::where('type', 'sellers_buyers')->first();
        $bannerimages = json_decode($buyerbanner['value'], true);

        $quotationbanner =  BusinessSetting::where('type','quotation')->first()->value;
        $quotationdata = json_decode($quotationbanner,true)['banner'] ?? '';

        return view('leads.seller', compact('categories', 'leads', 'combinedLeads', 'countries', 'adimages', 'bannerimages','combinedLeadsPaginator'
            ,'counttotal','countrykeyvalue','industries','trending','quotationdata'));
    }

    public function sellerview(Request $request){
        // Get Lead by Id
        $leadrequest = Leads::where('id',$request->id)->first();

        // Total RFQ
        $totalrfq = Leads::where('type','seller')->get();
        $length = count($totalrfq);
        $i = 0;
        $counttotal = 0;
        while($i < $length){
            $counttotal += $totalrfq[$i]['quotes_recieved'];
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
        $adimages = BusinessSetting::where('type', 'seller')->first();
        $adimages = json_decode($adimages['value'], true);

        // Banner Images
        $buyerbanner = BusinessSetting::where('type', 'sellerbanner')->first();
        $buyerbanner = json_decode($buyerbanner['value'], true);

        // Banner Images
        $buyerbanner = BusinessSetting::where('type', 'sellers_buyers')->first();
        $bannerimages = json_decode($buyerbanner['value'], true);

        // Return Buyer View Page
        return view('leads.sellerview',compact('adimages','buyerbanner','counttotal','leadrequest','shopName','role','bannerimages'));
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
        $languages = [
            $languages[0]
        ];
        $digitalProductFileTypes = ['audio', 'video', 'document', 'software'];
        $digitalProductAuthors = $this->authorRepo->getListWhere(dataLimit: 'all');
        $publishingHouseList = $this->publishingHouseRepo->getListWhere(dataLimit: 'all');
        $countries = CountrySetupController::getCountries();
        $industries = Category::where('parent_id', '0')->get();
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        return view('admin-views.leads.add-new', compact('items','categories', 'countries', 'brands', 'brandSetting', 'digitalProductSetting', 'colors', 'attributes', 'languages', 'defaultLanguage', 'digitalProductFileTypes', 'digitalProductAuthors', 'publishingHouseList', 'industries'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'type' => 'required|string',
                'name' => 'required|string|max:255',
                'country' => 'required|string',
                'product_id' => 'required',
                'company_name' => 'string|max:255',
                'contact_number' => 'required|string|max:255',
                'quantity_required' => 'required|string|max:255',
                'buying_frequency' => 'required|string|max:255',
                'details' => 'required|string|max:1000', // Adjust max length if necessary
                'industry' => 'required|string|max:255',
                'term' => 'required|string|max:255',
                'unit' => 'required|string|max:255',
                'compliance_status' => 'required',
                'city' => 'nullable|string|max:255',
                'tags' => 'nullable|string|max:255',
                'refund' => 'nullable|string|max:255',
                'avl_stock' => 'nullable|string|max:255',
                'avl_stock_unit' => 'nullable|string|max:255',
                'lead_time' => 'nullable|string|max:255',
                'brand' => 'nullable|string|max:255',
                'payment_option' => 'nullable|string|max:255',
                'offer_type' => 'nullable|string|max:255',
                'size' => 'nullable|string|max:255',
                'images' => 'required',
            ]);

            // Get user details
            $userdata = ChatManager::getRoleDetail();
            $userId = $userdata['user_id'] ?? null;
            $role = $userdata['role'] ?? null;

            if ($request->hasFile('images')) {
                $imagePaths = [];
            
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('uploads/leads/images', $filename, 'public'); // stored in storage/app/public/uploads/leads/images
                    $imagePaths[] = 'storage/' . $path; // public path for display
                }
            
                $validatedData['images'] = json_encode($imagePaths);
            }            

            // Set additional data
            $validatedData['role'] = $role;
            $validatedData['added_by'] = $userId;
            $validatedData['posted_date'] = Carbon::now()->toDateString(); // Correct Carbon usage

            // Perform compliance check
            $complianceStatus = ComplianceService::checkLeadCompliance($validatedData);

            // Add compliance status to the validated data
            $validatedData['compliance_status'] = $complianceStatus;

            // Create a new lead record
            Leads::create($validatedData);

            toastr()->success('Lead Added Successfully');

            // Success message
            return redirect()->back()->with('success', 'Lead added successfully.');
        } catch (\Exception $e) {
            // Log the error if needed
            Log::error('Error in storing lead: ' . $e->getMessage());

            toastr()->error('Lead Add Failed');

            // Failure message
            return redirect()->back()->with('error', 'Failed to add lead. Please try again.');
        }
    }

    public function getBulkImportView()
    {
        return view('admin-views.leads.bulk-import');
    }

    public function importBulkLeads(Request $request, LeadService $service)
    {
        $userdata = ChatManager::getRoleDetail();
        $user_id = $userdata['user_id'];
        $user_role = $userdata['role'];

        $dataArray = $service->getImportLeadsService(request: $request, addedBy: $user_id, role: $user_role);
        if (!$dataArray['status']) {
            toastr()->error($dataArray['message']);
            return back();
        }

        // DB::table('leads')->insert($dataArray['leads']);
        toastr()->success(message: 'Leads Imported Successfully');
        return back();
    }

    public function list(Request $request)
    {
        // Start with the query
        $query = Leads::query();

        // Apply filters based on the request
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('country')) {
            $query->where('country', 'LIKE', '%' . $request->country . '%');
        }

        if ($request->filled('company_name')) {
            $query->where('company_name', 'LIKE', '%' . $request->company_name . '%');
        }

        if ($request->filled('searchValue')) {
            $query->where('name', 'LIKE', '%' . $request->searchValue . '%');
        }

        if ($request->filled('contact_number')) {
            $query->where('contact_number', 'LIKE', '%' . $request->contact_number . '%');
        }

        if ($request->filled('posted_date')) {
            $query->where('posted_date', 'LIKE', '%' . $request->posted_date . '%');
        }

        if ($request->filled('quantity_required')) {
            $query->where('quantity_required', 'LIKE', '%' . $request->quantity_required . '%');
        }

        if ($request->filled('buying_frequency')) {
            $query->where('buying_frequency', 'LIKE', '%' . $request->buying_frequency . '%');
        }

        $leads = $query->paginate(10);
        $totalleads = $leads->count();
        $name = Leads::select('name')->distinct()->pluck('name');
        $type = Leads::select('type')->distinct()->pluck('type');
        $country = Leads::select('country')->distinct()->pluck('country');
        $company_name = Leads::select('company_name')->distinct()->pluck('company_name');
        $contact_number = Leads::select('contact_number')->distinct()->pluck('contact_number');
        $posted_date = Leads::select('posted_date')->distinct()->pluck('posted_date');
        $quantity_required = Leads::select('quantity_required')->distinct()->pluck('quantity_required');
        $buying_frequency = Leads::select('buying_frequency')->distinct()->pluck('buying_frequency');

        return view('admin-views.leads.list', compact('leads', 'totalleads', 'name', 'type', 'country', 'company_name', 'contact_number', 'posted_date', 'quantity_required', 'buying_frequency'));
    }

    public function view($id)
    {
        $leads = Leads::findOrFail($id);
        return view('admin-views.leads.view', compact('leads'));
    }

    public function edit($id)
    {
        $leads = Leads::findOrFail($id);
        $categories = Category::all();
        $countries = CountrySetupController::getCountries();
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $industries = Category::where('parent_id', '0')->get();
        $defaultLanguage = $languages[0];
        $languages = [
            $languages[0]
        ];
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        $name = ChatManager::getproductname($leads->product_id);
        return view('admin-views.leads.edit', compact('items','name','leads', 'countries', 'categories', 'languages', 'defaultLanguage', 'industries'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'type' => 'required|string',
                'name' => 'required|string|max:255',
                'country' => 'required|string',
                'product_id' => 'required',
                'company_name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:255',
                'quantity_required' => 'required|string|max:255',
                'buying_frequency' => 'required|string|max:255',
                'details' => 'required|string|max:255',
                'industry' => 'required|string|max:255',
                'term' => 'required|string|max:255',
                'unit' => 'required|string|max:255',
                'compliance_status' => 'required',
                'city' => 'nullable|string|max:255',
                'tags' => 'nullable|string|max:255',
                'refund' => 'nullable|string|max:255',
                'avl_stock' => 'nullable|string|max:255',
                'avl_stock_unit' => 'nullable|string|max:255',
                'lead_time' => 'nullable|string|max:255',
                'brand' => 'nullable|string|max:255',
                'payment_option' => 'nullable|string|max:255',
                'offer_type' => 'nullable|string|max:255',
                'size' => 'nullable|string|max:255',
                'images' => 'nullable',
            ]);

            // Get the lead record
            $leads = Leads::findOrFail($id);

            // Perform compliance check
            $complianceStatus = ComplianceService::checkLeadCompliance($validatedData);

            // Add compliance status to the validated data
            $validatedData['compliance_status'] = $complianceStatus;

            // Images the user chose to keep
            $keepImages = $request->input('keep_images', []);

            // Delete old images not in the keep list
            $currentImages = $lead->images ?? [];
            $imagesToDelete = array_diff($currentImages, $keepImages);

            foreach ($imagesToDelete as $img) {
                // Optionally delete from storage if stored locally
                // Storage::delete(str_replace(url('/storage/'), '', $img));
            }

            // Handle new uploads
            $newImages = [];


            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('uploads/leads/images', $filename, 'public'); // stored in storage/app/public/uploads/leads/images
                    $newImages[] = 'storage/' . $path; // public path for display
                }
            }

            // Update images list
            $validatedData['images'] = array_merge($keepImages, $newImages);    

            // Update the lead record
            $leads->update($validatedData);

            toastr()->success('Lead Updated Successfully');

            return redirect()
                ->back()
                ->with('success', 'Lead updated successfully.');
        } catch (\Exception $e) {
            // Log the error if needed
            Log::error('Error in updating lead: ' . $e->getMessage());

            toastr()->error('Lead Update Failed');

            return redirect()->back()->with('error', 'Failed to update lead. Please try again.');
        }
    }

    public function delete($id)
    {
        $leads = Leads::findOrFail($id); // Fetch supplier or throw 404
        $leads->delete(); // Delete the lead

        return redirect()->route('admin.leads.list')->with('success', 'Supplier deleted successfully.');
    }

    public function vadd_new()
    {
        $categories = $this->categoryRepo->getListWhere(filters: ['position' => 0], dataLimit: 'all');
        $brands = $this->brandRepo->getListWhere(dataLimit: 'all');
        $brandSetting = getWebConfig(name: 'product_brand');
        $digitalProductSetting = getWebConfig(name: 'digital_product');
        $colors = $this->colorRepo->getList(orderBy: ['name' => 'desc'], dataLimit: 'all');
        $attributes = $this->attributeRepo->getList(orderBy: ['name' => 'desc'], dataLimit: 'all');
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        $languages = [
            $languages[0]
        ];
        $digitalProductFileTypes = ['audio', 'video', 'document', 'software'];
        $digitalProductAuthors = $this->authorRepo->getListWhere(dataLimit: 'all');
        $publishingHouseList = $this->publishingHouseRepo->getListWhere(dataLimit: 'all');
        $countries = CountrySetupController::getCountries();
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        $industries = Category::where('parent_id', '0')->get();
        return view('vendor-views.leads.add-new', compact('industries','items','categories', 'countries', 'brands', 'brandSetting', 'digitalProductSetting', 'colors', 'attributes', 'languages', 'defaultLanguage', 'digitalProductFileTypes', 'digitalProductAuthors', 'publishingHouseList'));
    }
    
    public function vgetBulkImportView()
    {
        return view('vendor-views.leads.bulk-import');
    }

    public function vlist(Request $request)
    {
        // Start with the query
        $query = Leads::query();

        // Filter out id field
        $vendorId = auth('seller')->id();

        $query->where('added_by', $vendorId);

        // Apply filters based on the request
        $query->where('type','seller');
        
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('country')) {
            $query->where('country', 'LIKE', '%' . $request->country . '%');
        }

        if ($request->filled('company_name')) {
            $query->where('company_name', 'LIKE', '%' . $request->company_name . '%');
        }

        if ($request->filled('searchValue')) {
            $query->where('name', 'LIKE', '%' . $request->searchValue . '%');
        }

        if ($request->filled('contact_number')) {
            $query->where('contact_number', 'LIKE', '%' . $request->contact_number . '%');
        }

        if ($request->filled('posted_date')) {
            $query->where('posted_date', 'LIKE', '%' . $request->posted_date . '%');
        }

        if ($request->filled('quantity_required')) {
            $query->where('quantity_required', 'LIKE', '%' . $request->quantity_required . '%');
        }

        if ($request->filled('buying_frequency')) {
            $query->where('buying_frequency', 'LIKE', '%' . $request->buying_frequency . '%');
        }

        $leads = $query->paginate(10);
        $name = Leads::select('name')->distinct()->pluck('name');
        $type = Leads::select('type')->distinct()->pluck('type');
        $country = Leads::select('country')->distinct()->pluck('country');
        $company_name = Leads::select('company_name')->distinct()->pluck('company_name');
        $contact_number = Leads::select('contact_number')->distinct()->pluck('contact_number');
        $posted_date = Leads::select('posted_date')->distinct()->pluck('posted_date');
        $quantity_required = Leads::select('quantity_required')->distinct()->pluck('quantity_required');
        $buying_frequency = Leads::select('buying_frequency')->distinct()->pluck('buying_frequency');
        $saleOffer = ChatManager::checksaleofferlimit();
        return view('vendor-views.leads.list', compact('leads', 'name', 'type', 'country', 'company_name', 'contact_number', 'posted_date', 'quantity_required', 'buying_frequency'));
    }

    public function vview($id)
    {
        $leads = Leads::findOrFail($id);
        return view('vendor-views.leads.view', compact('leads'));
    }

    public function vedit($id)
    {
        $leads = Leads::findOrFail($id);
        $categories = Category::all();
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        $languages = [
            $languages[0]
        ];
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        $name = ChatManager::getproductname($leads->product_id);
        $countries = CountrySetupController::getCountries();
        $industries = Category::where('parent_id', '0')->get();
        return view('vendor-views.leads.edit', compact('industries','items','name','leads', 'countries', 'categories', 'languages', 'defaultLanguage'));
    }

    public function toggle($id)
    {
        $saleOffer = ChatManager::checksaleofferlimit();
        if($saleOffer['status'] == 'failure'){
            toastr()->error('Leads Limit Used Up,Edit Current Leads or Delete!');
            return redirect()->back()->with('Leads Limit Used Up!');
        }
        $lead = Leads::findOrFail($id);
        $lead->active = !$lead->active; // Toggle active status
        $lead->save();

        toastr()->success($saleOffer['message']);
        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function getMessages()
    {
        $user_data = ChatManager::getRoleDetail();
        $chats = ChatManager::getMessagersName($user_data, 'leads', 'customer');
        $openchats = [];
        $closechats = [];
        foreach ($chats as $chat) {
            if ($chat['openstatus'] == 0) {
                $closechats[] = $chat;
            } else {
                $openchats[] = $chat;
            }
        }
        return view('admin-views.leads.messages', compact('chats', 'closechats', 'openchats'));
    }

    public function getVendorMessages()
    {
        $user_data = ChatManager::getRoleDetail();
        $chats = ChatManager::getMessagersName($user_data, 'leads', 'customer');
        $openchats = [];
        $closechats = [];
        foreach ($chats as $chat) {
            if ($chat['openstatus'] == 0) {
                $closechats[] = $chat;
            } else {
                $openchats[] = $chat;
            }
        }
        return view('vendor-views.leads.messages', compact('chats', 'closechats', 'openchats'));
    }

    public function searchbycountry($type){
        $type = $type;
        // Total RFQ
        $totalrfq = Leads::where('type','buyer')->get();
        $length = count($totalrfq);
        $i = 0;
        $counttotal = 0;
        $countrykeyvaluebuyer = [];
        while($i < $length){
            $counttotal += $totalrfq[$i]['quotes_recieved'];
            $countrykeyvaluebuyer[] = [
                'countryid' => $totalrfq[$i]['country'],
                'totquotes' => self::totalquotescountry('buyer',$totalrfq[$i]['country']),
            ];
            $i++;
        }
        // Total RFQ
        $totalrfq = Leads::where('type','seller')->get();
        $length = count($totalrfq);
        $i = 0;
        $counttotal = 0;
        $countrykeyvalueseller = [];
        while($i < $length){
            $counttotal += $totalrfq[$i]['quotes_recieved'];
            $countrykeyvalueseller[] = [
                'countryid' => $totalrfq[$i]['country'],
                'totquotes' => self::totalquotescountry('buyer',$totalrfq[$i]['country']),
            ];
            $i++;
        }
        return view('leads.countryviewmore',compact('countrykeyvaluebuyer','countrykeyvalueseller','type'));
    }

    public function buyeradminview(){
        return view('vendor-views.Leads.adminbuyerview');
    }
}
