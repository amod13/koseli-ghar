<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Repositories\BrandRepo;
use App\Repositories\CartItemRepo;
use App\Repositories\CategoryRepo;
use App\Repositories\MenuRepo;
use App\Repositories\ProductRepo;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private $view;
    protected $settingRepo,$menuRepo,$cartItemRepo,$categoryRepo,$brandRepo,$productRepo;
    public function __construct(SettingRepo $settingRepo,MenuRepo $menuRepo,CartItemRepo $cartItemRepo,CategoryRepo $categoryRepo,BrandRepo $brandRepo,ProductRepo $productRepo)
    {
        $this->settingRepo = $settingRepo;
        $this->menuRepo = $menuRepo;
        $this->cartItemRepo = $cartItemRepo;
        $this->categoryRepo = $categoryRepo;
        $this->brandRepo = $brandRepo;
        $this->productRepo = $productRepo;
        $this->view = 'site.page.shop.';
    }


    /**
     * Returns the product list page for the shop.
     *
     * This method retrieves the products, brands and category for a given category slug.
     * It also fetches the total price and cart items for the currently authenticated user.
     * The view returned is the product list page with the prepared data.
     *
     * @return \Illuminate\Contracts\View\View The view displaying the product list with the prepared data.
     */
    public function getShop()
    {
        $data['header_title'] = 'Product Shop';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();

        $data['categories'] = $this->categoryRepo->getMainCategoriesWithSubcategories();

        $userId = auth()->id() ?? null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $data['brands'] = $this->brandRepo->getAll();
        $data['products'] = $this->productRepo->getAllProductForShop();

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;


        return view($this->view.'list', ['data' => $data]);
    }

    /**
     * Returns the product list page for a given category slug.
     *
     * This method retrieves the products, brands and category for a given category slug.
     * It also fetches the total price and cart items for the currently authenticated user.
     * The view returned is the product list page with the prepared data.
     *
     * @param string $slug The category slug
     * @return \Illuminate\Contracts\View\View The view displaying the product list with the prepared data.
     */
    public function getCategoryBySlug($slug)
    {
        $data['header_title'] = 'Product Shop';
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['categories'] = $this->categoryRepo->getMainCategoriesWithSubcategories();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $data['items'] = $this->categoryRepo->getProductsByCategorySlug($slug);
        $data['categoryId'] = $data['items']['category']->id ?? null;


        $data['category'] = $data['items']['category'];
        $data['brands'] = $data['items']['brands'];
        $data['products'] = $data['items']['products'];

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;


        return view($this->view.'list', ['data' => $data]);
    }

}
