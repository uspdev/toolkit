<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ReplicadoController;
use App\Http\Controllers\WsfotoController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LibraryController;

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

Route::get('/', [MainController::class, 'index']);

Route::get('theme', function () {
    return view('theme');
});

Route::match(['get', 'post'], 'Wsfoto/obter',[WsfotoController::class, 'show']);

//Route::get('{nameSpace}', [ClasseController::class, 'listarClasses']);
Route::get('Replicado', [ReplicadoController::class, 'listarClasses']);
Route::get('Replicado/{classe}', [ReplicadoController::class, 'listarMetodos']);
Route::match(['get', 'post'], 'Replicado/{classe}/{metodo}',[ReplicadoController::class, 'show']);

Route::get('library/{library}', [LibraryController::class, 'index']);