<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\CategoryManager;
use App\Models\DealAssist as DealAssistModel;

class DealAssist extends Controller
{
    public function index(){
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        return view('dealassist.index',compact('categories'));
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
        $role = 'customer';
        $name = $validated['name'];
        $phone = $validated['phone'];

        if (auth('customer')->check()) {
            $customer = auth('customer')->user();
            $userId = $customer->id;
            $role = 'customer';
        } else {
            $role = 'guest';
        }

        // Create deal assist record
        $dealAssist = DealAssistModel::create([
            'user_id' => $userId,
            'email' => $validated['email'],
            'name' => $name,
            'phone_number' => $phone,
            'message' => $validated['message'],
            'role' => $role,
        ]);

        return response()->json([
            'success' => true,
            'type' => 'dealassist',
            'message' => 'Deal assist inquiry submitted successfully!',
            'deal_assist_id' => $dealAssist->id
        ]);
    }
}
