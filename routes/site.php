<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Site\Auth\LoginController;
use App\Http\Controllers\Site\Auth\RegisterController;
use App\Http\Controllers\Site\Auth\ResetPasswordController as AuthResetPasswordController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ReviewController;
use App\Http\Controllers\Site\SearchController;
use App\Http\Controllers\Site\ShopController;
use App\Http\Controllers\Site\User\DashboardController;
use App\Http\Controllers\Site\User\UserDetailController;
use App\Http\Controllers\Site\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


//-----------------------HOME SECTION ROUTE-----------------
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'HomeLayout')->name('home.index');
    Route::get('/product/{slug}', 'getProductSinglePage')->name('single.product.view');
    Route::get('/load-more-products', 'loadMoreProducts')->name('products.load.more');
    Route::get('/categories', 'getCategories')->name('get.categories');
});

// Route For Cart
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'getCartList')->name('site.cart.list');
    Route::post('/add-to-cart', 'addToCart')->name('cart.add')->middleware('throttle:50,1');
    Route::post('/cart/update', 'updateCart')->name('cart.update')->middleware('throttle:50,1');
    Route::delete('/cart/{id}', 'deleteCart')->name('site.cart.delete');
    Route::delete('/remove/cart/{id}', 'remove')->name('cart.remove');
});

// Route For Wishlist
Route::controller(WishlistController::class)->group(function () {
    Route::post('/wishlist/add/{id}', 'add')->name('wishlist.add');
    Route::get('/wishlist', 'getWishlist')->name('site.wishlist');
    Route::delete('/wishlist/delete/{id}', 'deleteWishlist')->name('wishlist.delete');
});

// Route For Review
Route::controller(ReviewController::class)->group(function () {
    Route::post('/review/store', 'reviewStore')->name('review.store')->middleware('throttle:20,1');
});

// Route For Checkout
Route::controller(CheckoutController::class)->group(function () {
    Route::get('/checkout', 'getCheckoutForm')->name('site.checkout');
    Route::get('/thankyou', 'getThankYouPage')->name('thankyou.page');
    Route::post('/store', 'store')->name('checkout.store')->middleware('throttle:10,1');
});

// Route For Shop
Route::controller(ShopController::class)->group(function () {
    Route::get('/shop', 'getShop')->name('site.shop.list');
    Route::get('/category/{slug}', 'getCategoryBySlug')->name('category.slug');
});

// Route For Search
Route::controller(SearchController::class)->group(function () {
    Route::get('/search', 'searchProduct')->name('site.search');
    Route::get('/search/brand', 'searchBrandOnChecked')->name('site.brand.search');
    Route::get('/search/{slug}', 'searchBrand')->name('only.brand.search');
});

// Route For Login
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'getLoginform')->name('user.login');
    Route::post('/user/login', 'loginStore')->name('user.login.store');
});

// Route For Register
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'getRegisterForm')->name('user.register');
    Route::post('/user/register', 'registerStore')->name('user.register.store')->middleware('throttle:4,1');
});

// Route For Forgot Password
Route::controller(AuthResetPasswordController::class)->group(function () {
    Route::get('/forgot/password', 'getForgotPasswordForm')->name('forgot.password.form');
    Route::get('/send/email', 'sendEmail')->name('forgot.password.send.email')->middleware('throttle:4,1');
    Route::get('/reset/password/{token}/{email}', 'getResetPasswordForm')->name('reset.password.form');
    Route::post('/reset/password', 'resetPassword')->name('reset.password')->middleware('throttle:40,1');
});

// Route For Dashboard
Route::controller(DashboardController::class)->group(function () {
    Route::get('/user/profile', 'getUserProfile')->name('site.user.profile');
    Route::get('/user/detail/form/{id}', 'getUserDetailForm')->name('user.detail.form');
    Route::get('/user/password/form/{id}', 'getUserPasswordForm')->name('user.password.form');
    Route::get('/user/billing/form/{id}', 'getUserBillingForm')->name('user.billing.form');
    Route::get('/user/orders/{id}', 'getUserOrders')->name('user.orders');
    Route::get('/orders/{id}', 'getOrderDetail')->name('site.user.order.detail');
    Route::get('/user/orders', 'searchOrder')->name('user.orders.filter');
    Route::get('/user/track/Order', 'getUserTrackOrder')->name('user.track.order');
    Route::get('/track/Order', 'getTrackOrderById')->name('search.track.order');
    Route::get('/user/cart/{id}', 'getUserCart')->name('user.cart.list');
    Route::get('/chat/message', 'getChat')->name('chat.message');
});

// Route For User Detail
Route::controller(UserDetailController::class)->group(function () {
    Route::put('/user/detail/form/{id}', 'update')->name('user.detail.form.update');
});



