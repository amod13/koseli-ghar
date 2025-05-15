<?php
namespace App\Repositories;

use App\Models\ArticleCategory;

class ArticleCategoryRepo extends BaseRepository
{
    public function __construct(ArticleCategory $model)
    {
        parent::__construct($model);
    }
}
