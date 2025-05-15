<?php

use App\Http\Controllers\Admin\Chat\ChatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductManagement\BrandController;
use App\Http\Controllers\Admin\ProductManagement\CategoryController;
use App\Http\Controllers\Admin\ProductManagement\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleHasPermissionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SocialLoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserDetailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::controller(DashboardController::class)->middleware('auth', 'check.permission')->group(function () {
    Route::get('/admin/dashboard', 'AdminLayout')->name('admin.dashboard');
});

// ---------------------------RESOURCE SECTION ROUTE-----------------------------
Route::middleware('auth', 'check.permission')->group(function () {
    $resources = [
        // 'category' => ProductCategoryController::class,
        'menu' => MenuController::class,
    ];
    foreach ($resources as $route => $controller) {
        Route::resource($route, $controller);
    }
});

//---------------------------ROLE SECTION ROUTE-----------------------------
Route::prefix('admin/role')->middleware('auth', 'check.permission')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('role.index');
    Route::get('create', [RoleController::class, 'create'])->name('role.create');
    Route::post('store', [RoleController::class, 'store'])->name('role.store');
    Route::get('edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::get('show/{id}', [RoleController::class, 'show'])->name('role.show');
    Route::put('update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('destroy/{id}', [RoleController::class, 'delete'])->name('role.destroy');
    Route::get('role-has-permission/{id}', [RoleController::class, 'addPermission'])->name('role.permission');
});

//---------------------------PERMISSION SECTION ROUTE-----------------------------
Route::prefix('admin/permission')->middleware('auth', 'check.permission')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::get('show/{id}', [PermissionController::class, 'show'])->name('permission.show');
    Route::put('update/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('destroy/{id}', [PermissionController::class, 'delete'])->name('permission.destroy');
});

//---------------------------ROLE HAS PERMISSION SECTION ROUTE-----------------------------
Route::prefix('admin/role-has-permission')->group(function () {
    Route::post('store', [RoleHasPermissionController::class, 'store'])->name('role.permission.store');
});

//---------------------------USER  SECTION ROUTE-----------------------------
Route::prefix('admin/user')->middleware('auth', 'check.permission')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('create', [UserController::class, 'create'])->name('user.create');
    Route::post('store', [UserController::class, 'store'])->name('user.store');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::put('update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('destroy/{id}', [UserController::class, 'delete'])->name('user.destroy');

    Route::post('/search', [UserController::class, 'getUserSearchByNameOrStatus'])->name('user.search');
});

//---------------------------Menu Route-----------------------------
Route::prefix('admin/menu')->middleware('auth', 'check.permission')->group(function () {
    Route::post('/menu/update-order', [MenuController::class, 'updateOrder'])->name('menu.updateOrder');
});

//---------------------------user detail-----------------------------
Route::prefix('setting/user/detail')->middleware('auth', 'check.permission')->group(function () {
    Route::get('/', [UserDetailController::class, 'index'])->name('user.detail.index');
    Route::get('edit/{id}', [UserDetailController::class, 'edit'])->name('user.detail.edit');
    Route::put('update/{id}', [UserDetailController::class, 'update'])->name('user.detail.update');
});

//---------------------------Setting-----------------------------
Route::prefix('admin/setting')->middleware('auth', 'check.permission')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('setting.index');
    Route::put('update/{id}', [SettingController::class, 'update'])->name('setting.update');
});

//---------------------------Category-----------------------------
Route::prefix('admin/category')->middleware('auth', 'check.permission')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::post('store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::get('show/{id}', [CategoryController::class, 'show'])->name('category.show');
    Route::put('update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('destroy/{id}', [CategoryController::class, 'delete'])->name('category.destroy');


    Route::get('search', [CategoryController::class, 'getCategorySearch'])->name('category.search');
    Route::post('category/remove-image/{id}', [CategoryController::class, 'removeImage'])->name('category.removeImage');
});


//---------------------------brand-----------------------------
Route::prefix('admin/brand')->middleware('auth', 'check.permission')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('brand.index');
    Route::post('store', [BrandController::class, 'store'])->name('brand.store');
    Route::get('edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::put('update/{id}', [BrandController::class, 'update'])->name('brand.update');
    Route::delete('destroy/{id}', [BrandController::class, 'delete'])->name('brand.destroy');

    Route::get('search', [BrandController::class, 'brandSearchByName'])->name('brand.search');
    Route::post('brand/remove-image/{id}', [BrandController::class, 'removeImage'])->name('brand.removeImage');
});

//---------------------------Product-----------------------------
Route::prefix('admin/product')->middleware('auth', 'check.permission')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('store', [ProductController::class, 'store'])->name('product.store');
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::get('show/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::put('update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('destroy/{id}', [ProductController::class, 'delete'])->name('product.destroy');

    Route::get('/search', [ProductController::class, 'getProductSearch'])->name('product.search');
    Route::get('/brand/search/{category_id}', [ProductController::class, 'getCategoryBaseBrand'])->name('category.brand.search');

    // product gallery image
    Route::get('/product/image/{id}', [ProductController::class, 'getImageView'])->name('product.image');
    Route::get('/product/file-row', [ProductController::class, 'getFilePartialRow'])->name('product.file.row');
    Route::post('/product/store-file-row', [ProductController::class, 'storeFile'])->name('product.file.store');
    Route::delete('/product/file/{id}', [ProductController::class, 'deleteFile'])->name('product.file.delete');
});


//---------------------------Order Management-----------------------------
Route::prefix('admin/order/manage')->middleware('auth', 'check.permission')->group(function () {
    Route::get('/', [OrderManagementController::class, 'index'])->name('order.manage.index');
    Route::put('/status', [OrderManagementController::class, 'updateStatusOfOrder'])->name('order.manage.status');
    Route::post('/search', [OrderManagementController::class, 'getOrderSearch'])->name('order.manage.search');
});


// social media login not complete
Route::get('auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback'])->name('google.callback');



// chat Route
Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');

