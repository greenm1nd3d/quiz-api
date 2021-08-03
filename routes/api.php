<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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

Route::group(['prefix' => '/v1'], function () {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/user/details', [UserController::class, 'getUserDetails']);
    });

    Route::get('/', [UserController::class, 'index']);
    Route::post('/register', [UserController::class, 'createAccount']);

    Route::get('/products', [ProductController::class, 'list']);
    Route::post('/product', [ProductController::class, 'create']);
    Route::post('/product/update', [ProductController::class, 'update']);
    Route::post('/product/delete', [ProductController::class, 'delete']);

    Route::post('/login', [\Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken']);
});