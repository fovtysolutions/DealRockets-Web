<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\ChatsOther;
use App\Models\Leads;
use App\Models\Product;
use App\Models\Seller;
use App\Models\StockSell;
use App\Utils\ChatManager;
use App\Utils\EmailHelper;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ChatOtherController extends Controller
{
    private function sendMessage(array $data)
    {
        // Validate incoming data
        $validator = Validator::make($data, [
            'sender_id' => 'required|integer',
            'sender_type' => 'required|in:customer,seller,admin',
            'receiver_id' => 'required|integer',
            'receiver_type' => 'required|in:seller,admin,customer',
            'message' => 'required|string|max:1000',
            'type' => 'required|string',
            'leads_id' => 'nullable|integer|exists:leads,id',
            'suppliers_id' => 'nullable|integer|exists:suppliers,id',
            'stocksell_id' => 'nullable|integer|exists:stock_sell,id',
            'product_id' => 'nullable|integer|exists:products,id',
            'product_qty' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        // Find existing chat_id for this conversation (both directions)
        $existingChat = ChatsOther::where('type', $validated['type'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('sender_id', $validated['sender_id'])
                        ->where('sender_type', $validated['sender_type'])
                        ->where('receiver_id', $validated['receiver_id'])
                        ->where('receiver_type', $validated['receiver_type']);
                })->orWhere(function ($q) use ($validated) {
                    $q->where('sender_id', $validated['receiver_id'])
                        ->where('sender_type', $validated['receiver_type'])
                        ->where('receiver_id', $validated['sender_id'])
                        ->where('receiver_type', $validated['sender_type']);
                });

                if (!empty($validated['leads_id'])) {
                    $query->where('leads_id', $validated['leads_id']);
                }
                if (!empty($validated['stocksell_id'])) {
                    $query->where('stocksell_id', $validated['stocksell_id']);
                }
                if (!empty($validated['product_id'])) {
                    $query->where('product_id', $validated['product_id']);
                }
            })
            ->first();

        if ($existingChat) {
            $validated['chat_id'] = $existingChat->chat_id;
            $validated['chat_initiator'] = 0;
        } else {
            $validated['chat_id'] = (string) Str::uuid();
            $validated['chat_initiator'] = 1;
        }

        // Create the chat message record
        $chat = ChatsOther::create($validated);

        // Increment quotes if applicable
        if (!empty($validated['leads_id'])) {
            Leads::where('id', $validated['leads_id'])->increment('quotes_recieved');
        }
        if (!empty($validated['stocksell_id'])) {
            StockSell::where('id', $validated['stocksell_id'])->increment('quote_recieved');
        }

        return $chat;
    }

    // Rewritten sendotherMessage to use sendMessage()
    public function sendotherMessage(Request $request)
    {
        try {
            $chat = $this->sendMessage($request->all());
            ChatManager::sendNotification([
                'sender_id'      => $chat['sender_id'],
                'receiver_id'    => $chat['receiver_id'],
                'receiver_type'  => $chat['receiver_type'],
                'type'           => $chat['type'],
                'stocksell_id'   => $chat['stocksell_id'],
                'leads_id'       => $chat['leads_id'],
                'suppliers_id'   => $chat['suppliers_id'],
                'product_id'     => $chat['product_id'],
                'product_qty'    => $chat['product_qty'],
                'title'          => 'New message received',
                'message'        => Str::limit($chat['message'], 100),
                'priority'       => 'normal',
                'action_url'     => 'inbox',
            ]);

            $user_id = $chat['receiver_id'];
            $role = $chat['receiver_type'];
            $type = $chat['type'];

            if ($role == 'seller'){
                $user = Seller::find($user_id);
            } else if ($role == 'admin') {
                $user = Admin::find($user_id);
            }

            if($type == 'stocksell'){
                $stocksell = StockSell::find($chat['stocksell_id']);
                $response = EmailHelper::sendStockSellInquiryMail($user, $stocksell);
            } else if($type == 'buyleads'){
                $lead = Leads::find($chat['leads_id']);
                $response = EmailHelper::sendBuyLeadInquiryMail($user, $lead);
            } else if($type == 'saleoffer'){
                $lead = Leads::find($chat['leads_id']);
                $response = EmailHelper::sendSaleOfferInquiryMail($user, $lead);
            } else if($type == ''){
                $response = EmailHelper::sendStockSellCreatedMail($user, $stockSell);
            } else {
                // Do Nothing
            }

            if (!$response['success']) {
                Log::error('Email Notification creation', [
                    'error'     => $response['message'] ?? 'Unknown error',
                ]);
            }
            return back()->with('success', 'Message sent successfully!');
        } catch (ValidationException $ve) {
            return back()->with('error', 'Message Sent Error: ' . $ve->getMessage());
        } catch (Exception $e) {
            return back()->with('error', 'Message Sent Error: ' . $e->getMessage());
        }
    }

    // Rewritten sendadminreply to use sendMessage()
    public function sendadminreply(Request $request)
    {
        try {
            $chat = $this->sendMessage($request->all());
            return response()->json(['message' => 'Message sent successfully!', 'data' => $chat], 201);
        } catch (ValidationException $ve) {
            return response()->json(['error' => 'Validation failed.', 'details' => $ve->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to send message.', 'details' => $e->getMessage()], 500);
        }
    }

    // Rewritten sendReplyMessage to use sendMessage()
    public function sendReplyMessage(Request $request)
    {
        try {
            $validated = $request->validate([
                'sender_id' => 'required|integer',
                'sender_type' => 'required|in:customer,seller,admin',
                'receiver_id' => 'required|integer',
                'receiver_type' => 'required|in:seller,admin,customer',
                'message' => 'required|string|max:1000',
                'listing_id' => 'required',
                'type' => 'required|string',
            ]);

            $type = $validated['type'];
            $listingId = $validated['listing_id'];

            // Assign specific listing ID key based on type
            switch ($type) {
                case 'products':
                    $validated['product_id'] = $listingId;
                    break;
                case 'stocksell':
                    $validated['stocksell_id'] = $listingId;
                    break;
                case 'buyleads':
                case 'sellleads':
                    $validated['leads_id'] = $listingId;
                    break;
                default:
                    return response()->json([
                        'error' => 'Invalid listing type.',
                        'details' => "Type '$type' is not supported.",
                    ], 422);
            }

            unset($validated['listing_id']); // remove listing_id as it is replaced

            $chat = $this->sendMessage($validated);

            return response()->json([
                'message' => 'Message sent successfully!',
                'data' => $chat,
            ], 201);
        } catch (ValidationException $ve) {
            return response()->json([
                'error' => 'Validation failed.',
                'details' => $ve->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to send message.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public static function getChatboxStatistics()
    {
        $roledetail = ChatManager::getRoleDetail();
        $role = $roledetail['role'];
        $userId = $roledetail['user_id'];

        if ($role == 'seller') {
            // Count total messages
            $totalMessages = ChatsOther::where('receiver_type', 'seller')->where('receiver_id', $userId)->count();

            // Count unread messages
            $unreadMessages = ChatsOther::where('receiver_type', 'seller')->where('receiver_id', $userId)->where('is_read', 0)->count();

            $readMessages = ChatsOther::where('receiver_type', 'seller')->where('receiver_id', $userId)->where('is_read', 1)->count();

            // Messages grouped by type
            $messagesByType = ChatsOther::where('receiver_type', 'seller')->where('receiver_id', $userId)->select('type')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('type')
                ->get();

            // Open vs Closed status
            $statusStats = ChatsOther::where('receiver_type', 'seller')->where('receiver_id', $userId)->select('openstatus')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('openstatus')
                ->get();

            // Messages by sender_type
            $bySenderType = ChatsOther::where('receiver_type', 'seller')->where('receiver_id', $userId)->select('sender_type')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('sender_type')
                ->get();

            $data = [
                'total_messages'     => $totalMessages,
                'read_messages'      => $readMessages,
                'unread_messages'    => $unreadMessages,
                'messages_by_type'   => $messagesByType,
                'status_distribution' => $statusStats,
                'by_sender_type'     => $bySenderType,
            ];

            return $data;
        }

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

        $data = [
            'total_messages'     => $totalMessages,
            'read_messages'      => $readMessages,
            'unread_messages'    => $unreadMessages,
            'messages_by_type'   => $messagesByType,
            'status_distribution' => $statusStats,
            'by_sender_type'     => $bySenderType,
        ];

        return $data;
    }

    public static function getInitialMessages($special = null, $search = null)
    {
        $roledetail = ChatManager::getRoleDetail();
        $role = $roledetail['role'];
        $userId = $roledetail['user_id'];

        $query = ChatsOther::query();

        if ($search != null) {
            $query->where('message', 'LIKE', '%' . $search . '%');
        }

        // if ($special != null) {
        //     switch ($special) {
        //         case 'unread':
        //             $query->where('is_read', 0);
        //             break;
        //         case 'read':
        //             $query->where('is_read', 1);
        //             break;
        //         case 'all':
        //         default:
        //             break;
        //     }
        // }

        switch ($role) {
            case 'seller':
                $query->whereIn('receiver_type', ['seller'])
                    ->where('receiver_id', $userId)
                    ->orderBy('sent_at', 'asc');
                break;
            case 'admin':
                $query->whereIn('receiver_type', ['admin', 'seller'])
                    ->orderBy('sent_at', 'asc');
                break;
        }

        $statuses = [
            'all'    => $query,
            'read'   => (clone $query)->where('is_read', 1),
            'unread' => (clone $query)->where('is_read', 0),
        ];

        $chatData = [];

        // 1. Build read/unread/all tabs
        foreach ($statuses as $status => $queryBuilder) {
            $chatData[$status] = $queryBuilder->get()
                ->filter(function ($item) {
                    return $item->leads_id || $item->stocksell_id || $item->product_id || $item->type === 'reachout';
                })
                ->groupBy(function ($item) {
                    return match ($item->type) {
                        'stocksell' => 'stocksell_' . $item->stocksell_id,
                        'products' => 'product_' . $item->product_id,
                        'buyleads', 'sellleads' => 'lead_' . $item->leads_id,
                        'reachout' => 'reachout_' . $item->id,
                        default => 'unknown_' . $item->id,
                    };
                })
                ->flatMap(function ($group) {
                    return $group->sortByDesc('created_at')->values();
                })
                ->values();
        }

        // 2. Build listing-type-specific tabs (flat and deduplicated)
        foreach (['buyleads', 'sellleads', 'stocksell', 'products'] as $typeKey) {
            $chatData[$typeKey] = collect($chatData['all'] ?? [])
                ->filter(fn($item) => $item->type === $typeKey)
                ->values();
        }

        return $chatData;
    }

    public function markAsRead(Request $request)
    {
        $id = $request->input('id');
        $item = ChatsOther::find($id);
        $item->is_read = 1;
        $item->save();
    }

    public function adminChatbox(Request $request)
    {
        $special = $request->input('special');
        $search = $request->input('search', null);

        $data['intialMessages'] = self::getInitialMessages($special, $search);
        $data['count'] = count($data['intialMessages']);
        $data['chatboxStatics'] = self::getChatboxStatistics();
        return view('admin-views.betterchat.messages', $data);
    }

    public function vendorChatbox(Request $request)
    {
        $special = $request->input('special');
        $search = $request->input('search', null);

        $data['intialMessages'] = self::getInitialMessages($special, $search);
        $data['count'] = count($data['intialMessages']);
        $data['chatboxStatics'] = self::getChatboxStatistics();
        return view('vendor-views.betterchat.messages', $data);
    }

    public function fetchChat($user_id, $user_type, $type, $listing_id)
    {
        $chats = ChatManager::getchats($user_id, $user_type, $type, $listing_id);
        return response()->json($chats);
    }

    public function getChatHeaderData(Request $request)
    {
        $id = $request->post('id');
        $chat = ChatsOther::where('id', $id)->first();

        if (!$chat) {
            return response()->json(['error' => 'Chat not found'], 404);
        }

        $type = $chat->type;

        switch ($type) {
            case 'stocksell':
                return [
                    'type' => $type,
                    'listing' => StockSell::find($chat->stocksell_id),
                ];

            case 'buyleads':
                return [
                    'type' => $type,
                    'listing' => Leads::where('type', 'buyer')->find($chat->leads_id),
                ];

            case 'sellleads':
                return [
                    'type' => $type,
                    'listing' => Leads::where('type', 'seller')->find($chat->leads_id),
                ];

            case 'products':
                return [
                    'type' => $type,
                    'listing' => Product::find($chat->product_id),
                ];

            case 'reachout':
                return [
                    'type' => $type,
                    'listing' => 'N/A',
                ];

            default:
                return response()->json(['error' => 'Unknown chat type'], 400);
        }
    }
}
