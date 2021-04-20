<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\WsfotoController;
use Illuminate\Support\Facades\Route;

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

Route::get('login', [LoginController::class, 'redirectToProvider']);
Route::get('callback', [LoginController::class, 'handleProviderCallback']);
Route::post('logout', [LoginController::class, 'logout']);

Route::get('/', [MainController::class, 'index']);

Route::get('theme', function () {
    return view('theme');
});

Route::match(['get', 'post'], 'Wsfoto/obter', [WsfotoController::class, 'show']);

Route::get('library/{library}', [LibraryController::class, 'index']);
Route::get('library/{library}/{class}', [LibraryController::class, 'methods']);
Route::match(['get', 'post'], 'library/{library}/{class}/{method}', [LibraryController::class, 'show']);
