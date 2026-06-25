<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   // app/Http/Controllers/ProductController.php
public function index()
{
    $products = Product::all()->map(function ($product) {
            // Safe URL extraction
            $imagePath = $product->image;
            
            // If the path already has 'storage/', don't duplicate it
            if ($imagePath && !str_starts_with($imagePath, 'http')) {
                if (!str_starts_with($imagePath, 'storage/')) {
                    $imagePath = 'storage/' . ltrim($imagePath, '/');
                }
                $imageUrl = asset($imagePath);
            } else {
                $imageUrl = asset('products/default-car.png'); // Fallback image
            }

            return [
                'id'          => $product->id,
                'name'        => $product->name,
                'space'       => $product->space,
                'format'      => $product->format,
                'finition'    => $product->finition,
                'description' => $product->description,
                'norm'        => $product->norm,
                'price'       => $product->price,
                'image'       => $imageUrl, // Generates clean http://127.0.0.1:8001/storage/...
                'category'    => $product->category
            ];
        });

        return response()->json($products);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Fixed validation: image must be an image file type, not a string!
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'space'       => 'required|string|max:255',
            'format'      => 'required|string|max:255',
            'finition'    => 'required|string|max:255',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validation rules for files
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'norm'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
        ]);

        // 2. Handle file upload safely
        if ($request->hasFile('image')) {
            // Stores inside storage/app/public/products
            $path = $request->file('image')->store('products', 'public');
            // This sets 'storage/products/filename.jpg'
            $validatedData['image'] = 'storage/' . $path;
        }

        // 3. Create using the validated array, NOT $request->all()
        $product = Product::create($validatedData);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
        ]);

        $product->update($request->all());
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}