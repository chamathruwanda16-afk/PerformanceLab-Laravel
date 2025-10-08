<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'image_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Route model binding by slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

   
    public function getImageUrlAttribute(): string
    {
        $p = trim((string) $this->image_path);

        // 1) no image => placeholder
        if ($p === '') {
            return asset('images/placeholder.jpg'); // create this file
        }

        
        if (Str::startsWith($p, ['http://', 'https://'])) {
            return $p;
        }

        // 3) normalize
        $p = ltrim($p, '/');

        
        if (Storage::disk('public')->exists($p)) {
            // requires: php artisan storage:link
            return Storage::url($p); // => /storage/...
        }

        
        if (file_exists(public_path($p))) {
            return asset($p);
        }

        // 6) bare filename stored => try public/images/<filename>
        if (file_exists(public_path('images/'.$p))) {
            return asset('images/'.$p);
        }

        // 7) fallback
        return asset('images/placeholder.jpg');
    }
}
