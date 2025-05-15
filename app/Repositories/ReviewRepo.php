<?php
namespace App\Repositories;

use App\Models\ProductReview;

class ReviewRepo extends BaseRepository
{
    public function __construct(ProductReview $model)
    {
        parent::__construct($model);
    }
}
