<?php

use App\Http\Controllers\LibraryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\WsfotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

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

// Esta rota permite utilizar php artisan route:cache sem dar problema na página principal.
// Porém adiciona um detalhe de recursividade
Route::get(parse_url(config('app.url'), PHP_URL_PATH), [MainController::class, 'index']);

Route::get('/', [MainController::class, 'index']);

Route::get('theme', [MainController::class, 'theme']);
Route::get('theme-skin-change', [MainController::class, 'themeSkinChange']);
Route::post('senha-de-app', [MainController::class, 'senhaDeApp']);

Route::match(['get', 'post'], 'Wsfoto/obter', [WsfotoController::class, 'show']);

Route::get('library/{library}', [LibraryController::class, 'index']);
Route::get('library/{library}/{class}', [LibraryController::class, 'methods']);
Route::match(['get', 'post'], 'library/{library}/{class}/{method}', [LibraryController::class, 'show']);

Route::get('permission', [MainController::Class, 'permission']);

Route::get('gates', function(){
    dd(Gate::abilities());
});
