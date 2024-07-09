<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::get('/', [LocalController::class, 'index']) -> name('index');
Route::get('/market-place', [LocalController::class, 'market']) -> name('market');
Route::get('/c/{category}', [LocalController::class, 'products']) -> name('products');
Route::get('/p/{product}', [LocalController::class, 'product']) -> name('product');
Route::get('/order', [LocalController::class, 'order']) -> name('order');
Route::get('/so', [LocalController::class, 'place_order']) -> name('place_order');
Route::get('/my-shopping-cart', [LocalController::class, 'cart']) -> name('cart');
Route::post('/chckt', [LocalController::class, 'checkout']) -> name('checkout');
Route::get('/checkout', [LocalController::class, 'checkout_view']) -> name('checkout-view');
Route::post('/complete-order', [LocalController::class, 'completeOrder']) -> name('complete-order');
Route::get('/healthylife', [LocalController::class, 'about']) -> name('about');
Route::post('/so-order', [LocalController::class, 'special_order']) -> name('special-order');
Route::post('/purchase', [ClientController::class, 'confirm_order']) -> name('purchase');
Route::get('/add-to-cart/{product}', [LocalController::class, 'addItemToCart']) -> name('add-to-cart');
Route::get('/change-cart-item/{product}/{quantity}', [LocalController::class, 'changeCartItem']) -> name('change-cart-item');
Route::get('/like/{idProduct}', [LocalController::class, 'add_a_like']) -> name('like');
Route::get('/confirm-order', [LocalController::class,'confirm_order']) -> name('confirm-order');
Route::post('/make-order', [LocalController::class,'make_order']) -> name('make-order');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('search-result', [SearchController::class, 'search_result']) -> name('search-result');
Route::get('/remove-item/{product_id}', [ClientController::class, 'remove_item_from_cart']) -> name('remove-item');
Route::get('/payment/{order}', [LocalController::class,'genInvoice'])->name('payment');
Route::get('/invoice/{order}', [LocalController::class,'sendOrderInvoice'])->name('mail.send0invoice');

Route::get('/dashboard', function () {
    return to_route('client.dashboard');
});

Route::get('/admin', function () {
    return to_route('admin.dashboard');
});

Route::middleware('admin') -> prefix('admin') ->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']) -> name('admin.dashboard');
    Route::get('/products', [AdminController::class, 'products']) -> name('admin.products');
    Route::get('/products/post', [AdminController::class, 'new_product']) -> name('admin.post');
    Route::get('/categories/add', [AdminController::class, 'newCategory']) -> name('admin.add-category');
    Route::post('/categories/post', [AdminController::class, 'createCategory']) -> name('admin.create-category');
    Route::get('/products/post/{category}', [AdminController::class, 'new_product']) -> name('admin.post-by-category');
    Route::post('/post-new-product', [AdminController::class, 'postNewProduct']) -> name('admin.post-new-prod');
    Route::get('/product/{product}/edit', [AdminController::class, 'edit_product']) -> name('admin.edit');
    Route::post('/edit-product', [AdminController::class, 'editProductInfo']) -> name('admin.edit-product');
    Route::get('/delete-product', [AdminController::class, 'deleteProduct']) -> name('admin.delete-prod');
    Route::get('/od/{order}', [AdminController::class, 'orderInfo']) -> name('admin.order');
    Route::get('/approve-order/{order}', [AdminController::class, 'approveOrder']) -> name('admin.approve-order');
    Route::post('/order-approve', [AdminController::class, 'orderApprove']) -> name('admin.order-approve');
    Route::post('/spcl-order-approve', [AdminController::class, 'spclOrderApprove']) -> name('admin.spcl-order-approve');
    Route::post('/deny-order', [AdminController::class, 'denyOrder']) -> name('admin.deny-order');
    Route::post('/deny-spcl-order', [AdminController::class, 'denySpclOrder']) -> name('admin.deny-spcl-order');
    Route::get('/undo-deny', [AdminController::class, 'undoDenyOrder']) -> name('admin.undo-deny');
    Route::get('/undo-delete-prod/{product}', [AdminController::class, 'undoDeleteProduct']) -> name('admin.undo-delete-prod');
    Route::get('/undo-deny-order', [AdminController::class, 'undoDenySpclOrder']) -> name('admin.undo-deny-order');
    Route::get('/so/{order}', [AdminController::class, 'special_order_info']) -> name('admin.special-order');
    Route::get('/orders', [AdminController::class, 'orders']) -> name('admin.orders');
    Route::get('/clients', [AdminController::class, 'clients']) -> name('admin.clients');
    Route::get('/complete-order/{order}', [AdminController::class, 'completeOrder']) -> name('admin.complete-order');
    Route::get('/clients/{client}', [AdminController::class, 'client']) -> name('admin.client');
    Route::get('/messages', [AdminController::class, 'messages']) -> name('admin.messages');
    Route::get('/load-new-messages', [AdminController::class, 'loadNewMessages']);
    Route::post('/add-items', [AdminController::class, 'addItems']) -> name('admin.add-items');
    Route::post('/send-msg', [AdminController::class, 'reply']) -> name('admin.send');
    Route::post('/promote', [AdminController::class, 'promote']) -> name('admin.promote');
    Route::get('/un-promote/{product}', [AdminController::class, 'unPromote']) -> name('admin.un-promote');
    Route::get('/profile', [AdminController::class, 'profile']) -> name('admin.profile');
    Route::patch('/profile', [ProfileController::class, 'edit_profile'])->name('admin.profile-update');
    Route::post('signout', [AuthenticatedSessionController::class, 'destroyAdminSession']) ->name('signout');
    Route::get('/poster/post', [AdminController::class, 'new_poster']) -> name('admin.new-poster');
    Route::get('/posting', [AdminController::class, 'posting']) -> name('admin.posting');
    Route::get('/edit-poster/{pst}/{poster}', [AdminController::class, 'editPoster']) -> name('admin.edit-poster');
    Route::get('/edit-slogan/{slogan}', [AdminController::class, 'editSlogan']) -> name('admin.edit-slogan');
    Route::post('/create-poster', [AdminController::class, 'create_poster']) -> name('admin.create-poster');
    Route::post('/edit-poster-info', [AdminController::class, 'editPosterInfo']) -> name('admin.edit-poster-info');
    Route::post('/edit-slogan-info', [AdminController::class, 'editSloganInfo']) -> name('admin.edit-slogan-info');
    Route::get('/del-poster/{poster_id}', [AdminController::class, 'del_poster']) -> name('admin.del-poster');
    Route::get('/complete-special-order/{order}', [AdminController::class, 'completeSpecialOrder']) -> name('admin.complete-special-order');
    Route::get('/{category}/edit', [AdminController::class, 'CategoryForm']) -> name('admin.edit-category');
    Route::post('/edit-category', [AdminController::class, 'EditCategory']) -> name('admin.edit-category-info');
  	Route::put('/password', [PasswordController::class, 'update_password'])->name('admin.password-update');
});

Route::middleware('admin')->get('/messages/latest', [AdminController::class, 'latestMessages'])->name('messages.latest');
Route::middleware('admin')->get('/messages/{userId}/all', [AdminController::class, 'getAllMessages'])->name('messages.get');

Route::middleware('auth') -> prefix('my') -> group( function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard']) -> name('client.dashboard');
    Route::get('/so', [ClientController::class, 'spcl_orders']) -> name('client.spclorders');
    Route::get('/p/{product}', [ClientController::class, 'product']) -> name('client.product');
    Route::get('/order/{slag}', [ClientController::class, 'order']) -> name('client.order');
    Route::get('/place-order', [ClientController::class, 'place_order']) -> name('client.place_order');
    Route::post('/chckt', [ClientController::class, 'checkout']) -> name('client.checkout');
    Route::get('/checkout', [ClientController::class, 'checkoutView'])->middleware('checkout')-> name('client.chckt');
    Route::post('/complete-order', [ClientController::class, 'completeOrder']) -> name('client.complete-order');
    Route::get('/messages', [ClientController::class, 'messages']) -> name('client.messages');
    Route::get('/profile', [ClientController::class, 'profile']) -> name('client.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/order', [ClientController::class, 'special_order']) -> name('client.special-order');
    Route::get('/market-place', [ClientController::class, 'market_place']) -> name('client.market-place');
    Route::get('/market-sort/{ctgr}', [ClientController::class, 'market_sort']) -> name('client.sort-market');
    Route::get('/confirm-order', [ClientController::class,'confirm_order']) -> name('client.confirm-order');
    Route::post('/update-order', [ClientController::class,'update_order']) -> name('client.update-order');
    Route::post('/make-order', [ClientController::class,'make_order']) -> name('client.make-order');
    Route::get('/update-delivery/{order_id}', [ClientController::class,'update_delivery']) -> name('update-delivery');
    Route::get('/address/{order_id}', [ClientController::class, 'address']) -> name('address');
    Route::get('/offload/{order_id}', [ClientController::class, 'offload_order']) -> name('offload-order');
    Route::get('/spcl-offload/{order_id}', [ClientController::class, 'offload_spcl']) -> name('offload-spcl');
    Route::get('/undo/{order_id}', [ClientController::class, 'undo_delete']) -> name('undo-delete');
    Route::get('/spcl-undo/{order_id}', [ClientController::class, 'undo_spcl']) -> name('undo-spcl');
    Route::post('/message', [ClientController::class, 'client_message']) -> name('client.message');
    Route::get('/wishlist-remove/{idProduct}', [ClientController::class, 'remove_item_from_wishlist']) -> name('wishlist-remove');
    Route::get('/c/{category}', [ClientController::class, 'products']) -> name('client.products');
  	Route::post('/update-profile-pic', [ProfileController::class, 'UpdateProfilePicture']) -> name('client.update-profile-pic');
});

require __DIR__.'/auth.php';
