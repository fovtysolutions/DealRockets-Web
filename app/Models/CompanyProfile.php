<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'subtitle',
        'description_head',
        'description_text',
        'images',
        'certificates',
        'total_capitalization',
        'year_established',
        'total_employees',
        'company_certificates',
        'product_certificates',
        'business_type',
        'total_annual_sales',
        'export_percentage',
        'oem_service',
        'small_orders_accepted',
        'main_export_markets',
        'payment_terms',
        'delivery_terms',
        'hot_products',
        'product_categories',
        'factory_size',
        'production_lines',
        'monthly_output',
        'main_products',
        'lead_time',
        'qc_staff_count',
        'inspection_process',
        'testing_equipment',
        'qc_certifications',
        'rd_staff_count',
        'patents',
        'annual_rd_spending',
        'customization_offered',
        'product_dev_time',
        'address',
        'local_time',
        'telephone',
        'mobile',
        'fax',
        'showroom',
        'contact_name',
        'contact_dept',
        'email',
        'website',
        'seller',
    ];
    protected $casts = [
        'images' => 'array',
        'certificates' => 'array',
        'company_certificates' => 'array',
        'product_certificates' => 'array',
        'main_export_markets' => 'array',
        'payment_terms' => 'array',
        'delivery_terms' => 'array',
        'hot_products' => 'array',
        'product_categories' => 'array',
        'main_products' => 'array',
        'testing_equipment' => 'array',
        'qc_certifications' => 'array',
    ];
}
