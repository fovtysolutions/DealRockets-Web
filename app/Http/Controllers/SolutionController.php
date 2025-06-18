<?php

namespace App\Http\Controllers;

use App\Models\Solution;
use App\Models\SolutionCategory;
use App\Models\SolutionSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SolutionController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'solution_name' => 'required|string|max:255',
            'solution_image' => 'required|image',

            'categories' => 'nullable|array|max:10',
            'categories.*.name' => 'nullable',
            'categories.*.image' => 'nullable|image',

            'categories.*.subcategories' => 'nullable|array|max:5',
            'categories.*.subcategories.*.name' => 'nullable',
            'categories.*.subcategories.*.image' => 'nullable|image',
        ]);

        $solutionImagePath = $request->hasFile('solution_image')
            ? $request->file('solution_image')->store('solutions', 'public')
            : null;

        $solution = Solution::create([
            'name' => $request->solution_name,
            'image' => $solutionImagePath,
        ]);

        foreach ($request->categories as $categoryData) {
            $categoryImagePath = isset($categoryData['image']) ? $categoryData['image']->store('solution_categories', 'public') : null;

            $category = $solution->categories()->create([
                'name' => $categoryData['name'],
                'image' => $categoryImagePath,
            ]);

            foreach ($categoryData['sub_categories'] as $sub) {
                $subImagePath = isset($sub['image']) ? $sub['image']->store('solution_sub_categories', 'public') : null;

                $category->subCategories()->create([
                    'name' => $sub['name'],
                    'image' => $subImagePath,
                ]);
            }
        }

        return redirect()->back()->with('success','Stored Success');
    }

}
