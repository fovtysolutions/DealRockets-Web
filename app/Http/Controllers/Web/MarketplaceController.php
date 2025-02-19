<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    // Fetch category details along with its products
    public function getCategoryDetails($category_id) {
        $categories = Category::where('id', $category_id)->first();
        $categoriesproducts = Product::where('category_id', $categories->id)->get();
    
        // Get all subcategories of the given category
        $subcategories = $categories->childes;
    
        // Collect all sub-subcategories (children of subcategories)
        $subsubcategories = collect();
    
        foreach ($subcategories as $subcategory) {
            $subsubcategories = $subsubcategories->merge($subcategory->childes);
        }
    
        // Randomly select 8 sub-subcategories
        $randomSubsubcategories = $subsubcategories->shuffle()->take(8);
    
        return view('web.products.categorylanding', compact('categories', 'categoriesproducts', 'randomSubsubcategories'));
    }
    
    // Fetch products by subcategory
    public function getProductsBySubCategory($subcategory_id){
        $subcategory = Category::where('id', $subcategory_id)->first();  // Assuming subcategory is stored in the same table
        if (!$subcategory) {
            return redirect()->back()->with('error', 'Subcategory not found.');
        }

        // Fetch products belonging to this subcategory
        $subcategoryProducts = Product::where('subcategory_id', $subcategory->id)->get();

        return view('web.products.productpage', compact('subcategory', 'subcategoryProducts'));
    }
}
