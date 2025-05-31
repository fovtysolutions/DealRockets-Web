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
    public function fetchChat($user_id,$user_type,$type,$listing_id){
        $reciever_data = ChatManager::getRoleDetail();
        $sender_data = [
            'user_id' => $user_id,
            'role' => $user_type
        ];
        $chats = ChatManager::getchats($sender_data,$reciever_data,$type,$listing_id);
        return $chats;
    }

    public function setRead(Request $request){
        try{
            $chat_data = $request->data;
            foreach ($chat_data as $item) {
                $chat_info = ChatsOther::where('id',$item['id'])->first();
                $chat_info->is_read = 1;
                $chat_info->save();
            }
            return response('success',200);
        } catch (Exception $e){
            Log::error('Set Read Error: ' . $e->getMessage()); 
            return response('Error setting read status', 500);
        }
    }

    public function setOpenStatus(Request $request){
        try{
            // Get Data for Filtering
            $type = $request->type;
            $sender_id = $request->sender_id;
            $sender_type = $request->sender_type;

            $user_chat_data = ChatsOther::where('type',$type)
            ->where('sender_id',$sender_id)
            ->where('sender_type',$sender_type)
            ->get();

            $average_status = $user_chat_data->avg('openstatus');

            $new_status = $average_status === 1 ? '0' : '1';

            ChatsOther::where('type',$type)
            ->where('sender_id',$sender_id)
            ->where('sender_type',$sender_type)
            ->update(['openstatus' => $new_status]);

            return response()->json([
                'success' => true,
                'message' => 'Open Status Updated Successfully',
                'new_status' => $new_status
            ]);
        } catch(Exception $e) {
            Log::error('Set Read Error: '. $e->getMessage());
            return response('Error setting read status',500);
        }
    }
}
