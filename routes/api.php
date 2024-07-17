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
    'prefix' => 'auth'

], function ($router) {
    Route::group(['prefix' => 'accounts'], function () {

        Route::post('authenticate', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('balances', [AuthController::class, 'getBalance'])->name('balance');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('changepassword', [AuthController::class, 'changePassword'])->name('changePassword');
    });
    
    Route::get('categories', [CategoryController::class, 'categories'])->name('categories');
    Route::post('services/{serviceId}/inquiry',[    ServiceControoler::class, 'inquiry'])->name('inquiry');
    Route::post('services/{serviceId}/fees',[    ServiceControoler::class, 'fees'])->name('fees');
});