<?php
namespace App\Repositories;

use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class CartItemRepo extends BaseRepository
{
    public function __construct(CartItem $model)
    {
        parent::__construct($model);
    }

    public function getCartItemsByUserId($userId = null)
    {
        $sessionId = session()->getId();

        // Common query
        $query = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->select(
                'cart_items.*',
                'products.name as product_name',
                'products.price as product_price',
                'products.image',
                'products.slug',
                'cart_items.quantity'
            );

        // Check login or guest
        if ($userId) {
            $query->where('cart_items.user_id', $userId)
                  ->where('cart_items.flag', 0); // Logged-in user
        } else {
            $query->where('cart_items.session_id', $sessionId)
                  ->where('cart_items.flag', 1); // Guest user
        }

        $data = $query->get();

        $totalPrice = $data->sum(function($item) {
            return $item->product_price * $item->quantity;
        });

        return [
            'cartItems' => $data,
            'totalPrice' => $totalPrice
        ];
    }



}
