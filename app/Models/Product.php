<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'brand_id',
        'price',
        'stock',
        'status',
        'is_featured',
        'image',
        'colors',
        'sizes',
        'gender',
        'sku',
        'meta_description',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

}
