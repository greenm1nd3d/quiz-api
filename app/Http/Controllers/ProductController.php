<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Email\IEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

use App\Models\Product;


class ProductController extends Controller
{
    public function index() {
        return "Nothing to see here";
    }

    public function create(Request $request)
    {
        Log::debug("Attempting to create product...");

        $validator = Validator::make($request->all(), [
            'sku' => 'required|size:10',
            'product' => 'required|min:3|max:100',
            'content' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1000',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $photo = time().'-'.rand(1000000,9999999).'.'.$request->photo->extension();
        $request->photo->move(public_path('products'), $photo);

        $data = [
            'user_id' => 1,
            'sku' => $request->sku,
            'product' => $request->product,
            'content' => $request->content,
            'photo' => $photo,
            'price' => $request->price
        ];

        $product = Product::create($data);
        if ($product) {
            return response()->json([
                'message' => 'Product successfully created'
            ], 200);
        }

        return response()->json([
            'error' => 'Bad Request',
            'status' => 400
        ]);
    }

    public function delete(Request $request)
    {
        Log::debug("Attempting to delete product...");

        try {
            $product = Product::findOrFail($request->id);
            $product->delete();

            return response()->json([
                'message' => 'Product successfully deleted.',
                'status' => 200
            ]);
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Could not find specified product.',
                'status' => 404
            ]);
        }
    }

    public function list()
    {
        return Product::all();
    }

    public function update(Request $request)
    {
        Log::debug("Attempting to update product...");

        try {
            $product = Product::findOrFail($request->id);

            if ($request->has('sku')) {
                $product->sku = $request->sku;
            }

            if ($request->has('product')) {
                $product->product = $request->product;
            }

            if ($request->has('content')) {
                $product->content = $request->content;
            }

            if ($request->has('photo')) {
                $photo = time().'-'.rand(1000000,9999999).'.'.$request->photo->extension();
                $request->photo->move(public_path('products'), $photo);

                $product->photo = $photo;
            }

            if ($request->has('price')) {
                $product->price = $request->price;
            }

            $product->save();

            return response()->json([
                'message' => 'Product successfully updated.',
                'status' => 200
            ]);
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
               'message' => 'Could not find specified product.',
               'status' => 404
            ]);
        }
    }
}