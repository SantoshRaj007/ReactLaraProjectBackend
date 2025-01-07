<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // This method will return all products
    public function index() {
        $products = Product::orderBy('created_at','DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $products
        ],200);

    }

    // This method will store a new product
    public function store(Request $request) {
        // Validate the request
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'price' => 'required|numeric',
            'category' => 'required|integer',
            'sku' => 'required|unique:products,sku',
            'is_featured' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ],400);
        }

        // Store the product

        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->category_id = $request->category;
        $product->brand_id = $request->brand;
        $product->sku = $request->sku;
        $product->qty = $request->qty;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->status = $request->status;
        $product->barcode = $request->barcode;
        $product->is_featured = $request->is_featured;
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product has been created successfully..!!'
        ],200);

    }

    // This method will return a single product
    public function show($id) {
        $product = Product::find($id);
        if ($product == null) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $product
        ]);
    }

    // This method will update a product
    public function update() {

    }

    // This method will delete a product
    public function destroy() {

    }
}
