<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Repositories\CartItemRepo;
use App\Repositories\CategoryRepo;
use App\Repositories\MenuRepo;
use App\Repositories\SearchRepo;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $view;
    protected $settingRepo,$menuRepo,$cartItemRepo,$categoryRepo,$repo;
    public function __construct(SettingRepo $settingRepo,MenuRepo $menuRepo,CartItemRepo $cartItemRepo,CategoryRepo $categoryRepo,SearchRepo $repo)
    {
        $this->settingRepo = $settingRepo;
        $this->menuRepo = $menuRepo;
        $this->cartItemRepo = $cartItemRepo;
        $this->categoryRepo = $categoryRepo;
        $this->repo = $repo;
        $this->view = 'site.page.shop.';
    }

    /**
     * Search for products by keyword.
     *
     * This method retrieves the products that match the given search keyword.
     * It also fetches the related brands from the same product results.
     * The view returned is the product list page with the products and brands.
     *
     * @param Request $request The request containing the search keyword.
     * @return \Illuminate\Contracts\View\View The view displaying the product list with the products and brands.
     */
    public function searchProduct(Request $request)
    {
        $search = $request['search_keyword'];

        $searchResults = $this->repo->searchData($search);

        $data['products'] = $searchResults['products'];
        $data['brands'] = $searchResults['brands'];
        $data['selectedCategories'] = $searchResults['categoriesMatched']->pluck('id')->toArray();

        $data['searchKeyword'] = $search;
        $data['categories'] = $this->categoryRepo->getMainCategoriesWithSubcategories();

        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        return view($this->view.'list',['data' => $data]);
    }

    /**
     * Handle search for products by brand slug when a brand is selected.
     *
     * This method retrieves the products associated with the given brand slug.
     * It also fetches the related brands from the same product results.
     * The view returned is the product list page with the products and brands.
     *
     * @param \Illuminate\Http\Request $request The request containing the search brand slug.
     * @param string $brandSlug The slug of the brand to filter products by.
     * @return \Illuminate\Contracts\View\View The view displaying the product list with the products and brands.
     */
    public function searchBrandOnChecked(Request $request)
    {
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId);

        $data['categories'] = $this->categoryRepo->getMainCategoriesWithSubcategories();

        $data['cartItems'] = $cartData['cartItems'];
        $data['totalPrice'] = $cartData['totalPrice'];

        // Gather search criteria
        $searchCriteria = [
            'brand_ids' => $request->input('brand_id', []),
            'min_price' => $request->input('min_price', 0),
            'max_price' => $request->input('max_price', 100000),
            'category_ids' => $request->input('category_id', []),
        ];

        $data['items'] = $this->repo->getFilteredProducts($searchCriteria);


        $data['brands'] = $data['items']['brands'];
        $data['products'] = $data['items']['products'];

        $data['selectedBrands'] = $request->input('brand_id', []);
        $data['selectedCategories'] = $request->input('category_id', []);
        $data['minPrice'] = $request->input('min_price', 0);
        $data['maxPrice'] = $request->input('max_price', 100000);

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

         return view($this->view.'list', ['data' => $data]);

    }

    /**
     * Search for products by brand slug.
     *
     * This method retrieves the products, brands and category for a given brand slug.
     * It also fetches the total price and cart items for the currently authenticated user.
     * The view returned is the product list page with the prepared data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @param string $slug The brand slug to filter products by.
     * @return \Illuminate\Contracts\View\View The view displaying the product list with the prepared data.
     */
    public function searchBrand(Request $request ,$slug)
    {
        $data['setting'] = $this->settingRepo->getFirstData();
        $data['menus'] = $this->menuRepo->getMenus();
        $userId = auth()->id() ?? null;
        $cartData = $this->cartItemRepo->getCartItemsByUserId($userId); // Get cart data

        $data['cartItems'] = $cartData['cartItems']; // Cart items collection
        $data['totalPrice'] = $cartData['totalPrice']; // Total price

        $data['items'] = $this->repo->getProductsByBrandSlug($slug);
        $data['categoryId'] = $data['items']['products']->first()->category_id ?? null;

        $data['brands'] = $data['items']['brands'];
        $data['products'] = $data['items']['products'];

        $data['searchBrand'] = $this->repo->getABrandIdBaseOnSlug($slug);

        $data['categories'] = $this->categoryRepo->getMainCategoriesWithSubcategories();

        $chats = Chat::latest()->take(50)->get()->reverse();
        $data['chats'] = $chats;

        return view($this->view.'list', ['data' => $data]);
    }

}
