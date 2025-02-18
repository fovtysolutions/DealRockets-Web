<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatsOther extends Model
{
    protected $fillable = ['sender_id', 'sender_type', 'receiver_id', 'receiver_type', 'message', 'is_read', 'sent_at','type','leads_id','suppliers_id','stocksell_id','openstatus'];

    public function sender()
    {
        return $this->morphTo();
    }

    public function receiver()
    {
        return $this->morphTo();
    }
}
