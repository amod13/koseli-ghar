<?php
namespace App\Repositories;

use App\Models\CheckoutDetail;
use Illuminate\Support\Facades\DB;

class CheckoutRepo extends BaseRepository
{
    public function __construct(CheckoutDetail $model)
    {
        parent::__construct($model);
    }

    /**
     * Get the order history of a user.
     *
     * @param int $userId The user ID to retrieve the order history for.
     * @return array An array containing the order items and total price.
     */
    public function getOrderHistory($userId)
    {
        // Retrieve order items for the user
        $data = DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.user_id', $userId)
            ->select(
                'order_items.*',
                'products.name as product_name',
                'products.price as product_price',
                'products.image',
                'products.slug',
                'order_items.quantity'
            )
            ->get();

        // Calculate total price
        $totalPrice = $data->sum(function ($item) {
            return $item->product_price * $item->quantity;
        });

        return [
            'cartItems' => $data,
            'totalPrice' => $totalPrice
        ];
    }

}
