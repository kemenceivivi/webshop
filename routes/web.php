<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderedItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cart', [OrderedItemController::class, 'showAll'])->name('cart')->middleware('auth');
Route::post('/cart/remove/{itemId}', [OrderedItemController::class, 'delete'])->name('ordereditem.deleted');
Route::post('/cart/remove/{itemId}', [OrderedItemController::class, 'delete'])->name('ordereditem.deleted');
Route::post('/cart/send', [OrderedItemController::class, 'validateOrder'])->name('update-order')->middleware('auth');
Route::post('/cart/remove/{itemId}', [OrderedItemController::class, 'delete'])->name('ordereditem.deleted');
Route::post('/cart/send', [OrderedItemController::class, 'validateOrder'])->name('update-order')->middleware('auth');

Route::post('/cart/add/{itemId}/quantity/{quantity}', [ItemController::class, 'addToCart'])->middleware('auth');
Route::get('/menu', [ItemController::class, 'showAll'])->name('items');

Route::get('/orders', [OrderController::class, 'showAllOrders'])->name('orders')->middleware('auth');

Route::get('/menu/category/{id}', [CategoryController::class, 'show'])->name('category');

//ADMIN
//category
Route::post('/admin/category/store', [CategoryController::class, 'storeNewCategory'])->name('store.new.category')->middleware('auth');
Route::get('/admin/category/{id}/edit', [CategoryController::class, 'toEdit'])->name('to.edit')->middleware('auth');
Route::post('/admin/category/{id}/update', [CategoryController::class, 'updateCategory'])->name('edit.category');
Route::post('/admin/category/delete/{categoryId}', [CategoryController::class, 'delete_category'])->name('category.deleted');
//item
Route::post('/admin/item/delete/{itemId}', [ItemController::class, 'delete_item'])->name('item.deleted');
Route::post('/admin/item/restore/{itemId}', [ItemController::class, 'restore_item'])->name('item.restore');
Route::get('/admin/item/{id}/edit', [ItemController::class, 'toEditItem'])->name('to.edit.item')->middleware('auth');
Route::get('/admin/item/new', [ItemController::class, 'newItemForm'])->name('new.item')->middleware('auth');
Route::post('/admin/item/store', [ItemController::class, 'storeNewItem'])->name('store.new.item')->middleware('auth');
Route::post('/admin/item/{id}/update', [ItemController::class, 'updateItem'])->name('edit.item')->middleware('auth');
//order
Route::get('/admin/manage/received', [OrderController::class, 'allOrdersAdmin'])->name('admins.orders')->middleware('auth');
Route::get('/admin/manage/processed', [OrderController::class, 'processedOrders'])->name('processed.orders')->middleware('auth');
Route::get('/admin/manage/{id}', [OrderController::class, 'manageReceived'])->name('admins.received')->middleware('auth');
Route::post('/admin/manage/accept/{orderId})', [OrderController::class, 'acceptOrder'])->name('accept.order')->middleware('auth');
Route::post('/admin/manage/reject/{orderId})', [OrderController::class, 'rejectOrder'])->name('reject.order')->middleware('auth');


Route::get('/admin/category/new', function () {
    return view('newcategory');
})->name('new-category');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/profile', function () {
    return view('profile');
})->name('profile')->middleware('auth');

