<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductsModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index()
    {
        $name = request()->input('name');
        $getProducts = ProductsModel::where('name', 'LIKE', '%' . $name . '%')
            ->orderBy("created_at", 'desc')->get();
        return response()->json($getProducts);
    }

    public function show($id)
    {
        return response()->json(ProductsModel::find($id));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'description' => 'nullable',
            'category' => 'required|in:makanan,minuman,snack',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'image' => 'required',
        ]);

        $imageFile = $request->file('image');
        $image = time() . str_replace(" ", "", $imageFile->hashName());
        $imageFile->storeAs('files/image', $image, 'public');

        ProductsModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'stock' => $request->stock,
            'price' => $request->price,
            'image' => $image,
        ]);

        return response()->json([
            'message' => 'Data berhasil ditambahkan'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'description' => 'nullable',
            'category' => 'required|in:makanan,minuman,snack',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $product = ProductsModel::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $image = time() . '_' . str_replace(" ", "", $imageFile->getClientOriginalName());
            $imageFile->storeAs('public/files/image', $image);

            if ($product->image) {
                Storage::delete('public/files/image/' . $product->image);
            }

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'stock' => $request->stock,
                'price' => $request->price,
                'image' => $image,
            ]);

            return response()->json(['message' => 'Product updated successfully'], 200);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'stock' => $request->stock,
            'price' => $request->price,
        ]);

        return response()->json(['message' => 'Product updated successfully'], 200);
    }

    public function destroy($id)
    {
        $product = ProductsModel::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($product->image) {
            Storage::delete('public/files/image/' . $product->image);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
