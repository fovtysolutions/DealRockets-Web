<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Enums\SessionKey;
use App\Enums\ViewPaths\Vendor\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\LoginRequest;
use App\Models\BusinessSetting;
use App\Models\VendorExtraDetail;
use App\Models\VendorUsers;
use App\Repositories\VendorWalletRepository;
use App\Services\VendorService;
use App\Traits\RecaptchaTrait;
use App\Utils\ChatManager;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use RecaptchaTrait;

    public function __construct(
        private readonly VendorRepositoryInterface $vendorRepo,
        private readonly VendorService             $vendorService,
        private readonly VendorWalletRepository    $vendorWalletRepo,

    ) {
        $this->middleware('guest:seller', ['except' => ['logout']]);
    }

    public function generateReCaptcha(): void
    {
        $recaptchaBuilder = $this->generateDefaultReCaptcha(4);
        if (Session::has(SessionKey::VENDOR_RECAPTCHA_KEY)) {
            Session::forget(SessionKey::VENDOR_RECAPTCHA_KEY);
        }
        Session::put(SessionKey::VENDOR_RECAPTCHA_KEY, $recaptchaBuilder->getPhrase());
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $recaptchaBuilder->output();
    }

    public function getLoginView(): View
    {
        $recaptchaBuilder = $this->generateDefaultReCaptcha(4);
        $recaptcha = getWebConfig(name: 'recaptcha');
        Session::put(SessionKey::VENDOR_RECAPTCHA_KEY, $recaptchaBuilder->getPhrase());
        $data = BusinessSetting::where('type', 'vendorsetting')->first();
        $vendorsetting = $data ? json_decode($data->value, true) : [];
        return view(Auth::VENDOR_LOGIN[VIEW], compact('recaptchaBuilder', 'recaptcha', 'vendorsetting'));
    }

    public function login(LoginRequest $request)
    {
        // Check if form is filled or not
        $email = $request['email'];
        $password = $request['password'];
        $vendorUsers = VendorUsers::where('email', $email)->first();
        if(!isset($vendorUsers)){
            return response()->json([
                'error' => translate('Create an Account First') . '!',
                'redirectRoute' => route('vendor.auth.login'),
            ]);
        }
        if(isset($vendorUsers) && isset($password)){
            if($password != $vendorUsers->password){
                return response()->json([
                    'error' => translate('Fill Correct Credentials') . '!',
                    'redirectRoute' => route('vendor.auth.login'),
                ]);
            }
        }
        $recaptcha = getWebConfig(name: 'recaptcha');
        if (isset($recaptcha) && $recaptcha['status'] == 0) {
            // Do Nothing
        } else if (isset($recaptcha) && $recaptcha['status'] == 1) {
            $request->validate([
                'g-recaptcha-response' => [
                    function ($attribute, $value, $fail) {
                        $secret_key = getWebConfig(name: 'recaptcha')['secret_key'];
                        $response = $value;
                        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response;
                        $response = Http::get($url);
                        $response = $response->json();
                        if (!isset($response['success']) || !$response['success']) {
                            $fail(translate('recaptcha_failed'));
                        }
                    },
                ],
            ]);
        } else {
            if ($recaptcha['status'] != 1 && strtolower($request->vendorRecaptchaKey) != strtolower(Session(SessionKey::VENDOR_RECAPTCHA_KEY))) {
                return response()->json(['error' => translate('captcha_failed') . '!']);
            }
        }
        if ($vendorUsers->is_complete != 0) {
            $vendor = $this->vendorRepo->getFirstWhere(['identity' => $request['email']]);
            if (!$vendor) {
                return response()->json(['error' => translate('credentials_doesnt_match') . '!']);
            }
            $passwordCheck = Hash::check($request['password'], $vendor['password']);
            if ($passwordCheck && $vendor['status'] !== 'approved') {
                return response()->json(['status' => $vendor['status']]);
            }
            if ($this->vendorService->isLoginSuccessful($request->email, $request->password, $request->remember)) {
                if ($this->vendorWalletRepo->getFirstWhere(params: ['id' => auth('seller')->id()]) === false) {
                    $this->vendorWalletRepo->add($this->vendorService->getInitialWalletData(vendorId: auth('seller')->id()));
                }
                $routename = ChatManager::RedirectSupplierDetails();
                Toastr::info(translate('welcome_to_your_dashboard') . '.');
                return response()->json([
                    'success' => translate('login_successful') . '!',
                    'redirectRoute' => route($routename['route']),
                ]);
            } else {
                return response()->json(['error' => translate('credentials_doesnt_match') . '!']);
            }
        } else {
            return response()->json([
                'success' => translate('Fill Details') . '!',
                'redirectRoute' => route('vendor.form',['id' => $vendorUsers->id]),
            ]);
        }
    }

    public function showVendorForm($id)
    {
        $vendorUsers = VendorUsers::findOrFail($id);

        $vendorProfileData = VendorExtraDetail::where('seller_users',$vendorUsers->id)->first();
        $sellerUsersId = $vendorUsers->id;
        $email = $vendorUsers->email;
        $vendor_type = $vendorUsers->vendor_type;
        $phone = $vendorUsers->phone;
        $password = $vendorUsers->password;
        $confirm_password = $vendorUsers->password;

        session(['sellersUser' => $vendorUsers->id]);

        return view('web-views.seller-view.auth.partial.vendor-information-form', compact(
            'vendorProfileData',
            'sellerUsersId',
            'vendor_type',
            'email',
            'phone',
            'password',
            'confirm_password'
        ));
    }

    public function logout(): RedirectResponse
    {
        $this->vendorService->logout();
        Toastr::success(translate('logged_out_successfully') . '.');
        return redirect()->route('vendor.auth.login');
    }
}
