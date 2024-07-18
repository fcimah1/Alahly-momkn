<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceControoler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([

    'middleware' => 'api',
    'prefix' => 'gateway/api/v2/'

], function ($router) {
    Route::group(['prefix' => 'accounts/1/'], function () {
        Route::post('authenticate', [AuthController::class, 'login'])->name('login');
        Route::get('balances', [AuthController::class, 'getBalance'])->name('balance');
        Route::post('changepassword', [AuthController::class, 'changePassword'])->name('changePassword');
    });
    
    Route::get('categories/0', [CategoryController::class, 'showCategories'])->name('categories');
    Route::post('services/{serviceId}/inquiry',[    ServiceControoler::class, 'inquiry'])->name('inquiry');
    Route::post('services/{serviceId}/fees',[    ServiceControoler::class, 'fees'])->name('fees');
});