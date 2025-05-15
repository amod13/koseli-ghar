<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardRepo
{
    /**
     * Returns an array containing the total number of orders for this week,
     * and the counts of orders by status for this week.
     *
     * The returned array has the following keys:
     * - total_orders: The total number of orders for this week.
     * - pending: The number of orders with status 'pending' for this week.
     * - processing: The number of orders with status 'processing' for this week.
     * - completed: The number of orders with status 'completed' for this week.
     * - cancelled: The number of orders with status 'cancelled' for this week.
     *
     * @return array
     */
    public function getTotalOrders()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        // Total orders this week
        $totalOrders = DB::table('orders')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        // Count orders by status for this week
        $statusCounts = DB::table('orders')
            ->select('status', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'total_orders' => $totalOrders,
            'pending' => $statusCounts['pending'] ?? 0,
            'processing' => $statusCounts['processing'] ?? 0,
            'completed' => $statusCounts['completed'] ?? 0,
            'cancelled' => $statusCounts['cancelled'] ?? 0,
        ];
    }


    /**
     * Get the top 10 selling categories for this week.
     *
     * @return Collection A collection of objects, each containing the name of a category
     *                   and the total number of orders for that category this week.
     */
    public function getTopSellingCategories()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Monday
        $endOfWeek = Carbon::now()->endOfWeek();     // Sunday

        return DB::table('orders')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
    }


    /**
     * Get this week's report including earnings, orders, customers, and products.
     *
     * This method calculates the total earnings, number of orders, number of customers,
     * and number of products added for the current week. It also compares these metrics
     * to the previous week and calculates the percentage change for each.
     *
     * The returned array contains the following keys:
     * - earnings: Total earnings from completed orders for this week.
     * - orders: Total number of orders for this week.
     * - customers: Total number of new customers registered this week.
     * - products: Total number of new products added this week.
     * - earnings_change: Percentage change in earnings compared to last week.
     * - orders_change: Percentage change in number of orders compared to last week.
     * - customers_change: Percentage change in number of customers compared to last week.
     * - products_change: Percentage change in number of products added compared to last week.
     *
     * @return array An array containing this week's report and percentage changes compared to last week.
     */

    public function getThisWeeksReport()
    {
        $startOfThisWeek = Carbon::now()->startOfWeek();
        $endOfThisWeek = Carbon::now()->endOfWeek();

        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();

        // This week's data
        $thisWeekEarnings = DB::table('orders')
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->where('status', 'completed')
            ->sum('total_price');

        $thisWeekOrders = DB::table('orders')
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->count();

        $thisWeekCustomers = DB::table('users')
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->where('role_id', 3)
            ->count();

        $thisWeekProducts = DB::table('products')
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->count();

        // Last week's data
        $lastWeekEarnings = DB::table('orders')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->where('status', 'completed')
            ->sum('total_price');

        $lastWeekOrders = DB::table('orders')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->count();

        $lastWeekCustomers = DB::table('users')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->where('role_id', 3)
            ->count();

        $lastWeekProducts = DB::table('products')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->count();

        // Calculate % change
        $calculateChange = function ($current, $previous) {
            if ($previous == 0) {
                return $current > 0 ? 100 : 0;
            }
            return round((($current - $previous) / $previous) * 100, 2);
        };

        return [
            'earnings' => $thisWeekEarnings,
            'orders' => $thisWeekOrders,
            'customers' => $thisWeekCustomers,
            'products' => $thisWeekProducts,

            'earnings_change' => $calculateChange($thisWeekEarnings, $lastWeekEarnings),
            'orders_change' => $calculateChange($thisWeekOrders, $lastWeekOrders),
            'customers_change' => $calculateChange($thisWeekCustomers, $lastWeekCustomers),
            'products_change' => $calculateChange($thisWeekProducts, $lastWeekProducts),
        ];
    }


    /**
     * Retrieve user details by user ID.
     *
     * This method fetches the user data, including their additional details,
     * by performing an inner join on the users and user_details tables.
     *
     * @param int $userId The user ID to retrieve details for.
     * @return \stdClass|null The user details including additional information, or null if not found.
     */
    public function getUserDetailById($userId)
    {
        $data = DB::table('users')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->where('users.id', $userId)
            ->select('users.*', 'user_details.*')
            ->first();

        return $data;
    }


    /**
     * Retrieve the orders of a user.
     *
     * This method fetches the orders for the given user ID, including the order status,
     * creation date, user name, order item quantity, product name, original price,
     * category discount, and product image.
     *
     * Each order will include a calculated discounted price based on the category discount.
     *
     * @param int $userId The ID of the user whose orders are to be retrieved.
     * @return \Illuminate\Support\Collection A collection of orders with detailed associations and discounted prices.
     */
    public function getUserOrders($userId)
    {
        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('user_details', 'orders.user_id', '=', 'user_details.user_id')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'orders.id as order_id',
                'orders.status',
                'orders.created_at',
                'user_details.first_name',
                'user_details.middle_name',
                'user_details.last_name',
                'order_items.quantity',
                'products.name as product_name',
                'products.price as original_price',
                'categories.discount as category_discount',
                'products.image'
            )
            ->orderBy('orders.id', 'desc')
            ->where('orders.user_id', $userId)
            ->get()
            ->map(function ($order) {
                $categoryDiscount = $order->category_discount ?? 0;
                $price = $order->original_price ?? 0;
                $discountAmount = ($price * $categoryDiscount) / 100;
                $discountedPrice = $price - $discountAmount;

                $order->discounted_price = $discountedPrice;

                return $order;
            });

        return $orders;
    }

    /**
     * Retrieve orders based on the given search criteria.
     *
     * This method expects the search criteria in the request object, which
     * can include the following keys:
     * - `order_id`: The order ID to filter by
     * - `product_name`: A keyword to search for in the product name
     * - `min_price`: The minimum total price to filter by
     * - `max_price`: The maximum total price to filter by
     * - `deliver_status`: The status of the orders to filter by
     * - `user_id`: The user ID to filter by
     *
     * The method retrieves the orders based on the search criteria and passes
     * the selected search criteria back to the view for form repopulation.
     *
     * @param  \Illuminate\Http\Request  $request The request object containing the search criteria
     * @return \Illuminate\Contracts\View\View The view with the filtered orders and selected search criteria
     */
    public function getOrderSearch($searchCriteria)
    {
        $order_id = $searchCriteria['order_id'];
        $product_name = $searchCriteria['product_name'];
        $min_price = $searchCriteria['min_price'];
        $max_price = $searchCriteria['max_price'];
        $status = $searchCriteria['deliver_status'];
        $user_id = $searchCriteria['user_id']; // New line

        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('user_details', 'orders.user_id', '=', 'user_details.user_id')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'orders.id as order_id',
                'orders.status',
                'orders.created_at',
                'orders.total_price',
                'user_details.first_name',
                'user_details.middle_name',
                'user_details.last_name',
                'order_items.quantity',
                'products.name as product_name',
                'products.price as original_price',
                'categories.discount as category_discount',
                'products.image'
            )
            ->when($order_id, function ($query) use ($order_id) {
                $query->where('orders.id', $order_id);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('orders.status', $status);
            })
            ->when($product_name, function ($query) use ($product_name) {
                $query->where('products.name', 'like', '%' . $product_name . '%');
            })
            ->when($min_price && $max_price, function ($query) use ($min_price, $max_price) {
                $query->whereBetween('orders.total_price', [$min_price, $max_price]);
            })
            ->when($user_id, function ($query) use ($user_id) {
                $query->where('orders.user_id', $user_id); // Apply user filter
            })
            ->orderBy('orders.id', 'desc')
            ->get()
            ->map(function ($order) {
                $categoryDiscount = $order->category_discount ?? 0;
                $price = $order->original_price ?? 0;
                $discountAmount = ($price * $categoryDiscount) / 100;
                $discountedPrice = $price - $discountAmount;

                $order->discounted_price = $discountedPrice;

                return $order;
            });

        return $orders;
    }

    /**
     * Check order status by order id.
     *
     * This method fetches the order status and other related details
     * for the given order ID and user ID.
     *
     * @param array $searchCriteria An associative array containing `order_id` and `user_id` keys.
     * @return \Illuminate\Database\Eloquent\Model The order detail with associated user, order items, product, and category details.
     */
    public function checkOrderStatusByOrderId($searchCriteria)
    {
        $order_id = $searchCriteria['order_id'];
        $user_id = $searchCriteria['user_id'];

        $items = DB::table('orders')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'orders.id as order_id',
                'orders.created_at',
                'orders.status',
                'products.name as product_name'
            )
            ->where('orders.id', $order_id)
            ->where('orders.user_id', $user_id)
            ->get();

        if ($items->isEmpty()) {
            return null;
        }

        $order = [
            'order_id' => $items[0]->order_id,
            'created_at' => $items[0]->created_at,
            'status' => $items[0]->status,
            'products' => $items->pluck('product_name')->toArray(),
        ];

        return $order;
    }




}
