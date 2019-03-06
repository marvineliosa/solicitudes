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

//SOLICITUDES DE CONTRATACION - ACCESO VALIDADO
Route::get('/solicitudes/contratacion', 'SolicitudesController@VistaCrearContratacion');
Route::get('/solicitudes/sustitucion', 'SolicitudesController@VistaCrearSustitucion');
Route::get('/solicitudes/promocion', 'SolicitudesController@VistaCrearPromocion');
Route::get('/solicitudes/cambio_adscripcion', 'SolicitudesController@VistaCrearCambioAdscripcion');

//LISTADOS
Route::get('/listado/completo', 'SolicitudesController@VistaListadoCompleto');//VALIDADO
Route::get('/listado/en_proceso', 'SolicitudesController@VistaListadoEnProceso');//VALIDADO

//listado revision informacion
Route::get('/listado/revision_informacion', 'SolicitudesController@VistaListadoRevisionInformacion');//VALIDADO

//listado nuevas en SPR
Route::get('/listado/nuevas', 'SolicitudesController@VistaNuevasSPR');

//listado nuevas en SPR
Route::get('/listado/por_revisar', 'SolicitudesController@VistaPorRevisarSPR');
Route::get('/listado/revisadas', 'SolicitudesController@VistaRevisadasSPR');

//listado nuevas en dependencia
Route::get('/listado/dependencia', 'SolicitudesController@VistaListadoDependencia');

//listado nuevas en dependencia
Route::get('/listado/spr', 'SolicitudesController@VistaListadoSecretarioParticular');

//listado analista
Route::get('/listado/analista', 'SolicitudesController@VistaListadoAnalista');

//listado CGA
Route::get('/listado/coordinacion', 'SolicitudesController@VistaListadoCGA');
//Listado por estatus
/*Route::get('/listado/recibido', 'SolicitudesController@VistaRecibidos');
Route::get('/listado/levantamiento', 'SolicitudesController@VistaLevantamiento');
Route::get('/listado/analisis', 'SolicitudesController@VistaAnalisis');
Route::get('/listado/revision', 'SolicitudesController@VistaRevision');
Route::get('/listado/firmas', 'SolicitudesController@VistaAnalisis');
Route::get('/listado/turnado_spr', 'SolicitudesController@VistaAnalisis');
Route::get('/listado/completado_rector', 'SolicitudesController@VistaAnalisis');//*/
Route::get('/listado/estatus/{estatus}', 'SolicitudesController@VistaGeneralEstatus');

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
//vistas de edicion de informacion para llenar cuadros
Route::get('/solicitud/contratacion/{id_solicitud}', 'SolicitudesController@AbrirContratacion');

Route::get('/solicitud/contratacion_sustitucion/{id_solicitud}', 'SolicitudesController@AbrirContratacionSustitucion');

Route::get('/solicitud/promocion/{id_solicitud}', 'SolicitudesController@AbrirPromocion');

Route::get('/solicitud/cambio_adscripcion/{id_solicitud}', 'SolicitudesController@AbrirCambioAdscripcion');

//solicitudes en revision de informaicon
Route::post('/revision_informacion/actualiza_estado', 'SolicitudesController@MarcarInformacionCorrecta');

//solicitudes nuevas en CGA
Route::post('/nuevas/turnar_cga', 'SolicitudesController@TurnarSolicitudCGA');


//contrataciones
Route::post('/contratacion/insertar', 'SolicitudesController@AlmacenarContratacion');
Route::post('/contratacion/guardar_datos_contratacion', 'SolicitudesController@GuardaDatosContratacion');

//Contrataciones por sustitucion
Route::post('/contratacion_sustitucion/insertar', 'SolicitudesController@AlmacenarContratacionSustitucion');
Route::post('/contratacion_sustitucion/guardar_datos_sustitucion', 'SolicitudesController@GuardaDatosSustitucion');

//promociones
Route::post('/promocion/insertar', 'SolicitudesController@AlmacenarPromocion');
Route::post('/promocion/guardar_datos_promocion', 'SolicitudesController@GuardaDatosPromocion');

//cambio de adscripcion
Route::post('/cambio_adscripcion/insertar', 'SolicitudesController@AlmacenarCambioAdscripcion');
Route::post('/cambio_adscripcion/guardar_datos_cambio_adscripcion', 'SolicitudesController@GuardaDatosCambioAdscripcion');

//solicitudes
Route::post('/solicitud/cambiar_estado', 'SolicitudesController@CambiarEstadoCGA');
Route::post('/solicitud/validar_solicitud', 'SolicitudesController@ValidarSolicitudSPR');
Route::post('/solicitud/validacion_titular', 'SolicitudesController@ValidarSolicitudDependencia');
Route::post('/solicitud/validacion_cga', 'SolicitudesController@ValidarSolicitudCGA');
Route::post('/solicitud/validacion_rectoria', 'SolicitudesController@ValidacionRectoria');
Route::post('/solicitudes/cambiar_prioridad', 'SolicitudesController@CambiarPrioridad');
Route::post('/solicitud/asignar_analista', 'SolicitudesController@AsignarAnalista');

//obtencion de datos para los modales de informacion
Route::post('/solicitud/obtener_datos_contratacion', 'SolicitudesController@ObtenerContratacion');
Route::post('/solicitud/obtener_datos_sustitucion', 'SolicitudesController@ObtenerSustitucion');
Route::post('/solicitud/obtener_datos_promocion', 'SolicitudesController@ObtenerPromocion');
Route::post('/solicitud/obtener_datos_cambio_adscripcion', 'SolicitudesController@ObtenerCambioAdscripcion');


//CUADROS
//Route::get('/cuadro/{id_solicitud}', 'SolicitudesController@VerCuadroElaborado');
Route::get('/cuadro/{id_solicitud}', 'SolicitudesController@VerCuadroElaborado');
Route::get('/cuadro/contratacion/{id_solicitud}', 'SolicitudesController@PDFContratacion');
Route::get('/cuadro/contratacion_sustitucion/{id_solicitud}', 'SolicitudesController@PDFSustitucion');
Route::get('/cuadro/promocion/{id_solicitud}', 'SolicitudesController@PDFPromocion');
Route::get('/cuadro/cambio_adscripcion/{id_solicitud}', 'SolicitudesController@PDFCambioAdscripcion');



Route::post('/login/validar', 'LoginController@ValidarUsuario');
Route::post('/salir', 'LoginController@cerrarSesion');

//Route::get('/dependencias','DependenciasController@VistaDependencias');
Route::post('/dependencias/editar','DependenciasController@EditarDependencia');
Route::post('/dependencias/trae_dependencia','DependenciasController@TraerDatosDependencia');
Route::post('/dependencias/obtener_nombre','DependenciasController@RegresarNombreDependencia');

Route::get('/usuarios','SolicitudesController@VistaUsuarios');
Route::post('/usuarios/eliminar','LoginController@EliminarUsuario');

//refrescando tablas
Route::post('/refrescar/listado_completo', 'SolicitudesController@RefrescarListadoCompleto');
Route::post('/refrescar/listado_general/{modulo}', 'SolicitudesController@RefrescarListadoGeneralEstatus');

//mails
Route::get('/enviamail','MailsController@pruebamail');

//archivos

//descargas
Route::get('/descargas/anexo_plantilla','ArchivosController@DescargarAnexoPlantilla');
Route::get('/descargas/archivo/{id_archivo}','ArchivosController@DescargarArchivo');

//archivos
Route::post('/archivos/obtener_archivos','ArchivosController@RegresarArchivosSolicitud');
Route::post('/archivos/agregar_mensaje','ArchivosController@AgregarMensaje');
Route::post('/archivos/actualizar_archivo','ArchivosController@ActualizaArchivo');

//comentarios
Route::post('/comentarios/traer','SolicitudesController@RegresarComentarios');
Route::post('/comentarios/guardar_general','SolicitudesController@GuardarComentarioGeneral');
Route::post('/comentarios/guardar_cga','SolicitudesController@GuardarComentarioCGA');
Route::post('/comentarios/guardar_spr','SolicitudesController@GuardarComentarioSPR');
Route::post('/comentarios/eliminar','SolicitudesController@EliminarComentario');

 
Route::get('qr-code', function () {
    $qr = QrCode::size(100)->generate('Welcome to kerneldev.com!');
    return $qr;
});
/*Route::get('/lock','SolicitudesController@BloquearSql');
Route::get('/unlock','SolicitudesController@DesbloquearSql');//*/