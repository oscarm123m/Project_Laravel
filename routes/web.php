<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\LoginController;

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
Route::get('mensaje', [EmpleadosController::class,'mensaje']);
Route::get('controlpago', [EmpleadosController::class,'pago']);
Route::get('nomina/{diast}/{pago}', [EmpleadosController::class,'nomina']);

Route::get('muestrasaludo/{nombre}/{dias}', [EmpleadosController::class,'saludo']);
Route::get('salir', [EmpleadosController::class,'salir'])->name('salir');
Route::get('formularioempleado', [EmpleadosController::class,'formularioempleado'])->name('formularioempleado');
Route::post('guardarempleado', [EmpleadosController::class,'guardarempleado'])->name('guardarempleado');

Route::get('eloquent', [EmpleadosController::class,'eloquent'])->name('eloquent');
Route::get('reporteempleados', [EmpleadosController::class,'reporteempleados'])->name('reporteempleados');

Route::get('desactivarempleados/{ide}', [EmpleadosController::class,'desactivarempleados'])->name('desactivarempleados');
Route::get('activarempleados/{ide}', [EmpleadosController::class,'activarempleados'])->name('activarempleados');
Route::get('borrarempleados/{ide}', [EmpleadosController::class,'borrarempleados'])->name('borrarempleados');
Route::get('actualizarempleado/{ide}', [EmpleadosController::class,'actualizarempleado'])->name('actualizarempleado');

Route::post('guardarcambio', [EmpleadosController::class,'guardarcambio'])->name('guardarcambio');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ruta1', function () {
    return "hola mundo";
});
Route::get('/redireccionamiento', function () {
    return redirect ('ruta1');
});

Route::get('login', [LoginController::class,'login'])->name('login');
Route::post('validar', [LoginController::class,'validar'])->name('validar');
Route::get('principal', [LoginController::class,'principal'])->name('principal');
Route::get('cerrarsession', [LoginController::class,'cerrarsession'])->name('cerrarsession');