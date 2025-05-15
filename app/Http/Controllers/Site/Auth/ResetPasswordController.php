<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\Chat;
use App\Repositories\CartItemRepo;
use App\Repositories\MenuRepo;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User; // make sure you have imported User model
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    private $view;
    protected $cartItemRepo,$menuRepo,$settingRepo;
    public function __construct(CartItemRepo $cartItemRepo,MenuRepo $menuRepo,SettingRepo $settingRepo)
    {
        $this->cartItemRepo = $cartItemRepo;
        $this->menuRepo = $menuRepo;
        $this->settingRepo = $settingRepo;
        $this->view = 'site.page.auth.forgot';
    }


    /**
     * Retrieves and displays the forgot password form for users.
     *
     * This method prepares the data needed to display the forgot password form page, including the header title,
     * site settings, menus, cart items, and total price. It fetches the cart items and total price
     * for the currently authenticated user and returns the corresponding view.
     *
     * @return \Illuminate\Contracts\View\View The view displaying the forgot password form with the prepared data.
     */
    public function getForgotPasswordForm()
    {
        $data['header_title'] = 'Forgot Password';
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
     * Handles the forgot password email sending request.
     *
     * This method validates the email address and checks if the user exists in the database.
     * If the user exists, it generates a random token, updates the user's email verification token,
     * and sends a password reset email to the user. If the user does not exist, it redirects back
     * with an error message.
     *
     * @param \Illuminate\Http\Request $request The request containing the email address.
     * @return \Illuminate\Http\RedirectResponse The redirect response containing a success or error message.
     */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // find user by email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // generate random token
            $token = Str::random(60);

            // save token to user table (remember_token)
            $user->email_verification_token = $token;
            $user->email = $request->email;
            $user->save();

            // send email
            Mail::to($user->email)->send(new PasswordResetMail($user));

            return redirect()->route('user.login')->with('success', 'We have sent you an email to reset your password.');
        } else {
            return redirect()->back()->with('error', 'We could not find a user with that email.');
        }
    }


    /**
     * Displays the reset password form.
     *
     * This method prepares the necessary data to display the reset password form page,
     * including the header title, site settings, menus, cart items, total price, and chat messages.
     * It also includes the user's email and token for password reset. The view returned is the
     * reset password form populated with the prepared data.
     *
     * @param string $token The token for password reset.
     * @param string $email The email of the user requesting the password reset.
     * @return \Illuminate\Contracts\View\View The view displaying the reset password form.
     */

    public function getResetPasswordForm($token, $email)
    {
        $data['header_title'] = 'Forgot Password';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();

        $data['email'] = $email;
        $data['token'] = $token;

        $userId = Auth::check() ? Auth::id() : null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId);
        $data['cartItems'] = $cartData['cartItems'];
        $data['totalPrice'] = $cartData['totalPrice'];

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;


        return view('site.page.auth.reset-password', ['data' => $data]);
    }


    /**
     * Reset the password for a user.
     *
     * This function resets the password for a user with the given email and token.
     * It validates the input, finds the user, updates the password and clears the token.
     * If the user is found, it redirects to the login page with a success message.
     * If the user is not found, it redirects back with an error message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'token' => 'required',
        ]);

        // Find user by email and token
        $user = User::where('email', $request->email)
                    ->where('email_verification_token', $request->token)
                    ->first();

        if ($user) {
            // Update the password
            $user->password = bcrypt($request->password);
            $user->email_verification_token = null; // Optionally clear the token
            $user->save();

            return redirect()->route('user.login')->with('success', 'Your password has been reset successfully.');
        } else {
            return redirect()->back()->with('error', 'We could not find a user with that email or invalid token.');
        }
    }

}
