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

        return redirect()->back()->with('success', 'Stored Success');
    }

    public function edit($id)
    {
        $solution = Solution::where('id',$id)->first();
        $solution->load('categories.subCategories');
        return view('solutions.edit', compact('solution'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'solution_name' => 'required|string|max:255',
            'solution_image' => 'nullable|image',

            'categories' => 'nullable|array|max:10',
            'categories.*.name' => 'nullable|string|max:255',
            'categories.*.image' => 'nullable|image',
            'categories.*.sub_categories' => 'nullable|array|max:5',
            'categories.*.sub_categories.*.name' => 'nullable|string|max:255',
            'categories.*.sub_categories.*.image' => 'nullable|image',
        ]);
        
        $solution = Solution::where('id',$id)->first();

        if ($request->hasFile('solution_image')) {
            Storage::disk('public')->delete($solution->image);
            $solution->image = $request->file('solution_image')->store('solutions', 'public');
        }

        $solution->name = $request->solution_name;
        $solution->save();

        // Remove old categories & subs
        foreach ($solution->categories as $cat) {
            Storage::disk('public')->delete($cat->image);
            foreach ($cat->subCategories as $sub) {
                Storage::disk('public')->delete($sub->image);
            }
        }
        $solution->categories()->delete();

        // Recreate fresh categories
        foreach ($request->input('categories', []) as $i => $catData) {
            if (empty($catData['name']) && !$request->file("categories.$i.image")) continue;

            $catImage = $request->file("categories.$i.image");
            $catImagePath = $catImage ? $catImage->store('solution_categories', 'public') : null;

            $category = $solution->categories()->create([
                'name' => $catData['name'] ?? null,
                'image' => $catImagePath,
            ]);

            foreach ($catData['sub_categories'] ?? [] as $j => $sub) {
                if (empty($sub['name']) && !$request->file("categories.$i.sub_categories.$j.image")) continue;

                $subImage = $request->file("categories.$i.sub_categories.$j.image");
                $subImagePath = $subImage ? $subImage->store('solution_sub_categories', 'public') : null;

                $category->subCategories()->create([
                    'name' => $sub['name'] ?? null,
                    'image' => $subImagePath,
                ]);
            }
        }

        return redirect()->route('admin.webtheme.solutions')->with('success', 'Solution updated successfully.');
    }

    public function destroy(Solution $solution)
    {
        // Delete all images
        Storage::disk('public')->delete($solution->image);
        foreach ($solution->categories as $cat) {
            Storage::disk('public')->delete($cat->image);
            foreach ($cat->subCategories as $sub) {
                Storage::disk('public')->delete($sub->image);
            }
        }

        $solution->delete();

        return redirect()->back()->with('success', 'Solution deleted.');
    }
}
