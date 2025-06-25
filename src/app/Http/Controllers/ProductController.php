<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\EditProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateRequest;


class ProductController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::latest()->paginate(6);
        return view('products.index', compact('products'));
    }

    public function edit(Product $product)
    {
        $seasons = Season::all();
        return view('products.edit', compact('product', 'seasons'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $sort = $request->input('sort');

        $query = Product::query();

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->paginate(10)->withQueryString();

        return view('products.index', compact('products'));
    }


    public function update(EditProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        // フォームからの値を更新
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        // チェックされた季節を同期（多対多）
        $product->seasons()->sync($request->input('seasons'));

        // 新しい画像がアップロードされた場合のみ処理
        if ($request->hasFile('image')) {
            // 古い画像があれば削除
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }


            // 元のファイル名を取得
            $originalName = $request->file('image')->getClientOriginalName();

            // 保存先パス（同名があると上書きされる）
            $path = $request->file('image')->storeAs('images', $originalName, 'public');

            // DBに保存
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }

    
    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    public function store(CreateRequest $request)
    {
        // 画像をstorageに保存
        if ($request->hasFile('image')) {
            $image = $request->file('image');
        $path = $image->storeAs('products', $image->getClientOriginalName(), 'public');
        }

        // 商品を作成
        $product = Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'image' => $path ?? null,
        ]);

        // 中間テーブルに季節を保存
        $product->seasons()->sync($request->input('seasons'));

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }
}
