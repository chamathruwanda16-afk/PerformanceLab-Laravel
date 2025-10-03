<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $products = Product::with('category')
            ->when($q, fn($qq) => $qq->where('name','like',"%{$q}%"))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', [
            'products'   => $products,
            'categories' => Category::orderBy('name')->get(['id','name']),
            'q'          => $q,
        ]);
    }

    public function create()
    {
        return view('admin.products.form', [
            'product'    => new Product(),
            'categories' => Category::orderBy('name')->get(['id','name']),
            'mode'       => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:products,slug',
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image_path'  => 'nullable|string|max:2000', // URL or relative path
        ]);

        $data['slug'] ??= Str::slug($data['name']);
        $product = Product::create($data);

        return redirect()->route('admin.products.index')->with('success','Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(['id','name']),
            'mode'       => 'edit',
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:products,slug,'.$product->id,
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image_path'  => 'nullable|string|max:2000',
        ]);

        $data['slug'] ??= Str::slug($data['name']);
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success','Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success','Product deleted.');
    }
}
