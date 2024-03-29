<?php

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
// Route::get('/', function () {
//      return view('welcome');
//  });
Route::get('/', 'WebController@index');

Route::get('users/carts', 'CartController@index')->name('carts.index');

Route::post('users/carts', 'CartController@store')->name('carts.store');

Route::delete('users/carts', 'CartController@destroy')->name('carts.destroy');
Route::delete('users/carts/{rowId}', 'CartController@delete');

Route::get('users/mypage', 'UserController@mypage')->name('mypage');
Route::get('users/mypage/edit', 'UserController@edit')->name('mypage.edit');
Route::get('users/mypage/address/edit', 'UserController@edit_address')->name('mypage.edit_address');
Route::put('users/mypage', 'UserController@update')->name('mypage.update');
Route::get('users/mypage/favorite', 'UserController@favorite')->name('mypage.favorite');
Route::get('users/mypage/password/edit', 'UserController@edit_password')->name('mypage.edit_password');
Route::put('users/mypage/password', 'UserController@update_password')->name('mypage.update_password');
Route::delete('users/mypage/delete', 'UserController@destroy')->name('mypage.destroy');
Route::get('users/mypage/cart_history', 'UserController@cart_history_index')->name('mypage.cart_history');
Route::get('users/mypage/cart_history/{num}', 'UserController@cart_history_show')->name('mypage.cart_history_show');
Route::get('users/mypage/register_card', 'UserController@register_card')->name('mypage.register_card');
Route::post('users/mypage/token', 'UserController@token')->name('mypage.token');

Route::post('products/{product}/reviews', 'ReviewController@store');

Route::get('products/{product}/favorite', 'ProductController@favorite')->name('products.favorite');

Route::get('products', 'ProductController@index')->name('products.index');
Route::get('products/{product}', 'ProductController@show')->name('products.show');
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'DashboardController@index')->middleware('auth:admins');

Route::get('items/create/{id}', 'ItemController@create');
Route::post('items/input', 'ItemController@input');
Route::post('/items', 'ItemController@store')->name('items.store');
Route::get('items/confirm', 'ItemController@confirm')->name('items.confirm');
Route::post('items/token', 'ItemController@token');
Route::post('items/store', 'ItemController@store');


Route::get('tokuteis/{id}/tokutei', 'Dashboard\TokuteiController@show')->name('tokuteis.tokutei');;

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
     Route::get('login', 'Dashboard\Auth\LoginController@showLoginForm')->name('login');
     Route::post('login', 'Dashboard\Auth\LoginController@login')->name('login');
     Route::post('logout', 'Dashboard\Auth\LoginController@loggedOut')->name('logout')->middleware('auth:admins');
     Route::resource('major_categories', 'Dashboard\MajorCategoryController')->middleware('auth:admins');
     Route::resource('categories', 'Dashboard\CategoryController')->middleware('auth:admins');
     Route::resource('products', 'Dashboard\ProductController')->middleware('auth:admins');
     Route::resource('users', 'Dashboard\UserController')->middleware('auth:admins');
     Route::get('orders', 'Dashboard\OrderController@index')->middleware('auth:admins');
     Route::get('products/import/csv', 'Dashboard\ProductController@import')->name('products.import_csv')->middleware('auth:admins');
     Route::post('products/import/csv', 'Dashboard\ProductController@import_csv')->middleware('auth:admins');
     Route::resource('events', 'Dashboard\EventController')->middleware('auth:admins');
     Route::get('events/{id}/thankyou_email', 'Dashboard\EventController@thankyou_email')->middleware('auth:admins');
     Route::post('events/{id}/compose_email', 'Dashboard\EventController@compose_email')->middleware('auth:admins');
     Route::resource('tickets', 'Dashboard\TicketController')->middleware('auth:admins');
     Route::get('mailstands/condition', 'Dashboard\MailStandController@condition')->name('mailstands.condition')->middleware('auth:admins');
     Route::post('mailstands/create', 'Dashboard\MailStandController@create')->middleware('auth:admins');
     Route::resource('mailstands', 'Dashboard\MailStandController')->middleware('auth:admins');
     Route::resource('tokuteis', 'Dashboard\TokuteiController')->middleware('auth:admins');
     Route::resource('sellingevents', 'Dashboard\SellingEventController')->middleware('auth:admins');
     Route::resource('contracts', 'Dashboard\ContractController')->middleware('auth:admins');
});

Route::get('/tasks', function () {
     return view('task');
 });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/privacy', 'PrivacyController@index')->name('privacy');
