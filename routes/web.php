<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Route::get('home', function () {
    return view('home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'owner/','middleware'=> ['auth:web','owner']], function () {
    Route::get('/home','HomeController@ownerHome')->name('owner.home');

    //admin route
    Route::get('admin/', 'AdminController@IndexOwner')->name('owner.admin.index');
    Route::get('admin/create', 'AdminController@Create')->name('owner.admin.create');
    Route::get('admin/{id}/edit', 'AdminController@Edit')->name('owner.admin.edit');
    Route::post('admin/store', 'AdminController@Store')->name('owner.admin.store');
    Route::post('admin/{id}/update', 'AdminController@Update')->name('owner.admin.update');
    Route::get('admin/{id}/delete','AdminController@Destroy')->name('owner.admin.delete');

    //bikehistories route
    Route::get('bikehistories/', 'BikehistoryController@IndexOwner')->name('owner.bikehistories.index');
    Route::get('bikehistories/export', 'BikehistoryController@exportBikeHistories')->name('owner.bikehistories.export');
    
    //carpethistories route
    Route::get('carpethistories/', 'CarpethistoryController@IndexOwner')->name('owner.carpethistories.index');
    Route::get('carpethistories/export', 'CarpethistoryController@exportCarpetHistories')->name('owner.carpethistories.export');
});

Route::group(['prefix' => 'admin/'], function () {
    Route::get('/home', 'HomeController@index')->name('admin.home');

    //workerlist route
    Route::get('worker/', 'WorkerController@Index')->name('worker.index');
    Route::get('worker/create', 'WorkerController@Create')->name('worker.create');
    Route::get('worker/{id}/edit', 'WorkerController@Edit')->name('worker.edit');
    Route::post('worker/store', 'WorkerController@Store')->name('worker.store');
    Route::post('worker/{id}/update', 'WorkerController@Update')->name('worker.update');
    Route::get('worker/{id}/delete','WorkerController@Destroy')->name('worker.delete');
    
    //adminlist route
    Route::get('admin/', 'AdminController@Index')->name('admin.index');

    //customer route
    Route::get('customer/', 'CustomerController@Index')->name('customer.index');
    Route::get('customer/create', 'CustomerController@Create')->name('customer.create');
    Route::get('customer/{id}/edit', 'CustomerController@Edit')->name('customer.edit');
    Route::post('customer/store', 'CustomerController@Store')->name('customer.store');
    Route::post('customer/{id}/update', 'CustomerController@Update')->name('customer.update');
    Route::get('customer/{id}/delete','CustomerController@Destroy')->name('customer.delete');
    Route::post('customer/find/','CustomerController@findByNameToIndex')->name('customer.findIndex');
    Route::get('customer/{id}/addmoney','CustomerController@addMoneyShow')->name('customer.addMoney');
    Route::post('customer/{id}/addmoney/update','CustomerController@addMoneyUpdate')->name('customer.addMoneyUpdate');

    //discount route
    Route::get('discount/', 'DiscountController@Index')->name('discount.index');
    Route::get('discount/create', 'DiscountController@Create')->name('discount.create');
    Route::get('discount/{id}/edit', 'DiscountController@Edit')->name('discount.edit');
    Route::post('discount/store', 'DiscountController@Store')->name('discount.store');
    Route::post('discount/{id}/update', 'DiscountController@Update')->name('discount.update');
    Route::get('discount/{id}/delete','DiscountController@Destroy')->name('discount.delete');

    //bike route
    Route::get('bike/', 'BikeController@Index')->name('bike.index');
    Route::get('bike/create', 'BikeController@Create')->name('bike.create');
    Route::get('bike/{id}/edit', 'BikeController@Edit')->name('bike.edit');
    Route::post('bike/store', 'BikeController@Store')->name('bike.store');
    Route::post('bike/{id}/update', 'BikeController@Update')->name('bike.update');
    Route::get('bike/{id}/delete','BikeController@Destroy')->name('bike.delete');
    Route::post('bike/findBike/','BikeController@findByPlate')->name('bike.findPlate');

    //carpet route
    Route::get('carpet/', 'CarpetController@Index')->name('carpet.index');
    Route::get('carpet/create', 'CarpetController@Create')->name('carpet.create');
    Route::get('carpet/{id}/edit', 'CarpetController@Edit')->name('carpet.edit');
    Route::post('carpet/store', 'CarpetController@Store')->name('carpet.store');
    Route::post('carpet/{id}/update', 'CarpetController@Update')->name('carpet.update');
    Route::get('carpet/{id}/delete','CarpetController@Destroy')->name('carpet.delete');
    Route::post('carpet/findcarpet/','CarpetController@findByColor')->name('carpet.findColor');

    //washtype route
    Route::get('washtype/', 'WashtypeController@Index')->name('washtype.index');
    Route::get('washtype/create', 'WashtypeController@Create')->name('washtype.create');
    Route::get('washtype/{id}/edit', 'WashtypeController@Edit')->name('washtype.edit');
    Route::post('washtype/store', 'WashtypeController@Store')->name('washtype.store');
    Route::post('washtype/{id}/update', 'WashtypeController@Update')->name('washtype.update');
    Route::get('washtype/{id}/delete','WashtypeController@Destroy')->name('washtype.delete');
    Route::post('washtype/findCustomer/','WashtypeController@findByWashtype')->name('washtype.findWashtype');

    //bikequeue route
    Route::get('bikequeue/', 'BikequeueController@Index')->name('bikequeue.index');
    Route::get('bikequeue/create', 'BikequeueController@Create')->name('bikequeue.create');
    Route::post('bikequeue/store', 'BikequeueController@Store')->name('bikequeue.store');
    Route::get('bikequeue/{id}/edit', 'BikequeueController@Edit')->name('bikequeue.edit');
    Route::post('bikequeue/{id}/update', 'BikequeueController@Update')->name('bikequeue.update');
    Route::get('bikequeue/{id}/delete','BikequeueController@Destroy')->name('bikequeue.delete');

    //bikebooking route
    Route::get('bikebooking/', 'BikebookingController@Index')->name('bikebooking.index');
    Route::get('bikebooking/create', 'BikebookingController@Create')->name('bikebooking.create');
    Route::post('bikebooking/store', 'BikebookingController@Store')->name('bikebooking.store');
    Route::get('bikebooking/{id}/edit', 'BikebookingController@Edit')->name('bikebooking.edit');
    Route::post('bikebooking/{id}/update', 'BikebookingController@Update')->name('bikebooking.update');
    Route::get('bikebooking/{id}/delete','BikebookingController@Destroy')->name('bikebooking.delete');

    //carpetqueue route
    Route::get('carpetqueue/', 'CarpetqueueController@Index')->name('carpetqueue.index');
    Route::get('carpetqueue/create', 'CarpetqueueController@Create')->name('carpetqueue.create');
    Route::post('carpetqueue/store', 'CarpetqueueController@Store')->name('carpetqueue.store');
    Route::get('carpetqueue/{id}/edit', 'CarpetqueueController@Edit')->name('carpetqueue.edit');
    Route::post('carpetqueue/{id}/update', 'CarpetqueueController@Update')->name('carpetqueue.update');
    Route::get('carpetqueue/{id}/delete','CarpetqueueController@Destroy')->name('carpetqueue.delete');

    //carpetbooking route
    Route::get('carpetbooking/', 'CarpetbookingController@Index')->name('carpetbooking.index');
    Route::get('carpetbooking/create', 'CarpetbookingController@Create')->name('carpetbooking.create');
    Route::post('carpetbooking/store', 'CarpetbookingController@Store')->name('carpetbooking.store');
    Route::get('carpetbooking/{id}/edit', 'CarpetbookingController@Edit')->name('carpetbooking.edit');
    Route::post('carpetbooking/{id}/update', 'CarpetbookingController@Update')->name('carpetbooking.update');
    Route::get('carpetbooking/{id}/delete', 'CarpetbookingController@Destroy')->name('carpetbooking.delete');

    //pay route
    Route::get('pay/', 'PayController@displaySearch')->name('paying.searchform');
    Route::post('pay/find/', 'PayController@searchQueue')->name('paying.search');
    Route::post('pay/find/bike/{id}', 'PayController@bikePayingProcess')->name('paying.bikepay');
    Route::post('pay/find/carpet/{id}', 'PayController@carpetPayingProcess')->name('paying.carpetpay');

    //bikehistories route
    Route::get('bikehistories/', 'BikehistoryController@Index')->name('bikehistories.index');
    Route::post('bikehistories/findbyworker/','BikehistoryController@findByWorker')->name('bikehistories.findbyworker');
    
    //bikereport route
    Route::get('bikereport/daily', 'BikereportController@dailyIndex')->name('bikereport.dailyindex');
    Route::post('bikereport/daily/findbydate', 'BikereportController@dailyIndexByDate')->name('bikereport.dailyindexbydate');
    Route::get('bikereport/monthly', 'BikereportController@monthlyIndex')->name('bikereport.monthlyindex');
    Route::post('bikereport/monthly/findbymonth', 'BikereportController@monthlyIndexByDate')->name('bikereport.monthlyindexbydate');
    Route::get('bikereport/yearly', 'BikereportController@yearlyIndex')->name('bikereport.yearlyindex');
    Route::post('bikereport/yearly/findbyyear', 'BikereportController@yearlyIndexByDate')->name('bikereport.yearlyindexbydate');

    //bikereport route
    Route::get('carpetreport/daily', 'CarpetreportController@dailyIndex')->name('carpetreport.dailyindex');
    Route::post('carpetreport/daily/findbydate', 'CarpetreportController@dailyIndexByDate')->name('carpetreport.dailyindexbydate');
    Route::get('carpetreport/monthly', 'CarpetreportController@monthlyIndex')->name('carpetreport.monthlyindex');
    Route::post('carpetreport/monthly/findbymonth', 'CarpetreportController@monthlyIndexByDate')->name('carpetreport.monthlyindexbydate');
    Route::get('carpetreport/yearly', 'CarpetreportController@yearlyIndex')->name('carpetreport.yearlyindex');
    Route::post('carpetreport/yearly/findbyyear', 'CarpetreportController@yearlyIndexByDate')->name('carpetreport.yearlyindexbydate');

    //carpethistories route
    Route::get('carpethistories/', 'CarpethistoryController@Index')->name('carpethistories.index');
    Route::post('carpethistories/findbyworker/','CarpethistoryController@findByWorker')->name('carpethistories.findbyworker');
});
