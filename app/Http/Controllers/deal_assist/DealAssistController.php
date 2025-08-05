<?php

namespace App\Http\Controllers\deal_assist;

use App\Http\Controllers\Controller;
use App\Models\DealAssist;
use App\Utils\ChatManager;
use Illuminate\Http\Request;

class DealAssistController extends Controller
{
    // Show list of deal assists
    public function index(Request $request)
    {
        $query = DealAssist::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone_number', 'LIKE', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting (always descending for latest first)
        $sortBy = $request->get('sort_by', 'created_at');

        // Validate sort fields to prevent SQL injection
        $allowedSortFields = ['id', 'name', 'email', 'created_at', 'role'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }

        $query->orderBy($sortBy, 'desc');

        // Paginate results
        $dealAssists = $query->paginate(10)->appends($request->query());

        return view('admin-views.deal_assist.index', compact('dealAssists'));
    }

    // Vendor View
    public function vendorindex()
    {
        $userdata = ChatManager::getRoleDetail();
        $userId = $userdata['user_id'] ?? null;
        $role = $userdata['role'] ?? null;
        $dealAssists = DealAssist::where('user_id',$userId)->where('role',$role)->paginate(10);
        return view('vendor-views.deal_assist.index', compact('dealAssists'));
    }

    public function store(Request $request)
    {
        $userdata = ChatManager::getRoleDetail();
        $userId = $userdata['user_id'] ?? null;
        $role = $userdata['role'] ?? null;

        $validated = $request->validate([
            'phone_number' => 'required',
            'email' => 'required|email',
            'name' => 'required|string|max:255',
        ]);

        $validated['user_id'] = $userId;
        $validated['role'] = $role;

        DealAssist::create($validated);
        return redirect()->back()->with('success', 'Deal Assist created.');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:deal_assist,id',
            'user_id' => 'required|integer',
            'phone_number' => 'required',
            'email' => 'required|email',
            'name' => 'required|string|max:255',
        ]);

        DealAssist::findOrFail($request->id)->update($validated);
        return redirect()->back()->with('success', 'Deal Assist updated.');
    }

    // Handle delete
    public function destroy($id)
    {
        DealAssist::destroy($id);
        return redirect()->route('dealassist.index')->with('success', 'Deleted successfully!');
    }

    // Handle frontend deal assist inquiry submission
    public function submitInquiry(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
            'sender_id' => 'nullable|integer',
            'sender_type' => 'required|string',
            'receiver_id' => 'required|integer',
            'receiver_type' => 'required|string',
            'type' => 'required|string',
        ]);

        // Get user information
        $userId = null;
        $role = 'guest';
        $name = $validated['name'];
        $phone = $validated['phone'];

        if (auth('customer')->check()) {
            try {
                $customer = auth('customer')->user();
                if ($customer && isset($customer->id)) {
                    $userId = $customer->id;
                    $role = 'customer';
                }
            } catch (\Exception $e) {
                // If there's an error accessing user properties, continue as guest
                $role = 'guest';
                $userId = null;
            }
        }

        // Create deal assist record
        $dealAssist = DealAssist::create([
            'user_id' => $userId,
            'email' => $validated['email'],
            'name' => $name,
            'phone_number' => $phone,
            'message' => $validated['message'],
            'role' => $role,
        ]);

        // You can also store the message in a separate messages table if needed
        // For now, we'll return success response for the chat system to handle

        return response()->json([
            'success' => true,
            'type' => 'dealassist',
            'message' => 'Deal assist inquiry submitted successfully!',
            'deal_assist_id' => $dealAssist->id
        ]);
    }
}
