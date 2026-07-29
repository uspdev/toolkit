<?php

use App\Http\Controllers\Api\CurrentUserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('uspdevApiKeys')->group(function (): void {
    // Retorna os dados do dono da chave, tanto por Bearer token quanto por
    // ?api_key= quando essa opção estiver habilitada na configuração.
    Route::get('/toolkit/user', CurrentUserController::class)
        ->name('toolkit.api.current-user');
});

// Route::get('{nameSpace}', [UspdevController::class, 'listarClasses']);
// Route::get('{nameSpace}/{classe}', [UspdevController::class, 'listarMetodos']);

// Route::match(['get', 'post'], 'Replicado/{classe}/{metodo}',[UspdevController::class, 'show']);
