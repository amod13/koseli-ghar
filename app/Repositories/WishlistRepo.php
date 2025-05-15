<?php
namespace App\Repositories;

use App\Models\Wishlist;
use Faker\Provider\Base;
use Illuminate\Support\Facades\DB;

class WishlistRepo extends BaseRepository
{
    public function __construct(Wishlist $model)
    {
        parent::__construct($model);
    }

    /**
     * Retrieve wishlist items for a specific user, including product details and calculated prices.
     *
     * This function queries the wishlist_items table, joining with products and categories to
     * gather product information and category discounts. It calculates the original and discounted
     * prices for each wishlist item based on the category discount percentage.
     *
     * @param int $userId The ID of the user whose wishlist items are to be retrieved.
     * @return \Illuminate\Support\Collection A collection of wishlist items with additional product details
     *                                        and calculated prices.
     */

    public function getWishlistItemByUserId($userId)
    {
        $data = DB::table('wishlist_items')
            ->leftJoin('products', 'wishlist_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id') // Assuming the discount is stored in the category
            ->select(
                'wishlist_items.*',
                'products.name as product_name',
                'products.price as product_price',
                'products.image',
                'products.slug',
                'categories.discount as category_discount' // Assuming category discount is stored in the categories table
            )
            ->where('wishlist_items.user_id', $userId)
            ->get();

        // Calculate original and discounted prices for each wishlist item
        $data = $data->map(function($item) {
            // Get the discount percentage from the category or default to 0 if not available
            $categoryDiscount = $item->category_discount ?? 0;

            // Calculate the discounted price
            $discountAmount = ($item->product_price * $categoryDiscount) / 100;
            $discountedPrice = $item->product_price - $discountAmount;

            // Add original and discounted prices to the item
            $item->original_price = $item->product_price;
            $item->discounted_price = $discountedPrice;

            return $item;
        });

        return $data;
    }

}
