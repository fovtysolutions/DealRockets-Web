<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatsOther;
use App\Models\Leads;
use App\Models\StockSell;
use App\Utils\ChatManager;
use Exception;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\ValidationException;

class ChatOtherController extends Controller
{
    public function sendotherMessage(Request $request)
    {
        try {
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
                'product_id' => 'integer|exists:products,id',
                'product_qty' => 'integer',
            ]);

            $chat = ChatsOther::create($validated);

            if (isset($chat->leads_id)) {
                $leads = Leads::where('id', $validated['leads_id'])->first();
                $leads->increment('quotes_recieved');
            }

            if (isset($chat->stocksell_id)) {
                $stock = StockSell::where('id', $validated['stocksell_id'])->first();
                $stock->increment('quote_recieved');
            }

            return back()->with('success', 'Message sent successfully!');
        } catch (ValidationException $ve) {
            return back()->with('error', 'Message Sent Error: ' . $ve->getMessage());
        } catch (Exception $e) {
            return back()->with('error', 'Message Sent Error: ' . $e->getMessage());
        }
    }

    public function sendadminreply(Request $request)
    {
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

    public function getChatboxStatistics()
    {
        // Count total messages
        $totalMessages = ChatsOther::count();

        // Count unread messages
        $unreadMessages = ChatsOther::where('is_read', 0)->count();

        $readMessages = ChatsOther::where('is_read', 1)->count();

        // Messages grouped by type
        $messagesByType = ChatsOther::select('type')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('type')
            ->get();

        // Open vs Closed status
        $statusStats = ChatsOther::select('openstatus')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('openstatus')
            ->get();

        // Messages by sender_type
        $bySenderType = ChatsOther::select('sender_type')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('sender_type')
            ->get();

        return response()->json([
            'total_messages'     => $totalMessages,
            'read_messages'      => $readMessages,
            'unread_messages'    => $unreadMessages,
            'messages_by_type'   => $messagesByType,
            'status_distribution' => $statusStats,
            'by_sender_type'     => $bySenderType,
        ]);
    }

    public function getInitialMessages()
    {

        $roledetail = ChatManager::getRoleDetail();

        $role = $roledetail['role'];
        $userId = $roledetail['user_id'];

        $query = ChatsOther::query();

        switch ($role){
            case 'seller':
                $query->whereIn('receiver_type', ['seller'])
                    ->where('receiver_id', $userId)
                    ->orderBy('sent_at', 'asc'); // or 'id' if you prefer

            case 'admin':
                $query->whereIn('receiver_type', ['admin', 'seller'])
                    ->orderBy('sent_at', 'asc'); // or 'id' if you prefer
        }

        // Fetch all, group by relevant context ID
        $messages = $query->get()
            ->filter(function ($item) {
                return $item->leads_id || $item->stocksell_id || $item->product_id || $item->suppliers_id;
            })
            ->groupBy(function ($item) {
                return match ($item->type) {
                    'stocksell' => 'stocksell_' . $item->stocksell_id,
                    'products' => 'product_' . $item->product_id,
                    'buyleads', 'reachout' => 'lead_' . $item->leads_id,
                    'sellleads' => 'supplier_' . $item->suppliers_id,
                    default => 'unknown_' . $item->id,
                };
            });

        return response()->json(['data' => $messages]);
    }
}
