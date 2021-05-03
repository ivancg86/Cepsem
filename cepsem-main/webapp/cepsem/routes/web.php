<?php

use App\Http\Controllers\AfectatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecursController;
use App\Http\Controllers\UsuariController;
use SebastianBergmann\Environment\Console;
use App\Http\Controllers\AlertantController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\IncidenciaHasRecursController;
use App\Http\Controllers\TipusRecursController;
use App\Http\Controllers\TipusAlertantController;
use App\Http\Controllers\TipusIncidenciaController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/login', function () {
    return view('pages.login');
});


Route::get('/cecos/incidencia/{id}', function ($id) {
    return redirect()->action([App\Http\Controllers\IncidenciaController::class, 'show'], ['incidency' => $id]);
});

Route::get('/formacio', function(){
    return view('pages.formacio.index');
});

Route::get('/cecos/incidencia', [IncidenciaController::class, 'show']);


Route::get('/login', [UsuariController::class, 'showLogin'])->name('login');
Route::post('/login', [UsuariController::class, 'login'] );
Route::get('/logout', [UsuariController::class, 'logout']);

Route::middleware(['auth' ,'admin'])->group(function () {
    Route::resource('/cecos/tipus-recurs', TipusRecursController::class);
    Route::resource('/cecos/alertants', AlertantController::class);
    Route::resource('/cecos/incidencies', IncidenciaController::class);
    Route::resource('/cecos/usuaris', UsuariController::class);
    Route::resource('/cecos/afectats', AfectatController::class);
    Route::resource('/cecos/recursos-mobils', RecursController::class);
    Route::resource('/cecos/tipus-incidencia', TipusIncidenciaController::class);
    Route::resource('/cecos/tipus-alertant', TipusAlertantController::class);
    Route::resource('/cecos/recursMobil', IncidenciaHasRecursController::class);
    Route::get('/cecos', function () {
        return view('pages.cecos.index');
    });

});

Route::middleware(['auth' ,'cecos'])->group(function () {

    Route::resource('/cecos/incidencies', IncidenciaController::class);
    Route::get('/cecos', function () {
        return view('pages.cecos.index');
    });

});

Route::middleware(['auth' ,'recurs.mobil'])->group(function () {

    Route::resource('/cecos/recursMobil', IncidenciaHasRecursController::class);
    Route::resource('/cecos/incidencies', IncidenciaController::class);
    Route::get('/cecos', function () {
        return view('pages.cecos.index');
    });
});


Route::get('/clearcache', function() {

    $notice = '';

    $notice.= ' / APPLICATION';
    // Laravel Clear APPLICATION Cache On Shared Hosting
    $exitCode = Artisan::call('cache:clear');

    $notice.= ' / VIEW';
    // Laravel Clear VIEW Cache On Shared Hosting
    $exitCode = Artisan::call('view:clear');

    // $notice.= ' / ROUTE';
    // Laravel Clear ROUTE Cache On Shared Hosting
    // $exitCode = Artisan::call('route:cache');

    $notice.= ' / CONFIG';
    // Laravel Clear CONFIG Cache On Shared Hosting
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('config:cache');


    $notice.= ' cleared';

    return $notice;

});
