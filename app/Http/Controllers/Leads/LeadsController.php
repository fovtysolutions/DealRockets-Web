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
use Illuminate\Support\Str;
use App\Utils\EmailHelper;
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
    ) {}

    private function validateLeadRequest(Request $request)
    {
        return $request->validate([
            'type' => 'required|string',
            'name' => 'string|max:255',
            'country' => 'required|string',
            'product_id' => 'nullable',
            'company_name' => 'string|max:255',
            'contact_number' => 'nullable|string|max:255',
            'quantity_required' => 'required|string|max:255',
            'buying_frequency' => 'string|max:255',
            'details' => 'required|string|max:1000',
            'industry' => 'required|string|max:255',
            'term' => 'string|max:255',
            'unit' => 'string|max:255',
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
            'sub_category_id' => 'nullable',
            'hs_code' => 'required|string|max:255',
            'rate' => 'required|string|max:255',
            'delivery_terms' => 'nullable|string|max:255',
            'delivery_mode' => 'nullable|string|max:255',
            'place_of_loading' => 'nullable|string|max:255',
            'port_of_loading' => 'nullable|string|max:255',
            'packing_type' => 'nullable|string|max:255',
            'dynamic_data' => 'nullable',
        ]);
    }

    private function totalquotescountry($type, $country)
    {
        $totquotesrecieved = Leads::where('type', $type)->where('country', $country)->get();
        return count($totquotesrecieved);
    }

    public function buyer(Request $request)
    {
        $categoriesn = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        // Filter Countries
        $leadsQuery = Leads::where('type', 'buyer')->where('approved', 1)->where('active', 1)->whereHas('countryRelation', function ($query) {
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
        if ($request->has('industry') && $request->industry) {
            $leadsQuery->where('industry', $request->industry);
        }

        $items = $leadsQuery->paginate(10);

        // Top 20 Countries by quotes recieved
        $countries = Country::all()->pluck('id');

        // Trending Section
        $trending = ChatManager::GetTrendingProducts();

        // Ad Images
        $adSetting = BusinessSetting::where('type', 'buyer')->first();
        $adimages = $adSetting ? json_decode($adSetting->value, true) : [];

        // Buyer Banner Images
        $buyerBannerSetting = BusinessSetting::where('type', 'buyerbanner')->first();
        $buyerbanner = $buyerBannerSetting ? json_decode($buyerBannerSetting->value, true) : [];

        // Banners for Buyers (separate type)
        $bannerBuyersSetting = BusinessSetting::where('type', 'banners_buyers')->first();
        $bannerimages = $bannerBuyersSetting ? json_decode($bannerBuyersSetting->value, true) : [];

        // Quotation Banner
        $quotationSetting = BusinessSetting::where('type', 'quotation')->first();
        $quotationdata = $quotationSetting ? (json_decode($quotationSetting->value, true)['banner'] ?? '') : '';

        if (Auth('customer')->check()) {
            $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
            if (isset($membership['error'])) {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
            }
        } else {
            $membership = ['status' => 'NotMade', 'message' => 'Membership Not Avaliable'];
        }

        // Return the Data to Frontend Page
        return view('leads.buyer', compact('categoriesn', 'membership', 'items', 'countries', 'adimages', 'buyerbanner', 'trending', 'bannerimages', 'quotationdata'));
    }

    public function leadsDynamic(Request $request)
    {
        $query = Leads::query();

        // Always filter by status and type
        $query->where('type', 'buyer')->where('approved', 1)->where('active', 1);

        // Filter by country if necessary
        $query->whereHas('countryRelation', function ($query) {
            $query->whereRaw('blacklist = ?', ['no']);
        });

        if ($request->filled('specific_id')) {
            $query->where('id', $request->input('specific_id'));
        }

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

        // Membership
        if (Auth('customer')->check()) {
            $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
            if (isset($membership['error'])) {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
            }
        } else {
            $membership = ['status' => 'NotMade', 'message' => 'Membership Not Avaliable'];
        }

        // If it's an AJAX request, return only the partial view with trade show cards
        if ($request->ajax()) {
            return response()->json([
                'html' => view('leads.partials.dynamic-buyers', compact('items', 'membership'))->render(),
                'pagination' => $items->links('custom-paginator.custom')->render(),
            ]);
        }

        // Otherwise, return the full page
        return response()->json([
            'html' => view('leads.partials.dynamic-buyers', compact('items', 'membership'))->render(),
            'pagination' => $items->links('custom-paginator.custom')->render(),
        ]);
    }

    public function sellleadsDynamic(Request $request)
    {
        $query = Leads::query();

        // Always filter by status and type
        $query->where('type', 'seller')->where('approved', 1)->where('active', 1);

        // Filter by country if necessary
        $query->whereHas('countryRelation', function ($query) {
            $query->whereRaw('blacklist = ?', ['no']);
        });

        if ($request->filled('specific_id')) {
            $query->where('id', $request->input('specific_id'));
        }

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

        // Membership
        if (Auth('customer')->check()) {
            $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
            if (isset($membership['error'])) {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
            }
        } else {
            $membership = ['status' => 'NotMade', 'message' => 'Membership Not Avaliable'];
        }

        // If it's an AJAX request, return only the partial view with trade show cards
        if ($request->ajax()) {
            return response()->json([
                'html' => view('leads.partials.dynamic-sellleads', compact('items', 'membership'))->render(),
                'pagination' => $items->links('custom-paginator.custom')->render(),
            ]);
        }

        // Otherwise, return the full page
        return response()->json([
            'html' => view('leads.partials.dynamic-sellleads', compact('items', 'membership'))->render(),
            'pagination' => $items->links('custom-paginator.custom')->render(),
        ]);
    }

    public function seller(Request $request)
    {
        $categoriesn = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        // Filter Countries
        $leadsQuery = Leads::where('type', 'seller')->where('approved', 1)->where('active', 1);
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
        if ($request->has('industry') && $request->industry) {
            $leadsQuery->where('industry', $request->industry);
        }

        $items = $leadsQuery->paginate(10);

        // Top 20 Countries by quotes recieved
        $countries = Country::all()->pluck('id');

        // All Industry
        $industries = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();

        // Trending Section
        $trending = ChatManager::GetTrendingProducts();

        // Seller Ad Images
        $sellerAdSetting = BusinessSetting::where('type', 'seller')->first();
        $adimages = $sellerAdSetting ? json_decode($sellerAdSetting->value, true) : [];

        // Seller-Buyer Banner Images
        $sellerBuyerBannerSetting = BusinessSetting::where('type', 'sellers_buyers')->first();
        $bannerimages = $sellerBuyerBannerSetting ? json_decode($sellerBuyerBannerSetting->value, true) : [];

        // Quotation Banner
        $quotationSetting = BusinessSetting::where('type', 'quotation')->first();
        $quotationdata = $quotationSetting ? (json_decode($quotationSetting->value, true)['banner'] ?? '') : '';

        if (Auth('customer')->check()) {
            $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
            if (isset($membership['error'])) {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
            }
        } else {
            $membership = ['status' => 'NotMade', 'message' => 'Membership Not Avaliable'];
        }

        return view('leads.seller', compact('categoriesn', 'membership', 'items', 'countries', 'adimages', 'bannerimages', 'industries', 'trending', 'quotationdata'));
    }

    public function add_new()
    {
        $categories = $this->categoryRepo->getListWhere(filters: ['position' => 0], dataLimit: 'all');
        $brands = $this->brandRepo->getListWhere(dataLimit: 'all');
        $countries = CountrySetupController::getCountries();
        $industry = Category::where('parent_id', '0')->get();
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        return view('admin-views.leads.add-new', compact('items', 'categories', 'countries', 'brands', 'industry'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $this->validateLeadRequest($request);

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

            $validatedData['dynamic_data'] = json_encode($validatedData['dynamic_data'] ?? []);

            // Create a new lead record
            $lead = Leads::create($validatedData);

            $user_id = $userId;
            $role = $role;
            $type = $lead['type']; // 'buyer' or 'seller'

            if ($role === 'admin') {
                $user = Admin::find($user_id);
            } else {
                $user = Seller::find($user_id);
            }

            // Send creation notification
            ChatManager::sendNotification([
                'sender_id'     => $user_id,
                'receiver_id'   => $user_id,
                'receiver_type' => $role,
                'type'          => $type === 'buyer' ? 'buy_lead_created' : 'sale_offer_created',
                'stocksell_id'  => null,
                'leads_id'      => $lead->id,
                'suppliers_id'  => $user_data['vendor_id'] ?? null,
                'product_id'    => null,
                'product_qty'   => null,
                'title'         => $type === 'buyer' ? 'Your Buy Lead Has Been Created' : 'Your Sale Offer Has Been Created',
                'message'       => Str::limit($product->details ?? 'Your listing is now live.', 100),
                'priority'      => 'normal',
                'action_url'    => $type === 'buyer' ? 'buy-leads' : 'sale-offers',
            ]);

            // Send corresponding email
            if ($type === 'buyer') {
                $response = EmailHelper::sendBuyLeadCreatedMail($user, $lead);
            } else {
                $response = EmailHelper::sendSaleOfferCreatedMail($user, $lead);
            }

            // Log failure if needed
            if (!$response['success']) {
                Log::error('Email sending failed for listing creation', [
                    'user_id'    => $user->id,
                    'email'      => $user->email,
                    'error'      => $response['message'] ?? 'Unknown error',
                    'lead_id' => $lead->id,
                    'listing_type' => $type
                ]);
            }

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
            $query->where('details', 'LIKE', '%' . $request->name . '%');
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

        $query->orderBy('posted_date', 'desc');

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
        $industry = Category::where('parent_id', '0')->get();
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $brands = $this->brandRepo->getListWhere(dataLimit: 'all');
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        $name = ChatManager::getproductname($leads->product_id);
        $dynamicData = $leads->dynamic_data;
        return view('admin-views.leads.edit', compact('dynamicData', 'items', 'name', 'leads', 'brands', 'countries', 'categories', 'industry'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $this->validateLeadRequest($request);

            // Get the lead record
            $leads = Leads::findOrFail($id);

            // Perform compliance check
            $complianceStatus = ComplianceService::checkLeadCompliance($validatedData);

            // Add compliance status to the validated data
            $validatedData['compliance_status'] = $complianceStatus;

            // Images the user chose to keep (from form input)
            $keepImages = $request->input('keep_images', []); // default to empty array

            // Current images already saved in DB
            $currentImages = $lead->images ?? []; // default to empty array

            // Ensure both are arrays
            $keepImages = is_array($keepImages) ? $keepImages : [];
            $currentImages = is_array($currentImages) ? $currentImages : [];

            // Delete old images not in the keep list
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
                    $path = $image->storeAs('uploads/leads/images', $filename, 'public'); // saved to storage/app/public/uploads/leads/images
                    $newImages[] = 'storage/' . $path; // convert to public path
                }
            }

            // Update images list
            $validatedData['images'] = array_merge($keepImages, $newImages);

            $validatedData['dynamic_data'] = json_encode($validatedData['dynamic_data'] ?? []);

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

        return redirect()->back()->with('success', 'Lead deleted successfully.');
    }

    public function vadd_new()
    {
        $categories = $this->categoryRepo->getListWhere(filters: ['position' => 0], dataLimit: 'all');
        $brands = $this->brandRepo->getListWhere(dataLimit: 'all');
        $countries = CountrySetupController::getCountries();
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        $industry = Category::where('parent_id', '0')->get();
        return view('vendor-views.leads.add-new', compact('industry', 'items', 'categories', 'countries', 'brands'));
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
        $query->where('role', 'seller');

        // Apply filters based on the request
        $query->where('type', 'seller');

        if ($request->filled('name')) {
            $query->where('details', 'LIKE', '%' . $request->name . '%');
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
        $brands = $this->brandRepo->getListWhere(dataLimit: 'all');
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        $name = ChatManager::getproductname($leads->product_id);
        $countries = CountrySetupController::getCountries();
        $industry = Category::where('parent_id', '0')->get();
        $dynamicData = $leads->dynamic_data;
        return view('vendor-views.leads.edit', compact('brands', 'dynamicData', 'industry', 'items', 'name', 'leads', 'countries', 'categories', 'languages', 'defaultLanguage'));
    }

    public function toggle($id)
    {
        $saleOffer = ChatManager::checksaleofferlimit();
        // if ($saleOffer['status'] == 'failure') {
        //     toastr()->error('Leads Limit Used Up,Edit Current Leads or Delete!');
        //     return redirect()->back()->with('Leads Limit Used Up!');
        // }
        $lead = Leads::findOrFail($id);
        $lead->active = !$lead->active; // Toggle active status
        $lead->save();

        toastr()->success($saleOffer['message']);
        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function approve($id)
    {
        $lead = Leads::findOrFail($id);
        $lead->approved = 1;
        $lead->save();

        toastr()->success('Lead Approved Successfully');
        return redirect()->back();
    }

    public function deny($id)
    {
        $lead = Leads::findOrFail($id);
        $lead->approved = 0;
        $lead->save();

        toastr()->info('Lead Denied Successfully');
        return redirect()->back();
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

    public function searchbycountry($type)
    {
        $type = $type;
        // Total RFQ
        $totalrfq = Leads::where('type', 'buyer')->get();
        $length = count($totalrfq);
        $i = 0;
        $counttotal = 0;
        $countrykeyvaluebuyer = [];
        while ($i < $length) {
            $counttotal += $totalrfq[$i]['quotes_recieved'];
            $countrykeyvaluebuyer[] = [
                'countryid' => $totalrfq[$i]['country'],
                'totquotes' => self::totalquotescountry('buyer', $totalrfq[$i]['country']),
            ];
            $i++;
        }
        // Total RFQ
        $totalrfq = Leads::where('type', 'seller')->get();
        $length = count($totalrfq);
        $i = 0;
        $counttotal = 0;
        $countrykeyvalueseller = [];
        while ($i < $length) {
            $counttotal += $totalrfq[$i]['quotes_recieved'];
            $countrykeyvalueseller[] = [
                'countryid' => $totalrfq[$i]['country'],
                'totquotes' => self::totalquotescountry('buyer', $totalrfq[$i]['country']),
            ];
            $i++;
        }
        return view('leads.countryviewmore', compact('countrykeyvaluebuyer', 'countrykeyvalueseller', 'type'));
    }

    public function buyeradminview()
    {
        return view('vendor-views.Leads.adminbuyerview');
    }

    /**
     * Search HS codes based on query string
     */
    public function searchHsCodes(Request $request)
    {
        $query = $request->get('query', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $csvPath = public_path('db/harmonized-system.csv');
        
        if (!file_exists($csvPath)) {
            return response()->json(['error' => 'HS Code database not found'], 404);
        }

        $results = [];
        $handle = fopen($csvPath, 'r');
        
        if ($handle !== false) {
            // Skip header row
            fgetcsv($handle);
            
            $count = 0;
            $maxResults = 20; // Limit results for performance
            
            while (($data = fgetcsv($handle)) !== false && $count < $maxResults) {
                if (count($data) >= 3) {
                    $hsCode = $data[1]; // hscode column
                    $description = $data[2]; // description column
                    
                    // Search in both HS code and description (case insensitive)
                    if (stripos($hsCode, $query) !== false || stripos($description, $query) !== false) {
                        $results[] = [
                            'hs_code' => $hsCode,
                            'description' => $description,
                            'display' => $hsCode . ' - ' . $description
                        ];
                        $count++;
                    }
                }
            }
            
            fclose($handle);
        }

        return response()->json($results);
    }
}
