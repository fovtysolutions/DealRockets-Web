<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Contracts\Repositories\BusinessSettingRepositoryInterface;
use App\Contracts\Repositories\EmailTemplatesRepositoryInterface;
use App\Contracts\Repositories\HelpTopicRepositoryInterface;
use App\Contracts\Repositories\ShopRepositoryInterface;
use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Contracts\Repositories\VendorWalletRepositoryInterface;
use App\Enums\ViewPaths\Vendor\Auth;
use App\Events\VendorRegistrationEvent;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Vendor\VendorAddRequest;
use App\Models\Seller;
use App\Models\VendorExtraDetail;
use App\Repositories\VendorRegistrationReasonRepository;
use App\Services\ShopService;
use App\Services\VendorService;
use App\Traits\EmailTemplateTrait;
use App\Utils\CategoryManager;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPVerify;
use App\Models\VendorUsers;

class RegisterController extends BaseController
{
    use EmailTemplateTrait;
    public function __construct(
        private readonly VendorRepositoryInterface $vendorRepo,
        private readonly VendorWalletRepositoryInterface $vendorWalletRepo,
        private readonly ShopRepositoryInterface $shopRepo,
        private readonly VendorService $vendorService,
        private readonly ShopService $shopService,
        private readonly EmailTemplatesRepositoryInterface $emailTemplatesRepo,
        private readonly BusinessSettingRepositoryInterface $businessSettingRepo,
        private readonly HelpTopicRepositoryInterface $helpTopicRepo,
        private readonly VendorRegistrationReasonRepository $vendorRegistrationReasonRepo,

    ) {}

    public function index(?Request $request, string $type = null): View|Collection|LengthAwarePaginator|null|callable|RedirectResponse
    {
        return $this->getView();
    }

    public function getView(): View|RedirectResponse
    {
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $businessMode = getWebConfig(name: 'business_mode');
        $vendorRegistration = getWebConfig(name: 'seller_registration');
        if ((isset($businessMode) && $businessMode == 'single') || (isset($vendorRegistration) && $vendorRegistration == 0)) {
            Toastr::warning(translate('access_denied') . '!!');
            return redirect('/');
        }
        $vendorRegistrationHeader = json_decode($this->businessSettingRepo->getFirstWhere(params: ['type' => 'vendor_registration_header'])['value']);
        $vendorRegistrationReasons = $this->vendorRegistrationReasonRepo->getListWhere(orderBy: ['priority' => 'desc'], filters: ['status' => 1], dataLimit: 'all');
        $sellWithUs = json_decode($this->businessSettingRepo->getFirstWhere(params: ['type' => 'vendor_registration_sell_with_us'])['value']);
        $downloadVendorApp = json_decode($this->businessSettingRepo->getFirstWhere(params: ['type' => 'download_vendor_app'])['value']);
        $businessProcess = json_decode($this->businessSettingRepo->getFirstWhere(params: ['type' => 'business_process_main_section'])['value']);
        $businessProcessStep = json_decode($this->businessSettingRepo->getFirstWhere(params: ['type' => 'business_process_step'])['value']);
        $helpTopics = $this->helpTopicRepo->getListWhere(
            orderBy: ['id' => 'desc'],
            filters: ['type' => 'vendor_registration', 'status' => '1'],
            dataLimit: 'all'
        );

        if (session('vendor_data')) {
            $vendor_data = session('vendor_data');
        } else {
            $vendor_data = [];
        }
        return view(VIEW_FILE_NAMES[Auth::VENDOR_REGISTRATION[VIEW]], compact('vendor_data', 'categories', 'vendorRegistrationHeader', 'vendorRegistrationReasons', 'sellWithUs', 'downloadVendorApp', 'helpTopics', 'businessProcess', 'businessProcessStep'));
    }

    public function restDetails(Request $request)
    {
        $vendor_type = $request->post('vendor_type');
        $email = $request->post('email');
        $phone = $request->post('phone');
        $password = $request->post('password');
        $confirm_password = $request->post('confirm_password');

        // Phone check
        if ($phone && Seller::where('phone', $phone)->exists()) {
            session()->flash('error', 'The phone number has already been taken.');
            return redirect()->back()->withInput();
        }

        // Email check
        if ($email && Seller::where('email', $email)->exists()) {
            session()->flash('error', 'The email has already been taken.');
            return redirect()->back()->withInput();
        }

        // Password validation
        if ($password && !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])(?!.*\s).{8,}$/', $password)) {
            session()->flash('error', 'The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one digit, one special character, and no spaces.');
            return redirect()->back()->withInput();
        }

        if ($password != $confirm_password) {
            session()->flash('error', 'Passwords do not Match.');
            return redirect()->back()->withInput();
        }

        if (!isset($phone) || !isset($email) || !isset($password)) {
            session()->flash('error', 'Please Fill all the Fields');
            return redirect()->back()->withInput();
        }

        if (self::check_sellers_register_exists($email) == 1) {
            $sellerUsersId = session('sellersUser');
            $vendorProfileData = VendorExtraDetail::find($sellerUsersId);
            return view('web-views.seller-view.auth.partial.vendor-information-form', compact('vendorProfileData','sellerUsersId', 'vendor_type', 'email', 'phone', 'password', 'confirm_password'));
        }

        $otp = rand(10000, 99999);
        Mail::to($email)->send(new OTPVerify($otp));

        session(['otp' => $otp]);
        session([
            'vendor_data' => [
                'vendor_type' => $request->vendor_type,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'confirm_password' => $request->confirm_password,
            ]
        ]);
        return view('web-views.seller-view.auth.otp.fillotp', compact('otp', 'vendor_type', 'email', 'phone', 'password', 'confirm_password'));
    }

    public function resendotp(Request $request)
    {
        $email = $request->post('email');

        $otp = rand(10000, 99999);
        Mail::to($email)->send(new OTPVerify($otp));

        try {
            session(['otp' => $otp]);
            Mail::to($email)->send(new OTPVerify($otp));

            return response()->json([
                'success' => true,
                'message' => 'OTP resent successfully',
                'otp' => $otp // optional: remove in production
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP: ' . $e->getMessage()
            ]);
        }
    }

    private static function make_sellers_register($data)
    {
        $vendorData = $data;

        VendorUsers::create([
            'vendor_type' => $vendorData['vendor_type'],
            'email' => $vendorData['email'],
            'phone' => $vendorData['phone'],
            'password' => $vendorData['password'],
        ]);
    }

    private static function check_sellers_register_exists($email)
    {
        $vendorUsers = VendorUsers::where('email', $email)->first();
        
        if ($vendorUsers) {
            session(['sellersUser' => $vendorUsers->id]);
            return 1;
        } else {
            return 0;
        }
    }

    public function verifyotpcustom(Request $request)
    {
        $user_otp = $request->input('otp');
        $actual_otp = session('otp');

        if ($user_otp == $actual_otp) {
            session()->forget('otp');

            $vendor_data = session('vendor_data');

            self::make_sellers_register($vendor_data);

            return redirect()->route('vendor.auth.registration.index');
        } else {
            return redirect()->route('vendor.auth.registration.index')->with('error', 'Invalid OTP');
        }
    }

    public function saveVendorExtraDetails(Request $request,$sellerusers)
    {
        $validated = $request->validate([
            'company_images' => 'array|max:3',
            'company_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'factory_images' => 'array|max:3',
            'factory_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload helpers
        $uploadImages = function ($files, $folder) {
            $paths = [];
            if (is_array($files)) {
                foreach (array_slice($files, 0, 3) as $file) {
                    $paths[] = $file->store("vendor_files/{$folder}", 'public');
                }
            }
            return $paths;
        };

        $uploadImage = function ($file, $folder) {
            return $file ? $file->store("vendor_files/{$folder}", 'public') : null;
        };

        // Upload files
        $business_license_path = $uploadImage($request->file('business_license'), 'business_license');
        $tax_certificate_path = $uploadImage($request->file('tax_certificate'), 'tax_certificate');
        $import_export_license_path = $uploadImage($request->file('import_export_license'), 'license');
        $bank_proof_path = $uploadImage($request->file('bank_proof'), 'bank_proof');
        $authority_id_path = $uploadImage($request->file('authority_id'), 'authority_id');
        $business_card_path = $uploadImage($request->file('business_card'), 'business_card');
        $authorized_signature_path = $uploadImage($request->file('signature'), 'signature');

        $companyImages = $uploadImages($request->file('company_images'), 'company');
        $factoryImages = $uploadImages($request->file('factory_images'), 'factory');

        // Prepare data
        $data = [
            'company_name' => $request->input('company_name'),
            'registered_business_name' => $request->input('registered_name'),
            'business_type' => $request->input('business_type'),
            'year_of_establishment' => (int) $request->input('establishment_year'),
            'registration_number' => $request->input('registration_number'),
            'country_of_registration' => $request->input('registration_country'),
            'tax_id' => $request->input('tax_id'),
            'tax_expiry' => $request->input('tax_expiry'),
            'industry_category' => $request->input('industry'),
            'main_products_services' => $request->input('main_products'),

            'head_office_address' => $request->input('office_address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'postal_code' => $request->input('zip_code'),
            'company_phone' => $request->input('company_phone'),
            'company_email' => $request->input('company_email'),
            'website' => $request->input('website_url'),

            'contact_person_name' => $request->input('contact_name'),
            'designation' => $request->input('designation'),
            'mobile_number' => $request->input('mobile_number'),
            'contact_email' => $request->input('contact_email'),
            'alt_contact' => $request->input('alt_contact'),

            'bank_name' => $request->input('bank_name'),
            'account_name' => $request->input('bank_account_name'),
            'account_number' => $request->input('iban'),
            'swift_code' => $request->input('swift_code'),
            'bank_address' => $request->input('bank_address'),
            'currency' => $request->input('currency_accepted'),

            'local_branches' => json_encode($request->input('local_branches', [])),
            'overseas_offices' => json_encode($request->input('overseas_offices', [])),
            'export_countries' => json_encode($request->input('export_countries', [])),
            'warehousing_locations' => json_encode($request->input('warehousing_locations', [])),

            'authority_name' => $request->input('person_name_designation'),
            'authority_designation' => $request->input('authority_designation'),
            'authority_contact' => $request->input('person_contact'),
            'authority_email' => $request->input('person_email'),

            'is_operational' => $request->boolean('is_operational'),
            'is_info_verified' => $request->boolean('info_verified'),
            'has_authorized_consent' => $request->boolean('authorized_consent'),
            'authorized_name' => $request->input('authorized_name'),

            'company_images' => json_encode($companyImages),
            'factory_images' => json_encode($factoryImages),

            'role' => 'seller',
            'seller_users' => $sellerusers,
        ];

        // Only add image paths if they were uploaded
        if ($business_license_path) $data['business_license_path'] = $business_license_path;
        if ($tax_certificate_path) $data['tax_certificate_path'] = $tax_certificate_path;
        if ($import_export_license_path) $data['import_export_license_path'] = $import_export_license_path;
        if ($bank_proof_path) $data['bank_proof_path'] = $bank_proof_path;
        if ($authority_id_path) $data['authority_id_path'] = $authority_id_path;
        if ($business_card_path) $data['business_card_path'] = $business_card_path;
        if ($authorized_signature_path) $data['authorized_signature_path'] = $authorized_signature_path;

        // Create or update
        $existing = VendorExtraDetail::where('seller_users', $sellerusers)->first();

        if ($existing) {
            $existing->update($data);
            return $existing;
        } else {
            return VendorExtraDetail::create($data);
        }
    }

    private function createVendorExtraDetail(Request $request, $vendorid)
    {
        $validated = $request->validate([
            'company_images' => 'array|max:3',
            'company_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'factory_images' => 'array|max:3',
            'factory_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload helpers
        $uploadImages = function ($files, $folder) {
            $paths = [];
            if (is_array($files)) {
                foreach (array_slice($files, 0, 3) as $file) {
                    $paths[] = $file->store("vendor_files/{$folder}", 'public');
                }
            }
            return $paths;
        };

        $uploadImage = function ($file, $folder) {
            return $file ? $file->store("vendor_files/{$folder}", 'public') : null;
        };

        // Upload files
        $business_license_path = $uploadImage($request->file('business_license'), 'business_license');
        $tax_certificate_path = $uploadImage($request->file('tax_certificate'), 'tax_certificate');
        $import_export_license_path = $uploadImage($request->file('import_export_license'), 'license');
        $bank_proof_path = $uploadImage($request->file('bank_proof'), 'bank_proof');
        $authority_id_path = $uploadImage($request->file('authority_id'), 'authority_id');
        $business_card_path = $uploadImage($request->file('business_card'), 'business_card');
        $authorized_signature_path = $uploadImage($request->file('signature'), 'signature');

        $companyImages = $uploadImages($request->file('company_images'), 'company');
        $factoryImages = $uploadImages($request->file('factory_images'), 'factory');

        $sellerusers = session('sellersUser');
        
        // Prepare data
        $data = [
            'company_name' => $request->input('company_name'),
            'registered_business_name' => $request->input('registered_name'),
            'business_type' => $request->input('business_type'),
            'year_of_establishment' => (int) $request->input('establishment_year'),
            'registration_number' => $request->input('registration_number'),
            'country_of_registration' => $request->input('registration_country'),
            'tax_id' => $request->input('tax_id'),
            'tax_expiry' => $request->input('tax_expiry'),
            'industry_category' => $request->input('industry'),
            'main_products_services' => $request->input('main_products'),

            'head_office_address' => $request->input('office_address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'postal_code' => $request->input('zip_code'),
            'company_phone' => $request->input('company_phone'),
            'company_email' => $request->input('company_email'),
            'website' => $request->input('website_url'),

            'contact_person_name' => $request->input('contact_name'),
            'designation' => $request->input('designation'),
            'mobile_number' => $request->input('mobile_number'),
            'contact_email' => $request->input('contact_email'),
            'alt_contact' => $request->input('alt_contact'),

            'bank_name' => $request->input('bank_name'),
            'account_name' => $request->input('bank_account_name'),
            'account_number' => $request->input('iban'),
            'swift_code' => $request->input('swift_code'),
            'bank_address' => $request->input('bank_address'),
            'currency' => $request->input('currency_accepted'),

            'local_branches' => json_encode($request->input('local_branches', [])),
            'overseas_offices' => json_encode($request->input('overseas_offices', [])),
            'export_countries' => json_encode($request->input('export_countries', [])),
            'warehousing_locations' => json_encode($request->input('warehousing_locations', [])),

            'authority_name' => $request->input('person_name_designation'),
            'authority_designation' => $request->input('authority_designation'),
            'authority_contact' => $request->input('person_contact'),
            'authority_email' => $request->input('person_email'),

            'is_operational' => $request->boolean('is_operational'),
            'is_info_verified' => $request->boolean('info_verified'),
            'has_authorized_consent' => $request->boolean('authorized_consent'),
            'authorized_name' => $request->input('authorized_name'),

            'company_images' => json_encode($companyImages),
            'factory_images' => json_encode($factoryImages),

            'seller_id' => $vendorid,
            'role' => 'seller',
            'seller_users' => $sellerusers,
        ];

        // Only add image paths if they were uploaded
        if ($business_license_path) $data['business_license_path'] = $business_license_path;
        if ($tax_certificate_path) $data['tax_certificate_path'] = $tax_certificate_path;
        if ($import_export_license_path) $data['import_export_license_path'] = $import_export_license_path;
        if ($bank_proof_path) $data['bank_proof_path'] = $bank_proof_path;
        if ($authority_id_path) $data['authority_id_path'] = $authority_id_path;
        if ($business_card_path) $data['business_card_path'] = $business_card_path;
        if ($authorized_signature_path) $data['authorized_signature_path'] = $authorized_signature_path;

        // Create or update
        $existing = VendorExtraDetail::where('seller_id', $vendorid)->first();

        if ($existing) {
            $existing->update($data);
            return $existing;
        } else {
            return VendorExtraDetail::create($data);
        }
    }

    public function add(VendorAddRequest $request): JsonResponse
    {
        $vendor = $this->vendorRepo->add(data: $this->vendorService->getAddData($request));
        self::createVendorExtraDetail($request, $vendor['id']);
        $this->shopRepo->add($this->shopService->getAddShopDataForRegistration(request: $request, vendorId: $vendor['id']));
        $this->vendorWalletRepo->add($this->vendorService->getInitialWalletData(vendorId: $vendor['id']));
        
        $n = 20;
        $chatid = bin2hex(random_bytes($n / 2));
        $membershipid = bin2hex(random_bytes($n / 2));

        $data = [
            'vendorName' => $request['f_name'],
            'status' => 'pending',
            'membership_id' => $membershipid,
            'chat_id' => $chatid,
            'membership_status' => 'pending',
            'subject' => translate('Vendor_Registration_Successfully_Completed'),
            'title' => translate('Vendor_Registration_Successfully_Completed'),
            'userType' => 'vendor',
            'templateName' => 'registration',
        ];
        event(new VendorRegistrationEvent(email: $request['email'], data: $data));
        return response()->json(
            [
                'redirectRoute' => route('vendor.auth.login')
            ]
        );
    }
}
