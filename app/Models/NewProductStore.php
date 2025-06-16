<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewProductStore extends Model
{
    use HasFactory;
    protected $table = 'new_product_stores';
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'hts_code',
        'thumbnail',
        'extra_images',
        'origin',
        'minimum_order_qty',
        'unit',
        'supply_capacity',
        'unit_price',
        'delivery_terms',
        'delivery_mode',
        'place_of_loading',
        'port_of_loading',
        'lead_time',
        'lead_time_unit',
        'payment_terms',
        'packing_type',
        'weight_per_unit',
        'dimensions_per_unit',
        'target_market',
        'brand',
        'short_details',
        'details',
        'dynamic_data',
        'dynamic_data_technical',
        'certificates',
        'role',
        'user_id',
        'local_currency',
        'supply_unit',
    ];
}
