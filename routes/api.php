<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//user
Route::post('login','App\Http\Controllers\API\AuthController@login');
Route::post('register','App\Http\Controllers\API\AuthController@register');
Route::post('logout','App\Http\Controllers\API\AuthController@logout')->middleware('auth:sanctum');
Route::post('save_user_info','App\Http\Controllers\API\AuthController@saveUserInfo')->middleware('auth:sanctum');

//post
Route::apiResource('posts', 'App\Http\Controllers\PostsController');
Route::get('/my_posts','App\Http\Controllers\API\AuthController@myPosts')->middleware('auth:sanctum');


//comment
Route::post('comments/create','App\Http\Controllers\API\CommentsController@store')->middleware('auth:sanctum');
Route::post('comments/delete','App\Http\Controllers\API\CommentsController@destroy')->middleware('auth:sanctum');
Route::post('comments/update','App\Http\Controllers\API\CommentsController@update')->middleware('auth:sanctum');
Route::post('posts/comments','App\Http\Controllers\API\CommentsController@comments')->middleware('auth:sanctum');


//like
Route::post('posts/like','App\Http\Controllers\API\LikesController@like')->middleware('auth:sanctum');
