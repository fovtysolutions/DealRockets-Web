<?php

namespace App\Http\Controllers\Vendor\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Seller;
use App\Models\Supplier;
use App\Utils\ChatManager;
use Illuminate\Http\Request;
use LDAP\Result;

class SupplierController extends Controller
{
    public function getIndex(){
        $data['languages'] = getWebConfig(name: 'pnc_language') ?? null;
        $data['defaultLanguage'] = $data['languages'][0];
        $data['languages'] = 
        [
            $data['languages'][0]
        ];
        $data['categories'] = Category::all();
        // Get the logged-in user's details
        $userdata = ChatManager::getRoleDetail();
        $userId = $userdata['user_id'];
        $userrole = $userdata['role'];

        // Check if the user already has a supplier profile
        $data['supplier'] = Supplier::where('added_by', $userId)->where('role',$userrole)->first();
        return view('vendor-views.supplier.supplier-update',$data);
    }

    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'business_type' => 'required|exists:categories,id', // Validate that business_type exists in the Category table
            'main_products' => 'required|string|max:255',
            'management_certification' => 'nullable|string|max:255', // Use nullable for optional fields
            'city_province' => 'required|string|max:255',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
    
        // Get user details
        $userdata = ChatManager::getRoleDetail();
        $userId = $userdata['user_id'];
        $role = $userdata['role'];
    
        // Add user-specific data
        $validatedData['added_by'] = $userId;
        $validatedData['role'] = $role;
    
        // Resolve business type
        $business_type = Category::find($validatedData['business_type']);
        if ($business_type) {
            $validatedData['business_type'] = $business_type->name;
        } else {
            return redirect()->back()->withErrors(['business_type' => 'Invalid business type selected.']);
        }
    
        // Handle image uploads
        $images = [];
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("image{$i}")) {
                $images["image{$i}"] = $request->file("image{$i}")->store('suppliers/images', 'public');
            }
        }
    
        // Create supplier
        $supplier = Supplier::create(array_merge($validatedData, $images));
    
        // Update seller's supplier_id and confirmation status
        $seller = Seller::find($userId);
        if ($seller) {
            $seller->supplier_id = $supplier->id;
            $seller->suppliers_confirm_status = 1;
            $seller->save();
        } else {
            return redirect()->back()->withErrors(['seller' => 'Seller not found.']);
        }
    
        // Redirect with success message
        toastr()->success('Supplier Profile Created Successfully.');
        return redirect()->back()->with('success', 'Supplier Profile Created Successfully.');
    }

    public function update(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'business_type' => 'required|exists:categories,id', // Validate that business_type exists in the Category table
            'main_products' => 'required|string|max:255',
            'management_certification' => 'nullable|string|max:255', // Optional field
            'city_province' => 'required|string|max:255',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,jfif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,jfif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,jfif|max:2048',
        ]);

        // Get the logged-in user's details
        $userdata = ChatManager::getRoleDetail();
        $userId = $userdata['user_id'];

        // Find the supplier profile for the user
        $supplier = Supplier::where('added_by', $userId)->first();
        if (!$supplier) {
            return redirect()->back()->withErrors(['supplier' => 'Supplier profile not found.']);
        }

        // Resolve business type name
        $business_type = Category::find($validatedData['business_type']);
        if ($business_type) {
            $validatedData['business_type'] = $business_type->name;
        } else {
            return redirect()->back()->withErrors(['business_type' => 'Invalid business type selected.']);
        }

        // Handle image uploads and replace existing images if uploaded
        $images = [];
        for ($i = 1; $i <= 3; $i++) {
            $imageField = "image{$i}";
            if ($request->hasFile($imageField)) {
                // Delete the old image if it exists
                if ($supplier->$imageField) {
                    \Storage::disk('public')->delete($supplier->$imageField);
                }
                // Store the new image
                $images[$imageField] = $request->file($imageField)->store('suppliers/images', 'public');
            }
        }

        // Update supplier data
        $supplier->update(array_merge($validatedData, $images));

        // Update seller's confirmation status if required
        $seller = Seller::find($userId);
        if ($seller) {
            $seller->suppliers_confirm_status = 1; // Assuming it should stay confirmed after an update
            $seller->save();
        }

        // Redirect with a success message
        toastr()->success('Supplier Profile Updated Successfully.');
        return redirect()->back()->with('success', 'Supplier Profile Updated Successfully.');
    }
}
