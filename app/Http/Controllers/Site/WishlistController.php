<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Chat;
use App\Models\Wishlist;
use App\Repositories\CartItemRepo;
use App\Repositories\MenuRepo;
use App\Repositories\SettingRepo;
use App\Repositories\WishlistRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    private $view;
    protected $repo,$menuRepo,$settingRepo,$cartItemRepo;
    public function __construct(WishlistRepo $repo,SettingRepo $settingRepo,MenuRepo $menuRepo,CartItemRepo $cartItemRepo)
    {
        $this->repo = $repo;
        $this->menuRepo = $menuRepo;
        $this->settingRepo = $settingRepo;
        $this->cartItemRepo = $cartItemRepo;
        $this->view = 'site.page.wishlist.';
    }


    /**
     * Adds a product to the wishlist.
     *
     * This method takes the product ID from the request and checks if the user is logged in.
     * If the user is not logged in, it returns a JSON response with a 401 status code indicating that the user must be logged in to add items to their wishlist.
     *
     * It then checks if the product is already in the user's wishlist. If it is, it returns a JSON response with a success status of false and a message indicating that the item is already in the user's wishlist.
     *
     * If the product is not already in the wishlist, it stores the item in the wishlist and removes it from the cart if it exists there.
     * The method then returns a JSON response with a success status of true and a message indicating that the item was moved to the wishlist successfully.
     *
     * @param Request $request The request object containing the product ID.
     * @param int $id The ID of the product to add to the wishlist.
     * @return \Illuminate\Http\JsonResponse The JSON response object.
     */
    public function add(Request $request, $id)
    {
        try {
            // Check if the user is logged in
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'You must be logged in to add items to your wishlist.'], 401);
            }

            // Get the logged-in user
            $user = Auth::user();

            // Check if the product is already in the user's wishlist
            $existingItem = Wishlist::where('user_id', $user->id)->where('product_id', $request->product_id)->first();

            if ($existingItem) {
                return response()->json(['success' => false, 'message' => 'This item is already in your wishlist.']);
            }

            // Store the item in the wishlist
            $wishlistItem = new Wishlist();
            $wishlistItem->user_id = $user->id;
            $wishlistItem->product_id = $request->product_id;
            $wishlistItem->save();

            // Remove the item from the cart
            $cartItem = CartItem::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
            if ($cartItem) {
                $cartItem->delete();  // Remove the item from the cart
            }

            return response()->json(['success' => true, 'success' => 'Item moved to your wishlist successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Displays the wishlist page.
     *
     * This method checks if the user is logged in. If not, it redirects to the login page with
     * an error message. It then prepares the data needed to display the wishlist page, including
     * the header title, site settings, menus, cart items, total price, and the user's wishlist items.
     * It fetches the wishlist items for the currently authenticated user and returns the corresponding view.
     *
     * @return \Illuminate\Contracts\View\View The view displaying the wishlist with the prepared data.
     */
    public function getWishlist()
    {
           // Check if the user is authenticated
           if (!auth()->check()) {
            // If not logged in, redirect to login page with a message
            return redirect()->route('login')->with('error', 'Please log in to proceed to checkout.');
        }

        $data['header_title'] = 'Wishlist';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();

        $userId = auth()->user()->id;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price;

        $data['wishlistItems'] = $this->repo->getWishlistItemByUserId($userId);


        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;



        return view($this->view . 'wishlist', ['data' => $data]);

    }

    /**
     * Removes a product from the wishlist.
     *
     * This method attempts to delete a wishlist item based on the provided ID
     * using the wishlist repository. It returns a redirect response with
     * a success message if deletion is successful, or an error message if
     * the deletion fails.
     *
     * @param int $id The ID of the wishlist item to be deleted.
     * @return \Illuminate\Http\RedirectResponse A redirect response indicating the result of the deletion.
     */
    public function deleteWishlist($id)
    {
        $data = $this->repo->deleteRecord($id);
        if($data){
            return redirect()->back()->with('success', 'Item removed from your wishlist successfully!');
        }else{
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

}
