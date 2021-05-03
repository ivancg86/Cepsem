<?php

use App\Http\Controllers\API\AfectatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UsuariController;
use App\Http\Controllers\API\AlertantController;
use App\Http\Controllers\API\IncidenciaController;
use App\Http\Controllers\API\IncidenciaHasRecursController;
use App\Http\Controllers\API\RecursController;

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

Route::apiResource('alertants', AlertantController::class);
Route::apiResource('incidencies', IncidenciaController::class);
Route::apiResource('usuaris', UsuariController::class);
Route::apiResource('recursos',RecursController::class);
Route::apiResource('afectats',AfectatController::class);
Route::apiResource('recursMobil',IncidenciaHasRecursController::class);

Route::get('alertant/{tlf}', [AlertantController::class, 'getAlertantbyTelefon']);


Route::get('recursos/notactiu/{tipus_recurs_id}', [RecursController::class, 'getAvailableRecurs']);
Route::get('recursos/{id}/actiu/{availability}', [RecursController::class, 'setRecursAvailability']);
