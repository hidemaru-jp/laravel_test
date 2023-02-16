<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController; 
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MailSendController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::resource('items', ItemsController::class); 

    Route::resource('users', UsersController::class, [
        'only' => ['show', 'update', 'edit']
    ]);  

    Route::get('cart/complete',[CartController::class,'complete']);
    Route::get('cart/confirm',[CartController::class,'confirm']);
    Route::resource('cart',CartController::class);
    Route::get('/mail', [CartController::class, 'send']);
    Route::post('/payment', [App\Http\Controllers\CartController::class, 'payment'])->name('payment');
});

