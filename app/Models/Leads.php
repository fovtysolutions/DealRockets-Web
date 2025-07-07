<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', // 'buyer' or 'seller'
        'name',
        'country',
        'company_name',
        'contact_number',
        'posted_date',
        'quantity_required',
        'buying_frequency',
        'details',
        'added_by',
        'role',
        'industry',
        'term',
        'unit',
        'product_id',
        'active',
        'images',
        'compliance_status',
        'city',
        'tags',
        'refund',
        'avl_stock',
        'avl_stock_unit',
        'lead_time',
        'brand',
        'payment_option',
        'offer_type',
        'size',
        'sub_category_id',
        'hs_code',
        'rate',
        'delivery_terms',
        'delivery_mode',
        'place_of_loading',
        'port_of_loading',
        'packing_type',
        'size',
        'brand',
        'dynamic_data',
    ];

    public function countryRelation()
    {
        return $this->belongsTo(Country::class, 'country', 'id'); // Adjust 'country' and 'id' as per your database schema
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
