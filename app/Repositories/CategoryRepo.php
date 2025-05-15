<?php
namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepo extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * Retrieve all records from the database with pagination.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getMainCategoriesWithSubcategories()
    {
        // Fetch all main categories (those without parent_id)
        $mainCategories = DB::table('categories')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Add subcategories for each main category
        foreach ($mainCategories as $mainCategory) {
            $mainCategory->subcategories = DB::table('categories')
                ->where('parent_id', $mainCategory->id)
                ->get();
        }

        return $mainCategories;
    }


    /**
     * Fetch a category by its ID and include its subcategories.
     *
     * @param int $id
     * @return \App\Models\Category|null
     */
    public function getCategoryIdBasedWithSubcategories($id)
    {
        // Fetch the main category by ID
        $mainCategory = DB::table('categories')->where('id', $id)->first();

        if ($mainCategory) {
            // Fetch subcategories for the main category
            $mainCategory->subcategories = DB::table('categories')
                ->where('parent_id', $mainCategory->id)
                ->get();
        }

        return $mainCategory;
    }


    /**
     * Search categories by name.
     *
     * @param string|null $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchCategories($search = null)
    {
        return $this->model->when($search, function($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%");
        })->whereNull('parent_id') // Only search main categories
          ->paginate(10);  // Adjust pagination as needed
    }


    /**
     * Get 4 categories with is_display_slider = 1.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCategoryWhereIsSliderIsOne()
    {
        $data = DB::table('categories')
            ->where('is_display_slider', 1)
            ->select('id', 'slug', 'slider_image','name')
            ->take(4)
            ->get();

        return $data;
    }


    /**
     * Retrieve all main categories (categories without a parent_id).
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMainCategories()
    {
        $data = DB::table('categories')
            ->whereNull('parent_id')
            ->select('id', 'slug', 'name','image')
            ->get();

        return $data;
    }


    /**
     * Get all categories with their respective brands.
     *
     * @return \Illuminate\Support\Collection
     *
     * The resulting collection will contain the following structure:
     * [
     *     [
     *         'category_id' => int,
     *         'category_name' => string,
     *         'brands' => [
     *             [
     *                 'brand_id' => int,
     *                 'brand_name' => string,
     *                 'brand_image' => string,
     *             ],
     *             ...
     *         ],
     *     ],
     *     ...
     * ]
     */
    public function getCategoryBaseBrand()
    {
        $rawData = DB::table('categories')
            ->join('brands', 'categories.id', '=', 'brands.category_id')
            ->select(
                'categories.id as category_id',
                'categories.name as category_name',
                'categories.slug as category_slug',
                'brands.id as brand_id',
                'brands.name as brand_name',
                'brands.image as brand_image',
                'brands.slug as brand_slug'
            )
            ->get();

        // Group brands under their respective categories
        $groupedData = $rawData->groupBy('category_id')->map(function ($items) {
            return [
                'category_id' => $items->first()->category_id,
                'category_name' => $items->first()->category_name,
                'category_slug' => $items->first()->category_slug,
                'brands' => $items->map(function ($brand) {
                    return [
                        'brand_id' => $brand->brand_id,
                        'brand_name' => $brand->brand_name,
                        'brand_image' => $brand->brand_image,
                        'brand_slug' => $brand->brand_slug
                    ];
                })->values()
            ];
        })->values();

        return $groupedData;
    }


    /**
     * Get products by category slug.
     *
     * This method retrieves a paginator of products belonging to the given category slug.
     * Each product is transformed to include the original price and discounted price based on
     * the category's discount. Additionally, it fetches related brands from the same category
     * and returns both products and brands.
     *
     * @param string $slug The category slug
     * @return array An associative array containing the products, brands, and category
     */
    public function getProductsByCategorySlug($slug)
    {
        // Step 1: Get the category
        $category = DB::table('categories')->where('slug', $slug)->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        // Step 2: Paginate products with category discount
        $paginator = DB::table('products')
            ->where('category_id', $category->id)
            ->select(
                'products.*',
                DB::raw("'" . $category->name . "' as category_name"),
                DB::raw($category->discount . ' as category_discount')
            )
            ->paginate(18);

        // Step 3: Transform each product
        $paginator->getCollection()->transform(function ($product) {
            $categoryDiscount = $product->category_discount ?? 0;
            $discountAmount = ($product->price * $categoryDiscount) / 100;
            $product->original_price = $product->price;
            $product->discounted_price = round($product->price - $discountAmount, 2);
            return $product;
        });

        // Step 4: Get related brands from the same category products
        $brandIds = DB::table('products')
            ->where('category_id', $category->id)
            ->distinct()
            ->pluck('brand_id');

            $brands = DB::table('brands')
            ->whereRaw('FIND_IN_SET(?, category_id)', [$category->id])
            ->get();

        // Step 5: Return both products and brands
        return [
            'products' => $paginator,
            'brands' => $brands,
            'category' => $category,
        ];
    }



}
