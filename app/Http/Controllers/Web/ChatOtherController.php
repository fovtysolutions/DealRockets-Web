<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatsOther;
use App\Models\Leads;
use App\Models\StockSell;
use Illuminate\Validation\Rules\Exists;

class ChatOtherController extends Controller
{
    public function sendotherMessage(Request $request)
    {
        $validated = $request->validate([
            'sender_id' => 'required|integer',
            'sender_type' => 'required|in:customer,seller,admin',
            'receiver_id' => 'required|integer',
            'receiver_type' => 'required|in:seller,admin,customer',
            'message' => 'required|string|max:1000',
            'type' => 'required|string',
            'leads_id' => 'integer|exists:leads,id',
            'suppliers' => 'integer|exists:suppliers,id',
            'stocksell_id' => 'integer|exists:stock_sell,id',
        ]);
        
        $chat = ChatsOther::create($validated);

        if(isset($chat->leads_id)){
            $leads = Leads::where('id',$validated['leads_id'])->first();
            $leads->increment('quotes_recieved');
        }

        if(isset($chat->stocksell_id)){
            $stock = StockSell::where('id',$validated['stocksell_id'])->first();
            $stock->increment('quote_recieved');
        }

        return response()->json(['message' => 'Message sent successfully!', 'data' => $chat], 201);
    }

    public function sendadminreply(Request $request){
        $validated = $request->validate([
            'sender_id' => 'required|integer',
            'sender_type' => 'required|in:customer,seller,admin',
            'receiver_id' => 'required|integer',
            'receiver_type' => 'required|in:seller,admin,customer',
            'message' => 'required|string|max:1000',
            'type' => 'required|string',
        ]);
        
        $chat = ChatsOther::create($validated);

        return response()->json(['message' => 'Message sent successfully!', 'data' => $chat], 201);

    }
}
