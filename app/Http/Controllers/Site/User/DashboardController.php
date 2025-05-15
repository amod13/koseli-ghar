<?php

namespace App\Http\Controllers\Site\User;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Repositories\CartItemRepo;
use App\Repositories\DashboardRepo;
use App\Repositories\MenuRepo;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    private $view;
    protected $repo, $settingRepo, $menuRepo, $cartItemRepo;

    public function __construct(DashboardRepo $repo, SettingRepo $settingRepo, MenuRepo $menuRepo, CartItemRepo $cartItemRepo)
    {
        $this->repo = $repo;
        $this->settingRepo = $settingRepo;
        $this->menuRepo = $menuRepo;
        $this->cartItemRepo = $cartItemRepo;
        $this->view = 'site.page.dashboard.';
    }


    /**
     * @OA\Get(
     *     path="/user/profile",
     *     summary="Get the user profile page",
     *     tags={"User"},
     *     @OA\Response(response=200, description="User profile page"),
     *     security={{"bearer": {}}}
     * )
     */
    public function getUserProfile()
    {
        $data['header_title'] = 'Profile';

        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;

        $data['userDetail'] = $this->repo->getUserDetailById($userId);

        $data['userId'] = $userId;

        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        return view($this->view . 'index', ['data' => $data]);
    }

    /**
     * Displays the user detail form.
     *
     * This method prepares the data needed to display the user detail form page,
     * including the header title, site settings, menus, cart items, and total price.
     * It fetches the cart items and total price for the currently authenticated user
     * and returns the corresponding view.
     *
     * @param int $userId The ID of the user whose details are to be displayed.
     * @return \Illuminate\Contracts\View\View The view displaying the user detail form with the prepared data.
     */
    public function getUserDetailForm($userId)
    {
        $data['header_title'] = 'Profile Detail';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;

        $data['userDetail'] = $this->repo->getUserDetailById($userId);

        $data['userId'] = $userId ?? null;

        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        return view($this->view . 'user_detail', ['data' => $data]);
    }


    /**
     * Displays the user password change form.
     *
     * This method prepares the data needed to display the user password change form page,
     * including the header title, site settings, menus, cart items, and total price.
     * It fetches the cart items and total price for the currently authenticated user
     * and returns the corresponding view.
     *
     * @param int $userId The ID of the user whose password is to be changed.
     * @return \Illuminate\Contracts\View\View The view displaying the user password change form with the prepared data.
     */
    public function getUserPasswordForm($userId)
    {
        $data['header_title'] = 'User Password';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;

        $data['userId'] = $userId ?? null;

        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        return view($this->view . 'password_change', ['data' => $data]);
    }


    /**
     * Displays the user billing form.
     *
     * This method prepares the data needed to display the user billing form page,
     * including the header title, site settings, menus, cart items, and total price.
     * It fetches the cart items and total price for the currently authenticated user
     * and returns the corresponding view.
     *
     * @param int $userId The ID of the user whose billing detail is to be updated.
     * @return \Illuminate\Contracts\View\View The view displaying the user billing form with the prepared data.
     */
    public function getUserBillingForm($userId)
    {
        $data['header_title'] = 'Billing Detail';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;

        $data['userDetail'] = $this->repo->getUserDetailById($userId);

        $data['userId'] = $userId ?? null;

        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price


        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;


        return view($this->view . 'billing_address', ['data' => $data]);
    }

    /**
     * Displays the user orders page.
     *
     * This method prepares the data needed to display the user orders page,
     * including the header title, site settings, menus, cart items, and total price.
     * It fetches the cart items and total price for the currently authenticated user
     * and returns the corresponding view.
     *
     * @param int $userId The ID of the user whose orders are to be displayed.
     * @return \Illuminate\Contracts\View\View The view displaying the user orders with the prepared data.
     */
    public function getUserOrders($userId)
    {
        $data['header_title'] = 'My Orders';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;

        $data['orders'] = $this->repo->getUserOrders($userId);

        $data['userId'] = $userId ?? null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data
        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;


        return view($this->view . 'user_orders', ['data' => $data]);
    }

    /**
     * Displays the track order page.
     *
     * This method prepares the data needed to display the track order page,
     * including the header title, site settings, menus, cart items, and total price.
     * It fetches the cart items and total price for the currently authenticated user
     * and returns the corresponding view.
     *
     * @return \Illuminate\Contracts\View\View The view displaying the track order with the prepared data.
     */
    public function getUserTrackOrder()
    {
        $data['header_title'] = 'Track Order';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;

        $data['userId'] = $userId ?? null;

        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price


        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;


        return view($this->view . 'track_order', ['data' => $data]);
    }

    /**
     * Displays the user cart page.
     *
     * This method prepares the data needed to display the user cart page,
     * including the header title, site settings, menus, cart items, and total price.
     * It fetches the cart items and total price for the currently authenticated user
     * and returns the corresponding view.
     *
     * @param int $userId The ID of the user whose cart is to be displayed.
     * @return \Illuminate\Contracts\View\View The view displaying the user cart with the prepared data.
     */
    public function getUserCart($userId)
    {
        $data['header_title'] = 'Track Order';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;

        $data['userId'] = $userId ?? null;

        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;


        return view($this->view . 'cart_list', ['data' => $data]);
    }

    /**
     * Displays the search order page.
     *
     * This method prepares the data needed to display the search order page,
     * including the header title, site settings, menus, cart items, and total price.
     * It fetches the cart items and total price for the currently authenticated user
     * and returns the corresponding view.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the search criteria.
     * @return \Illuminate\Contracts\View\View The view displaying the search order with the prepared data.
     */
    public function searchOrder(Request $request)
    {
        $userId = auth()->id();

        $searchCriteria = [
            'order_id' => $request->input('order_id'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'deliver_status' => $request->input('deliver_status'),
            'product_name' => $request->input('product_name'),
            'user_id' => $userId, // Pass user_id for filtering
        ];

        $data['header_title'] = 'Track Order';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $data['userId'] = $userId;

        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId);
        $data['cartItems'] = $cartData['cartItems'];
        $data['totalPrice'] = $cartData['totalPrice'];

        $data['orders'] = $this->repo->getOrderSearch($searchCriteria);


        // For form repopulation
        $data['selected_order_id'] = $request->input('order_id');
        $data['selected_min_price'] = $request->input('min_price');
        $data['selected_max_price'] = $request->input('max_price');
        $data['selected_deliver_status'] = $request->input('deliver_status') ?? null;
        $data['selected_product_name'] = $request->input('product_name');

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        return view($this->view . 'user_orders', ['data' => $data]);
    }

    /**
     * Displays the track order page by order ID.
     *
     * This method prepares the data needed to display the track order page,
     * including the header title, site settings, menus, cart items, and total price.
     * It fetches the cart items and total price for the currently authenticated user
     * and returns the corresponding view.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the order ID.
     * @return \Illuminate\Contracts\View\View The view displaying the track order with the prepared data.
     */
    public function getTrackOrderById(Request $request)
    {
        $data['header_title'] = 'Track Order';

        $userId = auth()->id() ?? null;
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $data['userId'] = $userId;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId);
        $data['cartItems'] = $cartData['cartItems'];
        $data['totalPrice'] = $cartData['totalPrice'];

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        $searchCriteria = [
            'order_id' => $request->input('order_id'),
            'user_id' => $userId
        ];

        $data['order'] = $this->repo->checkOrderStatusByOrderId($searchCriteria);


        $data['selected_order_id'] = $request->input('order_id');

        return view($this->view . 'track_order', ['data' => $data]);
    }


}
