<?php

namespace App\Http\Controllers\Api;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }


    public function store(Request $request)
    {
        try {
            // Validate the incoming data
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
            ]);

            // Create the category
            $category = Category::create($validated);

            // Return the success response with the created category
            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => $category
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch the validation error and return in a standardized format
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => $e->errors()  // Return all validation errors
            ], 422);
        }
    }




    public function update(Request $request, $id)
    {
        // Find the category or return a 404 error if not found
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                'data' => null
            ], 404);
        }

        try {
            // Validate the incoming data
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
            ]);

            // Update the category
            $category->update($validated);

            // Return the success response with the updated category
            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => $category
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors if validation fails
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => $e->errors()  // Return all validation errors
            ], 422);
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                'data' => null
            ], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully',
            'data' => null
        ], 200);
    }
}
