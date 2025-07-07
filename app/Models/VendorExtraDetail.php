<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorExtraDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'vendor_extra_details';

    public function sellerUser()
    {
        return $this->belongsTo(\App\Models\VendorUsers::class, 'seller_users', 'id');
    }
}
