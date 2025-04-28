<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\TradeshowService;
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
use App\Utils\CategoryManager;
use App\Models\TradeIndustry;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Tradeshow;
use App\Models\TradeCategory;
use App\Models\Country;
use App\Models\BusinessSetting;
use App\Models\Category;
use App\Utils\ChatManager;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class TradeshowController extends Controller
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
    
    public function index(Request $request)
    {
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        
        $query = Tradeshow::query();
        
        $query->whereHas('countryRelation', function($query) {
            $query->whereRaw('blacklist = ?', ['no']);
        });        

        if ($request->filled('name')) {
            $query->where('description', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->has('country') && is_array($request->country)) {
            $query->whereIn('country', $request->country);
        }

        if ($request->has('industry') && is_array($request->industry)) {
            $query->whereIn('industry', $request->industry);
        }

        $tradeshows = $query->paginate(9);

        $bannerslimit = BusinessSetting::where('type', 'tradeshowbannerrotatingbox')->first();
        $banners = $bannerslimit ? json_decode($bannerslimit->value, true) : [];
        $banners = $banners['tradeshowbannerrotatingbox'];

        $industries = Category::all();
        $countries = Tradeshow::select('country')->distinct()->pluck('country');
        $locations = CountrySetupController::getCountries();
        $featuredTradeshows = Tradeshow::where('featured', '1')->take(6)->get();
        $tophundred = Tradeshow::orderBy('popularity', 'DESC')->take(9)->get();
        $topvenues = Tradeshow::orderBy('popularity', 'DESC')->take(6)->get();
        $topCountries = Tradeshow::select('country', DB::raw('count(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->take(10)
            ->get();
        $featuredOrganizers = Tradeshow::where('featured', '1')->take(10)->get();
        $rotatingbox = json_decode(BusinessSetting::where('type', 'tradeshowrotatingbox')->first()->value, true)['tradeshowrotatingbox'];

        return view('tradeshow.index', compact(
            'categories',
            'topCountries',
            'tradeshows',
            'countries',
            'banners',
            'industries',
            'locations',
            'rotatingbox',
            'featuredTradeshows',
            'tophundred',
            'topvenues',
            'featuredOrganizers'
        ));
    }

    public function detailsview(Request $request, $name, $id)
    {
        $tradeshow = Tradeshow::findOrFail($id);
        $bannerslimit = json_decode(BusinessSetting::where('type', 'tradeshowbannerlimit')->first()->value, true)['tradeshowbannerlimit'];
        $banners = Tradeshow::limit($bannerslimit)->get();
        $industries = TradeCategory::where('active', '1')->get();
        $locations = CountrySetupController::getCountries();
        $related = Tradeshow::orderBy('popularity', 'DESC')
        ->where('country', $tradeshow->country)
        ->where('id', '!=', $id) // Exclude the current tradeshow
        ->take(4)
        ->get();
        return view('tradeshow.detail', compact('tradeshow', 'bannerslimit', 'banners', 'industries', 'locations','related'));
    }

    public function filterview(Request $request, $search, $country, $industry, $company)
    {
        // Required Stuff
        $bannerslimit = json_decode(BusinessSetting::where('type', 'tradeshowbannerlimit')->first()->value, true)['tradeshowbannerlimit'];
        $banners = Tradeshow::limit($bannerslimit)->get();
        $industries = TradeCategory::where('active', '1')->get();
        $locations = CountrySetupController::getCountries();

        // Initialize query
        $query = Tradeshow::query();

        // Filter by text if search is provided
        if (!($search == 'all')) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        // Convert country name to country ID if countryName is provided
        if (!($country == 'all')) {
            // Filter by country if found
            $query->where('country', $country);
        }

        // Filter by industry if provided
        if (!($industry == 'all')) {
            $query->where('industry', $industry);
        }

        // Filter by company if provided
        if (!($company == 'all')){
            $query->where('company_name',$company);
        }

        // Paginate results
        $tradeshows = $query->paginate(15);

        return view('tradeshow.filter', compact('tradeshows', 'banners', 'industries', 'locations'));
    }

    public function dynamicData(Request $request) {

        // Start building the query for Tradeshow
        $query = Tradeshow::query();
        
        // Filter by country if necessary
        $query->whereHas('countryRelation', function($query) {
            $query->whereRaw('blacklist = ?', ['no']);
        });
        
        // Filter by description/name if it's provided
        if ($request->filled('name')) {
            $query->where('description', 'LIKE', '%' . $request->name . '%');
        }
        
        // Filter by country if it's an array of selected countries
        if ($request->has('country') && is_array($request->country)) {
            $query->whereIn('country', $request->country);
        }
        
        // Filter by industry if it's an array of selected industries
        if ($request->has('industry') && is_array($request->industry)) {
            $query->whereIn('industry', $request->industry);
        }
        
        // Get the paginated results (9 per page)
        $tradeshows = $query->paginate(9);
        
        // If it's an AJAX request, return only the partial view with trade show cards
        if ($request->ajax()) {
            return response()->json([
                'html' => view('tradeshow.partials.dynamic-list', compact('tradeshows'))->render(),
                'pagination' => $tradeshows->links('custom-paginator.custom')->render(),
            ]);
        }
    
        // Otherwise, return the full page
        return response()->json([
            'html' => view('tradeshow.partials.dynamic-list', compact('tradeshows'))->render(),
            'pagination' => $tradeshows->links('custom-paginator.custom')->render(),
        ]);
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
        $countries = CountrySetupController::getCountries();
        $industries = TradeCategory::where('active', '1')->get();

        return view('admin-views.tradeshow.add-new', compact('categories', 'industries', 'countries', 'brands', 'brandSetting', 'digitalProductSetting', 'colors', 'attributes', 'languages', 'defaultLanguage', 'digitalProductFileTypes', 'digitalProductAuthors', 'publishingHouseList'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'company_name' => 'required|string',
            'hall' => 'required|string|max:255',
            'stand' => 'required|string',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'website' => 'required|string|max:255',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate images
            'industry' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'company_icon' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'featured' => 'required',
            'popularity' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'timeline' => 'nullable|string', // Validate the timeline as a string
        ]);

        // Parse the timeline into JSON format
        $validatedData['timeline'] = $request->has('timeline') ? json_encode(explode("\n", $request->timeline)) : null;

        // Get user details
        $userdata = ChatManager::getRoleDetail();
        $userId = $userdata['user_id'] ?? null;
        $role = $userdata['role'] ?? null;

        // Set additional data
        $validatedData['role'] = $role;
        $validatedData['added_by'] = $userId;

        // Handle file uploads
        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('tradeshow', 'public');
                $imagePaths[] = $path; // Store each image path
            }
        }

        if ($request->hasFile('company_icon')) {
            $cicon = $request->file('company_icon');
            $cpath = $cicon->store('tradeshow', 'public');
        }

        // Create a new tradeshow record with images
        Tradeshow::create(array_merge($validatedData, ['image' => json_encode($imagePaths)], ['company_icon' => $cpath]));

        // Redirect or return response
        return redirect()->route('admin.tradeshow.list')->with('success', 'Tradeshow added successfully.');
    }

    public function getBulkImportView()
    {
        return view('admin-views.tradeshow.bulk-import');
    }

    public function importTradeshow(Request $request, TradeshowService $service)
    {
        $userdata = ChatManager::getRoleDetail();
        $user_id = $userdata['user_id'];
        $user_role = $userdata['role'];

        $dataArray = $service->getImportTradeShowService($request, $user_id, $user_role);
        if (!$dataArray['status']) {
            toastr()->error($dataArray['message']);
            return back();
        }

        // $this->productRepo->addArray(data: $dataArray['products']);
        toastr()->success(message: 'Tradeshows Imported Successfully');
        return back();
    }

    public function list(Request $request)
    {
        // Start with the query
        $query = Tradeshow::query();

        // Apply filters based on the request
        if ($request->filled('company_name')) {
            $query->where('company_name', $request->company_name);
        }

        if ($request->filled('hall')) {
            $query->where('hall', 'LIKE', '%' . $request->hall . '%');
        }

        if ($request->filled('stand')) {
            $query->where('stand', 'LIKE', '%' . $request->stand . '%');
        }

        if ($request->filled('address')) {
            $query->where('address', 'LIKE', '%' . $request->address . '%');
        }

        if ($request->filled('searchValue')) {
            $query->where('name', 'LIKE', '%' . $request->searchValue . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'LIKE', '%' . $request->city . '%');
        }

        if ($request->filled('country')) {
            $query->where('country', 'LIKE', '%' . $request->country . '%');
        }

        if ($request->filled('description')) {
            $query->where('description', 'LIKE', '%' . $request->description . '%');
        }

        if ($request->filled('website')) {
            $query->where('website', 'LIKE', '%' . $request->website . '%');
        }

        $tradeshows = $query->get();
        $totalTradeshows = $tradeshows->count();
        $totaltradeshowpage = Tradeshow::paginate(10);
        $name = Tradeshow::select('name')->distinct()->pluck('name');
        $company_name = Tradeshow::select('company_name')->distinct()->pluck('company_name');
        $hall = Tradeshow::select('hall')->distinct()->pluck('hall');
        $stand = Tradeshow::select('stand')->distinct()->pluck('stand');
        $address = Tradeshow::select('address')->distinct()->pluck('address');
        $city = Tradeshow::select('city')->distinct()->pluck('city');
        $country = Tradeshow::select('country')->distinct()->pluck('country');
        $description = Tradeshow::select('description')->distinct()->pluck('description');
        $website = Tradeshow::select('website')->distinct()->pluck('website');

        return view(
            'admin-views.tradeshow.list',
            compact(
                'tradeshows',
                'totalTradeshows',
                'name',
                'company_name',
                'hall',
                'stand',
                'address',
                'city',
                'country',
                'description',
                'website',
                'totaltradeshowpage',
            )
        );
    }

    public function view($id)
    {
        $tradeshow = Tradeshow::findOrFail($id);
        return view('admin-views.tradeshow.view', compact('tradeshow'));
    }

    public function edit($id)
    {
        $tradeshow = Tradeshow::findOrFail($id);
        $categories = Category::all();
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $languages = [
            $languages[0]
        ];
        $defaultLanguage = $languages[0];
        $countries = CountrySetupController::getCountries();
        $industries = TradeCategory::where('active', '1')->get();
        return view('admin-views.tradeshow.edit', compact('tradeshow', 'industries', 'countries', 'categories', 'languages', 'defaultLanguage'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'company_name' => 'required|string',
            'hall' => 'required|string|max:255',
            'stand' => 'required|string',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'website' => 'required|string|max:255',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:10248', // Validate images
            'industry' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'company_icon' => 'image|mimes:jpeg,png,jpg|max:10248',
            'featured' => 'required',
            'popularity' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'timeline' => 'nullable|string', // Validate the timeline as a string
        ]);

        // Find the existing tradeshow record
        $tradeshow = Tradeshow::findOrFail($id);

        // Parse the timeline into JSON format
        $validatedData['timeline'] = $request->has('timeline') ? json_encode(explode("\n", $request->timeline)) : $tradeshow->timeline;

        // Handle file uploads for images
        $imagePaths = json_decode($tradeshow->image, true) ?? []; // Existing images

        // Remove images that were deleted on the frontend
        if ($request->filled('removed_images')) {
            $removedImages = json_decode($request->removed_images, true);
            $imagePaths = array_diff($imagePaths, $removedImages);

            // Optionally, delete the removed images from storage
            // foreach ($removedImages as $removedImage) {
            //     \Storage::disk('public')->delete($removedImage);
            // }
        }

        // Add new images
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('tradeshow', 'public');
                $imagePaths[] = $path; // Add new image paths
            }
        }

        // Handle company_icon file upload
        $cpath = $tradeshow->company_icon;
        if ($request->hasFile('company_icon')) {
            // Ensure that a new file is uploaded
            $cicon = $request->file('company_icon');
            $cpath = $cicon->store('tradeshow', 'public'); // Store the new file
        }

        // Update the tradeshow record with the new data
        $tradeshow->update(array_merge($validatedData, [
            'image' => json_encode(array_values($imagePaths)),
            'company_icon' => $cpath // Update company_icon path
        ]));

        return redirect()->route('admin.tradeshow.view', ['id' => $id])->with('success', 'Tradeshow updated successfully.');
    }

    public function delete($id)
    {
        $tradeshow = Tradeshow::findOrFail($id); // Fetch supplier or throw 404
        $tradeshow->delete(); // Delete the lead

        return redirect()->route('admin.tradeshow.list')->with('success', 'Trade Show deleted successfully.');
    }

    public function catindex()
    {
        try {
            // Display all job categories
            $categories = TradeCategory::all();
            return view('admin-views.tradeshow.category_management.list', compact('categories'));
        } catch (QueryException $e) {
            // Catch any database related errors and show a message
            toastr()->error('Error fetching categories: ' . $e->getMessage());
            return redirect()->route('admin.tradeshow.category.list');
        }
    }

    public function catcreate()
    {
        try {
            // Show the form to create a new job category
            return view('admin-views.tradeshow.category_management.add');
        } catch (\Exception $e) {
            toastr()->error('Error loading the category creation form: ' . $e->getMessage());
            return redirect()->route('admin.tradeshow.category.list');
        }
    }

    public function catstore(Request $request)
    {
        try {
            // Validate and store the new job category
            $request->validate([
                'name' => 'required|string|max:255',
                'active' => 'required|in:1,0',
            ]);

            TradeCategory::create($request->all());

            toastr()->success('Category Successfully Created');
            return redirect()->route('admin.tradeshow.category.list')
                ->with('success', 'Job Category created successfully.');
        } catch (QueryException $e) {
            // Catch database-related errors during create operation
            toastr()->error('Error creating category: ' . $e->getMessage());
            return redirect()->route('admin.tradeshow.category.list');
        } catch (\Exception $e) {
            // Catch general errors
            toastr()->error('Unexpected error: ' . $e->getMessage());
            return redirect()->route('admin.tradeshow.category.list');
        }
    }

    public function catupdate(Request $request, TradeCategory $tradeCategory)
    {
        try {
            // Validate and update the job category
            $request->validate([
                'name' => 'required|string|max:255',
                'active' => 'required|in:1,0',
            ]);

            $tradeCategory->update($request->all());

            toastr()->success('Category Successfully Updated');
            return redirect()->route('admin.tradeshow.category.list')
                ->with('success', 'Job Category updated successfully.');
        } catch (QueryException $e) {
            // Catch database-related errors during update operation
            toastr()->error('Error updating category: ' . $e->getMessage());
            return redirect()->route('admin.tradeshow.category.list');
        } catch (\Exception $e) {
            // Catch general errors
            toastr()->error('Unexpected error: ' . $e->getMessage());
            return redirect()->route('admin.tradeshow.category.list');
        }
    }

    public function catdestroy(TradeCategory $tradeCategory)
    {
        try {
            // Delete the job category
            $tradeCategory->delete();

            toastr()->success('Category Successfully Deleted');
            return redirect()->route('admin.tradeshow.category.list')
                ->with('success', 'Job Category deleted successfully.');
        } catch (QueryException $e) {
            // Catch database-related errors during delete operation
            toastr()->error('Error deleting category: ' . $e->getMessage());
            return redirect()->route('admin.tradeshow.category.list');
        } catch (\Exception $e) {
            // Catch general errors
            toastr()->error('Unexpected error: ' . $e->getMessage());
            return redirect()->route('admin.tradeshow.category.list');
        }
    }
}
