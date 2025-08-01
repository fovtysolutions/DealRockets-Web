<?php

namespace App\Http\Controllers\Web;

use App\Contracts\Repositories\BusinessSettingRepositoryInterface;
use App\Contracts\Repositories\RobotsMetaContentRepositoryInterface;
use App\Events\RefundEvent;
use App\Http\Requests\Web\CustomerProfileUpdateRequest;
use App\Models\SupportTicketConv;
use App\Traits\PdfGenerator;
use App\Utils\Helpers;
use App\Events\OrderStatusEvent;
use App\Http\Controllers\Admin\Settings\CountrySetupController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\DeliveryMan;
use App\Models\DeliveryZipCode;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCompare;
use App\Models\RefundRequest;
use App\Models\Review;
use App\Models\Seller;
use App\Models\ShippingAddress;
use App\Models\SupportTicket;
use App\Models\Wishlist;
use App\Traits\CommonTrait;
use App\Models\User;
use App\Utils\CustomerManager;
use App\Utils\ImageManager;
use App\Utils\OrderManager;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\TableJobProfile;
use App\Models\Vacancies;
use App\Models\Country;
use App\Models\CV;
use App\Models\Favourites;
use Illuminate\Support\Facades\Log;
use App\Models\JobAppliers;
use App\Utils\CategoryManager;
use App\Models\ShortlistCandidates;

class UserProfileController extends Controller
{
    use CommonTrait, PdfGenerator;

    public function __construct(private Order $order, private Seller $seller, private Product $product, private Review $review, private DeliveryMan $deliver_man, private ProductCompare $compare, private Wishlist $wishlist, private readonly BusinessSettingRepositoryInterface $businessSettingRepo, private readonly RobotsMetaContentRepositoryInterface $robotsMetaContentRepo) {}

    public function user_profile(Request $request)
    {
        $wishlists = $this->wishlist
            ->whereHas('wishlistProduct', function ($q) {
                return $q;
            })
            ->where('customer_id', auth('customer')->id())
            ->count();
        $total_order = $this->order->where('customer_id', auth('customer')->id())->count();
        $total_loyalty_point = auth('customer')->user()->loyalty_point;
        $total_wallet_balance = auth('customer')->user()->wallet_balance;
        $addresses = ShippingAddress::where('customer_id', auth('customer')->id())->latest()->get();
        $customer_detail = User::where('id', auth('customer')->id())->first();

        return view(VIEW_FILE_NAMES['user_profile'], compact('customer_detail', 'addresses', 'wishlists', 'total_order', 'total_loyalty_point', 'total_wallet_balance'));
    }

    public function job_panel(Request $request)
    {
        // Get categories for the dropdown
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $countries = CountrySetupController::getCountries();
        $userId = Auth::Guard('customer')->user()->id;
        $userjobs = Vacancies::where('user_id', $userId)->where('Approved', '1')->get();
        $jobs_posted = Vacancies::where('user_id', $userId)->where('Approved', '1')->pluck('id');
        $jobapplys = [];
        foreach ($jobs_posted as $jobs) {
            $jobapplys[] = [
                'jobid' => $jobs,
                'jobname' => Vacancies::where('id', $jobs)->pluck('title')->first(),
                'appliers' => JobAppliers::where('jobid', $jobs)->get(),
            ];
        }
        $shortlistedcanditates = ShortlistCandidates::where('recruiter_id', $userId)->get();
        $candidatesshortlisted = [];
        foreach ($shortlistedcanditates as $candidates) {
            $candidatesshortlisted[] = [
                'jobid' => $candidates->jobid,
                'jobname' => Vacancies::where('id', $candidates->jobid)->pluck('title')->first(),
                'shortlisted' => User::where('id', $candidates->applier_id)->get(),
            ];
        }
        return view('web.jobpanel', compact('countries', 'userjobs', 'categories', 'jobapplys', 'candidatesshortlisted'));
    }

    public function accountjobapplied(Request $request)
    {
        $user = Auth::guard('customer')->user()->id;
        $jobapplies = JobAppliers::where('user_id', $user)->get();
        $applies = [];
        foreach ($jobapplies as $jobapplied) {
            $jobid = $jobapplied->jobid;
            $jobdetails = Vacancies::where('id', $jobapplied->jobid)->first();
            switch ($jobapplied->apply_via) {
                case 'cv':
                    $job_apply_data = CV::where('user_id', $user)->first();
                    $applies[] = [
                        'job_id' => $jobid,
                        'apply_type' => 'cv',
                        'job_data' => $jobdetails->id,
                        'job_apply_form' => '',
                        'job_apply_cv' => $job_apply_data->image_path,
                    ];
                    break;
                case 'form':
                    $job_apply_data = TableJobProfile::where('user_id', $user)->first();
                    $applies[] = [
                        'job_id' => $jobid,
                        'apply_type' => 'form',
                        'job_data' => $jobdetails->id,
                        'job_apply_form' => $job_apply_data->id,
                        'job_apply_cv' => '',
                    ];
                    break;
                default:
                    break;
            }
        }
        return view('web.jobsapplied', compact('applies'));
    }

    public function accountjobprofile(Request $request)
    {
        $user = Auth::guard('customer')->user()->id;
        $profile = TableJobProfile::where('user_id', $user)->first();
        $countries = CountrySetupController::getCountries();

        if ($profile) {
            if (isset($profile->languages)) {
                $profile->languages = json_decode($profile->languages, true);
                $profile->languages = implode(',', $profile->languages);
            }
            if (isset($profile->skills)) {
                $profile->skills = json_decode($profile->skills, true);
                $profile->skills = implode(',', $profile->skills);
            }
            if (isset($profile->preferred_locations)) {
                $profile->preferred_locations = json_decode($profile->preferred_locations, true);
                $profile->preferred_locations = implode(',', $profile->preferred_locations);
            }
            if (isset($profile->references)) {
                $profile->references = json_decode($profile->references, true);
                $profile->references = implode(',', $profile->references);
            }
            if (isset($profile->portfolio_items)) {
                $profile->portfolio_items = json_decode($profile->portfolio_items, true);
                $profile->portfolio_items = implode(',', $profile->portfolio_items);
            }
            if (isset($profile->videos)) {
                $profile->videos = json_decode($profile->videos, true);
                $profile->videos = implode(',', $profile->videos);
            }
            if (isset($profile->previous_employers)) {
                $profile->previous_employers = json_decode($profile->previous_employers, true);
                $profile->previous_employers = implode(',', $profile->previous_employers);
            }

            $currencies = TableJobProfile::distinct()->pluck('currency');
            $keywords = TableJobProfile::distinct()->pluck('skills');
            $industries = Category::all();

            return view('web.jobprofile', compact('profile', 'countries', 'currencies', 'keywords', 'industries'));
        }

        $currencies = TableJobProfile::distinct()->pluck('currency');
        $keywords = TableJobProfile::distinct()->pluck('skills');
        $industries = Category::all();
        return view('web.jobprofile', compact('countries', 'profile', 'currencies', 'keywords', 'industries'));
    }

    public function updatejobprofile(Request $request)
    {
        $user = Auth::guard('customer')->user()->id;
        $storage = config('filesystems.disks.default') ?? 'public';

        // Validation for the incoming request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'alternate_email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'nationality' => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'highest_education' => 'nullable|string|max:100',
            'field_of_study' => 'nullable|string|max:255',
            'university_name' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|integer|digits:4|min:1900|max:' . date('Y'),
            'additional_courses' => 'nullable|string',
            'certifications' => 'nullable|string',
            'languages' => 'nullable|string',
            'skills' => 'nullable|string',
            'bio' => 'nullable|string',
            'linkedin_profile' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'years_of_experience' => 'nullable|integer',
            'current_position' => 'nullable|string|max:255',
            'current_employer' => 'nullable|string|max:255',
            'work_experience' => 'nullable|string',
            'desired_position' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:50',
            'desired_salary' => 'nullable|numeric',
            'relocation' => 'nullable|boolean',
            'industry' => 'nullable|string|max:255',
            'preferred_locations' => 'nullable|string',
            'open_to_remote' => 'nullable|boolean',
            'available_immediately' => 'nullable|boolean',
            'availability_date' => 'nullable|date',
            'references' => 'nullable|string',
            'hobbies' => 'nullable|string',
            'has_drivers_license' => 'nullable|boolean',
            'visa_status' => 'nullable|string|max:100',
            'passport_number' => 'nullable|string|max:100',
            'has_criminal_record' => 'nullable|boolean',
            'is_verified' => 'nullable|boolean',
            'short_term_goal' => 'nullable|string|max:255',
            'long_term_goal' => 'nullable|string|max:255',
            'seeking_internship' => 'nullable|boolean',
            'open_to_contract' => 'nullable|boolean',
            'github_profile' => 'nullable|url|max:255',
            'behance_profile' => 'nullable|url|max:255',
            'twitter_profile' => 'nullable|url|max:255',
            'personal_website' => 'nullable|url|max:255',
            'portfolio_items' => 'nullable|string',
            'videos' => 'nullable|string',
            'profile_views' => 'nullable|integer',
            'applications_sent' => 'nullable|integer',
            'connections' => 'nullable|integer',
            'currency' => 'string',
            'previous_employers' => 'string',
        ]);

        $validated['user_id'] = $user;
        $validated['languages'] = json_encode(explode(',', $validated['languages']));
        $validated['skills'] = json_encode(explode(',', $validated['skills']));
        $validated['preferred_locations'] = json_encode(explode(',', $validated['preferred_locations']));
        $validated['references'] = json_encode(explode(',', $validated['references']));
        $validated['portfolio_items'] = json_encode(explode(',', $validated['portfolio_items']));
        $validated['videos'] = json_encode(explode(',', $validated['videos']));
        $validated['previous_employers'] = json_encode(explode(',', $validated['previous_employers']));

        // Fetch existing profile
        $profile = TableJobProfile::where('user_id', $user)->first();

        try {
            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                $profile_photo = $request->file('profile_photo');
                $profilephoto_name = time() . '_' . $profile_photo->getClientOriginalName();
                $validated['profile_photo'] = Storage::disk($storage)->putFileAs('profile_photos', $profile_photo, $profilephoto_name);
            }

            // Handle resume upload
            if ($request->hasFile('resume')) {
                $resume = $request->file('resume');
                $resume_name = time() . '_' . $resume->getClientOriginalName();
                $validated['resume'] = Storage::disk($storage)->putFileAs('profile_resume', $resume, $resume_name);
            }

            if ($profile) {
                // Update existing profile with validated data
                $profile->update($validated);
            } else {
                // Create new profile if not exists
                TableJobProfile::create($validated);
            }

            // Return success response
            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Failed to update job profile for user ' . $user . ': ' . $e->getMessage());

            // Return error response
            return redirect()
                ->back()
                ->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function user_account(Request $request)
    {
        $country_restrict_status = getWebConfig(name: 'delivery_country_restriction');
        $customerDetail = User::where('id', auth('customer')->id())->first();
        return view(VIEW_FILE_NAMES['user_account'], compact('customerDetail'));
    }

    public function getUserProfileUpdate(CustomerProfileUpdateRequest $request): RedirectResponse
    {
        $imageName = $request->file('image') ? ImageManager::update('profile/', auth('customer')->user()->image, 'webp', $request->file('image')) : auth('customer')->user()->image;
        $user = auth('customer')->user();
        User::find($user['id'])->update([
            'f_name' => $request['f_name'],
            'l_name' => $request['l_name'],
            'phone' => $user['is_phone_verified'] ? $user['phone'] : $request['phone'],
            'email' => $request['email'],
            'is_phone_verified' => $request['phone'] == $user['phone'] ? $user['is_phone_verified'] : 0,
            'is_email_verified' => $request['email'] == $user['email'] ? $user['is_email_verified'] : 0,
            'image' => $imageName,
            'password' => strlen($request['password']) > 5 ? bcrypt($request['password']) : auth('customer')->user()->password,
        ]);

        Toastr::info(translate('updated_successfully'));
        return redirect()->back();
    }

    public function account_address_add()
    {
        $country_restrict_status = getWebConfig(name: 'delivery_country_restriction');
        $zip_restrict_status = getWebConfig(name: 'delivery_zip_code_area_restriction');
        $default_location = getWebConfig(name: 'default_location');

        $countries = $country_restrict_status ? $this->get_delivery_country_array() : COUNTRIES;

        $zip_codes = $zip_restrict_status ? DeliveryZipCode::all() : 0;

        return view(VIEW_FILE_NAMES['account_address_add'], compact('countries', 'zip_restrict_status', 'zip_codes', 'default_location'));
    }

    public function account_delete($id)
    {
        if (auth('customer')->id() == $id) {
            $user = User::find($id);

            $ongoing = ['out_for_delivery', 'processing', 'confirmed', 'pending'];
            $order = Order::where('customer_id', $user->id)
                ->whereIn('order_status', $ongoing)
                ->count();
            if ($order > 0) {
                Toastr::warning(translate('you_can_not_delete_account_due_ongoing_order'));
                return redirect()->back();
            }
            auth()->guard('customer')->logout();

            ImageManager::delete('/profile/' . $user['image']);
            session()->forget('wish_list');

            $user->delete();
            Toastr::info(translate('Your_account_deleted_successfully!!'));
            return redirect()->route('home');
        }

        Toastr::warning(translate('access_denied') . '!!');
        return back();
    }

    public function account_address(): View|RedirectResponse
    {
        $country_restrict_status = getWebConfig(name: 'delivery_country_restriction');
        $zip_restrict_status = getWebConfig(name: 'delivery_zip_code_area_restriction');

        $countries = $country_restrict_status ? $this->get_delivery_country_array() : COUNTRIES;
        $zip_codes = $zip_restrict_status ? DeliveryZipCode::all() : 0;

        $countriesName = [];
        $countriesCode = [];
        foreach ($countries as $country) {
            $countriesName[] = $country['name'];
            $countriesCode[] = $country['code'];
        }

        if (auth('customer')->check()) {
            $shippingAddresses = ShippingAddress::where('customer_id', auth('customer')->id())->latest()->get();
            return view('web-views.users-profile.account-address', compact('shippingAddresses', 'country_restrict_status', 'zip_restrict_status', 'countries', 'zip_codes', 'countriesName', 'countriesCode'));
        } else {
            return redirect()->route('home');
        }
    }

    public function address_store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|max:20',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'address' => 'required',
        ]);

        $numericPhoneValue = preg_replace('/[^0-9]/', '', $request['phone']);
        $numericLength = strlen($numericPhoneValue);
        if ($numericLength < 4 || $numericLength > 20) {
            $request->validate(
                [
                    'phone' => 'min:5|max:20',
                ],
                [
                    'phone.min' => translate('The_phone_number_must_be_at_least_4_characters'),
                    'phone.max' => translate('The_phone_number_may_not_be_greater_than_20_characters'),
                ],
            );
        }

        $country_restrict_status = getWebConfig(name: 'delivery_country_restriction');
        $zip_restrict_status = getWebConfig(name: 'delivery_zip_code_area_restriction');

        $country_exist = self::delivery_country_exist_check($request->country);
        $zipcode_exist = self::delivery_zipcode_exist_check($request->zip);

        if ($country_restrict_status && !$country_exist) {
            Toastr::error(translate('Delivery_unavailable_in_this_country!'));
            return back();
        }

        if ($zip_restrict_status && !$zipcode_exist) {
            Toastr::error(translate('Delivery_unavailable_in_this_zip_code_area!'));
            return back();
        }

        $address = [
            'customer_id' => auth('customer')->check() ? auth('customer')->id() : null,
            'contact_person_name' => $request['name'],
            'address_type' => $request['addressAs'],
            'address' => $request['address'],
            'city' => $request['city'],
            'zip' => $request['zip'],
            'country' => $request['country'],
            'phone' => $request['phone'],
            'is_billing' => $request['is_billing'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shipping_addresses')->insert($address);

        Toastr::success(translate('address_added_successfully!'));

        if (theme_root_path() == 'default') {
            return back();
        } else {
            return redirect()->route('user-profile');
        }
    }

    public function address_edit(Request $request, $id)
    {
        $shippingAddress = ShippingAddress::where('customer_id', auth('customer')->id())->find($id);
        $country_restrict_status = getWebConfig(name: 'delivery_country_restriction');
        $zip_restrict_status = getWebConfig(name: 'delivery_zip_code_area_restriction');

        $delivery_countries = $country_restrict_status ? self::get_delivery_country_array() : COUNTRIES;
        $delivery_zipcodes = $zip_restrict_status ? DeliveryZipCode::all() : 0;

        $countriesName = [];
        $countriesCode = [];
        foreach ($delivery_countries as $country) {
            $countriesName[] = $country['name'];
            $countriesCode[] = $country['code'];
        }

        if (isset($shippingAddress)) {
            return view(VIEW_FILE_NAMES['account_address_edit'], compact('shippingAddress', 'country_restrict_status', 'zip_restrict_status', 'delivery_countries', 'delivery_zipcodes', 'countriesName', 'countriesCode'));
        } else {
            Toastr::warning(translate('access_denied'));
            return back();
        }
    }

    public function address_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|max:20',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'address' => 'required',
        ]);

        $numericPhoneValue = preg_replace('/[^0-9]/', '', $request['phone']);
        $numericLength = strlen($numericPhoneValue);
        if ($numericLength < 4 || $numericLength > 20) {
            $request->validate(
                [
                    'phone' => 'min:5|max:20',
                ],
                [
                    'phone.min' => translate('The_phone_number_must_be_at_least_4_characters'),
                    'phone.max' => translate('The_phone_number_may_not_be_greater_than_20_characters'),
                ],
            );
        }

        $country_restrict_status = getWebConfig(name: 'delivery_country_restriction');
        $zip_restrict_status = getWebConfig(name: 'delivery_zip_code_area_restriction');

        $country_exist = self::delivery_country_exist_check($request->country);
        $zipcode_exist = self::delivery_zipcode_exist_check($request->zip);

        if ($country_restrict_status && !$country_exist) {
            Toastr::error(translate('Delivery_unavailable_in_this_country!'));
            return back();
        }

        if ($zip_restrict_status && !$zipcode_exist) {
            Toastr::error(translate('Delivery_unavailable_in_this_zip_code_area!'));
            return back();
        }

        $updateAddress = [
            'contact_person_name' => $request->name,
            'address_type' => $request->addressAs,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'country' => $request->country,
            'phone' => $request->phone,
            'is_billing' => $request->is_billing,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        if (auth('customer')->check()) {
            ShippingAddress::where('id', $request->id)->update($updateAddress);
            Toastr::success(translate('address_updated_successfully!'));
        } else {
            Toastr::error(translate('Insufficient_permission!'));
        }
        return theme_root_path() == 'default' ? redirect()->route('account-address') : redirect()->route('user-profile');
    }

    public function address_delete(Request $request)
    {
        if (auth('customer')->check()) {
            ShippingAddress::destroy($request->id);
            Toastr::success(translate('address_Delete_Successfully'));
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function account_payment()
    {
        if (auth('customer')->check()) {
            return view('web-views.users-profile.account-payment');
        } else {
            return redirect()->route('home');
        }
    }

    public function account_order(Request $request)
    {
        $order_by = $request->order_by ?? 'desc';
        if (theme_root_path() == 'theme_fashion') {
            $show_order = $request->show_order ?? 'ongoing';

            $array = ['pending', 'confirmed', 'out_for_delivery', 'processing'];
            $orders = $this->order
                ->withSum('orderDetails', 'qty')
                ->where(['customer_id' => auth('customer')->id(), 'is_guest' => '0'])
                ->when($show_order == 'ongoing', function ($query) use ($array) {
                    $query->whereIn('order_status', $array);
                })
                ->when($show_order == 'previous', function ($query) use ($array) {
                    $query->whereNotIn('order_status', $array);
                })
                ->when($request['search'], function ($query) use ($request) {
                    $query->where('id', 'like', "%{$request['search']}%");
                })
                ->orderBy('id', $order_by)
                ->paginate(10)
                ->appends(['show_order' => $show_order, 'search' => $request->search]);
        } else {
            $orders = $this->order
                ->withSum('orderDetails', 'qty')
                ->where(['customer_id' => auth('customer')->id(), 'is_guest' => '0'])
                ->orderBy('id', $order_by)
                ->paginate(10);
        }

        return view(VIEW_FILE_NAMES['account_orders'], compact('orders', 'order_by'));
    }

    public function account_order_details(Request $request): View|RedirectResponse
    {
        $order = $this->order
            ->with(['deliveryManReview', 'customer', 'offlinePayments', 'details.productAllStatus'])
            ->where(['id' => $request['id'], 'customer_id' => auth('customer')->id(), 'is_guest' => '0'])
            ->first();

        if ($order) {
            $order?->details?->map(function ($detail) use ($order) {
                $order['total_qty'] += $detail->qty;

                $reviews = Review::where(['product_id' => $detail['product_id'], 'customer_id' => auth('customer')->id()])
                    ->whereNull('delivery_man_id')
                    ->get();
                $reviewData = null;
                foreach ($reviews as $review) {
                    if ($review->order_id == $detail->order_id) {
                        $reviewData = $review;
                    }
                }

                if (isset($reviews[0]) && is_null($reviewData)) {
                    $reviewData = $reviews[0]['order_id'] == null ? $reviews[0] : null;
                }
                $detail['reviewData'] = $reviewData;
                return $order;
            });
            return view(VIEW_FILE_NAMES['account_order_details'], [
                'order' => $order,
                'refund_day_limit' => getWebConfig(name: 'refund_day_limit'),
                'current_date' => Carbon::now(),
            ]);
        }

        Toastr::warning(translate('invalid_order'));
        return redirect()->route('account-oder');
    }

    public function account_order_details_seller_info(Request $request)
    {
        $order = $this->order->with(['seller.shop'])->find($request->id);
        if (!$order) {
            Toastr::warning(translate('invalid_order'));
            return redirect()->route('account-oder');
        }

        $productIds = $this->product
            ->active()
            ->where(['added_by' => $order->seller_is])
            ->where('user_id', $order->seller_id)
            ->pluck('id')
            ->toArray();
        $rating = $this->review->active()->whereIn('product_id', $productIds);
        $rating_count = $rating->count();
        $avg_rating = $rating->avg('rating');
        $product_count = count($productIds);

        $vendorRattingStatusPositive = 0;
        foreach ($rating->pluck('rating') as $singleRating) {
            $singleRating >= 4 ? $vendorRattingStatusPositive++ : '';
        }

        $rating_percentage = $rating_count != 0 ? ($vendorRattingStatusPositive * 100) / $rating_count : 0;

        return view(VIEW_FILE_NAMES['seller_info'], compact('avg_rating', 'product_count', 'rating_count', 'order', 'rating_percentage'));
    }

    public function account_order_details_delivery_man_info(Request $request)
    {
        $order = $this->order
            ->with([
                'verificationImages',
                'details.product',
                'deliveryMan.rating',
                'deliveryManReview',
                'deliveryMan' => function ($query) {
                    return $query->withCount('review');
                },
            ])
            ->find($request->id);

        if (!$order) {
            Toastr::warning(translate('invalid_order'));
            return redirect()->route('account-oder');
        }

        if (theme_root_path() == 'theme_fashion' || theme_root_path() == 'default') {
            foreach ($order->details as $details) {
                if ($details->product) {
                    if ($details->product->product_type == 'physical') {
                        $order['product_type_check'] = $details->product->product_type;
                        break;
                    } else {
                        $order['product_type_check'] = $details->product->product_type;
                    }
                }
            }
        }

        $delivered_count = $this->order->where(['order_status' => 'delivered', 'delivery_man_id' => $order->delivery_man_id, 'delivery_type' => 'self_delivery'])->count();

        return view(VIEW_FILE_NAMES['delivery_man_info'], compact('delivered_count', 'order'));
    }

    public function getAccountOrderDetailsReviewsView(Request $request): View|RedirectResponse
    {
        $order = $this->order
            ->with(['deliveryManReview', 'customer', 'offlinePayments', 'details'])
            ->where(['id' => $request['id'], 'customer_id' => auth('customer')->id(), 'is_guest' => '0'])
            ->first();
        if ($order) {
            $order?->details?->map(function ($detail) use ($order) {
                $order['total_qty'] += $detail->qty;
                $reviews = Review::with('reply')
                    ->where(['product_id' => $detail['product_id'], 'customer_id' => auth('customer')->id()])
                    ->whereNull('delivery_man_id')
                    ->get();
                $reviewData = null;
                foreach ($reviews as $review) {
                    if ($review->order_id == $detail->order_id) {
                        $reviewData = $review;
                    }
                }
                if (isset($reviews[0]) && !$reviewData) {
                    $reviewData = $reviews[0]['order_id'] != null ? $reviews[0] : null;
                }
                $detail['reviewData'] = $reviewData;
                return $order;
            });

            return view(VIEW_FILE_NAMES['order_details_review'], compact('order'));
        }
        Toastr::warning(translate('invalid_order'));
        return redirect()->route('account-oder');
    }

    public function account_wishlist()
    {
        if (auth('customer')->check()) {
            $wishlists = Wishlist::where('customer_id', auth('customer')->id())->get();
            return view('web-views.products.wishlist', compact('wishlists'));
        } else {
            return redirect()->route('home');
        }
    }

    public function account_tickets()
    {
        if (auth('customer')->check()) {
            $supportTickets = SupportTicket::where('customer_id', auth('customer')->id())->latest()->paginate(10);
            return view(VIEW_FILE_NAMES['account_tickets'], compact('supportTickets'));
        } else {
            return redirect()->route('home');
        }
    }

    public function submitSupportTicket(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'ticket_subject' => 'required',
                'ticket_type' => 'required',
                'ticket_priority' => 'required',
                'ticket_description' => 'required_without_all:image.*',
                'image.*' => 'required_without_all:ticket_description|image|mimes:jpeg,png,jpg,gif|max:6000',
            ],
            [
                'ticket_subject.required' => translate('The_ticket_subject_is_required'),
                'ticket_type.required' => translate('The_ticket_type_is_required'),
                'ticket_priority.required' => translate('The_ticket_priority_is_required'),
                'ticket_description.required_without_all' => translate('Either_a_ticket_description_or_an_image_is_required'),
                'image.*.required_without_all' => translate('Either_a_ticket_description_or_an_image_is_required'),
                'image.*.image' => translate('The_file_must_be_an_image'),
                'image.*.mimes' => translate('The_file_must_be_of_type:_jpeg,_png,_jpg,_gif'),
                'image.*.max' => translate('The_image_must_not_exceed_6_MB'),
            ],
        );

        $images = [];
        if ($request->file('image')) {
            foreach ($request['image'] as $key => $value) {
                $image_name = ImageManager::upload('support-ticket/', 'webp', $value);
                $images[] = [
                    'file_name' => $image_name,
                    'storage' => getWebConfig(name: 'storage_connection_type') ?? 'public',
                ];
            }
        }

        $ticket = [
            'subject' => $request['ticket_subject'],
            'type' => $request['ticket_type'],
            'customer_id' => auth('customer')->check() ? auth('customer')->id() : null,
            'priority' => $request['ticket_priority'],
            'description' => $request['ticket_description'],
            'attachment' => json_encode($images),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('support_tickets')->insert($ticket);
        return back();
    }

    public function single_ticket(Request $request)
    {
        $ticket = SupportTicket::with([
            'conversations' => function ($query) {
                $query->when(theme_root_path() == 'default', function ($sub_query) {
                    $sub_query->orderBy('id', 'desc');
                });
            },
        ])
            ->where('id', $request->id)
            ->first();
        return view(VIEW_FILE_NAMES['ticket_view'], compact('ticket'));
    }

    public function comment_submit(Request $request, $id)
    {
        if ($request->file('image') == null && empty($request['comment'])) {
            Toastr::error(translate('type_something') . '!');
            return back();
        }

        DB::table('support_tickets')
            ->where(['id' => $id])
            ->update([
                'status' => 'open',
                'updated_at' => now(),
            ]);

        $image = [];
        if ($request->file('image')) {
            $validator = $request->validate([
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:6000',
            ]);
            foreach ($request->image as $key => $value) {
                $image_name = ImageManager::upload('support-ticket/', 'webp', $value);
                $image[] = [
                    'file_name' => $image_name,
                    'storage' => getWebConfig(name: 'storage_connection_type') ?? 'public',
                ];
            }
        }
        $data = [
            'customer_message' => $request->comment,
            'attachment' => $image,
            'support_ticket_id' => $id,
            'position' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        SupportTicketConv::create($data);
        Toastr::success(translate('message_send_successfully') . '!');
        return back();
    }

    public function support_ticket_close($id)
    {
        DB::table('support_tickets')
            ->where(['id' => $id])
            ->update([
                'status' => 'close',
                'updated_at' => now(),
            ]);
        Toastr::success(translate('ticket_closed') . '!');
        return redirect('/account-tickets');
    }

    public function support_ticket_delete(Request $request)
    {
        if (auth('customer')->check()) {
            $support = SupportTicket::find($request->id);

            if ($support->attachment && count(json_decode($support->attachment)) > 0) {
                foreach (json_decode($support->attachment, true) as $image) {
                    ImageManager::delete('/support-ticket/' . $image);
                }
            }

            foreach ($support->conversations as $conversation) {
                if ($conversation->attachment && count(json_decode($conversation->attachment)) > 0) {
                    foreach (json_decode($conversation->attachment, true) as $image) {
                        ImageManager::delete('/support-ticket/' . $image);
                    }
                }
            }
            $support->conversations()->delete();

            $support->delete();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function track_order(): View
    {
        $robotsMetaContentData = $this->robotsMetaContentRepo->getFirstWhere(params: ['page_name' => 'track-order']);
        if (!$robotsMetaContentData) {
            $robotsMetaContentData = $this->robotsMetaContentRepo->getFirstWhere(params: ['page_name' => 'default']);
        }
        return view(VIEW_FILE_NAMES['tracking-page'], [
            'robotsMetaContentData' => $robotsMetaContentData,
        ]);
    }

    public function track_order_wise_result(Request $request)
    {
        if (auth('customer')->check()) {
            $orderDetails = Order::with('orderDetails')
                ->where('id', $request['order_id'])
                ->whereHas('details', function ($query) {
                    $query->where('customer_id', auth('customer')->id());
                })
                ->first();

            if (!$orderDetails) {
                Toastr::warning(translate('invalid_order'));
                return redirect()->route('account-oder');
            }

            $isOrderOnlyDigital = self::getCheckIsOrderOnlyDigital($orderDetails);
            return view(VIEW_FILE_NAMES['track_order_wise_result'], compact('orderDetails', 'isOrderOnlyDigital'));
        }
        return back();
    }

    public function getCheckIsOrderOnlyDigital($order): bool
    {
        $isOrderOnlyDigital = true;
        if ($order->orderDetails) {
            foreach ($order->orderDetails as $detail) {
                $product = json_decode($detail->product_details, true);
                if (isset($product['product_type']) && $product['product_type'] == 'physical') {
                    $isOrderOnlyDigital = false;
                }
            }
        }
        return $isOrderOnlyDigital;
    }

    public function track_order_result(Request $request)
    {
        $isOrderOnlyDigital = false;
        $user = auth('customer')->user();
        $user_phone = $request['phone_number'] ?? '';

        if (!isset($user)) {
            $userInfo = User::where('phone', $request['phone_number'])
                ->orWhere('phone', 'like', "%{$request['phone_number']}%")
                ->first();
            $order = Order::where('id', $request['order_id'])->first();

            if ($order && $order->is_guest) {
                $orderDetails = Order::with('shippingAddress')
                    ->where('id', $request['order_id'])
                    ->first();

                $orderDetails = $orderDetails && $orderDetails->shippingAddress && $orderDetails->shippingAddress->phone == $request['phone_number'] ? $orderDetails : null;

                if (!$orderDetails) {
                    $orderDetails = Order::where('id', $request['order_id'])
                        ->whereHas('billingAddress', function ($query) use ($request) {
                            $query->where('phone', $request['phone_number']);
                        })
                        ->first();
                }
            } elseif ($userInfo) {
                $orderDetails = Order::where('id', $request['order_id'])
                    ->whereHas('details', function ($query) use ($userInfo) {
                        $query->where('customer_id', $userInfo->id);
                    })
                    ->first();
            } else {
                Toastr::error(translate('invalid_Order_Id_or_phone_Number'));
                return redirect()->route('track-order.index', ['order_id' => $request['order_id'], 'phone_number' => $request['phone_number']]);
            }
        } else {
            $order = Order::where('id', $request['order_id'])->first();
            if ($order && $order->is_guest) {
                $orderDetails = Order::where('id', $request['order_id'])
                    ->whereHas('shippingAddress', function ($query) use ($request) {
                        $query->where('phone', $request['phone_number']);
                    })
                    ->first();
            } elseif ($user->phone == $request['phone_number']) {
                $orderDetails = Order::where('id', $request['order_id'])
                    ->whereHas('details', function ($query) {
                        $query->where('customer_id', auth('customer')->id());
                    })
                    ->first();
            }

            if ($request['from_order_details'] == 1) {
                $orderDetails = Order::where('id', $request['order_id'])
                    ->whereHas('details', function ($query) {
                        $query->where('customer_id', auth('customer')->id());
                    })
                    ->first();
            }
        }

        $order_verification_status = getWebConfig(name: 'order_verification');

        if (isset($orderDetails)) {
            if ($orderDetails['order_type'] == 'POS') {
                Toastr::error(translate('this_order_is_created_by_') . ($orderDetails['seller_is'] == 'seller' ? 'vendor' : 'admin') . translate('_from POS') . ',' . translate('please_contact_with_') . ($orderDetails['seller_is'] == 'seller' ? 'vendor' : 'admin') . translate('_to_know_more_details') . '.');
                return redirect()->back();
            }
            $isOrderOnlyDigital = self::getCheckIsOrderOnlyDigital($orderDetails);
            return view(VIEW_FILE_NAMES['track_order'], compact('orderDetails', 'user_phone', 'order_verification_status', 'isOrderOnlyDigital'));
        }

        Toastr::error(translate('invalid_Order_Id_or_phone_Number'));
        return redirect()->route('track-order.index', ['order_id' => $request['order_id'], 'phone_number' => $request['phone_number']]);
    }

    public function track_last_order()
    {
        $orderDetails = OrderManager::track_order(Order::where('customer_id', auth('customer')->id())->latest()->first()->id);

        if ($orderDetails != null) {
            return view('web-views.order.tracking', compact('orderDetails'));
        } else {
            return redirect()->route('track-order.index')->with('Error', translate('invalid_Order_Id_or_phone_Number'));
        }
    }

    public function order_cancel($id)
    {
        $order = Order::where(['id' => $id])->first();
        if ($order['payment_method'] == 'cash_on_delivery' && $order['order_status'] == 'pending') {
            OrderManager::stock_update_on_order_status_change($order, 'canceled');
            Order::where(['id' => $id])->update([
                'order_status' => 'canceled',
            ]);
            Toastr::success(translate('successfully_canceled'));
        } elseif ($order['payment_method'] == 'offline_payment') {
            Toastr::error(translate('The_order_status_cannot_be_updated_as_it_is_an_offline_payment'));
        } else {
            Toastr::error(translate('status_not_changable_now'));
        }
        return back();
    }

    public function refund_request(Request $request, $id): View|RedirectResponse
    {
        $orderDetails = OrderDetail::find($id);
        $user = auth('customer')->user();

        $loyaltyPointStatus = getWebConfig(name: 'loyalty_point_status');
        if ($loyaltyPointStatus == 1) {
            $loyaltyPoint = CustomerManager::count_loyalty_point_for_amount($id);
            if ($user['loyalty_point'] < $loyaltyPoint) {
                Toastr::warning(translate('you_have_not_sufficient_loyalty_point_to_refund_this_order') . '!!');
                return back();
            }
        }

        return view('web-views.users-profile.refund-request', [
            'order_details' => $orderDetails,
        ]);
    }

    public function store_refund(Request $request): RedirectResponse
    {
        $request->validate([
            'order_details_id' => 'required',
            'amount' => 'required',
            'refund_reason' => 'required',
        ]);
        $orderDetails = OrderDetail::find($request->order_details_id);
        $user = auth('customer')->user();

        $loyalty_point_status = getWebConfig(name: 'loyalty_point_status');
        if ($loyalty_point_status == 1) {
            $loyalty_point = CustomerManager::count_loyalty_point_for_amount($request->order_details_id);

            if ($user->loyalty_point < $loyalty_point) {
                Toastr::warning(translate('you_have_not_sufficient_loyalty_point_to_refund_this_order') . '!!');
                return back();
            }
        }

        $refundRequest = new RefundRequest();
        $refundRequest->order_details_id = $request->order_details_id;
        $refundRequest->customer_id = auth('customer')->id();
        $refundRequest->status = 'pending';
        $refundRequest->amount = $request->amount;
        $refundRequest->product_id = $orderDetails->product_id;
        $refundRequest->order_id = $orderDetails->order_id;
        $refundRequest->refund_reason = $request->refund_reason;

        if ($request->file('images')) {
            $images = [];
            foreach ($request->file('images') as $img) {
                $images[] = [
                    'image_name' => ImageManager::upload('refund/', 'webp', $img),
                    'storage' => getWebConfig(name: 'storage_connection_type') ?? 'public',
                ];
            }
            $refundRequest->images = $images;
        }
        $refundRequest->save();

        $orderDetails->refund_request = 1;
        $orderDetails->save();

        $order = Order::find($orderDetails->order_id);
        event(new RefundEvent(status: 'refund_request', order: $order, refund: $refundRequest, orderDetails: $orderDetails));

        Toastr::success(translate('refund_requested_successful!!'));
        return redirect()->route('account-order-details', ['id' => $orderDetails->order_id]);
    }

    public function generate_invoice($id)
    {
        $order = Order::with('seller')->with('shipping')->where('id', $id)->first();
        $data['email'] = $order->customer['email'];
        $data['order'] = $order;
        $invoiceSettings = json_decode($this->businessSettingRepo->getFirstWhere(params: ['type' => 'invoice_settings'])?->value, true);
        $mpdf_view = \View::make(VIEW_FILE_NAMES['order_invoice'], compact('order', 'invoiceSettings'));
        $this->generatePdf(view: $mpdf_view, filePrefix: 'order_invoice_', filePostfix: $order['id'], pdfType: 'invoice', requestFrom: 'web');
    }

    public function refund_details($id)
    {
        $order_details = OrderDetail::find($id);
        $refund = RefundRequest::with(['product', 'order'])
            ->where('customer_id', auth('customer')->id())
            ->where('order_details_id', $order_details->id)
            ->first();
        $product = $this->product->find($order_details->product_id);
        $order = $this->order->find($order_details->order_id);

        if (request()->ajax()) {
            if ($product) {
                return response()->json([
                    'status' => 1,
                    'view' => view(VIEW_FILE_NAMES['refund_details'], compact('order_details', 'refund', 'product', 'order'))->render(),
                ]);
            }
            return response()->json(['status' => 0, 'message' => translate('product_not_found')]);
        }

        if ($product) {
            return view(VIEW_FILE_NAMES['refund_details'], compact('order_details', 'refund', 'product', 'order'));
        }

        Toastr::error(translate('product_not_found'));
        return redirect()->back();
    }

    public function submit_review(Request $request, $id)
    {
        $order_details = OrderDetail::where(['id' => $id])
            ->whereHas('order', function ($q) {
                $q->where(['customer_id' => auth('customer')->id(), 'payment_status' => 'paid']);
            })
            ->first();

        if (!$order_details) {
            Toastr::error(translate('invalid_order!'));
            return redirect('/');
        }

        return view('web-views.users-profile.submit-review', compact('order_details'));
    }

    public function refer_earn(Request $request)
    {
        $ref_earning_status = getWebConfig(name: 'ref_earning_status') ?? 0;
        if (!$ref_earning_status) {
            Toastr::error(translate('you_have_no_permission'));
            return redirect('/');
        }
        $customer_detail = User::where('id', auth('customer')->id())->first();

        return view(VIEW_FILE_NAMES['refer_earn'], compact('customer_detail'));
    }

    public function user_coupons(Request $request)
    {
        $seller_ids = Seller::approved()->pluck('id')->toArray();
        $seller_ids = array_merge($seller_ids, [null, '0']);

        $coupons = Coupon::with('seller')
            ->where(['status' => 1])
            ->whereIn('customer_id', [auth('customer')->id(), '0'])
            ->whereIn('customer_id', [auth('customer')->id(), '0'])
            ->whereDate('start_date', '<=', date('Y-m-d'))
            ->whereDate('expire_date', '>=', date('Y-m-d'))
            ->paginate(8);

        return view(VIEW_FILE_NAMES['user_coupons'], compact('coupons'));
    }

    public function getfavourites(Request $request)
    {
        $user = auth('customer')->user(); // Or use auth()->user() based on guard
        $favourites_array = Favourites::where('user_id', $user->id)->where('role', 'customer')->get();
        return view('web.getfavourites', compact('favourites_array'));
    }
}
