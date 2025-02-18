<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\MembershipTier;
use function App\Utils\payment_gateways;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MembershipTierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $membershipTiers = MembershipTier::all();
        return response()->json($membershipTiers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('membership_tiers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'membership_id' => 'required|string|max:255',
            'membership_name' => 'required|string|max:255',
            'membership_type' => 'required|string|max:255',
            'membership_active' => 'required|string|max:255',
            'membership_order' => 'required|string|max:255',
        ]);

        $validated['membership_id'] = (integer) ($validated['membership_id']);
        $validated['membership_order'] = (integer) ($validated['membership_order']);

        $membershipTier = MembershipTier::create($validated);

        return redirect()->route('admin.membershiptier')->with([
            'message' => 'Membership Tier created successfully!',
            'data' => $membershipTier,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MembershipTier $membershipTier)
    {
        return response()->json($membershipTier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MembershipTier $membershipTier)
    {
        return view('membership_tiers.edit', compact('membershipTier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MembershipTier $membershipTier)
    {
        // Validate basic fields
        $validated = $request->validate([
            'membership_name' => 'string|max:255',
            'membership_active' => 'nullable|boolean',  // Ensure this is boolean
            'membership_order' => 'nullable|integer',  // Order can be optional
            'sell_offer' => 'nullable|integer',
            'access_leads' => 'nullable|boolean',
            'access_suppliers' => 'nullable|boolean',
            'access_jobs' => 'nullable|boolean',
            'access_stock' => 'nullable|boolean',
            'industry_jobs' => 'nullable|string',  // Industry jobs can be 'yes' or 'no'
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'no_of_cv' => 'nullable|integer',
            'charge_cv' => 'nullable|numeric',
        ]);
        
        // Handle membership_benefits update
        $existingBenefits = json_decode($membershipTier->membership_benefits, true) ?? [];

        // If the membership type is customer
        if ($membershipTier->membership_type == 'customer') {
            // Set the description separately for customer membership
            $description = $request->has('description') ? (string) $request->description : $existingBenefits['description'] ?? 'no';
            
            // Update other benefits
            $updatedBenefits = [
                'description' => $description,
                'price' => $request->has('price') ? (float) $request->price : $existingBenefits['price'] ?? 0,
                'buy_leads' => $request->has('buy_leads') ? (int) $request->buy_leads : $existingBenefits['buy_leads'] ?? 0,
                'sell_leads' => $request->has('sell_leads') ? (int) $request->sell_leads : $existingBenefits['sell_leads'] ?? 0,
                'industry_jobs' => $request->has('industry_jobs') ? (string) $request->industry_jobs : $existingBenefits['industry_jobs'] ?? 'no',
                'no_of_cv' => $request->has('no_of_cv') ? (string) $request->no_of_cv : $existingBenefits['no_of_cv'] ?? 0,
                'charge_cv' => $request->has('charge_cv') ? (string) $request->charge_cv : $existingBenefits['charge_cv'] ?? 0,
            ];
        }
        // If the membership type is seller
        elseif ($membershipTier->membership_type == 'seller') {
            // Set the description separately for seller membership
            $description = $request->has('description') ? (string) $request->description : $existingBenefits['description'] ?? 'no';
            
            // Update other benefits
            $updatedBenefits = [
                'description' => $description,
                'price' => $request->has('price') ? (float) $request->price : $existingBenefits['price'] ?? 0,
                'buy_leads' => $request->has('buy_leads') ? (int) $request->buy_leads : $existingBenefits['buy_leads'] ?? 0,
                'sell_leads' => $request->has('sell_leads') ? (int) $request->sell_leads : $existingBenefits['sell_leads'] ?? 0,
                'sell_offer' => $request->has('sell_offer') ? (int) $request->sell_offer : $existingBenefits['sell_offer'] ?? 0,
                'industry_jobs' => $request->has('industry_jobs') ? (string) $request->industry_jobs : $existingBenefits['industry_jobs'] ?? 'no',
                'no_of_cv' => $request->has('no_of_cv') ? (string) $request->no_of_cv : $existingBenefits['no_of_cv'] ?? 0,
                'charge_cv' => $request->has('charge_cv') ? (string) $request->charge_cv : $existingBenefits['charge_cv'] ?? 0,
                // Panel Filters
                'access_leads' => $request->has('access_leads') ? (int) $request->access_leads : $existingBenefits['access_leads'] ?? 0,
                'access_suppliers' => $request->has('access_suppliers') ? (int) $request->access_suppliers : $existingBenefits['access_suppliers'] ?? 0,
                'access_jobs' => $request->has('access_jobs') ? (int) $request->access_jobs : $existingBenefits['access_jobs'] ?? 0,
                'access_stock' => $request->has('access_stock') ? (int) $request->access_stock : $existingBenefits['access_stock'] ?? 0,
            ];
        }                                                       
        // Return an error if membership type is not recognized
        else {
            return response()->json(['error' => 'Invalid membership type'], 400);
        }

        // Encode the updated benefits back to JSON
        $validated['membership_benefits'] = json_encode($updatedBenefits);

        // Handle membership order update if it exists in the request
        if ($request->has('membership_order')) {
            $validated['membership_order'] = (int) $request->membership_order;
        } else {
            // Use the existing order if no new value is provided
            $validated['membership_order'] = $membershipTier->membership_order;
        }

        // Handle membership active status toggle
        if ($request->has('membership_active')) {
            $validated['membership_active'] = (int) $request->membership_active;
        }
        // Update the membership tier with validated data
        $membershipTier->update($validated);

        toastr()->success('Membership Tier updated successfully!');

        // Return back with success message and data
        return redirect()->back()->with([
            'message' => 'Membership Tier updated successfully!',
            'data' => $membershipTier,
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MembershipTier $membershipTier)
    {
        $membershipTier->delete();

        return response()->json([
            'message' => 'Membership Tier deleted successfully!',
        ]);
    }

    // Admin View Function
    public function adminview(){
        $customer_tiers = MembershipTier::orderBy('membership_order','asc')->where('membership_type','customer')->get();
        $seller_tiers = MembershipTier::orderBy('membership_order','asc')->where('membership_type','seller')->get();
        return view('admin-views.business-settings.membership_tiers',compact('customer_tiers','seller_tiers'));
    }

    public function adminplancreate(){
        $membershipId = MembershipTier::orderBy('membership_id','desc')->first();
        $membershipId = $membershipId ? $membershipId->membership_id + 1 : 101;
        return view('admin-views.business-settings.membership_plans',compact('membershipId'));
    }

    public function vendorview(){
        $seller_tiers = MembershipTier::orderBy('membership_order','asc')->where('membership_type','seller')->where('membership_active',1)->get();
        $getDBfieldr = BusinessSetting::where('type','memsettingseller')->first();
        $decodedDatar = json_decode($getDBfieldr['value'],true);
        if(!empty($getDBfieldr)){
            $memdatar = $decodedDatar;
        } else {
            $memdatar = [];
        }
        $digital_payment = getWebConfig(name: 'digital_payment');
        $payment_gateways_list = payment_gateways();
        return view('vendor-views.membership.membership_tiers',compact('memdatar','seller_tiers','digital_payment','payment_gateways_list'));        
    }
}
