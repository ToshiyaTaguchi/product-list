<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\EditProductRequest;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 検索
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 並び替え
        if ($request->sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->paginate(6);

        return view('products.index', compact('products'));
    }

    public function edit(Product $product)
    {
        $seasons = Season::all();
        return view('products.edit', compact('product', 'seasons'));
    }

    public function update(EditProductRequest $request, Product $product)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
