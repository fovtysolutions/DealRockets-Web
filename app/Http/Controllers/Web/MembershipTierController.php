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
            'membership_active' => 'nullable|boolean',
            'membership_order' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'billing_cycle' => 'nullable|string|in:monthly,yearly,one_time',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle new feature-based system
        if ($request->has('features')) {
            $features = $request->input('features', []);
            
            // Sync features with pivot data
            $syncData = [];
            foreach ($features as $featureId => $featureData) {
                $syncData[$featureId] = [
                    'value' => $featureData['value'] ?? '0',
                    'is_unlimited' => isset($featureData['unlimited']) && $featureData['unlimited']
                ];
            }
            
            $membershipTier->features()->sync($syncData);
        }

        // Legacy support - handle old benefits structure
        $this->updateLegacyBenefits($request, $membershipTier, $validated);

        // Handle membership order update
        if ($request->has('membership_order')) {
            $validated['membership_order'] = (int) $request->membership_order;
        }

        // Handle membership active status toggle
        if ($request->has('membership_active')) {
            $validated['membership_active'] = (int) $request->membership_active;
        }

        // Update the membership tier
        $membershipTier->update($validated);

        Toastr::success('Membership Tier updated successfully!');

        return redirect()->back()->with([
            'message' => 'Membership Tier updated successfully!',
            'data' => $membershipTier->load('features'),
        ]);
    }

    /**
     * Handle legacy benefits update for backward compatibility
     */
    private function updateLegacyBenefits(Request $request, MembershipTier $membershipTier, array &$validated)
    {
        $existingBenefits = json_decode($membershipTier->membership_benefits, true) ?? [];

        if ($membershipTier->membership_type == 'customer') {
            $updatedBenefits = [
                'description' => $request->input('description', $existingBenefits['description'] ?? ''),
                'price' => $request->input('price', $existingBenefits['price'] ?? 0),
                'buy_leads' => $request->input('buy_leads', $existingBenefits['buy_leads'] ?? 0),
                'sell_leads' => $request->input('sell_leads', $existingBenefits['sell_leads'] ?? 0),
                'industry_jobs' => $request->input('industry_jobs', $existingBenefits['industry_jobs'] ?? 'no'),
                'no_of_cv' => $request->input('no_of_cv', $existingBenefits['no_of_cv'] ?? 0),
                'charge_cv' => $request->input('charge_cv', $existingBenefits['charge_cv'] ?? 0),
            ];
        } elseif ($membershipTier->membership_type == 'seller') {
            $updatedBenefits = [
                'description' => $request->input('description', $existingBenefits['description'] ?? ''),
                'price' => $request->input('price', $existingBenefits['price'] ?? 0),
                'buy_leads' => $request->input('buy_leads', $existingBenefits['buy_leads'] ?? 0),
                'sell_leads' => $request->input('sell_leads', $existingBenefits['sell_leads'] ?? 0),
                'sell_offer' => $request->input('sell_offer', $existingBenefits['sell_offer'] ?? 0),
                'industry_jobs' => $request->input('industry_jobs', $existingBenefits['industry_jobs'] ?? 'no'),
                'no_of_cv' => $request->input('no_of_cv', $existingBenefits['no_of_cv'] ?? 0),
                'charge_cv' => $request->input('charge_cv', $existingBenefits['charge_cv'] ?? 0),
                'access_leads' => $request->input('access_leads', $existingBenefits['access_leads'] ?? 0),
                'access_suppliers' => $request->input('access_suppliers', $existingBenefits['access_suppliers'] ?? 0),
                'access_jobs' => $request->input('access_jobs', $existingBenefits['access_jobs'] ?? 0),
                'access_stock' => $request->input('access_stock', $existingBenefits['access_stock'] ?? 0),
            ];
        }

        if (isset($updatedBenefits)) {
            $validated['membership_benefits'] = json_encode($updatedBenefits);
        }
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
        $customer_tiers = MembershipTier::with('features')
            ->orderBy('membership_order','asc')
            ->where('membership_type','customer')
            ->get();
        
        $seller_tiers = MembershipTier::with('features')
            ->orderBy('membership_order','asc')
            ->where('membership_type','seller')
            ->get();
        
        $availableFeatures = \App\Models\MembershipFeature::where('is_active', true)
            ->orderBy('category')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');
        
        return view('admin-views.business-settings.membership_tiers', compact(
            'customer_tiers', 
            'seller_tiers', 
            'availableFeatures'
        ));
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
