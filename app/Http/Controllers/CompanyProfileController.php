<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function store(Request $request)
    {
        $sellerId = auth('seller')->user()->id;

        // Get existing or create new
        $companyProfile = CompanyProfile::firstOrNew(['seller' => $sellerId]);

        // Fields to exclude from direct assignment
        $fileFields = ['images', 'certificates', 'company_certificates', 'product_certificates'];

        // Start with normal data
        $data = $request->except($fileFields);
        $data['seller'] = $sellerId;

        // Handle each multiple-file upload field
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $paths = [];
                foreach ($request->file($field) as $file) {
                    $paths[] = $file->store("company_profile/{$field}", 'public');
                }
                $data[$field] = json_encode($paths);
            }
        }

        // Save or update
        $companyProfile->fill($data)->save();

        return response()->json([
            'message' => $companyProfile->wasRecentlyCreated
                ? 'Company profile created successfully.'
                : 'Company profile updated successfully.',
            'data' => $companyProfile
        ]);
    }

    public function destroy(CompanyProfile $companyProfile)
    {
        $companyProfile->delete();

        return response()->json(['message' => 'Company profile deleted successfully.']);
    }
}
