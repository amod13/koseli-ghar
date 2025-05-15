<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\createRecord;
use App\Models\CartItem;
use App\Models\CheckoutDetail;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repositories\CartItemRepo;
use App\Repositories\CheckoutRepo;
use App\Repositories\MenuRepo;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;

use App\Mail\OrderPlacedMail;
use App\Models\Chat;
use App\Models\UserDetail;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    private $view;
    protected $repo,$settingRepo,$menuRepo,$cartItemRepo,$userRepo;
    public function __construct(CheckoutRepo $repo,SettingRepo $settingRepo,MenuRepo $menuRepo,CartItemRepo $cartItemRepo,UserRepo $userRepo)
    {
        $this->repo = $repo;
        $this->settingRepo = $settingRepo;
        $this->menuRepo = $menuRepo;
        $this->cartItemRepo = $cartItemRepo;
        $this->userRepo = $userRepo;
        $this->view = 'site.page.checkout.';
    }

    /**
     * Display the checkout form view with necessary data.
     *
     * This method retrieves and prepares data for the checkout form view, including
     * header title, settings, menus, user's cart items, and total price. It authenticates
     * the user to fetch the relevant cart data.
     *
     * @return \Illuminate\Contracts\View\View The checkout form view populated with data.
     */
    public function getCheckoutForm()
    {
        $data['header_title'] = 'Checkout Form';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();

        $userId = Auth::check() ? Auth::id() : null;
        $data['userDetail'] = $this->userRepo->getUserDetailByIdForCheckout($userId);

        // dd($data['userDetail']);

        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price;


        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        if ($data['cartItems']->isEmpty()) {
            return redirect()->route('home.index');
        } else {
            return view($this->view . 'form', ['data' => $data]);
        }

    }

    /**
     * Processes the store request for checkout.
     *
     * Validates the request data for required fields, creates an order record
     * in the CheckoutDetail model, and saves each cart item's information to
     * the OrderItem table. Additionally, it updates the product stock based
     * on the purchased quantities.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing order details.
     * @return \Illuminate\Http\RedirectResponse Redirects to the thank you page with a success message upon order completion.
     */
    public function store(createRecord $request)
    {
        $request->validate([
            'first_name'           => 'required',
            'last_name'           => 'required',
            'email'           => 'required|email',
            'phone'           => 'required',
            'address'         => 'required',
            'payment_method'  => 'required',
        ]);

        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = Session::getId(); // 👈 session id capture

        if ($userId) {
            $userDetail = UserDetail::updateOrCreate(
                ['user_id' => $userId],
                [
                    'first_name'  => $request->first_name,
                    'last_name'   => $request->last_name,
                    'middle_name' => $request->middle_name,
                    'email'       => $request->email,
                    'phone'       => $request->phone,
                    'address'     => $request->address,
                    'city'        => $request->city,
                ]
            );
        } else {
            // Create a temporary object for guest checkout
            $userDetail = (object)[
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'middle_name' => $request->middle_name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'address'     => $request->address,
                'city'        => $request->city,
            ];
        }

        // Save to orders table
        $order = CheckoutDetail::create([
            'user_id'        => $userId,
            'session_id'     => $sessionId, // 👈 store session id too
            'total_price'    => $request->total_price,
            'status'         => 'pending',
            'payment_method' => $request->payment_method,
            'message'        => $request->message ?? null,
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'middle_name' => $request->middle_name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'city'        => $request->city,
        ]);

        // Get cart items
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // 👈 update this method
        $data['cartItems'] = $cartData['cartItems'];

        foreach ($data['cartItems'] as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product_price,
            ]);

            // Reduce stock
            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock = max($product->stock - $item->quantity, 0);
                $product->save();
            }
        }

        // Clear cart
        if ($userId) {
            CartItem::where('user_id', $userId)->delete();
        } else {
            CartItem::where('session_id', $sessionId)->delete(); // 👈 clear guest cart
        }

        // Send confirmation email
        Mail::to($userDetail->email)->send(new OrderPlacedMail($order, $userDetail));

        return redirect()->route('home.index')->with('success', 'Your order has been received and will be processed soon!');

    }


    /**
     * Display the thank you page view.
     *
     * This method prepares data for the thank you page view, setting the
     * header title to "Thank You", and returns the corresponding view.
     *
     * @return \Illuminate\Contracts\View\View The thank you page view.
     */
    public function getThankYouPage()
    {
         // Check if the user is authenticated
         if (!auth()->check()) {
            // If not logged in, redirect to login page with a message
            return redirect()->route('login')->with('error', 'Please log in to proceed to checkout.');
        }

        $data['header_title'] = 'Thank You';

        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();

        $userId = auth()->user()->id ?? null;

        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data
        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price;


        return view($this->view . 'thankyou', ['data' => $data]);
    }

}
