<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class StockSell extends Model
{
    use HasFactory;
    protected $table = "stock_sell";
    protected $fillable = [
        'name', 'description', 'quantity', 'product_id', 'status', 'user_id',
        'role', 'created_at', 'updated_at', 'image', 'country','industry','company_name',
        'company_address','company_icon','compliance_status','upper_limit','lower_limit',
        'unit','city','stock_type','product_type','origin','badge','refundable','sub_category_id',
        'hs_code','rate','local_currency','delivery_terms','place_of_loading','port_of_loading','packing_type',
        'weight_per_unit','dimensions_per_unit','dynamic_data','dynamic_data_technical','certificate'
    ];

    public function countryRelation()
    {
        return $this->belongsTo(Country::class, 'country', 'id'); // Adjust 'country' and 'id' as per your database schema
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
