<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/admin/results', [AdminController::class, 'results'])->name('results');

Route::get('/admin/quizzes', [AdminController::class, 'quizzes'])->name('quizzes');
Route::get('/admin/add-quiz', [AdminController::class, 'addQuiz'])->name('add-quiz');
Route::post('/admin/add-quiz-post', [AdminController::class, 'addQuizPost'])->name('add-quiz-post');
Route::get('/admin/update-quiz/{id}', [AdminController::class, 'updateQuiz'])->name('update-quiz');
Route::post('/admin/update-quiz/{id}', [AdminController::class, 'updateQuizPost'])->name('update-quiz');
Route::get('/admin/delete-quiz/{id}', [AdminController::class, 'deleteQuiz'])->name('delete-quiz');

Route::get('/admin/quiz/{id}/questions', [AdminController::class, 'questions'])->name('questions');
Route::get('/admin/quiz/{id}/add-question', [AdminController::class, 'addQuestion'])->name('add-question');
Route::post('/admin/add-question-post', [AdminController::class, 'addQuestionPost'])->name('add-question-post');
Route::get('/admin/update-question/{id}', [AdminController::class, 'updateQuestion'])->name('update-question');
Route::post('/admin/update-question', [AdminController::class, 'updateQuestionPost'])->name('update-question-post');
Route::get('/admin/quiz/{quizId}/delete-question/{id}', [AdminController::class, 'deleteQuestion'])->name('delete-question');

Route::get('/admin/quiz/question/{id}/choice', [AdminController::class, 'choice'])->name('choice');
Route::post('/admin/choice-post', [AdminController::class, 'choicePost'])->name('choice-post');

Route::get('/admin/results', [AdminController::class, 'results'])->name('results');
Route::get('/admin/answers/{id}', [AdminController::class, 'results'])->name('answers');