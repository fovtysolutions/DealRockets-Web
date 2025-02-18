<?php

namespace App\Services;

use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Quotation;
use App\Models\Admin;

class QuotationService
{
    public function getImportquotationService(object $request, string $addedBy, string $role): array
    {
        try {
            $collections = (new FastExcel)->import($request->file('quotation_file'));
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => translate('you_have_uploaded_a_wrong_format_file') . ',' . translate('please_upload_the_right_file'),
                'quotation' => []
            ];
        }

        $columnKey = [
            'name',
            'description',
            'quantity',
        ];
        $skip = [];

        if (count($collections) <= 0) {
            return [
                'status' => false,
                'message' => translate('you_need_to_upload_with_proper_data'),
                'quotation' => []
            ];
        }

        $quotation = [];
        foreach ($collections as $collection) {
            foreach ($collection as $key => $value) {
                if ($key != "" && !in_array($key, $columnKey)) {
                    return [
                        'status' => false,
                        'message' => translate('Please_upload_the_correct_format_file'),
                        'quotation' => []
                    ];
                }

                if ($key != "" && $value === "" && !in_array($key, $skip)) {
                    return [
                        'status' => false,
                        'message' => translate('Please fill ' . $key . ' fields'),
                        'quotation' => []
                    ];
                }
            }

            $adminId = auth('admin')->id();
            $admin = Admin::where('id',$adminId);

            // Prepare supplier data with only the new fields
            $quotation[] = [
                'name' => $collection['name'],
                'description' => $collection['description'],
                'quantity' => $collection['quantity'],
                'user_id' => $addedBy,
                'role' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Bulk insert quotation to improve performance
        Quotation::insert($quotation);

        return [
            'status' => true,
            'message' => count($quotation) . ' - ' . translate('quotation_imported_successfully'),
            'quotation' => $quotation
        ];
    }
}
