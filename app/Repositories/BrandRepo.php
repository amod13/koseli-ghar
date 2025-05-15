<?php
namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class BrandRepo extends BaseRepository
{
    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all brands with their respective category name
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllBrands()
    {
        $data = DB::table('brands')
            ->leftJoin('categories', 'brands.category_id', '=', 'categories.id')
            ->leftJoin('products', 'brands.id', '=', 'products.brand_id')
            ->select(
                'brands.id',
                'brands.name',
                'brands.image', // Add other columns from brands if needed
                'categories.name as category_name',
                DB::raw('COUNT(products.id) as total_products')
            )
            ->groupBy('brands.id', 'brands.name', 'brands.image', 'categories.name') // Include all non-aggregated columns
            ->orderBy('brands.created_at', 'desc')
            ->paginate(10);

        return $data;
    }

    /**
     * Search brands by name
     *
     * @param string $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchByBrandName($name = null, $categoryId = null)
    {
        $query = DB::table('brands')
            ->leftJoin('categories', 'brands.category_id', '=', 'categories.id')
            ->select('brands.*', 'categories.name as category_name');

        if (!is_null($name)) {
            $query->where('brands.name', 'like', '%' . $name . '%');
        }

        if (!is_null($categoryId)) {
            $query->where('brands.category_id', $categoryId);
        }

        return $query->orderBy('brands.created_at', 'desc')->paginate(10);
    }




}
