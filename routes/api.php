<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Customers API
Route::get('/customers', 'API\APICustomerController@index');
Route::post('/customers/login', 'API\APICustomerController@loginCustomer');
Route::get('/customers/find/{id}', 'API\APICustomerController@show');
Route::post('/customers/register','API\APICustomerController@register');
Route::put('/customers/update/{customers}','API\APICustomerController@update');
Route::delete('/customers/delete/{customers}','API\APICustomerController@destroy');

// Workers API
Route::get('/workers', 'API\APIWorkerController@index');
Route::post('/workers/login', 'API\APIWorkerController@loginWorker');
Route::get('/workers/find/{id}', 'API\APIWorkerController@show');
Route::post('/workers/register','API\APIWorkerController@register');
Route::put('/workers/update/{workers}','API\APIWorkerController@update');
Route::delete('/workers/delete/{workers}','API\APIWorkerController@destroy');

// Carpet API
Route::get('/carpets', 'API\APICarpetController@index');
Route::get('/carpets/find/{id}', 'API\APICarpetController@show');
Route::get('/carpets/findbycustomer/{id}', 'API\APICarpetController@searchCarpetCustomer');
Route::post('/carpets/create','API\APICarpetController@store');
Route::put('/carpets/update/{id}','API\APICarpetController@update');
Route::delete('/carpets/delete/{id}','API\APICarpetController@destroy');

// Bikes API
Route::get('/bikes', 'API\APIBikeController@index');
Route::get('/bikes/find/{id}', 'API\APIBikeController@show');
Route::get('/bikes/findbycustomer/{id}', 'API\APIBikeController@searchBikeCustomer');
Route::post('/bikes/create','API\APIBikeController@store');
Route::put('/bikes/update/{id}','API\APIBikeController@update');
Route::delete('/bikes/delete/{id}','API\APIBikeController@destroy');

// Discounts API
Route::get('/discounts', 'API\APIDiscountController@index');
Route::get('/discounts/find/{id}', 'API\APIDiscountController@show');

// Washtype API
Route::get('/washtypes', 'API\APIWashtypeController@index');
Route::get('/washtypes/find/{id}', 'API\APIWashtypeController@show');

// Carpet Queue API
Route::get('/carpetqueues', 'API\APICarpetqueueController@index');
Route::get('/carpetqueues/find/{id}', 'API\APICarpetqueueController@show');
Route::post('/carpetqueues/create','API\APICarpetqueueController@store');
Route::delete('/carpetqueues/delete/{id}','API\APICarpetqueueController@destroy');

// Bike Booking API
Route::get('/carpetbooking', 'API\APICarpetbookingController@index');
Route::get('/carpetbooking/find/{id}', 'API\APICarpetbookingController@show');
Route::get('/carpetbooking/findbycustomer/{id}','API\APICarpetbookingController@showByUser');
Route::delete('/carpetbooking/delete/{id}','API\APICarpetbookingController@destroy');

// Bike Queue API
Route::get('/bikequeues', 'API\APIBikequeueController@index');
Route::get('/bikequeues/find/{id}', 'API\APIBikequeueController@show');
Route::post('/bikequeues/create','API\APIBikequeueController@store');
Route::delete('/bikequeues/delete/{id}','API\APIBikequeueController@destroy');

// Bike Booking API
Route::get('/bikebooking', 'API\APIBikebookingController@index');
Route::get('/bikebooking/find/{id}', 'API\APIBikebookingController@show');
Route::get('/bikebooking/findbycustomer/{id}','API\APIBikebookingController@showByUser');
Route::delete('/bikebooking/delete/{id}','API\APIBikebookingController@destroy');

// Bike Histories API
Route::get('/bikehistories', 'API\APIBikehistoriesController@index');
Route::get('/bikehistories/findbycustomer/{id}', 'API\APIBikehistoriesController@showByCustomer');
Route::get('/bikehistories/findbyworker/{id}', 'API\APIBikehistoriesController@showByWorker');
Route::get('/bikehistories/findbyworker/{id}/count', 'API\APIBikehistoriesController@countByWorker');
Route::put('/bikehistories/updaterating/{id}','API\APIBikehistoriesController@updateRating');

// carpet Histories API
Route::get('/carpethistories', 'API\APICarpethistoriesController@index');
Route::get('/carpethistories/findbycustomer/{id}', 'API\APICarpethistoriesController@showByCustomer');
Route::get('/carpethistories/findbyworker/{id}', 'API\APICarpethistoriesController@showByWorker');
Route::get('/carpethistories/findbyworker/{id}/count', 'API\APICarpethistoriesController@countByWorker');
Route::put('/carpethistories/updaterating/{id}','API\APICarpethistoriesController@updateRating');
