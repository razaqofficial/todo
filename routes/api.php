<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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

Route::group(['prefix' => 'todos', 'as' => 'todo.'], function() {
    Route::get('', [TodoController::class, 'index'])->name('index');
    Route::get('/show/{todo}', [TodoController::class, 'show'])->name('show');
    Route::post('/create', [TodoController::class, 'create'])->name('create');
    Route::patch('/update/{todo}', [TodoController::class, 'update'])->name('update');
    Route::delete('/delete/{todo}', [TodoController::class, 'delete'])->name('delete');
});
