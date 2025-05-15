<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckoutDetail;
use App\Repositories\OrderManageRepo;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    private $view;
    protected $repo;
    public function __construct(OrderManageRepo $repo)
    {
        $this->middleware('check.permission');
        $this->repo = $repo;
        $this->view = 'admin.page.order_management.';
    }

    /**
     * Display a listing of orders.
     *
     * This method sets the header title and retrieves all orders from the repository.
     * It then returns the view for displaying the order list.
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function index()
    {
        $data['header_title'] = 'Order List';
        $data['orders'] = $this->repo->getAllOrder();

        return view($this->view . 'index', ['data' => $data]);
    }

    /**
     * Update the status of the order.
     *
     * This method updates the status of the order in the database based on the
     * request parameters. It expects the order ID and the status in the request.
     * The method uses the CheckoutDetail model to find the order and update its
     * status, and redirects back to the referring page with a success message
     * upon completion.
     *
     * @param  \Illuminate\Http\Request  $request The request object containing the order ID and status.
     * @return \Illuminate\Http\RedirectResponse The response object with a redirect to the referring page.
     */
    public function updateStatusOfOrder(Request $request)
    {
        $order = CheckoutDetail::find($request->orderId);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    /**
     * Retrieve orders based on the given search criteria.
     *
     * This method expects the search criteria in the request object, which
     * can include the following keys:
     * - `date`: The date to filter by order creation date
     * - `status`: The status of the orders to filter by
     * - `keyword`: A keyword to search for in the order details
     *
     * The method retrieves the orders based on the search criteria and passes
     * the selected search criteria back to the view for form repopulation.
     *
     * @param  \Illuminate\Http\Request  $request The request object containing the search criteria
     * @return \Illuminate\Contracts\View\View The view with the filtered orders and selected search criteria
     */
    public function getOrderSearch(Request $request)
    {
        // Fetch search criteria from the request
        $searchCriteria = [
            'to_date' => $request->input('to_date'),
            'from_date' => $request->input('from_date'),
            'status' => $request->input('status'),
        ];
    // get alll= ordr based on the search criteria
    $data['orders'] = $this->repo->getAllOrderBySearchCriteria($searchCriteria);

    // Pass the selected search criteria back to the view for form repopulation
    $data['selected_to_date'] = $request->input('to_date');
    $data['selected_from_date'] = $request->input('from_date');
    $data['selected_status'] = $request->input('status');

    return view($this->view . '.index', ['data' => $data]);
    }


}
