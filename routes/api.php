<?php

use App\Http\Controllers\ComercioController;
use App\Http\Controllers\VentaController;
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

Route::post('ventas', VentaController::class.'@create')->name('ventas.create');
Route::get('ventas/{id}', VentaController::class.'@show')->name('ventas.show');
Route::post('ventas/delete/{id}', VentaController::class.'@destroy')->name('ventas.destroy');

Route::get('comercio', ComercioController::class.'@index')->name('comercio.index');
Route::get('comercio/{rut}', ComercioController::class.'@show')->name('comercio.show');