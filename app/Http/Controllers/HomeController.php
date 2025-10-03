<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
   // TODO: replace these with real DB queries later
        $bestSellers = [
            ['name' => 'Turbo Kit',      'slug' => 'turbo-kit',      'price' => 125000, 'image' => 'turbo-kit.jpg'],
            ['name' => 'Intercooler',    'slug' => 'intercooler',    'price' =>  89000, 'image' => 'intercooler.jpg'],
            ['name' => 'Turbocharger',   'slug' => 'turbocharger',   'price' => 152000, 'image' => 'turbocharger.jpg'],
        ];

        $categories = [
            ['name'=>'Turbo Chargers',  'image'=>'cat-turbo.png'],
            ['name'=>'Wheels & Tires',  'image'=>'cat-wheels.png'],
            ['name'=>'Universal Parts', 'image'=>'cat-universal.png'],
            ['name'=>'Accessories',     'image'=>'cat-accessories.png'],
        ];

        return view('home', compact('bestSellers', 'categories'));
    }
}