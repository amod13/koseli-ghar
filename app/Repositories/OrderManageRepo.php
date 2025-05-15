<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OrderManageRepo
{
    public function __construct()
    {
        //
    }

    /**
     * Retrieve all orders with related user, order items, products, and category details.
     * Each order will include a calculated discounted price based on the category discount.
     *
     * @return \Illuminate\Support\Collection A collection of orders with detailed associations and discounted prices.
     */
    public function getAllOrder()
    {
        $data = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('user_details', 'orders.user_id', '=', 'user_details.user_id')
            ->select(
                'orders.id as order_id',
                'orders.total_price',
                'orders.status',
                'orders.payment_method',
                'orders.first_name',
                'orders.middle_name',
                'orders.last_name',
                'orders.email',
                'orders.phone',
                'orders.address'
            )
            ->orderBy('orders.id', 'desc')
            ->distinct() // ensures each order is unique
            ->get();

        return $data;
    }


    /**
     * Retrieve all orders with related user, order items, products, and category details,
     * filtered by given search criteria.
     *
     * The search criteria can include the following keys:
     * - `date`: A date string in the format of 'Y-m-d' to filter by order creation date
     * - `status`: The status of the orders to filter by
     * - `keyword`: A keyword to search for in the product name and user name
     *
     * Each order will include a calculated discounted price based on the category discount.
     *
     * @param array $searchCriteria An associative array of search criteria
     * @return \Illuminate\Support\Collection A collection of orders with detailed associations and discounted prices
     */
    public function getAllOrderBySearchCriteria($searchCriteria)
    {
        $data = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('user_details', 'orders.user_id', '=', 'user_details.user_id')
            ->select(
                'orders.id as order_id',
                'orders.total_price',
                'orders.status',
                'orders.payment_method',
                'orders.created_at',
                'users.name as user_name',
                'orders.first_name',
                'orders.middle_name',
                'orders.last_name',
                'orders.email',
                'orders.phone',
                'orders.address'
            )
            ->where(function ($query) use ($searchCriteria) {
                if (!empty($searchCriteria['from_date']) && !empty($searchCriteria['to_date'])) {
                    $query->whereBetween('orders.created_at', [$searchCriteria['from_date'], $searchCriteria['to_date']]);
                } elseif (!empty($searchCriteria['from_date'])) {
                    $query->where('orders.created_at', '>=', $searchCriteria['from_date']);
                } elseif (!empty($searchCriteria['to_date'])) {
                    $query->where('orders.created_at', '<=', $searchCriteria['to_date']);
                }
            })
            ->when(!empty($searchCriteria['status']), function ($query) use ($searchCriteria) {
                $query->where('orders.status', $searchCriteria['status']);
            })

            ->orderBy('orders.id', 'desc')
            ->get();

        return $data;
    }




}
