<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Admin\Settings\CountrySetupController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\StockSell;
use Brian2694\Toastr\Facades\Toastr;
use App\Utils\ChatManager;
use App\Utils\CategoryManager;
use Exception;
use App\Models\Country;
use App\Models\StockCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\ComplianceService; // Import the ComplianceService

class StockSellController extends Controller
{
    public function index(Request $request)
    {
        $query = StockSell::query();
        $query->whereHas('countryRelation',function($query){
            $query->where('country','no');
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
        $items = $query->get()->paginate(10);
        return view('admin-views.stocksell.index', compact('items'));
    }

    public function create()
    {
        $user_data = ChatManager::getRoleDetail();
        $user_id = $user_data['user_id'];
        $role = $user_data['role'];
        $items = Product::where('user_id', $user_id)->where('added_by', $role)->get()->pluck('name', 'id');
        $countries = CountrySetupController::getCountries();
        $categories = StockCategory::all();
        return view('admin-views.stocksell.create', compact('items', 'countries', 'categories'));
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

        // Create the StockSell record
        $stockSell = StockSell::create($validatedData);

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

        // If images were uploaded, save their paths to the database
        if (!empty($imagePaths)) {
            $stockSell->update(['image' => json_encode($imagePaths)]);  // Store image paths as a JSON array
        }

        toastr()->success('Stock Successfully Created');
        return redirect()->route('admin.stock.index')->with('success', 'Record created successfully.');
    }

    public function show($id)
    {
        $stocksell = StockSell::where('id', $id)->first();
        $name = ChatManager::getproductname($stocksell->product_id);
        return view('admin-views.stocksell.show', compact('stocksell', 'name'));
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
        $categories = StockCategory::all();
        return view('admin-views.stocksell.edit', compact('stocksell', 'items', 'name', 'countries', 'categories'));
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
    
            // Perform compliance check
            $complianceStatus = ComplianceService::checkStockSaleCompliance($validatedData);
    
            // Add compliance status to the validated data
            $validatedData['compliance_status'] = $complianceStatus;
    
            // Update the StockSell record with the validated data
            $stockSell->update($validatedData);
    
            toastr()->success('Record Updated Successfully');
            return redirect()->route('admin.stock.index')->with('success', 'Record updated successfully.');
        } catch (Exception $e) {
            toastr()->error('Record Updation Failed');
            Log::error("Error Updating Record: " . $e->getMessage());
            return redirect()->back()->with('error', 'Record Updation Failed');
        }
    }

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
            'images' => "$nullable|array|max:10",  // Max 5 images allowed, nullable for update
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',  // Validate each image
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
            'role' => $user_data['role']
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

    public function destroy($id)
    {
        $stocksell = StockSell::findOrFail($id);
        $stocksell->delete();
        toastr()->success('Record Deleted Successfully');
        return redirect()->route('admin.stock.index')->with('success', 'Record deleted successfully.');
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
        return view('admin-views.stocksell.messages', compact('chats', 'closechats', 'openchats'));
    }

    public function catindex()
    {
        try {
            // Display all job categories
            $categories = StockCategory::all();
            return view('admin-views.stocksell.category_management.list', compact('categories'));
        } catch (QueryException $e) {
            // Catch any database related errors and show a message
            toastr()->error('Error fetching categories: ' . $e->getMessage());
            return redirect()->route('admin.stock.category.list');
        }
    }

    public function catcreate()
    {
        try {
            // Show the form to create a new job category
            return view('admin-views.stocksell.category_management.add');
        } catch (\Exception $e) {
            toastr()->error('Error loading the category creation form: ' . $e->getMessage());
            return redirect()->route('admin.stock.category.list');
        }
    }

    public function catstore(Request $request)
    {
        try {
            // Validate and store the new job category
            $request->validate([
                'name' => 'required|string|max:255',
                'active' => 'required|in:1,0',
            ]);

            StockCategory::create($request->all());

            toastr()->success('Category Successfully Created');
            return redirect()->route('admin.stock.category.list')
                ->with('success', 'Job Category created successfully.');
        } catch (QueryException $e) {
            // Catch database-related errors during create operation
            toastr()->error('Error creating category: ' . $e->getMessage());
            return redirect()->route('admin.stock.category.list');
        } catch (\Exception $e) {
            // Catch general errors
            toastr()->error('Unexpected error: ' . $e->getMessage());
            return redirect()->route('admin.stock.category.list');
        }
    }

    public function catupdate(Request $request, StockCategory $stockCategory)
    {
        try {
            // Validate and update the job category
            $request->validate([
                'name' => 'required|string|max:255',
                'active' => 'required|in:1,0',
            ]);

            $stockCategory->update($request->all());

            toastr()->success('Category Successfully Updated');
            return redirect()->route('admin.stock.category.list')
                ->with('success', 'Job Category updated successfully.');
        } catch (QueryException $e) {
            // Catch database-related errors during update operation
            toastr()->error('Error updating category: ' . $e->getMessage());
            return redirect()->route('admin.stock.category.list');
        } catch (\Exception $e) {
            // Catch general errors
            toastr()->error('Unexpected error: ' . $e->getMessage());
            return redirect()->route('admin.stock.category.list');
        }
    }

    public function catdestroy(StockCategory $stockCategory)
    {
        try {
            // Delete the job category
            $stockCategory->delete();

            toastr()->success('Category Successfully Deleted');
            return redirect()->route('admin.stock.category.list')
                ->with('success', 'Job Category deleted successfully.');
        } catch (QueryException $e) {
            // Catch database-related errors during delete operation
            toastr()->error('Error deleting category: ' . $e->getMessage());
            return redirect()->route('admin.stock.category.list');
        } catch (\Exception $e) {
            // Catch general errors
            toastr()->error('Unexpected error: ' . $e->getMessage());
            return redirect()->route('admin.stock.category.list');
        }
    }
}
