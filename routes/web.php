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
    return view('welcome');
});


Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();

// Only logged in users can access the below routes
Route::group(['middleware'=>'auth'], function(){

    Route::get('/home', 'HomeController@index');

    Route::get('/users/api', function(){
        return view('users.token');
    })->name('users.api');

    //except exempts specified route from the middleware restriction
    Route::resource('qrcodes', 'QrcodeController')->except(['show']);

    Route::resource('accounts', 'AccountController')->except(['show']);

    //Create a route for show Account that makes ID optional
    Route::get('/accounts/show/{id?}', 'AccountController@show')->name('accounts.show');

    Route::resource('accountHistories', 'AccountHistoryController');

    Route::post('/accounts/apply_for_payout', 'AccountController@apply_for_payout')->name('accounts.apply_for_payout');

    Route::post('/accounts/confirm_transfer', 'AccountController@confirm_transfer')
    ->name('accounts.confirm_transfer')
    ->middleware('checkmoderator');

    Route::get('/accounts/create', 'AccountController@create')
    ->name('accounts.create')
    ->middleware('checkadmin');

    Route::get('accountHistories', 'AccountHistoryController@index')
    ->name('accountHistories.index')
    ->middleware('checkmoderator');

    Route::get('accountHistories/create', 'AccountHistoryController@create')
    ->name('accountHistories.create')
    ->middleware('checkadmin');

    //Only admins can access this route
    Route::resource('roles', 'RoleController')->middleware('checkadmin');

    Route::resource('transactions', 'TransactionController');

    Route::resource('users', 'UserController');

    
    //Implements CheckModerator Middleware
    Route::group(['middleware'=>'checkmoderator'], function(){
        Route::get('/users', 'UserController@index')->name('users.index');
        Route::get('/accounts', 'AccountController@index')->name('accounts.index');
    });
});

// Create route to show QRCode so that even while not logged in you can pay for the QRCode

Route::get('qrcodes/{id}', 'QrcodeController@show')->name('qrcodes.show');

// Laravel 5.1.17 and above
Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay'); 

Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');

//Route to send unlogged in user email to the paystack payment form to track the buyer details
Route::post('/qrcodes/show_payment_page', 'QrcodeController@show_payment_page')->name('qrcodes.show_payment_page');