<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Http\Controllers\PassportAuthController;

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

Route::post('register', PassportAuthController::class . '@register')->name('register');
Route::post('login', PassportAuthController::class . '@login')->name('login');


//protected routes
Route::middleware('auth:api')->group(function () {
    Route::post('logout', PassportAuthController::class . '@logout')->name('logout');
});