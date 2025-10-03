<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;        // <-- add
use App\Models\Category;       // (if you use it)


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(12);
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}

