<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\NewProductStore;
use App\Models\Product;
use App\Utils\ChatManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewProductStoreController extends Controller
{
    public function getSlug($name)
    {
        return Str::slug($name, '-') . '-' . Str::random(6);
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        $data['target_market'] = json_encode($data['target_market'] ?? []);
        $data['dynamic_data'] = json_encode($data['dynamic_data'] ?? []);
        $data['dynamic_data_technical'] = json_encode($data['dynamic_data_technical'] ?? []);
        $data['slug'] = $this->getSlug($data['name']);
        $data['published'] = 0;
        $data['status'] = 0;

        // Handle file uploads (null-safe)
        $data['thumbnail'] = $request->hasFile('thumbnail')
            ? $this->uploadFile($request, 'thumbnail', 'products/thumbnails')
            : null;

        $data['certificates'] = $request->hasFile('certificates')
            ? $this->uploadMultiple($request, 'certificates', 'products/certificates')
            : null;

        $data['extra_images'] = $request->hasFile('extra_images')
            ? $this->uploadMultiple($request, 'extra_images', 'products/extra_images')
            : null;

        $user_details = ChatManager::getRoleDetail();

        $data['added_by'] = $user_details['role'];
        $data['user_id'] = $user_details['user_id'];

        Log::info($data);

        $product = Product::create($data);

        session()->flash('success', 'Product Added successfully!');
        return redirect()->back();
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request);

        $data['target_market'] = json_encode($data['target_market'] ?? []);
        $data['dynamic_data'] = json_encode($data['dynamic_data'] ?? []);
        $data['dynamic_data_technical'] = json_encode($data['dynamic_data_technical'] ?? []);
        $data['slug'] = $this->getSlug($data['name']);

        // Handle file uploads if updated
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadFile($request, 'thumbnail', 'products/thumbnails');
        }

        if ($request->hasFile('certificates')) {
            $data['certificates'] = $this->uploadMultiple($request, 'certificates', 'products/certificates');
        }

        if ($request->hasFile('extra_images')) {
            $data['extra_images'] = $this->uploadMultiple($request, 'extra_images', 'products/extra_images');
        }

        $product->update($data);

        session()->flash('success', 'Product updated successfully!');
        return redirect()->back();
    }

    // ✅ Shared validation logic
    protected function validateProduct(Request $request): array
    {
        return $request->validate([
            'category_id' => 'required|integer',
            'sub_category_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'hts_code' => 'nullable|string',
            'origin' => 'nullable|string',
            'minimum_order_qty' => 'nullable|numeric',
            'unit' => 'nullable|string',
            'supply_capacity' => 'nullable|string',
            'unit_price' => 'nullable|string',
            'delivery_terms' => 'nullable|string',
            'delivery_mode' => 'nullable|string',
            'place_of_loading' => 'nullable|string',
            'port_of_loading' => 'nullable|string',
            'lead_time' => 'nullable|string',
            'lead_time_unit' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'packing_type' => 'nullable|string',
            'weight_per_unit' => 'nullable|string',
            'dimensions_per_unit' => 'nullable|string',
            'dimension_unit' => 'nullable|string',
            'master_packing' => 'nullable|string',
            'container' => 'nullable|string',
            'target_market' => 'nullable',
            'brand' => 'nullable|string',
            'short_details' => 'nullable|string',
            'details' => 'nullable|string',
            'dynamic_data' => 'nullable',
            'dynamic_data_technical' => 'nullable',
            'thumbnail' => 'nullable|image',
            'extra_images' => 'array|max:8',
            'extra_images.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
            'certificates' => 'array|max:8',
            'certificates.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
            'local_currency' => 'nullable',
            'supply_unit' => 'nullable',
            'load_capacity_per_lot' => 'nullable',
            'master_packing_type' => 'nullable',
        ]);
    }

    // ✅ Helper to upload single file
    protected function uploadFile(Request $request, string $field, string $path)
    {
        return $request->hasFile($field)
            ? $request->file($field)->store($path, 'public')
            : null;
    }

    // ✅ Helper to upload multiple files
    protected function uploadMultiple(Request $request, string $field, string $path)
    {
        if (!$request->hasFile($field)) {
            return null;
        }

        $paths = [];
        foreach ($request->file($field) as $file) {
            $paths[] = $file->store($path, 'public');
        }

        return json_encode($paths);
    }

    public function view($id)
    {
        $product = Product::find($id);

        return view('vendor-views.product.product_view', compact('product'));
    }

    public function view_admin($id)
    {
        $product = Product::find($id);

        return view('admin-views.product.product_view', compact('product'));
    }

    public function update_status($id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->status == 0) {
                $product->status = 1;
            } else {
                $product->status = 0;
            }
            $product->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Status update failed.']);
        }
    }

    public function deny_status($id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->status == 1) {
                $product->status = 2;
            } else {
                $product->status = 1;
            }
            $product->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Status update failed.']);
        }
    }

    public function publish_update($id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->published == 0) {
                $product->published = 1;
            } else {
                $product->published = 0;
            }
            $product->save();

            return response()->json(['success' => true, 'message' => 'Published successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Publishing failed.']);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->back()->with('success', 'Product Deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete product.');
        }
    }
}
