<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepo extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all products with category and brand names
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllProducts()
    {
        $data = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select('products.*', 'categories.name as category_name', 'brands.name as brand_name')
            ->orderBy('products.created_at', 'desc')
            ->paginate(10);

        return $data;
    }

    /**
     * Get all products with category and brand names, transformed to include the
     * original price and discounted price based on the category's discount.
     * Only active products with is_featured set to 1 are included.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllProductForShop()
    {
        $query = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'categories.discount as category_discount',
                'brands.name as brand_name'
            )
            ->where('products.status', '=', 1)   // Only active products
            ->where('products.is_featured', '=', 1);

        // Apply transformation after pagination, but preserve pagination metadata
        $products = $query->paginate(24);

        $products->getCollection()->transform(function ($product) {
            $categoryDiscount = $product->category_discount ?? 0;
            $discountAmount = ($product->price * $categoryDiscount) / 100;
            $product->original_price = $product->price;
            $product->discounted_price = round($product->price - $discountAmount, 2);
            return $product;
        });

        return $products;
    }


    /**
     * Get the details of a product by its ID, including category and brand names.
     *
     * @param int $id
     * @return \stdClass|null
     */
    public function getProductDetailById($id)
    {
        $data = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->where('products.id', $id)
            ->select(
                'products.*',
                'categories.name as category_name',
                'brands.name as brand_name',
                DB::raw("(SELECT COUNT(*) FROM product_reviews WHERE product_reviews.product_id = products.id) as review_count")
            )
            ->first();

        if ($data) {
            // Convert comma-separated strings to arrays
            $data->sizes = !empty($data->sizes) ? explode(',', $data->sizes) : [];
            $data->colors = !empty($data->colors) ? explode(',', $data->colors) : [];

            // Get related files
            $productFiles = DB::table('product_files')
                ->where('product_id', $id)
                ->get();

            $data->product_files = $productFiles->toArray();
        } else {
            $data = (object)[
                'sizes' => [],
                'colors' => [],
                'product_files' => [],
                'review_count' => 0,
            ];
        }

        return $data;
    }


    /**
     * Retrieve a collection of active and featured products for display on the home page,
     * including their category and brand names, and calculates the discounted price based
     * on the category discount.
     *
     * This function selects up to 8 products that are marked as active and featured, joining
     * with the categories and brands tables to obtain additional information. The discount
     * amount is computed using the category's discount percentage, and both the original
     * and discounted prices are appended to each product object.
     *
     * @return \Illuminate\Support\Collection
     */

    public function getAllProductsWhereStatusIsActiveForHome($limit = 6)
    {
        $products = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'categories.discount as category_discount',
                'brands.name as brand_name'
            )
            ->where('products.status', '=', 1)
            ->where('products.is_featured', '=', 1)
            ->orderBy('products.id', 'desc')
            ->paginate($limit);

        $products->getCollection()->transform(function ($product) {
            $categoryDiscount = $product->category_discount ?? 0;
            $discountAmount = ($product->price * $categoryDiscount) / 100;
            $product->original_price = $product->price;
            $product->discounted_price = $product->price - $discountAmount;
            return $product;
        });

        return $products;
    }


     /**
      * Retrieves a collection of products based on the given search criteria
      *
      * This function accepts an associative array of search criteria and applies
      * filters to the query based on the provided values. The search criteria
      * can include the following keys:
      *
      * - `category_id`: The ID of the category to filter by
      * - `brand_id`: The ID of the brand to filter by
      * - `keyword`: A keyword to search for in the product name, brand name,
      *              and category name
      *
      * The function returns a collection of products that match the search
      * criteria, including the category and brand names.
      *
      * @param array $searchCriteria
      * @return \Illuminate\Support\Collection
      */
    public function getAllProductsBySearchCriteria($searchCriteria)
    {
        $categoryId   = $searchCriteria['category_id'] ?? null;
        $brandId      = $searchCriteria['brand_id'] ?? null;
        $keyword      = $searchCriteria['keyword'] ?? null;
        $status       = $searchCriteria['status'] ?? null;
        $isFeatured   = $searchCriteria['is_featured'] ?? null;

        $query = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'brands.name as brand_name',
                'products.status',
                'products.is_featured'
            );

        // Apply filters
        if (!is_null($categoryId)) {
            $query->where('products.category_id', $categoryId);
        }

        if (!is_null($brandId)) {
            $query->where('products.brand_id', $brandId);
        }

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('products.name', 'like', '%' . $keyword . '%')
                ->orWhere('brands.name', 'like', '%' . $keyword . '%')
                ->orWhere('categories.name', 'like', '%' . $keyword . '%');
            });
        }

        if (!is_null($status)) {
            $query->where('products.status', $status);
        }

        if (!is_null($isFeatured)) {
            $query->where('products.is_featured', $isFeatured);
        }

        return $query->paginate(10);
    }


    /**
     * Retrieve a product by its slug, including related category, brand, and file information.
     *
     * This function performs a query to fetch a product based on the provided slug. It joins
     * the categories, brands, and product_files tables to gather additional information such as
     * category name, brand name, and any related files. The category's discount is used to
     * calculate the discounted price, and both the original and discounted prices are added to
     * the product object. Additionally, the sizes and colors are converted from comma-separated
     * strings to arrays. If no product is found, an empty object with default values is returned.
     *
     * @param string $slug The slug of the product to retrieve.
     * @return \stdClass|null The product object with additional details or a default object if not found.
     */
    public function getProductWhereSlugIs($slug)
    {
        $data = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('product_files', 'products.id', '=', 'product_files.product_id')
            ->where('products.slug', $slug)
            ->select(
                'products.*',
                'categories.id as category_id',
                'categories.name as category_name',
                'categories.status as category_status',
                'brands.name as brand_name',
                'categories.discount as category_discount'
            )
            ->first();

        if ($data) {
            // Calculate discount for main product
            $categoryDiscount = $data->category_discount ?? 0;
            $discountAmount = ($data->price * $categoryDiscount) / 100;
            $discountedPrice = $data->price - $discountAmount;

            $data->original_price = $data->price;
            $data->discounted_price = $discountedPrice;
            $data->sizes = !empty($data->sizes) ? explode(',', $data->sizes) : [];
            $data->colors = !empty($data->colors) ? explode(',', $data->colors) : [];

            // Product files
            $productFiles = DB::table('product_files')
                ->where('product_id', $data->id)
                ->get();
            $data->product_files = $productFiles->toArray();

            // Related products
            $relatedProducts = collect();
            if ($data->category_status == 1) {
                $relatedProductsRaw = DB::table('products')
                    ->where('category_id', $data->category_id)
                    ->where('id', '!=', $data->id)
                    ->limit(6)
                    ->get();

                $relatedProducts = $relatedProductsRaw->map(function ($product) use ($categoryDiscount) {
                    $discountAmount = ($product->price * $categoryDiscount) / 100;
                    $discountedPrice = $product->price - $discountAmount;

                    $product->original_price = $product->price;
                    $product->discounted_price = $discountedPrice;

                    // You can set default image if needed
                    $product->image = $product->image ?? 'default.jpg';

                    return $product;
                });
            }

            $data->related_products = $relatedProducts;
        } else {
            $data = (object) [
                'sizes' => [],
                'colors' => [],
                'product_files' => [],
                'related_products' => collect()
            ];
        }

        return $data;
    }


     /**
      * Retrieves all reviews for a given product slug.
      *
      * @param string $slug The product slug
      * @return \Illuminate\Support\Collection A collection of reviews, with the user_name field added from the users table,
      *      and the created_at field converted to a human-readable format using Carbon's diffForHumans.
      */
     public function getAllReviewsWhereProductSlugIs($slug)
     {
         $data = DB::table('product_reviews')
             ->leftJoin('users', 'product_reviews.user_id', '=', 'users.id')
             ->leftJoin('products', 'product_reviews.product_id', '=', 'products.id')
             ->where('products.slug', $slug)
             ->select('product_reviews.*', 'users.name as user_name')
             ->orderBy('product_reviews.rating', 'desc')
             ->get();

         // Convert the created_at field to a human-readable format using Carbon
         $data->transform(function ($item) {
             // Make sure the created_at field is a Carbon instance
             $item->created_at = \Carbon\Carbon::parse($item->created_at)->diffForHumans();
             return $item;
         });

         return $data;
     }



}
