<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // ----------------------------------------------------------
    // GET CATEGORIES
    // ----------------------------------------------------------
    public function index() {
        $categories = Category::all();

        return response()->json([
            'status' => 'success',
            'data' => CategoryResource::collection($categories),
        ]);
    }

    // ----------------------------------------------------------
    // GET DETAIL CATEGORY
    // ----------------------------------------------------------
    public function show(Category $category) {
        $category = Category::firstWhere('slug', $category->slug);

        return response()->json([
            'status' => 'success',
            'data' => new CategoryResource($category)
        ]);
    }

    // ----------------------------------------------------------
    // CREATE CATEGORY
    // ----------------------------------------------------------
    public function store(Request $request) {
        // ----------------------------------------------------------
        // VALIDATION RULES
        // ----------------------------------------------------------
        $validateData = $request->validate([
            'category_slug' => 'required|max:255|unique:categories,slug',
            'category_name' => 'required',
        ]);

        // ----------------------------------------------------------
        // CREATE CATEGORY
        // ----------------------------------------------------------
        Category::create([
            'slug' => $validateData['category_slug'],
            'name' => $validateData['category_name'],
        ]);

        // ----------------------------------------------------------
        // RESPONSE
        // ----------------------------------------------------------
        return response()->json([
            'status' => 'success',
            'data' => "New category has been added!",
        ]);
    }

    // ----------------------------------------------------------
    // UPDATE CATEGORY
    // ----------------------------------------------------------
    public function update(Request $request, Category $category) {
        // ----------------------------------------------------------
        // VALIDATION RULES
        // ----------------------------------------------------------
        $rules = [
            'category_name' => 'required',
        ];
        
        if($request->category_slug != $category->slug) {
            $rules['category_slug'] = 'required|max:255|unique:categories,slug';
        }

        $validateData = $request->validate($rules);

        // ----------------------------------------------------------
        // UPDATE RULES
        // ----------------------------------------------------------
        $updateRules = [
            'name' => $validateData['category_name'],
        ];

        if($request->category_slug != $category->slug) {
            $updateRules['slug'] = $validateData['category_slug'];
        }

        // ----------------------------------------------------------
        // UPDATE CATEGORY
        // ----------------------------------------------------------
        Category::where('slug', $category->slug)->update($updateRules);

        // ----------------------------------------------------------
        // RESPONSE
        // ----------------------------------------------------------
        return response()->json([
            'status' => 'success',
            'data' => "Category has been updated!",
        ]);
    }

    // ----------------------------------------------------------
    // DELETE CATEGORY
    // ----------------------------------------------------------
    public function destroy(Category $category) {
        Category::where('slug', $category->slug)->delete();

        return response()->json([
            'status' => 'success',
            'data' => "Category has been deleted!",
        ]);
    }

    // ----------------------------------------------------------
    // CHECK SLUG FOR CREATE/UPDATE CATEGORY
    // ----------------------------------------------------------
    public function checkSlug(String $parameter) {
        $slug = SlugService::createSlug(Category::class, 'slug', $parameter);

        return response()->json(['category_slug' => $slug]);
    }
}
