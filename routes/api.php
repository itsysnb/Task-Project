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
    'as' => 'v1.',
], function (){
    // Authentication routes
    Route::post('register', [\App\Http\Controllers\Api\v1\Auth\SanctumController::class, 'register'])->name('auth.register');
    Route::post('login', [\App\Http\Controllers\Api\v1\Auth\SanctumController::class, 'login'])->name('auth.login');
});

Route::group([
    'middleware' => 'auth:sanctum',
    'namespace' => 'v1',
    'prefix' => 'v1',
    'as' => 'v1.',
], function (){
    // logout route
    Route::post('logout', [\App\Http\Controllers\Api\v1\Auth\SanctumController::class, 'logout'])->name('auth.logout');
    // task routes
    Route::get('tasks', [\App\Http\Controllers\Api\v1\Task\TaskController::class, 'index'])->name('task.index');
    Route::post('tasks', [\App\Http\Controllers\Api\v1\Task\TaskController::class, 'store'])->name('task.store');
    Route::patch('tasks/{task}', [\App\Http\Controllers\Api\v1\Task\TaskController::class, 'update'])->name('task.update');
    Route::delete('tasks/{task}', [\App\Http\Controllers\Api\v1\Task\TaskController::class, 'destroy'])->name('task.delete');
    Route::patch('tasks/{task}/toggle-completed', [\App\Http\Controllers\Api\v1\Task\TaskController::class, 'toggleCompleted'])->name('task.toggle.completed');
    Route::get('tasks/filter', [\App\Http\Controllers\Api\v1\Task\TaskController::class, 'filter'])->name('task.filter');
});
