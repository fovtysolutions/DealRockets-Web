<?php

namespace App\Services;

use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Leads;

class LeadService
{
    public function getImportLeadsService(object $request, string $addedBy,string $role): array
    {
        try {
            $collections = (new FastExcel)->import($request->file('leads_file'));
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => translate('you_have_uploaded_a_wrong_format_file') . ',' . translate('please_upload_the_right_file'),
                'leads' => []
            ];
        }

        $columnKey = [
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
        ];
        $skip = [];

        if (count($collections) <= 0) {
            return [
                'status' => false,
                'message' => translate('you_need_to_upload_with_proper_data'),
                'leads' => []
            ];
        }

        $leads = [];
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
            $leads[] = [
                'type' => $collection['type'],
                'name' => $collection['name'],
                'country' => $collection['country'],
                'company_name' => $collection['company_name'],
                'contact_number' => $collection['contact_number'],
                'posted_date' => $collection['posted_date'],
                'quantity_required' => $collection['quantity_required'],
                'buying_frequency' => $collection['buying_frequency'],
                'details' => $collection['details'],
                'added_by' => $addedBy,
                'role' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Bulk insert leads to improve performance
        Leads::insert($leads);

        return [
            'status' => true,
            'message' => count($leads) . ' - ' . translate('leads_imported_successfully'),
            'leads' => $leads
        ];
    }
    public function getImportLeadsServiceAuth(object $request, string $addedBy, string $role): array
    {
        try {
            $collections = (new FastExcel)->import($request->file('leads_file'));
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => translate('you_have_uploaded_a_wrong_format_file') . ',' . translate('please_upload_the_right_file'),
                'leads' => []
            ];
        }
        
        $columnKey = [
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
        ];
        $skip = [];

        if (count($collections) <= 0) {
            return [
                'status' => false,
                'message' => translate('you_need_to_upload_with_proper_data'),
                'leads' => []
            ];
        }

        $leads = [];
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
            $leads[] = [
                'type' => $collection['type'], // 'buyer' or 'seller'
                'name' => $collection['name'],
                'country' => $collection['country'],
                'company_name' => $collection['company_name'],
                'contact_number' => $collection['contact_number'],
                'posted_date' => $collection['posted_date'],
                'quantity_required' => $collection['quantity_required'],
                'buying_frequency' => $collection['buying_frequency'],
                'details' => $collection['details'],
                'added_by' => $addedBy ,
                'role' => $role ,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Bulk insert leads to improve performance
        Leads::insert($leads);

        return [
            'status' => true,
            'message' => count($leads) . ' - ' . translate('leads_imported_successfully'),
            'leads' => $leads
        ];
    }
}
