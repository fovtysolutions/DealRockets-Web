<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Admin\Settings\CountrySetupController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Utils\CategoryManager;
use Illuminate\Http\Request;
use App\Models\StockSell;
use Brian2694\Toastr\Facades\Toastr;
use App\Utils\ChatManager;
use Exception;
use App\Models\Country;
use App\Models\StockCategory;
use App\Services\ComplianceService;
use Illuminate\Support\Facades\Log;

class VendorStockSellController extends Controller
{
    private function validateStockSellData($request, $nullable = '')
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer',
            'product_id' => 'required',
            'status' => 'required|in:active,inactive,rejected',
            'country' => 'required',
            'industry' => 'required',
            'company_name' => 'required',
            'company_address' => 'required',
            'company_icon' => 'nullable',
            'images' => "$nullable|array|max:10",
            'images.*' => 'image|max:2048',
            'compliance_status' => 'nullable|in:pending,approved,flagged',
            'upper_limit' => 'nullable|string',
            'lower_limit' => 'nullable|string',
            'unit' => 'nullable|string',
            'city' => 'required|string',
            'stock_type' => 'nullable|string',
            'product_type' => 'nullable|string',
            'origin' => 'nullable|string',
            'badge' => 'nullable|string',
            'refundable' => 'nullable|string',
            'sub_category_id' => 'nullable|string',
            'hs_code' => 'nullable|string',
            'rate' => 'nullable|integer',
            'rate_unit' => 'nullable|string',
            'local_currency' => 'nullable|string',
            'delivery_terms' => 'nullable|string',
            'place_of_loading' => 'nullable|string',
            'port_of_loading' => 'nullable|string',
            'packing_type' => 'nullable|string',
            'weight_per_unit' => 'nullable|string',
            'weight_per_unit_type' => 'nullable|string',
            'dimensions_per_unit' => 'nullable|string',
            'dimensions_per_unit_type' => 'nullable|string',
            'dimension_per_unit' => 'nullable|string',
            'dimension_per_unit_type' => 'nullable|string',
            'master_packing' => 'nullable|string',
            'master_packing_unit' => 'nullable|string',
            'certificate' => 'nullable|image',
            'dynamic_data' => 'nullable',
            'dynamic_data_technical' => 'nullable',
        ]);
    }

    private function prepareStockSellData($request, $user_data = null)
    {
        if (!$user_data) {
            $user_data = ChatManager::getRoleDetail();
        }

        return [
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'product_id' => $request->product_id,
            'status' => $request->status,
            'country' => $request->country,
            'industry' => $request->industry,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'user_id' => $user_data['user_id'],
            'role' => $user_data['role'],
            'compliance_status' => $request->compliance_status ?? 'pending',
            'upper_limit' => $request->upper_limit,
            'lower_limit' => $request->lower_limit,
            'unit' => $request->unit,
            'city' => $request->city,
            'stock_type' => $request->stock_type,
            'product_type' => $request->product_type,
            'origin' => $request->origin,
            'badge' => $request->badge,
            'refundable' => $request->refundable,
            'sub_category_id' => $request->sub_category_id,
            'hs_code' => $request->hs_code,
            'rate' => $request->rate,
            'rate_unit' => $request->rate_unit,
            'local_currency' => $request->local_currency,
            'delivery_terms' => $request->delivery_terms,
            'place_of_loading' => $request->place_of_loading,
            'port_of_loading' => $request->port_of_loading,
            'packing_type' => $request->packing_type,
            'weight_per_unit' => $request->weight_per_unit,
            'weight_per_unit_type' => $request->weight_per_unit_type,
            'dimensions_per_unit' => $request->dimensions_per_unit,
            'dimensions_per_unit_type' => $request->dimensions_per_unit_type,
            'dimension_per_unit' => $request->dimension_per_unit,
            'dimension_per_unit_type' => $request->dimension_per_unit_type,
            'master_packing' => $request->master_packing,
            'master_packing_unit' => $request->master_packing_unit,
            'dynamic_data' => $request->dynamic_data,
            'dynamic_data_technical' => $request->dynamic_data_technical,
        ];
    }

    private function handleImages($request, $existingImages = [])
    {
        $imagePaths = $existingImages;

        if ($request->hasFile('images')) {
            // Ensure the total number of images does not exceed 5
            $newImagesCount = count($existingImages) + count($request->file('images'));
            if ($newImagesCount > 5) {
                toastr()->error('You can upload a maximum of 5 images.');
                return redirect()->back();  // Redirect back if the limit is exceeded
            }

            foreach ($request->file('images') as $image) {
                // Create a unique name for the image
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Store the image in the public directory (using public_path)
                $image->move(public_path('stock_images'), $imageName);

                // Add the new image path to the array
                $imagePaths[] = 'stock_images/' . $imageName;
            }
        }

        return $imagePaths;
    }

    private function handleImageRemovals($request, $existingImages)
    {
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageToRemove) {
                // Delete the image file from the public storage using public_path
                $imagePath = public_path($imageToRemove);
                if (file_exists($imagePath)) {
                    unlink($imagePath);  // Remove the image file
                }

                // Remove the image path from the existing images array
                $existingImages = array_filter($existingImages, function ($img) use ($imageToRemove) {
                    return $img !== $imageToRemove;
                });
            }
        }

        return $existingImages;
    }

    public function index(Request $request)
    {
        $query = StockSell::query();
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $query->where('user_id', $user_id);
        $query->where('role', $role);
        $query->whereHas('countryRelation', function ($query) {
            $query->where('blacklist', 'no');
        });

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->status) {
            $query->where('status', 'like', '%' . $request->status . '%');
        }
        if ($request->minqty) {
            $query->where('quantity', '>=', $request->minqty);
        }
        if ($request->maxqty) {
            $query->where('quantity', '<=', $request->maxqty);
        }
        $items = $query->paginate(10);
        return view('vendor-views.stocksell.index', compact('items'));
    }

    public function create()
    {
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        $countries = CountrySetupController::getCountries();
        $industry = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $categories = StockCategory::all();
        return view('vendor-views.stocksell.create', compact('items', 'industry', 'countries', 'categories'));
    }

    public function store(Request $request)
    {
        $user_data = ChatManager::getRoleDetail();

        // Validate the form data
        $this->validateStockSellData($request);

        // Prepare the validated data (excluding images)
        $validatedData = $this->prepareStockSellData($request, $user_data);

        // Perform compliance check
        $complianceStatus = ComplianceService::checkStockSaleCompliance($validatedData);

        // Add compliance status to the validated data
        $validatedData['compliance_status'] = $complianceStatus;

        // Handle image uploads and save paths
        $imagePaths = $this->handleImages($request);

        // Handle company icon upload
        if ($request->hasFile('company_icon')) {
            $companyIcon = $request->file('company_icon');

            $imageName = time() . '_' . $companyIcon->getClientOriginalName();

            $companyIcon->move(public_path('stock_images'), $imageName);

            $companyIconPath = 'stock_images/' . $imageName;

            $validatedData['company_icon'] = $companyIconPath;
        }

        if ($request->hasFile('certificate')) {
            $certificate = $request->file('certificate');

            $imageName = time() . '_' . $certificate->getClientOriginalName();

            $certificate->move(public_path('stock_images'), $imageName);

            $certificate = 'stock_images/certificates' . $imageName;

            $validatedData['certificate'] = $certificate;
        }

        $validatedData['dynamic_data'] = json_encode($validatedData['dynamic_data']);
        $validatedData['dynamic_data_technical'] = json_encode($validatedData['dynamic_data_technical']);

        // Create the StockSell record
        $stockSell = StockSell::create($validatedData);

        // If images were uploaded, save their paths to the database
        if (!empty($imagePaths)) {
            $stockSell->update(['image' => json_encode($imagePaths)]);  // Store image paths as a JSON array
        }

        toastr()->success('Stock Successfully Created');
        return redirect()->route('vendor.stock.index')->with('success', 'Record created successfully.');
    }

    public function show($id)
    {
        $stocksell = StockSell::where('id', $id)->first();
        $name = ChatManager::getproductname($stocksell->product_id);
        return view('vendor-views.stocksell.show', compact('stocksell', 'name'));
    }

    public function edit($id)
    {
        $stocksell = StockSell::where('id', $id)->first();
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        $name = ChatManager::getproductname($stocksell->product_id);
        $countries = CountrySetupController::getCountries();
        $industry = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $categories = StockCategory::all();
        $dynamicData = $stocksell->dynamic_data;
        $dynamicDataTechnical = $stocksell->dynamic_data_technical;
        return view('vendor-views.stocksell.edit', compact('stocksell', 'items', 'name', 'industry', 'dynamicData', 'dynamicDataTechnical', 'countries', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validateStockSellData($request, 'nullable');

            $validatedData = $this->prepareStockSellData($request);

            $stockSell = StockSell::findOrFail($id);

            $existingImages = json_decode($stockSell->image, true) ?? [];

            $existingImages = $this->handleImageRemovals($request, $existingImages);

            $imagePaths = $this->handleImages($request, $existingImages);

            if ($imagePaths) {
                $validatedData['image'] = json_encode($imagePaths);
            }

            if (!$request->has('sub_category_id')) {
                $validatedData['sub_category_id'] = $stockSell->sub_category_id;
            }

            if ($request->hasFile('company_icon')) {
                // If the StockSell has an existing company_icon, delete the old one
                if ($stockSell->company_icon) {
                    $oldIconPath = public_path('stock_images/' . $stockSell->company_icon);

                    // Check if the file exists and delete it
                    if (file_exists($oldIconPath)) {
                        unlink($oldIconPath);  // Delete the old company icon file
                    }
                }

                // Store the new company icon in the public 'stock_images' directory
                $companyIcon = $request->file('company_icon');
                $imageName = time() . '_' . $companyIcon->getClientOriginalName();

                // Move the new company icon to the 'stock_images' folder
                $companyIcon->move(public_path('stock_images'), $imageName);

                // Save the new icon's relative path in the database
                $companyIconPath = 'stock_images/' . $imageName;
                $validatedData['company_icon'] = $companyIconPath;  // Save the path for the new icon
            }

            if ($request->hasFile('certificate')) {
                // If the StockSell has an existing company_icon, delete the old one
                if ($stockSell->certificate) {
                    $oldIconPath = public_path('stock_images/' . $stockSell->certificate);

                    // Check if the file exists and delete it
                    if (file_exists($oldIconPath)) {
                        unlink($oldIconPath);  // Delete the old company icon file
                    }
                }

                // Store the new company icon in the public 'stock_images' directory
                $certificate = $request->file('certificate');
                $imageName = time() . '_' . $certificate->getClientOriginalName();

                // Move the new company icon to the 'stock_images' folder
                $certificate->move(public_path('stock_images/'), $imageName);

                // Save the new icon's relative path in the database
                $certificate = 'stock_images/' . $imageName;
                $validatedData['certificate'] = $certificate;  // Save the path for the new icon
            }

            // Perform compliance check
            $complianceStatus = ComplianceService::checkStockSaleCompliance($validatedData);

            // Add compliance status to the validated data
            $validatedData['compliance_status'] = $complianceStatus;

            $validatedData['dynamic_data'] = json_encode($validatedData['dynamic_data']);
            $validatedData['dynamic_data_technical'] = json_encode($validatedData['dynamic_data_technical']);

            // Update the StockSell record with the validated data
            $stockSell->update($validatedData);
            toastr()->success('Record Updated Successfully');

            return redirect()->route('vendor.stock.index')->with('success', 'Record updated successfully.');
        } catch (Exception $e) {
            toastr()->error('Record Updation Failed');
            Log::error("Error Updating Record", [$e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $stocksell = StockSell::findOrFail($id);
        $stocksell->delete();
        toastr()->success('Record Deleted Successfully');
        return redirect()->route('vendor.stock.index')->with('success', 'Record deleted successfully.');
    }

    public function messages()
    {
        $user_data = ChatManager::getRoleDetail();
        $chats = ChatManager::getMessagersName($user_data, 'stocksale', 'customer');
        $openchats = [];
        $closechats = [];
        foreach ($chats as $chat) {
            if ($chat['openstatus'] == 0) {
                $closechats[] = $chat;
            } else {
                $openchats[] = $chat;
            }
        }
        return view('vendor-views.stocksell.messages', compact('chats', 'closechats', 'openchats'));
    }
}
