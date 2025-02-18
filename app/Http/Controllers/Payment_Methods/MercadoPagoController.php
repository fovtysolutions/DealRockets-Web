<?php

namespace App\Http\Controllers\Payment_Methods;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Traits\Processor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\SDK;

class MercadoPagoController extends Controller
{
    use Processor;

    private PaymentRequest $paymentRequest;
    private $config;
    private $user;

    public function __construct(PaymentRequest $paymentRequest, User $user)
    {
        $config = $this->payment_config('mercadopago', 'payment_config');
        if (!is_null($config) && $config->mode == 'live') {
            $this->config = json_decode($config->live_values);
        } elseif (!is_null($config) && $config->mode == 'test') {
            $this->config = json_decode($config->test_values);
        }
        $this->paymentRequest = $paymentRequest;
        $this->user = $user;
    }


    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required|uuid'
        ]);

        if ($validator->fails()) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_400, null, $this->error_processor($validator)), 400);
        }

        $data = $this->paymentRequest::where(['id' => $request['payment_id']])->where(['is_paid' => 0])->first();
        if (!isset($data)) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_204), 200);
        }
        $config = $this->config;
        return view('payment.payment-view-marcedo-pogo', compact('config', 'data'));
    }

    public function make_payment(Request $request)
    {
        SDK::setAccessToken($this->config->access_token);
        $payment = new Payment();
        $payment->transaction_amount = (float)$request['transactionAmount'];
        $payment->token = $request['token'];
        $payment->description = $request['description'];
        $payment->installments = (int)$request['installments'];
        $payment->payment_method_id = $request['paymentMethodId'];
        $payment->issuer_id = (int)$request['issuer'];

        $payer = new Payer();
        $payer->email = $request['payer']['email'];
        $payer->identification = array(
            "type" => $request['payer']['identification']['type'],
            "number" => $request['payer']['identification']['number']
        );
        $payment->payer = $payer;
        $payment->save();

        if ($payment->status == 'approved') {
            $this->paymentRequest::where(['id' => $request['payment_id']])->update([
                'payment_method' => 'mercadopago',
                'is_paid' => 1,
                'transaction_id' => $payment->id,
            ]);
            $data = $this->paymentRequest::where(['id' => $request['payment_id']])->first();
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
        $payment_data = $this->paymentRequest::where(['id' => $request['payment_id']])->first();
        if (isset($payment_data) && function_exists($payment_data->failure_hook)) {
            call_user_func($payment_data->failure_hook, $payment_data);
        }
        return $this->payment_response($payment_data,'fail');
    }

    public function get_test_user(Request $request)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.mercadopago.com/users/test_user");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->config->access_token
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, '{"site_id":"MLA"}');
        $response = curl_exec($curl);
    }
}
