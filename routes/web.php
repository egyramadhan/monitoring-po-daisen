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

Route::get('/', function () {
    return view('index');
});

Route::get('/monitoring', 'MonitoringController@index');
Route::get('/monitoring-po', 'MonitoringController@dashboard');

Route::get('/purchase_requests', 'PurchaseRequestController@get_material_request');
Route::get('/purchase_orders', 'PurchaseOrderController@get_purchase_order');
Route::get('/material_receipt', 'MaterialReceiveController@get_material_receipt');
Route::get('/item-price', 'ListPriceController@getDataPrice');
Route::get('/item-from-po', 'ListPriceController@getItemPricePO');
Route::get('/list-price', 'ListPriceController@index');
Route::get('list-prices', ['uses' => 'ListPriceController@index', 'as' => 'prices.index']);

// Route::resource('export', 'ExportController');


Route::get('/show/{id}', 'MonitoringController@show');
Route::get('/show_history/{item_code}', 'ListPriceController@show');
Route::get('autocomplete', array('as' => 'autocomplete', 'uses' => 'SearchController@autocomplete'));
Route::get('autocomplete_po', array('as' => 'autocomplete_po', 'uses' => 'SearchController@autocomplete_po'));
