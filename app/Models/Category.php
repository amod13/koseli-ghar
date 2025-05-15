<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table  = 'categories';

    protected $fillable = [
        'name',
        'image',
        'status',
        'parent_id',
        'slug',
        'description',
        'is_featured',
        'discount',
        'is_display_slider',
        'slider_image',
        'is_display_home'
    ];

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_category');
    }

}
