<?php

namespace App\Http\Controllers\deal_assist;

use App\Http\Controllers\Controller;
use App\Models\DealAssist;
use Illuminate\Http\Request;

class DealAssistController extends Controller
{
    // Show list of deal assists
    public function index()
    {
        $dealAssists = DealAssist::all()->paginate(10);
        return view('admin-views.deal_assist.index', compact('dealAssists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'phone_number' => 'required',
            'email' => 'required|email',
            'name' => 'required|string|max:255',
        ]);

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
}
