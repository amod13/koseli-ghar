<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Repositories\CartItemRepo;
use App\Repositories\MenuRepo;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $view;
    protected $cartItemRepo,$menuRepo,$settingRepo;
    public function __construct(CartItemRepo $cartItemRepo,MenuRepo $menuRepo,SettingRepo $settingRepo)
    {
        $this->cartItemRepo = $cartItemRepo;
        $this->menuRepo = $menuRepo;
        $this->settingRepo = $settingRepo;
        $this->view = 'site.page.auth.login';
    }

    /**
     * Displays the login form
     *
     * This method prepares the data needed to display the login form page, including the header title,
     * site settings, menus, cart items, and total price. It fetches the cart items and total price
     * for the currently authenticated user and returns the corresponding view.
     *
     * @return \Illuminate\Contracts\View\View The view displaying the login form with the prepared data.
     */
    public function getLoginform()
    {
        $data['header_title'] = 'Login Form';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();

        $userId = Auth::check() ? Auth::id() : null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId);
        $data['cartItems'] = $cartData['cartItems'];
        $data['totalPrice'] = $cartData['totalPrice'];

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        return view($this->view, ['data' => $data]);
    }


    /**
     * Stores the user login credentials
     *
     * This method validates the given request data for required fields, attempts to login the user
     * using the provided email and password. If the login attempt is successful, it redirects the user
     * to the home page with a success message. If the login attempt fails, it redirects the user back
     * to the login form with an error message.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing login credentials.
     * @return \Illuminate\Http\RedirectResponse Redirects to the home page or login form with a message.
     */
    public function loginStore(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if(Auth::user()->role_id == null){
                return redirect()->route('home.index')->with('success', 'Login Successfully');
            }else{
                return redirect()->route('admin.dashboard')->with('success', 'Login Successfully');
            }

        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }


}
