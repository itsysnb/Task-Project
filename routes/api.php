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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'namespace' => 'v1',
    'prefix' => 'v1',
    'as' => 'v1',
], function (){
    // Authentication routes
    Route::post('register', [\App\Http\Controllers\Api\v1\Auth\SanctumController::class, 'register'])->name('auth.register');
    Route::post('login', [\App\Http\Controllers\Api\v1\Auth\SanctumController::class, 'login'])->name('auth.login');
});
