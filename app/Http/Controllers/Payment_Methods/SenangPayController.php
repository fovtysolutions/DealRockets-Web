<?php

namespace App\Http\Controllers\Payment_Methods;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Traits\Processor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;

class SenangPayController extends Controller
{
    use Processor;

    private $config_values;

    private PaymentRequest $payment;
    private $user;

    public function __construct(PaymentRequest $payment, User $user)
    {
        $config = $this->payment_config('senang_pay', 'payment_config');
        if (!is_null($config) && $config->mode == 'live') {
            $this->config_values = json_decode($config->live_values);
        } elseif (!is_null($config) && $config->mode == 'test') {
            $this->config_values = json_decode($config->test_values);
        }
        $this->payment = $payment;
        $this->user = $user;
    }

    public function index(Request $request): View|Factory|JsonResponse|Application
    {
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required|uuid'
        ]);

        if ($validator->fails()) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_400, null, $this->error_processor($validator)), 400);
        }

        $payment_data = $this->payment::where(['id' => $request['payment_id']])->where(['is_paid' => 0])->first();
        if (!isset($payment_data)) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_204), 200);
        }
        $payer = json_decode($payment_data['payer_information']);
        $config = $this->config_values;
        session()->put('payment_id', $payment_data->id);
        return view('payment.senang-pay', compact('payment_data', 'payer', 'config'));
    }

    public function return_senang_pay(Request $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        if ($request['status_id'] == 1) {
            $this->payment::where(['id' => session()->get('payment_id')])->update([
                'payment_method' => 'senang_pay',
                'is_paid' => 1,
                'transaction_id' => $request['transaction_id'],
            ]);
            $data = $this->payment::where(['id' => session()->get('payment_id')])->first();
            $input = $request->all();
            if(isset($data) && $data->attribute == 'membershipcustomer'){
                $uid = Auth('customer')->user()->id;
                $price = PaymentRequest::where('id',$input['payment_id'])->first()->payment_amount;
                $membership = Membership::create([
                    'transaction_id' => $input['payment_id'],
                    'paymentstatus' => "Approved",
                    'membership_id' => $uid,
                    'membership_status' => "active",
                    'amount' => $price,
                    'membership_user_type' => 'customer',
                ]);
                $customer_tiers = MembershipTier::orderBy('membership_order','asc')->where('membership_type','customer')->where('membership_active',1)->get();
                foreach($customer_tiers as $tier){
                    $price1 = json_decode($tier->membership_benefits,true)['price'];
                    if((float) $price1 == (float) $price){
                        $membership->type = $tier->membership_name;
                        $membership->save();
                    } 
                }

                                $user = User::where('id',$uid)->first();
                $user->membership_id = $membership->id;
                $user->membership_status = 'cleared';
                $user->membership = $membership->type;
                $user->save();
                toastr()->success('Membership Successfully Started');
                return redirect()->route('home');
            }
            if(isset($data) && $data->attribute == 'membershipseller'){
                $uid = Auth('seller')->user()->id;
                $price = PaymentRequest::where('id',$input['payment_id'])->first()->payment_amount;
                $membership = Membership::create([
                    'transaction_id' => $input['payment_id'],
                    'paymentstatus' => "Approved",
                    'membership_id' => $uid,
                    'membership_status' => "active",
                    'amount' => $price,
                    'membership_user_type' => 'seller',
                ]);
                $seller_tiers = MembershipTier::orderBy('membership_order','asc')->where('membership_type','seller')->where('membership_active',1)->get();
                foreach($seller_tiers as $tier){
                    $price1 = json_decode($tier->membership_benefits,true)['price'];
                    if((float) $price1 == (float) $price){
                        $membership->type = $tier->membership_name;
                        $membership->save();
                    } 
                }

                                $user = User::where('id',$uid)->first();
                $user->membership_id = $membership->id;
                $user->membership_status = 'cleared';
                $user->membership = $membership->type;
                $user->save();
                toastr()->success('Membership Successfully Started');
                return redirect()->route('home');
            }
            if (isset($data) && function_exists($data->success_hook)) {
                call_user_func($data->success_hook, $data);
            }
            return $this->payment_response($data,'success');
        }
        $payment_data = $this->payment::where(['id' => session()->get('payment_id')])->first();
        if (isset($payment_data) && function_exists($payment_data->failure_hook)) {
            call_user_func($payment_data->failure_hook, $payment_data);
        }
        return $this->payment_response($payment_data,'fail');
    }
}
