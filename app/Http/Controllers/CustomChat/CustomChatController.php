<?php

namespace App\Http\Controllers\CustomChat;

use App\Http\Controllers\Controller;
use App\Models\ChatsOther;
use Illuminate\Http\Request;
use App\Utils\ChatManager;
use Error;
use Exception;
use Illuminate\Support\Facades\Log;

class CustomChatController extends Controller
{
    /**
     * Fetch a chat thread based on user and listing
     */
    public function fetchChat($user_id, $user_type, $type, $listing_id)
    {
        try {
            $receiver_data = ChatManager::getRoleDetail();

            $sender_data = [
                'user_id' => $user_id,
                'role' => $user_type
            ];

            $chats = ChatManager::getchats($sender_data, $receiver_data, $type, $listing_id);

            // Include user info for display
            $senderInfo = ChatManager::getUserDataChat($user_id, $user_type);
            $receiverInfo = ChatManager::getUserDataChat($receiver_data['user_id'], $receiver_data['role']);

            return response()->json([
                'success' => true,
                'chats' => $chats,
                'sender' => $senderInfo,
                'receiver' => $receiverInfo,
            ]);
        } catch (Exception $e) {
            Log::error('Fetch Chat Error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch chat'], 500);
        }
    }

    /**
     * Mark messages as read
     */
    public function setRead(Request $request)
    {
        try {
            foreach ($request->data as $item) {
                $chat = ChatsOther::find($item['id']);
                if ($chat && !$chat->is_read) {
                    $chat->is_read = true;
                    $chat->read_at = now();
                    $chat->save();
                }
            }

            return response('success', 200);
        } catch (Exception $e) {
            Log::error('Set Read Error: ' . $e->getMessage());
            return response('Error setting read status', 500);
        }
    }

    /**
     * Toggle open/close status for chats
     */
    public function setOpenStatus(Request $request)
    {
        try {
            $type = $request->type;
            $sender_id = $request->sender_id;
            $sender_type = $request->sender_type;

            $chats = ChatsOther::where('type', $type)
                ->where('sender_id', $sender_id)
                ->where('sender_type', $sender_type)
                ->get();

            $avgStatus = $chats->avg('openstatus');
            $newStatus = $avgStatus == 1 ? '0' : '1';

            ChatsOther::where('type', $type)
                ->where('sender_id', $sender_id)
                ->where('sender_type', $sender_type)
                ->update(['openstatus' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Open Status Updated Successfully',
                'new_status' => $newStatus,
            ]);
        } catch (Exception $e) {
            Log::error('Set Open Status Error: ' . $e->getMessage());
            return response('Error setting open status', 500);
        }
    }
}
