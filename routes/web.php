<?php

use App\Http\Controllers\PessoaController;
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

Route::get('/', function () {
    return view('index');
});

Route::get('theme', function () {
    return view('theme');
});

Route::get('Pessoa', [PessoaController::class, 'list']);

// No final
Route::match(['get', 'post'], '{classe}/{metodo}',[PessoaController::class, 'show']);

