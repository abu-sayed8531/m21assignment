<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

abstract class Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => "Product not found."
            ], 422);
        }
        return response()->json($product);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => "required|max:100|string",
            'description' => 'string|nullable',
            'price' => 'numeric',
            'stock' => 'integer'


        ]);


        Product::create($validated);
        return response()->json([
            'message' => "Data saved successfully.",
            'data'  => $validated,
        ]);
    }
    public function update(Request $request, $id)
    {

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                "message" => "Product not found."
            ], 422);
        }
        $productData =  $request->only(['name', 'description', 'price', 'stock']);
        foreach ($productData as $field => $data) {
            $product->$field = $data;
        }
        $product->save();
        return response()->json([
            'message' =>  "Data updated successfully",
        ]);
    }
    public function destroy($id)
    {

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                "message" => "Product not found"
            ], 422);
        }
        $product->delete();
        return response()->json([
            'message' => "Product deleted successfully",
        ]);
    }
}
