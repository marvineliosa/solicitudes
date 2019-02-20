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
//listados
/*Route::get('/listado/completo', function () {
    return view('listado_completo');
});//*/
Route::get('/listado/completo', 'SolicitudesController@VistaListadoCompleto');

Route::get('/listado/en_proceso', 'SolicitudesController@VistaListadoEnProceso');

//listado revision informacion
Route::get('/listado/revision_informacion', 'SolicitudesController@VistaListadoRevisionInformacion');

//listado nuevas en SPR
Route::get('/listado/nuevas', 'SolicitudesController@VistaNuevasSPR');

//listado nuevas en SPR
Route::get('/listado/por_revisar', 'SolicitudesController@VistaPorRevisarSPR');
Route::get('/listado/revisadas', 'SolicitudesController@VistaRevisadasSPR');

//listado nuevas en SPR
Route::get('/listado/dependencia', 'SolicitudesController@VistaListadoDependencia');

//listado CGA
Route::get('/listado/coordinacion', 'SolicitudesController@VistaListadoCGA');

Route::get('/listado/contratacion_sustitucion', function () {
    return view('listado_contratacion_sustitucion');
});
Route::get('/listado/contratacion', function () {
    return view('listado_contratacion');
});
Route::get('/listado/promocion', function () {
    return view('listado_promocion');
});
Route::get('/listado/cambio_adscripcion', function () {
    return view('listado_cambio_adscripcion');
});
Route::get('/salir', function () {
    return view('login');
});
/*Route::get('/solicitud/contratacion/{id_solicitud}', function () {
    return view('edicion_contratacion');
});//*/
Route::get('/solicitud/contratacion/{id_solicitud}', 'SolicitudesController@AbrirContratacion');

//solicitudes en revision de informaicon
Route::post('/revision_informacion/actualiza_estado', 'SolicitudesController@MarcarInformacionCorrecta');

//solicitudes nuevas en CGA
Route::post('/nuevas/turnar_cga', 'SolicitudesController@TurnarSolicitudCGA');


//contrataciones
Route::post('/contratacion/insertar', 'SolicitudesController@AlmacenarContratacion');
Route::post('/contratacion/guardar_datos_cga', 'SolicitudesController@GuardaDatosCGA');

//Contrataciones por sustitucion
Route::post('/contratacion_sustitucion/insertar', 'SolicitudesController@AlmacenarContratacionSustitucion');

//promociones
Route::post('/promocion/insertar', 'SolicitudesController@AlmacenarPromocion');

//cambio de adscripcion
Route::post('/cambio_adscripcion/insertar', 'SolicitudesController@AlmacenarCambioAdscripcion');

//solicitudes
Route::post('/solicitud/cambiar_estado', 'SolicitudesController@CambiarEstadoCGA');
Route::post('/solicitud/validar_solicitud', 'SolicitudesController@ValidarSolicitudSPR');

Route::post('/solicitud/validacion_titular', 'SolicitudesController@ValidarSolicitudDependencia');

Route::post('/solicitud/validacion_cga', 'SolicitudesController@ValidarSolicitudCGA');


//CUADROS
//Route::get('/cuadro/{id_solicitud}', 'SolicitudesController@VerCuadroElaborado');
Route::get('/cuadro/{id_solicitud}', 'SolicitudesController@VerCuadroElaborado');
Route::get('/cuadro/contratacion/{id_solicitud}', 'SolicitudesController@PDFContratacion');


Route::post('/login/validar', 'LoginController@ValidarUsuario');
Route::post('/salir', 'LoginController@cerrarSesion');