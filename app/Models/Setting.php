<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [ // Corrected 'filleable' to 'fillable'
        'site_name',
        'logo',
        'favicon',
        'address',
        'phone',
        'email',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'tiktok',
        'whatsapp',
        'meta_tags', // Fixed typo: 'met_tags' to 'meta_tags'
        'meta_title',
        'meta_description',
        'meta_keywords',
        'google_map',
        'default_image',
        'limit_title',
        'is_display_cart',
        'is_display_wishlist',
        'is_display_brand_slider',
        'theme_color',
        'hover_color',
    ];
}
