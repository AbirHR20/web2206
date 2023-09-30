<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
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

//frontend
Route::get('/',[FrontendController::class,'index'])->name('index');
Route::get('/category/products/{id}',[FrontendController::class,'category_products'])->name('category.products');
Route::get('/subcategory/products/{id}',[FrontendController::class,'subcategory_products'])->name('subcategory.products');
Route::get('/product/details/{slug}',[FrontendController::class,'products_details'])->name('products.details');
Route::post('/getSize',[FrontendController::class,'getSize']);
Route::post('/getQuantity',[FrontendController::class,'getQuantity']);

Route::get('/dashboard', [HomeController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//profile update
Route::get('/user/profile',[HomeController::class,'user_profile'])->name('user.profile');
Route::post('/user/info/update',[HomeController::class,'user_info_update'])->name('user.name.update');
Route::post('/password/update',[HomeController::class,'password_update'])->name('user.pass.update');
Route::post('user/photo/update',[HomeController::class,'user_photo_update'])->name('user.photo.update');

//user
Route::get('user/list',[UserController::class,'user_list'])->name('user.list');
Route::get('user/remove/{user_id}',[UserController::class,'user_remove'])->name('user.remove');

//category
Route::get('category/',[CategoryController::class,'category'])->name('category');
Route::post('category/store',[CategoryController::class,'category_store'])->name('category.store');
Route::get('category/edit/{category_id}',[CategoryController::class,'category_edit'])->name('category.edit');
Route::post('category/update/',[CategoryController::class,'category_update'])->name('category.update');
Route::get('category/soft/delete/{category_id}',[CategoryController::class,'category_soft_delete'])->name('category.soft.delete');
Route::get('category/trash',[CategoryController::class,'category_trash'])->name('category.trash');
Route::get('category/restore/{id}',[CategoryController::class,'category_restore'])->name('category.restore');
Route::get('category/hard/delete/{id}',[CategoryController::class,'category_hard_delete'])->name('category.hard.delete');
Route::post('delete/check',[CategoryController::class,'delete_check'])->name('delete.check');
Route::post('restore/check',[CategoryController::class,'restore_check'])->name('restore.check');

//subcategory
Route::get('subcategory/',[SubcategoryController::class,'subcategory'])->name('subcategory');
Route::post('subcategory/store',[SubcategoryController::class,'subcategory_store'])->name('subcategory.store');
Route::get('subcategory/edit/{id}',[SubcategoryController::class,'subcategory_edit'])->name('subcategory.edit');
Route::post('subcategory/update/{id}',[SubcategoryController::class,'subcategory_update'])->name('subcategory.update');
Route::get('subcategory/delete/{id}',[SubcategoryController::class,'subcategory_delete'])->name('subcategory.delete');

//brand
Route::get('brand/',[BrandController::class,'brand'])->name('brand');
Route::post('brand/store',[BrandController::class,'brand_store'])->name('brand.store');
Route::get('brand/edit/{id}',[BrandController::class,'brand_edit'])->name('brand.edit');
Route::post('brand/update/{id}',[BrandController::class,'brand_update'])->name('brand.update');
Route::get('brand/delete/{id}',[BrandController::class,'brand_delete'])->name('brand.delete');

//product
Route::get('product',[ProductController::class,'product'])->name('product');
Route::post('getSubcategory',[ProductController::class,'getSubcategory'])->name('getSubcategory');
Route::post('product/store',[ProductController::class,'product_store'])->name('product.store');
Route::get('product/list',[ProductController::class,'product_list'])->name('product.list');
Route::get('product/delete/{id}',[ProductController::class,'product_delete'])->name('product.delete');
Route::get('product/show/{id}',[ProductController::class,'product_show'])->name('product.show');
Route::get('product/inventory/{id}',[InventoryController::class,'inventory'])->name('inventory');
Route::post('product/inventory/store/{id}',[InventoryController::class,'inventory_store'])->name('inventory.store');
Route::get('product/inventory/remove/{id}',[InventoryController::class,'inventory_remove'])->name('inventory.remove');


//product variation
Route::get('variation',[InventoryController::class,'variation'])->name('variation');
Route::post('color/store',[InventoryController::class,'color_store'])->name('color.store');
Route::post('size/store',[InventoryController::class,'size_store'])->name('size.store');
Route::get('color/remove/{id}',[InventoryController::class,'color_remove'])->name('color.remove');
Route::get('size/remove/{id}',[InventoryController::class,'size_remove'])->name('size.remove');
Route::post('/changeStatus',[ProductController::class,'changeStatus'])->name('changeStatus');

//customer
Route::get('/customer/login',[CustomerAuthController::class,'customer_login'])->name('customer.login');
Route::get('/customer/register',[CustomerAuthController::class,'customer_register'])->name('customer.register');
Route::post('/customer/store',[CustomerAuthController::class,'customer_store'])->name('customer.store');
Route::post('/customer/login/confirm',[CustomerAuthController::class,'customer_login_confirm'])->name('customer.login.confirm');
Route::get('/customer/profile',[CustomerController::class,'customer_profile'])->name('customer.profile')->middleware('customer');
Route::get('/customer/logout',[CustomerController::class,'customer_logout'])->name('customer.logout');
Route::post('/customer/profile/update',[CustomerController::class,'customer_profile_update'])->name('customer.profile.update');

//cart
Route::post('/cart/store',[CartController::class,'cart_store'])->name('cart.store');
Route::get('/cart/remove/{id}',[CartController::class,'cart_remove'])->name('cart.remove');
Route::get('/cart',[CartController::class,'cart'])->name('cart');
Route::post('/cart/update',[CartController::class,'cart_update'])->name('cart.update');


//coupon
Route::get('/coupon',[CouponController::class,'coupon'])->name('coupon');
Route::post('/coupon/store',[CouponController::class,'coupon_store'])->name('coupon.store');
Route::post('/couponChangeStatus',[ProductController::class,'couponChangeStatus'])->name('couponChangeStatus');
Route::get('/coupon/delete/{id}',[ProductController::class,'coupon_delete'])->name('coupon.delete');

//checkout
Route::get('/checkout',[CheckoutController::class,'checkout'])->name('checkout');
Route::post('/getCity',[CheckoutController::class,'getCity']);
Route::post('/order/store',[CheckoutController::class,'order_store'])->name('order.store');