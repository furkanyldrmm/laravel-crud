<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $products = $products->toArray();

        return array_reverse($products);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'image' => 'required',
                'name' => 'required'
            ]);

            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);

            $product = new Product([
                'name' => $request->input('name'),
                'picture' => $filename
            ]);

            $product->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return response()->json('Product created!');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required'
            ]);
            $product = Product::find($id);
            $product->name = $request->input('name');

            if ($request->file('image')) {
                $this->deleteImage($product->picture);
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('public/Image'), $filename);
                $product->picture = $filename;
            }

            $product->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage()], 500);
        }
        return response()->json('Product updated!');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $product = Product::findOrFail($id);
            $this->deleteImage($product->picture);
            $product->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return response()->json('Product deleted!');
    }

    public function deleteImage($image)
    {
        if (File::exists(public_path('public/Image/' . $image))) {
            File::delete(public_path('public/Image/' . $image));
        }
    }
}
