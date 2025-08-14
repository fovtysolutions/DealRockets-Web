<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipTopup;
use App\Models\MembershipFeature;
use App\Models\Membership;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use function App\Utils\payment_gateways;

class MembershipTopupController extends Controller
{
    public function index()
    {
        $user = auth('customer')->user();
        
        if (!$user) {
            return redirect()->route('customer.login');
        }

        $membership = Membership::where('membership_id', $user->id)
            ->where('membership_status', 'active')
            ->with('membershipTier')
            ->first();

        if (!$membership) {
            Toastr::error('No active membership found. Please purchase a membership first.');
            return redirect()->route('web.membership');
        }

        // Get available topup features
        $topupFeatures = MembershipFeature::where('is_topup_enabled', true)
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        // Get user's topup history
        $topupHistory = $membership->topups()
            ->with('membershipFeature')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $digital_payment = getWebConfig(name: 'digital_payment');
        $payment_gateways_list = payment_gateways();

        return view('web.membership-topup', compact(
            'membership', 
            'topupFeatures', 
            'topupHistory',
            'digital_payment',
            'payment_gateways_list'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'feature_id' => 'required|exists:membership_features,id',
            'quantity' => 'required|integer|min:1|max:1000',
            'payment_method' => 'required|string',
        ]);

        $user = auth('customer')->user();
        
        if (!$user) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $membership = Membership::where('membership_id', $user->id)
            ->where('membership_status', 'active')
            ->first();

        if (!$membership) {
            return response()->json(['error' => 'No active membership found'], 400);
        }

        $feature = MembershipFeature::findOrFail($request->feature_id);
        
        if (!$feature->is_topup_enabled) {
            return response()->json(['error' => 'Topup not available for this feature'], 400);
        }

        $quantity = $request->quantity;
        $unitPrice = $feature->topup_price_per_unit;
        $totalAmount = $quantity * $unitPrice;

        // Create topup record
        $topup = MembershipTopup::create([
            'membership_id' => $membership->id,
            'membership_feature_id' => $feature->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'transaction_id' => Str::random(20),
            'payment_method' => $request->payment_method,
            'expires_at' => now()->addMonths(12), // Topups expire after 12 months
        ]);

        // In a real application, integrate with payment gateway here
        // For now, we'll mark as completed for demo
        $topup->update([
            'status' => 'completed',
            'transaction_id' => 'demo_' . Str::random(10)
        ]);

        Toastr::success('Topup purchased successfully!');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Topup purchased successfully!',
                'topup' => $topup->load('membershipFeature')
            ]);
        }

        return redirect()->route('web.membership.topup')->with('success', 'Topup purchased successfully!');
    }

    public function getFeatureDetails($id)
    {
        $feature = MembershipFeature::findOrFail($id);
        
        if (!$feature->is_topup_enabled) {
            return response()->json(['error' => 'Topup not available for this feature'], 400);
        }

        return response()->json([
            'feature' => $feature,
            'formatted_price' => number_format($feature->topup_price_per_unit, 2)
        ]);
    }
}