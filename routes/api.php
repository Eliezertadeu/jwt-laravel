<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use Illuminate\Support\Facades\Hash;

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

Route::prefix('v1')->group(function () {
    Route::group(['middleware' => 'jwt'], function () {
        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@index');
        });
        Route::prefix('employees')->group(function () {
            Route::post('/', 'EmployeesController@insertOne');
            Route::get('/', 'EmployeesController@showAll');
            Route::get('/{id}', 'EmployeesController@showOne');
        });

        Route::prefix('positions')->group(function () {
            Route::post('/', 'PositionsController@insertOne');
            Route::get('/', 'PositionsController@showAll');
        });
        Route::post('/me', 'AuthController@me');
        Route::post('/logout', 'AuthController@logout');
        Route::post('/refresh', 'AuthController@refresh');
    });

    Route::prefix('auth')->group(function () {
        Route::post('/login', 'AuthController@login');
    });
});
