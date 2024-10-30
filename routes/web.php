<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SupplyController;
use App\Http\Controllers\admin\ImportController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\admin\FrontAdController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
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
// Đăng ký
Route::get('/customer/login',[LoginController::class,'index'])->name('customer.login');
Route::get('/customer/register',[RegisterController::class,'index'])->name('customer.register');
Route::post('/register', [RegisterController::class, 'authenticate'])->name('customer.authenticate');
Route::post('/logout',[LoginController::class,'logout'])->name('customer.logout');
Route::post('/authenticateUser',[LoginController::class,'authenticate'])->name('user.authenticate');


Route::get('/',[FrontController::class,'index'])->name('front.home');
Route::get('/ket-qua-giam-can',[FrontController::class,'ketqua'])->name('front.ketqua');
Route::get('/package/goi-an-giam-can',[FrontController::class,'showComboPackages'])->name('front.combo');
Route::get('/package/banh-an-giam-can',[FrontController::class,'showCookiesPackages'])->name('front.cookies');
Route::get('/package/ngu-coc',[FrontController::class,'showCerealPackages'])->name('front.cereal');
Route::get('/cong-cu-tinh-bmi',[FrontController::class,'bmi'])->name('front.bmi');

Route::get('/categories/{category}',[DetailController::class,'index'])->name('categories.view');


Route::post('/sell/{id}', [OrderController::class, 'muaNgay'])->name('bill.create');
// Route::get('/bill', [OrderController::class, 'bill'])->name('bill');
Route::post('/bill-view/{id}', [OrderController::class, 'billView'])->name('bill.view');
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/bill', [CartController::class, 'create'])->name('order.create');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/bill/view', [OrderController::class, 'showBill'])->name('bill.view1');

Route::get('/account',[AccountController::class,'index'])->name('account.view');
Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');
Route::get('/change-password',[AccountController::class,'showChangePasswordForm'])->name('account.password');
Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');





Route::group(['prefix'=> 'admin'], function(){

    Route::group(['middleware' => 'admin.guest'], function(){
        Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');

    });

    Route::group(['middleware' => 'admin.auth'], function(){
        // Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');


        // Category Route
        Route::get('/categories/create',[CategoryController::class,'create'])->name('categories.create');
        Route::get('/categories/edit',[CategoryController::class,'edit'])->name('categories.edit');
        Route::post('/upload-image', [CategoryController::class, 'uploadImage'])->name('upload_image');
        Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/manage',[CategoryController::class,'manage'])->name('categories.manage');
        Route::get('/categories/edit/{category}',[CategoryController::class,'edit'])->name('categories.edit');
        Route::post('/categories/edit/{category}',[CategoryController::class,'update'])->name('categories.update');
        Route::delete('/categories/destroy/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Supply Route
        Route::get('/suppliers/create',[SupplyController::class,'create'])->name('suppliers.create');
        Route::get('/suppliers/edit',[SupplyController::class,'edit'])->name('suppliers.edit');
        Route::post('/suppliers/create', [SupplyController::class, 'store'])->name('suppliers.store');
        Route::get('/suppliers/manage',[SupplyController::class,'manage'])->name('suppliers.manage');
        Route::get('/suppliers/edit/{supply}',[SupplyController::class,'edit'])->name('suppliers.edit');
        Route::post('/suppliers/edit/{supply}',[SupplyController::class,'update'])->name('suppliers.update');
        Route::delete('/suppliers/destroy/{supply}', [SupplyController::class, 'destroy'])->name('suppliers.destroy');

        // Import Route
        Route::get('/imports/create',[ImportController::class,'create'])->name('imports.create');
        Route::get('/imports/edit',[ImportController::class,'edit'])->name('imports.edit');
        Route::post('/imports/create', [ImportController::class, 'store'])->name('imports.store');
        Route::get('/imports/manage',[ImportController::class,'manage'])->name('imports.manage');
        Route::get('/imports/edit/{import}',[ImportController::class,'edit'])->name('imports.edit');
        Route::post('/imports/edit/{import}',[ImportController::class,'update'])->name('imports.update');
        Route::delete('/imports/destroy/{import}', [ImportController::class, 'destroy'])->name('imports.destroy');

        Route::get('/order/manage',[FrontAdController::class,'manage'])->name('order.manage');
        Route::get('/user/manage',[FrontAdController::class,'index'])->name('user.manage');
        Route::get('/dashboard',[FrontAdController::class,'stats'])->name('dashboard.manage');
        Route::post('/dashboard/filter', [FrontAdController::class, 'filterStats'])->name('admin.filterStats');

 

    });



});