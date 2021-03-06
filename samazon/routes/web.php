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

Route::get('/', 'WebController@index');

// カートの中身を確認するページへのURLを設定
Route::get('users/carts', 'CartController@index')->name('carts.index');
// カートへ追加する処理のルーティングを設定
Route::post('users/carts', 'CartController@store')->name('carts.store');
Route::put('users/carts', 'CartController@update')->name('carts.update');
Route::delete('users/carts', 'CartController@destroy')->name('carts.destroy');
// ユーザー情報関連の各ルーティングを設定
Route::get('users/mypage', 'UserController@mypage')->name('mypage');
Route::get('users/mypage/edit', 'UserController@edit')->name('mypage.edit');
Route::get('users/mypage/address/edit', 'UserController@edit_address')->name('mypage.edit_address');
Route::put('users/mypage', 'UserController@update')->name('mypage.update');
Route::get('users/mypage/favorite', 'UserController@favorite')->name('mypage.favorite');
// パスワード変更画面のURLとパスワードを更新するルーティングを追加
Route::get('users/mypage/password/edit', 'UserController@edit_password')->name('mypage.edit_password');
Route::put('users/mypage/password', 'UserController@update_password')->name('mypage.update_password');
Route::delete('users/mypage/delete', 'UserController@destroy')->name('mypage.destroy');
Route::get('users/mypage/register_card', 'UserController@register_card')->name('mypage.register_card');
Route::post('users/mypage/token', 'UserController@token')->name('mypage.token');
Route::get('users/mypage/cart_history', 'UserController@cart_history_index')->name('mypage.cart_history');
Route::get('users/mypage/cart_history/{num}', 'UserController@cart_history_show')->name('mypage.cart_history_show');

// Route:postでPOSTで使用するルーティングだと分かるようにする
// products/{product}/reviewsとして商品のデータを自動的に取得
// 使用するコントローラーとそのアクションを、ReviewController@storeと指定
Route::post('products/{product}/reviews', 'ReviewController@store');
Route::get('products/{product}/favorite', 'ProductController@favorite')->name('products.favorite');
Route::get('products', 'ProductController@index')->name('products.index');
Route::get('products/{product}', 'ProductController@show')->name('products.show');
// メールでの認証が済んでいない場合はメール送信画面へと遷移
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'DashboardController@index')->middleware('auth:admins');

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('login', 'Dashboard\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Dashboard\Auth\LoginController@login')->name('login');
    Route::resource('major_categories', 'Dashboard\MajorCategoryController')->middleware('auth:admins');
    Route::resource('categories', 'Dashboard\CategoryController')->middleware('auth:admins');
    Route::resource('products', 'Dashboard\ProductController')->middleware('auth:admins');
    Route::resource('users', 'Dashboard\UserController')->middleware('auth:admins');
    Route::get('orders', 'Dashboard\OrderController@index')->middleware('auth:admins');
    Route::get('products/import/csv', 'Dashboard\ProductController@import')->middleware('auth:admins');
    Route::post('products/import/csv', 'Dashboard\ProductController@import_csv')->middleware('auth:admins');
});

URL::forceScheme('https');
