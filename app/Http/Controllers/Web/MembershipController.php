<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\MembershipTier;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Toastr;
use function App\Utils\payment_gateways;
use App\Models\BusinessSetting;

class MembershipController extends Controller
{
    public function index(){
        $customer_tiers = MembershipTier::orderBy('membership_order','asc')->where('membership_type','customer')->where('membership_active',1)->get();
        $seller_tiers = MembershipTier::orderBy('membership_order','asc')->where('membership_type','seller')->where('membership_active',1)->get();
        $getDBfield = BusinessSetting::where('type','memsetting')->first();
        $decodedData = json_decode($getDBfield['value'],true);
        $getDBfieldr = BusinessSetting::where('type','memsettingseller')->first();
        $decodedDatar = json_decode($getDBfield['value'],true);
        if(!empty($getDBfield)){
            $memdata = $decodedData;
        } else {
            $memdata = [];
        }
        if(!empty($getDBfieldr)){
            $memdatar = $decodedDatar;
        } else {
            $memdatar = [];
        }
        $digital_payment = getWebConfig(name: 'digital_payment');
        $payment_gateways_list = payment_gateways();
        return view('web.membership',compact('memdata','memdatar','customer_tiers','seller_tiers','digital_payment','payment_gateways_list'));
    }

    public function store(Request $request){
        $txn_id = Str::random(10);
        $txn_status = 'Approved';
        $mem_id = Auth('customer')->user()->id;
        $mem_status = 'active';
        $amount = '39.99';
        
        Membership::create([
            'transaction_id' => $txn_id,
            'paymentstatus' => $txn_status,
            'membership_id' => $mem_id,
            'membership_status' => $mem_status,
            'amount' => $amount,
        ]);

        toastr()->success('Membership Successfully Applied');

        return redirect()->back()->with(['success'=>'Membership Successfully Created!']);
    }
}
