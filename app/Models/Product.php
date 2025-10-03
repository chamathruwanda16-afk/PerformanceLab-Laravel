<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'stock',
        'price',
        'image_path'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 👇 Add this function for route model binding by slug
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
