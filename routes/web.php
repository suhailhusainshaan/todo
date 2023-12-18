<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [ToDoController::class, 'index'])->name('home');
Route::post('store', [ToDoController::class, 'store'])->name('store');
Route::get('show-all', [ToDoController::class, 'show'])->name('store');
Route::put('complete/{id}', [ToDoController::class, 'complete'])->name('complete');
Route::delete('delete/{id}', [ToDoController::class, 'destroy'])->name('delete');