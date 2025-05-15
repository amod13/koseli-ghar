<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\site\register\create;
use App\Models\Chat;
use App\Repositories\CartItemRepo;
use App\Repositories\MenuRepo;
use App\Repositories\RegisterRepo;
use App\Repositories\SettingRepo;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    private $view;
    protected $repo,$cartItemRepo,$menuRepo,$settingRepo;
    public function __construct(UserRepo $repo,CartItemRepo $cartItemRepo,MenuRepo $menuRepo,SettingRepo $settingRepo)
    {
        $this->repo = $repo;
        $this->cartItemRepo = $cartItemRepo;
        $this->menuRepo = $menuRepo;
        $this->settingRepo = $settingRepo;
        $this->view = 'site.page.auth.register';
    }

    /**
     * Retrieves and displays the registration form for users.
     *
     * This method prepares the data needed to display the registration form page, including the header title,
     * site settings, menus, cart items, and total price. It fetches the cart items and total price
     * for the currently authenticated user and returns the corresponding view.
     *
     * @return \Illuminate\Contracts\View\View The view displaying the registration form with the prepared data.
     */
    public function getRegisterForm()
    {
        $data['header_title'] = 'Register Form';
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
     * Registers a new user using the given request data.
     *
     * This method validates the request data for required fields, creates a new user record,
     * and saves the record to the database. If the registration is successful, it redirects
     * the user to the home page with a success message. If the registration fails,
     * it redirects the user to the registration form with an error message.
     *
     * @param \App\Http\Requests\site\register\create $request The incoming request containing registration details.
     * @return \Illuminate\Http\RedirectResponse Redirects to the home page or registration form with a message.
     */
    // public function registerStore(create $request)
    // {
    //     $data = $request->only($this->repo->getModel()->getFillable());

    //     if (isset($data['password'])) {
    //         $data['password'] = bcrypt($data['password']);
    //     }

    //     $result = $this->repo->createRecord($data);

    //     if ($result) {
    //         return redirect()->route('user.login')->with('registered', 'You Are Registered Successfully');
    //     } else {
    //         return redirect()->back()->with('error', 'Something went wrong');
    //     }
    // }

    public function registerStore(create $request)
    {
        $data = $request->only($this->repo->getModel()->getFillable());

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $result = $this->repo->createRecord($data);

        if ($result) {
            return redirect()->route('user.login')
                             ->with('registered', 'You Are Registered Successfully')
                             ->with('email', $result->email); // pass the email
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

}
