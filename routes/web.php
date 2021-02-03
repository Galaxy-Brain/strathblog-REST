<?php

use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/posts', function () {
    return Inertia::render('Posts');
})->name('posts');
Route::middleware(['auth:sanctum', 'verified'])->get('/users', function () {
    return Inertia::render('Users');
})->name('users');



// Other

Route::group(['prefix'=>'api/v2'], function(){
    Route::apiResource('posts', 'App\Http\Controllers\PostsController');
    Route::get('posts/my_posts','App\Http\Controllers\PostsController@myPosts');
    Route::get('users', function(){
        return User::with('posts')->get();
    });
});
