<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
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
Route::get('/', [PostsController::class, 'index'])->name('top'); //Route::get('/user'_userがあるとnotfoundになる
Route::resource('comments', CommentsController::class)->only(['store', 'update', 'destroy']);
Route::resource('posts', PostsController::class)->only(['create', 'store', 'show', 'edit', 'update', 'destroy']);