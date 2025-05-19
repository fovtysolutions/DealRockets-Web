<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatsOther;
use App\Models\Leads;
use App\Models\StockSell;
use Exception;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\ValidationException;

class ChatOtherController extends Controller
{
    public function sendotherMessage(Request $request)
    {
        try{
            $validated = $request->validate([
                'sender_id' => 'required|integer',
                'sender_type' => 'required|in:customer,seller,admin',
                'receiver_id' => 'required|integer',
                'receiver_type' => 'required|in:seller,admin,customer',
                'message' => 'required|string|max:1000',
                'type' => 'required|string',
                'leads_id' => 'integer|exists:leads,id',
                'suppliers_id' => 'integer|exists:suppliers,id',
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
        } catch (ValidationException $ve){
            return response()->json(['message' => "Message Sent Error " . $ve->getMessage()], 500);
        } catch (Exception $e){
            return response()->json(['message' => "Message Sent Error " . $e->getMessage()], 500);
        }
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
