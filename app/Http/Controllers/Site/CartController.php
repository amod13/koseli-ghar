<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Chat;
use App\Models\Product;
use App\Repositories\CartItemRepo;
use App\Repositories\MenuRepo;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private $view;
    protected $cartItemRepo,$menuRepo,$settingRepo;
    public function __construct(CartItemRepo $cartItemRepo,MenuRepo $menuRepo,SettingRepo $settingRepo)
    {
        $this->cartItemRepo = $cartItemRepo;
        $this->menuRepo = $menuRepo;
        $this->settingRepo = $settingRepo;
         $this->view = 'site.page.cart.';
    }

    /**
     * Adds a product to the cart.
     *
     * Checks if the user is logged in, and if the product is already in the cart.
     * If the product is already in the cart, updates the quantity. If not, creates a new entry.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        $userId = Auth::id();
        $sessionId = session()->getId();

        if ($userId) {
            // Logged-in user: store with flag 0
            $cartItem = CartItem::where('user_id', $userId)
                ->where('product_id', $productId)
                ->where('flag', 0)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'flag' => 0
                ]);
            }
        } else {
            // Guest user: store using session ID with flag 1
            $cartItem = CartItem::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->where('flag', 1)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'session_id' => $sessionId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'flag' => 1
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product added to cart.');
    }

    /**
     * Update the quantities of items in the cart.
     *
     * This method receives a request containing an array of cart item IDs and their corresponding
     * updated quantities. It iterates through the array, ensures that each quantity is a valid
     * number greater than zero, and updates the quantity of each cart item in the database for
     * the authenticated user.
     *
     * @param \Illuminate\Http\Request $request The request object containing the updated quantities.
     * @return \Illuminate\Http\RedirectResponse The response object that redirects back to the cart page
     * with a success message.
     */
    public function updateCart(Request $request)
    {
        $userId = Auth::check() ? Auth::id() : null;
        $quantities = $request->input('quantities'); // Array of updated quantities

        foreach ($quantities as $cartItemId => $quantity) {
            // Ensure quantity is a valid number
            $quantity = (int) $quantity;

            // Check if the cart item exists
            $cartItem = DB::table('cart_items')
                ->where('id', $cartItemId)
                ->where('user_id', $userId)
                ->first();

            if ($cartItem) {
                // Get the product associated with the cart item
                $product = Product::find($cartItem->product_id);

                if (!$product) {
                    return redirect()->back()->with('error', 'Product not found.');
                }

                // Check if the requested quantity is available in stock
                if ($product->stock < $quantity) {
                    return redirect()->back()->with('error', 'Not enough stock for ' . $product->name);
                }

                // If the quantity is valid, update the cart item
                if ($quantity > 0) {
                    DB::table('cart_items')
                        ->where('id', $cartItemId)
                        ->where('user_id', $userId)
                        ->update(['quantity' => $quantity]);
                }
            }
        }

        // Redirect back to the cart page with a success message
        return redirect()->back()->with('success', 'Cart updated successfully.');
    }


    /**
     * Retrieves and displays the cart list for the authenticated user.
     *
     * This method prepares the data needed to display the cart list page, including the header title,
     * site settings, menus, cart items, and total price. It fetches the cart items and total price
     * for the currently authenticated user and returns the corresponding view.
     *
     * @return \Illuminate\Contracts\View\View The view displaying the cart list with the prepared data.
     */
    public function getCartList()
    {
        $data['header_title'] = 'Cart List';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();

        $userId = Auth::check() ? Auth::id() : null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId);

        $data['cartItems'] = $cartData['cartItems'];
        $data['totalPrice'] = $cartData['totalPrice'];

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;


        return view($this->view . 'list', ['data' => $data]);
    }


    /**
     * Delete a cart item by ID.
     *
     * This method attempts to delete a cart item based on the provided ID
     * using the cart item repository. It returns a redirect response with
     * a success message if deletion is successful, or an error message if
     * the deletion fails.
     *
     * @param int $id The ID of the cart item to be deleted.
     * @return \Illuminate\Http\RedirectResponse A redirect response indicating the result of the deletion.
     */
    public function deleteCart($id)
    {
        $data  = $this->cartItemRepo->deleteRecord($id);
        if($data){
            return redirect()->back()->with('success', 'Cart item deleted successfully.');
        }else{
            return redirect()->back()->with('error', 'Cart item not deleted successfully.');
        }
    }

    /**
     * Remove a cart item using the provided ID.
     *
     * This method takes the ID of the cart item to be deleted and calls the repository to delete the item.
     * It returns a JSON response with a success message and a status code of 200 if the deletion is successful,
     * or a JSON response with an error message and a status code of 400 if the item is not found or could not be removed.
     * If an exception occurs during the process, it returns a JSON response with an error message and a status code of 500.
     *
     * @param int $id The ID of the cart item to be removed.
     * @return \Illuminate\Http\JsonResponse The JSON response with the result of the deletion.
     */
    public function remove($id)
    {
        try {
            // Call the repository to delete the cart item
            $data = $this->cartItemRepo->deleteRecord($id);

            // Check if deletion was successful
            if ($data) {
                return response()->json(['success' => true, 'message' => 'Item removed from cart']);
            } else {
                return response()->json(['success' => false, 'message' => 'Item not found or could not be removed'], 400);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that may occur during the process
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }



}
