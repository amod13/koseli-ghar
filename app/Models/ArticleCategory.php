<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasFactory;

    protected $table = 'article_categories';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'parent_id',
    ];
}
