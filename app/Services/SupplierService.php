<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;

class SupplierService
{
    public function getImportBulkSupplierData(object $request, string $addedBy, string $role): array
    {
        try {
            $collections = (new FastExcel)->import($request->file('suppliers_file'));
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => translate('you_have_uploaded_a_wrong_format_file') . ',' . translate('please_upload_the_right_file'),
                'suppliers' => []
            ];
        }

        $columnKey = [
            'name',
            'business_type',
            'main_products',
            'management_certification',
            'city_province',
            'added_by',
            'role',
        ];
        $skip = [];

        if (count($collections) <= 0) {
            return [
                'status' => false,
                'message' => translate('you_need_to_upload_with_proper_data'),
                'suppliers' => []
            ];
        }

        $suppliers = [];
        foreach ($collections as $collection) {
            foreach ($collection as $key => $value) {
                if ($key != "" && !in_array($key, $columnKey)) {
                    return [
                        'status' => false,
                        'message' => translate('Please_upload_the_correct_format_file'),
                        'suppliers' => []
                    ];
                }

                if ($key != "" && $value === "" && !in_array($key, $skip)) {
                    return [
                        'status' => false,
                        'message' => translate('Please fill ' . $key . ' fields'),
                        'suppliers' => []
                    ];
                }
            }

            $suppliers[] = [
                'name' => $collection['name'],
                'business_type' => $collection['business_type'],
                'main_products' => $collection['main_products'],
                'management_certification' => $collection['management_certification'],
                'city_province' => $collection['city_province'],
                'added_by' => $addedBy,
                'role' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Here you might want to bulk insert suppliers to improve performance
        Supplier::insert($suppliers);

        return [
            'status' => true,
            'message' => count($suppliers) . ' - ' . translate('suppliers_imported_successfully'),
            'suppliers' => $suppliers
        ];
    }
}
