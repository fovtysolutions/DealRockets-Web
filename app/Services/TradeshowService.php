<?php

namespace App\Services;

use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Tradeshow;

class TradeshowService
{
    public function getImportTradeShowService(object $request, string $addedBy, string $role): array
    {
        try {
            $collections = (new FastExcel)->import($request->file('tradeshow_file'));
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => translate('you_have_uploaded_a_wrong_format_file') . ',' . translate('please_upload_the_right_file'),
                'leads' => []
            ];
        }

        $columnKey = [
            'name',
            'company_name', // 'buyer' or 'seller'
            'hall',
            'stand',
            'address',
            'city',
            'country',
            'description',
            'website',
        ];
        $skip = [];

        if (count($collections) <= 0) {
            return [
                'status' => false,
                'message' => translate('you_need_to_upload_with_proper_data'),
                'leads' => []
            ];
        }

        $tradeshow = [];
        foreach ($collections as $collection) {
            foreach ($collection as $key => $value) {
                if ($key != "" && !in_array($key, $columnKey)) {
                    return [
                        'status' => false,
                        'message' => translate('Please_upload_the_correct_format_file'),
                        'leads' => []
                    ];
                }

                if ($key != "" && $value === "" && !in_array($key, $skip)) {
                    return [
                        'status' => false,
                        'message' => translate('Please fill ' . $key . ' fields'),
                        'leads' => []
                    ];
                }
            }

            // Prepare supplier data with only the new fields
            $tradeshow[] = [
                'name' => $collection['name'],
                'company_name' => $collection['company_name'], // 'buyer' or 'seller'
                'hall' => $collection['hall'],
                'stand' => $collection['stand'],
                'address' => $collection['address'],
                'city' => $collection['city'],
                'country' => $collection['country'],
                'description' => $collection['description'],
                'website' => $collection['website'],
                'added_by' => $addedBy,
                'role' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Bulk insert leads to improve performance
        Tradeshow::insert($tradeshow);

        return [
            'status' => true,
            'message' => count($tradeshow) . ' - ' . translate('leads_imported_successfully'),
            'tradeshow' => $tradeshow
        ];
    }
}
