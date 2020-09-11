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

// Route::get('/show', function () {
//     return view('receipt');
// });

Route::get('/show/{id}', 'MonitoringController@show');
// Route::get('/receipt/tampil', 'MonitoringController@tampil');
// Route::get('/receipts/tampil/{$id}', 'MonitoringController@tampil');
