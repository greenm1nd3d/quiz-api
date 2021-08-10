<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoiceController;
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

    Route::get('/quizzes', [QuizController::class, 'list']);
    Route::post('/quiz', [QuizController::class, 'create']);
    Route::post('/quiz/submit', [QuizController::class, 'submit']);
    Route::post('/quiz/{id}/update', [QuizController::class, 'update']);
    Route::get('/quiz/{id}/delete', [QuizController::class, 'delete']);

    Route::get('/quiz/{id}', [QuestionController::class, 'list']);
    Route::get('/question/{id}', [QuestionController::class, 'show']);
    Route::post('/question', [QuestionController::class, 'create']);
    Route::post('/question/{id}/update', [QuestionController::class, 'update']);
    Route::get('/question/{id}/delete', [QuestionController::class, 'delete']);

    Route::get('/choices', [ChoiceController::class, 'list']);
    Route::post('/choices', [ChoiceController::class, 'create']);
    Route::post('/choices/{id}/update', [ChoiceController::class, 'update']);

    Route::post('/login', [\Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken']);
});