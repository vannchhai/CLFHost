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

Route::get('/', 'TemplateController@index');

Auth::routes();
Route::get('/home', 'HomeController@index');

Route::get('/user', 'User\UsersController@index');
Route::get('/user_create', 'User\UsersController@create');
Route::get('/user_edit/{id}', 'User\UsersController@edit');
Route::get('/user_delete/{id}', 'User\UsersController@delete');
Route::get('/user_detail/{id}', 'User\UsersController@detail');
Route::post('/user_insert', 'User\UsersController@insert');
Route::post('/user_update', 'User\UsersController@update');


Route::get('/item', 'Item\ItemsController@index');
Route::get('/item_block/{id}', 'Item\ItemsController@block');
Route::get('/item_reblock/{id}', 'Item\ItemsController@reblock');

Route::get('/itemCategory', 'Item\ItemsController@itemCategory');
Route::get('/category_create', 'Item\ItemsController@createCategory');
Route::get('/category_detail/{id}', 'Item\ItemsController@detailCategory');
Route::get('/category_edit/{id}', 'Item\ItemsController@editCategory');
Route::get('/category_delete/{id}', 'Item\ItemsController@deleteCategory');
Route::post('/category_insert', 'Item\ItemsController@categoryInsert');
Route::post('/category_update', 'Item\ItemsController@categoryUpdate');

Route::get('/advertising', 'Advertising\AdvertisingController@index');
Route::get('/ads_edit/{id}', 'Advertising\AdvertisingController@ads_edit');
Route::get('/ads_block/{id}', 'Advertising\AdvertisingController@ads_block');
Route::get('/ads_reblock/{id}', 'Advertising\AdvertisingController@ads_reblock');
Route::post('/ads_update', 'Advertising\AdvertisingController@ads_update');


Route::get('/page', 'Page\PagesController@index');
Route::get('/page_edit/{id}', 'Page\PagesController@page_edit');
Route::post('/page_update', 'Page\PagesController@page_update');

Route::get('/des_page_edit/{id}', 'Page\PagesController@des_page_edit');
Route::post('/des_page_update', 'Page\PagesController@des_page_update');


Route::get('/setting', 'Setting\SettingsController@index');
Route::get('/apps', 'MobileController@index');