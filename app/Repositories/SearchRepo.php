<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class SearchRepo
{
    public function __construct()
    {

    }

    /**
     * Searches for products by given search criteria, including product name, description,
     * category name, and brand name. The search results are paginated and transformed to
     * include the original price and discounted price based on the category's discount.
     * Additionally, it fetches related brands from the same product results and returns
     * both products and brands.
     *
     * @param string|null $search The search criteria
     * @return array An associative array containing the products and brands
     */

    public function searchData($search = null)
    {
        $query = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'categories.discount as category_discount'
            );

        $categoriesMatched = [];

        if ($search) {
            // Split search term into multiple words
            $keywords = explode(' ', $search);

            // Search for categories that match the search term
            $categoriesMatched = DB::table('categories')
                ->where(function ($q) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $q->orWhere('name', 'like', '%' . $keyword . '%');
                    }
                })
                ->get(); // Fetch categories that match the search keyword

            // Apply search conditions to products based on the search term
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('products.name', 'like', '%' . $keyword . '%')
                    ->orWhere('categories.name', 'like', '%' . $keyword . '%')
                    ->orWhere('brands.name', 'like', '%' . $keyword . '%');
                }
            });
        }

        $paginator = $query->paginate(18);

        // Transform product prices based on category discount
        $paginator->getCollection()->transform(function ($product) {
            $categoryDiscount = $product->category_discount ?? 0;
            $discountAmount = ($product->price * $categoryDiscount) / 100;
            $product->original_price = $product->price;
            $product->discounted_price = round($product->price - $discountAmount, 2);
            return $product;
        });

        // Get related brands
        $brandIds = $paginator->pluck('brand_id')->unique();
        $brands = DB::table('brands')
            ->whereIn('id', $brandIds)
            ->get();

        return [
            'products' => $paginator,
            'brands' => $brands,
            'categoriesMatched' => $categoriesMatched,  // Return the categories matched with the search
        ];
    }

    /**
     * Filters products by given criteria, including selected brand IDs and price range.
     * The results are paginated and transformed to include the original price and discounted
     * price based on the category's discount. Additionally, it fetches related brands from
     * the same product results and returns both products and brands.
     *
     * @param array $searchCrita The search criteria, including brand IDs and price range
     * @return array An associative array containing the products and brands
     */
    public function getFilteredProducts($searchCrita)
    {
        $query = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'categories.discount as category_discount',
                'brands.name as brand_name',
                'brands.id as brand_id',
            );

        // Filter by selected brand IDs
        if (!empty($searchCrita['brand_ids'])) {
            $query->whereIn('products.brand_id', $searchCrita['brand_ids']);
        }
        // filter Selected Category
        if (!empty($searchCrita['category_ids'])) {
            $query->whereIn('products.category_id', $searchCrita['category_ids']);
        }

        // Filter by price range
        if (!empty($searchCrita['min_price'])) {
            $query->where('products.price', '>=', $searchCrita['min_price']);
        }

        if (!empty($searchCrita['max_price'])) {
            $query->where('products.price', '<=', $searchCrita['max_price']);
        }

        // Get paginated products
        $products = $query->paginate(18);

        // Apply discount transformation
        $products->getCollection()->transform(function ($product) {
            $categoryDiscount = $product->category_discount ?? 0;
            $discountAmount = ($product->price * $categoryDiscount) / 100;
            $product->original_price = $product->price;
            $product->discounted_price = round($product->price - $discountAmount, 2);
            return $product;
        });

        // Get related brand IDs from the filtered products
        $relatedBrandIds = $products->pluck('brand_id')->unique()->filter();

        // Fetch only the related brands
        $brands = DB::table('brands')
        ->where(function ($q) use ($searchCrita) {
            foreach ($searchCrita['category_ids'] as $catId) {
                $q->orWhereRaw('FIND_IN_SET(?, category_id)', [$catId]);
            }
        })
        ->get();
        return [
            'products' => $products,
            'brands' => $brands,
        ];
    }

    /**
     * Retrieve products by brand slug.
     *
     * This method retrieves a paginator of products associated with the given brand slug.
     * Each product is transformed to include the original price and discounted price
     * based on the category's discount. Additionally, it fetches all brands and returns
     * both products and brands.
     *
     * @param string $brandSlug The slug of the brand to filter products by.
     * @return array An associative array containing the products and brands.
     */
    public function getProductsByBrandSlug($brandSlug)
    {
        $brand = DB::table('brands')->where('slug', $brandSlug)->first();
        if (!$brand) {
            return ['products' => [], 'brands' => []];
        }

        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'categories.discount as category_discount'
            )
            ->where('products.brand_id', $brand->id)
            ->paginate(18);

        $products->getCollection()->transform(function ($product) {
            $categoryDiscount = $product->category_discount ?? 0;
            $discountAmount = ($product->price * $categoryDiscount) / 100;
            $product->original_price = $product->price;
            $product->discounted_price = round($product->price - $discountAmount, 2);
            return $product;
        });

        // Fetch related brands
       // Fetch only the related brands
       $brands = DB::table('brands')
       ->where('id',  $brand->id)
       ->get();

        return [
            'products' => $products,
            'brands' => $brands,
        ];
    }

    /**
     * Fetch a brand's ID based on its slug.
     *
     * @param string $slug The brand slug to query by.
     * @return int The ID of the brand.
     */
    public function getABrandIdBaseOnSlug($slug)
    {
        $data = DB::table('brands')
            ->where('slug', $slug)
            ->first();

        return $data->id;
    }


}
