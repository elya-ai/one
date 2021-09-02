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

Route::post('register', 'App\Http\Controllers\HumanController@register');
Route::get('get', 'App\Http\Controllers\HumanController@get');
Route::post('auth', 'App\Http\Controllers\HumanController@auth');
Route::post('check', 'App\Http\Controllers\HumanController@check')->middleware("midAuth");
Route::post('reset', 'App\Http\Controllers\HumanController@ResetPassword');
