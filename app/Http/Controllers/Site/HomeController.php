<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Menu;
use App\Repositories\CartItemRepo;
use App\Repositories\CategoryRepo;
use App\Repositories\MenuRepo;
use App\Repositories\ProductRepo;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $menuRepo,$settingRepo,$productRepo,$categoryRepo,$cartItemRepo;
    public function __construct(MenuRepo $menuRepo,SettingRepo $settingRepo,ProductRepo $productRepo,CategoryRepo $categoryRepo,CartItemRepo $cartItemRepo)
    {
        $this->menuRepo = $menuRepo;
        $this->settingRepo = $settingRepo;
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->cartItemRepo = $cartItemRepo;
    }


    /**
     * Returns the home page of the site.
     *
     * This method retrieves the following data and passes it to the home page view:
     * - The header title
     * - The menus
     * - The setting
     * - The products whose status is active (for home page)
     * - The main categories
     * - The categories with base brand
     * - The cart items and total price for the currently authenticated user
     * - The latest 50 chats
     * - The categories with slider status true
     *
     * @return \Illuminate\Contracts\View\View The view displaying the home page with the prepared data.
     */
    public function HomeLayout()
    {
        $data['header_title'] = 'Best Ecommerce Site';
        $data['menus'] = $this->menuRepo->getMenus();
        $data['setting'] = $this->settingRepo->getFirstData();

        // $data['products'] = $this->productRepo->getAllProductsWhereStatusIsActiveForHome();

        $data['products'] = $this->productRepo->getAllProductsWhereStatusIsActiveForHome(6);

        $data['categories'] = $this->categoryRepo->getMainCategories();

        $data['brandBaseCategory'] = $this->categoryRepo->getCategoryBaseBrand();


        $userId = auth()->id() ?? null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;


        $data['sliders'] = $this->categoryRepo->getCategoryWhereIsSliderIsOne();

        return view('site.main.index', ['data' => $data]);
    }


    /**
     * Displays the category list page.
     *
     * This method retrieves the following data and passes it to the category list page view:
     * - The header title
     * - The menus
     * - The setting
     * - The cart items and total price for the currently authenticated user
     * - The latest 50 chats
     * - The categories
     *
     * @return \Illuminate\Contracts\View\View The view displaying the category list with the prepared data.
     */
    public function getCategories()
    {
        $data['header_title'] = 'Best Ecommerce Site';
        $data['menus'] = $this->menuRepo->getMenus();
        $data['setting'] = $this->settingRepo->getFirstData();


        $userId = auth()->id() ?? null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        $data['categories'] = $this->categoryRepo->getMainCategories();


        return view('site.page.category.index', ['data' => $data]);
    }


    /**
     * Handles the AJAX request for loading more products on the homepage.
     *
     * This method returns the rendered HTML of the product box partial.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function loadMoreProducts(Request $request)
    {
        $data['products'] = $this->productRepo->getAllProductsWhereStatusIsActiveForHome(6);
        $data['setting'] = $this->settingRepo->getFirstData();

        if ($request->ajax()) {
            return view('site.page.partials.product-box', ['data' => $data])->render();
        }

        return response()->json(['html' => '']);
    }


    /**
     * Returns the product detail page.
     *
     * @param string $slug The slug of the product to be displayed.
     * @return \Illuminate\Contracts\View\View
     */
    public function getProductSinglePage($slug)
    {
        $data['header_title'] = 'Product Detail';
        $data['product'] = $this->productRepo->getProductWhereSlugIs($slug);
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $data['reviews'] = $this->productRepo->getAllReviewsWhereProductSlugIs($slug);
        $data['averageRating'] = $data['reviews']->avg('rating'); // Calculate the average rating


        $userId = auth()->id() ?? null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        // dd($data['reviews']);
        return view('site.page.product.single', ['data' => $data]);
    }






}
