<?php

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
    return view('login');
});
Route::get('/solicitudes/contratacion', function () {
    return view('nuevo_contratacion');
});
Route::get('/solicitudes/sustitucion', function () {
    return view('nuevo_sustitucion');
});
Route::get('/solicitudes/promocion', function () {
    return view('nuevo_promocion');
});
Route::get('/solicitudes/cambio_adscripcion', function () {
    return view('nuevo_cambio_adscripcion');
});
Route::get('/listado/completo', function () {
    return view('listado_completo');
});
Route::get('/salir', function () {
    return view('login');
});
Route::get('/solicitud/contratacion/1', function () {
    return view('edicion_contratacion');
});
