<?php
  namespace App\Http\Controllers;

    use App\User;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request; //indispensable para usar Request de los JSON
    use Illuminate\Support\Facades\Storage;//gestion de archivos
    use Illuminate\Support\Facades\DB;//consulta a la base de datos


    class SolicitudesController extends Controller
    {
        /**
         * Show the profile for the given user.
         *
         * @param  int  $id
         * @return Response
         */

        public function GenerarReporte(Request $request){
            date_default_timezone_set('America/Mexico_City');
            $hoy = date('Y-m-d');
            /*$solicitudes = DB::table('SOLICITUDES_SOLICITUD')
                ->leftJoin('SOLICITUDES_DATOS_CGA', 'SOLICITUDES_SOLICITUD.SOLICITUD_ID', '=', 'SOLICITUDES_DATOS_CGA.FK_SOLICITUD_ID')
                ->get();
            //*/
            $fecha_inicial=$request['fecha_inicial'];
            $fecha_final=$request['fecha_final'];
            $estatus=$request['estatus'];
            $tipo_solicitud=$request['tipo_solicitud'];
            //dd($tipo_solicitud);
            $array_estatus = array();
            $array_tipo_solicitud = array();
            if(strcmp($estatus ,'TODO')==0){
                $array_estatus=['RECIBIDO SPR','VALIDACIÓN DE INFORMACIÓN','INFORMACIÓN CORRECTA','RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','CANCELADO POR TITULAR','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR','CANCELADO','OTRO'];
            }else{
                $array_estatus[]=$estatus;
            }
            if(strcmp($tipo_solicitud ,'TODO')==0){
                $array_tipo_solicitud=['CONTRATACIÓN','CONTRATACIÓN POR SUSTITUCIÓN','PROMOCION','CAMBIO DE ADSCRIPCIÓN'];
            }else{
                $array_tipo_solicitud[] = $tipo_solicitud;
            }
            //dd($array_tipo_solicitud);
            $datos_cga = DB::table('SOLICITUDES_DATOS_CGA')
                     ->select('FK_SOLICITUD_ID')
                     ->whereIn('DATOS_CGA_ESTATUS',$array_estatus)
                     ->whereBetween('created_at', [$fecha_inicial, $fecha_final])
                     ->get();
            //dd($datos_cga);

            $array_datos_cga = array();
            foreach ($datos_cga as $dato) {
                $array_datos_cga[] = $dato->FK_SOLICITUD_ID;
            }
            //dd($array_datos_cga);

            $solicitudes = DB::table('SOLICITUDES_SOLICITUD')
                     ->select('SOLICITUD_ID')
                     ->whereIn('SOLICITUD_ID',$array_datos_cga)
                     ->whereIn('SOLICITUD_TIPO_SOLICITUD',$array_tipo_solicitud)
                     ->get();//*/
            //$solicitudes = DB::table('SOLICITUDES_SOLICITUD')->get();
            //dd($solicitudes);
            
            $return_sol = array();
            foreach ($solicitudes as $solicitud) {
                $return_sol[] = SolicitudesController::ObtenerDatosReporte($solicitud->SOLICITUD_ID);
            }
            //dd($return_sol);

            //dd($solicitudes);
            //dd($request);
            $data = array(
                "solicitudes"=>$return_sol
            );

            echo json_encode($data);//*/

        }

        public function ObtenerDatosReporte($id_solicitud){
            $solicitudes = array();
            $DatosGenerales = SolicitudesController::DatosGenerales();
            $institucional = $DatosGenerales['institucional'];
            //dd($id_solicitud);
            $solicitud = (object)(array());
            //$solicitud->epale = 'algo';
            //dd($solicitud);
            $tmp_solicitud = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->select(
                                'SOLICITUD_ID as ID_SOLICITUD',
                                'SOLICITUD_OFICIO as OFICIO_SOLICITUD',
                                'SOLICITUD_NOMBRE as NOMBRE_SOLICITUD',
                                'SOLICITUD_DEPENDENCIA as DEPENDENCIA_SOLICITUD',
                                'SOLICITUD_CATEGORIA as CATEGORIA_SOLICITUD',
                                'SOLICITUD_PUESTO as PUESTO_SOLICITUD',
                                'SOLICITUD_ACTIVIDADES as ACTIVIDADES_SOLICITUD',
                                'SOLICITUD_NOMINA as NOMINA_SOLICITUD',
                                'SOLICITUD_SALARIO as SALARIO_SOLICITUD',
                                'SOLICITUD_JUSTIFICACION as JUSTIFICACION_SOLICITUD',
                                'SOLICITUD_TIPO_SOLICITUD as TIPO_SOLICITUD_SOLICITUD',
                                'SOLICITUD_FUENTE_RECURSOS as FUENTE_RECURSOS_SOLICITUD',
                                'SOLICITUD_URGENCIA as PRIORIDAD_SOLICITUD',
                                'created_at as FECHA_DE_SOLICITUD'
                            )
                    ->get();
            //dd($tmp_solicitud[0]);
            $solicitud->ID_SOLICITUD = $tmp_solicitud[0]->ID_SOLICITUD;
            //datos de candidato
            $solicitud->DEPENDENCIA = null;
            $solicitud->CODIGO_DEPENDENCIA = null;
            $solicitud->CANDIDATO = $tmp_solicitud[0]->NOMBRE_SOLICITUD;
            $solicitud->NOMINA = $tmp_solicitud[0]->NOMINA_SOLICITUD;
            $solicitud->TIPO_SOLICITUD = $tmp_solicitud[0]->TIPO_SOLICITUD_SOLICITUD;
            $solicitud->FUENTE_RECURSOS = $tmp_solicitud[0]->FUENTE_RECURSOS_SOLICITUD;
            $solicitud->PRIORIDAD = $tmp_solicitud[0]->PRIORIDAD_SOLICITUD;
            //$solicitud->JUSTIFICACION = $tmp_solicitud[0]->JUSTIFICACION_SOLICITUD;

            //datos de candidato
            $solicitud->CANDIDATO = $tmp_solicitud[0]->NOMBRE_SOLICITUD;
            $solicitud->CATEGORIA_SOLICITADA = $tmp_solicitud[0]->CATEGORIA_SOLICITUD;
            $solicitud->PUESTO_SOLICITADO = $tmp_solicitud[0]->PUESTO_SOLICITUD;
            $solicitud->ACTIVIDADES_SOLICITADAS = $tmp_solicitud[0]->ACTIVIDADES_SOLICITUD;
            $solicitud->SALARIO_SOLICITADO = $tmp_solicitud[0]->SALARIO_SOLICITUD;

            //datos extras en CxS y CA
            $solicitud->EN_SUSTITUCION_DE = null;
            $solicitud->DEPENDENCIA_DESTINO = null;
            $solicitud->FECHA_DE_SOLICITUD = $tmp_solicitud[0]->FECHA_DE_SOLICITUD;

            if(strcmp($tmp_solicitud[0]->TIPO_SOLICITUD_SOLICITUD, 'CONTRATACIÓN')==0){
                $solicitud->CATEGORIA_ANTERIOR = null;
                $solicitud->PUESTO_ANTERIOR = null;
                $solicitud->ACTIVIDADES_ANTERIORES = null;
                $solicitud->SALARIO_ANTERIOR = null;
            }else{
                $solicitud->CATEGORIA_ANTERIOR = $tmp_solicitud[0]->CATEGORIA_SOLICITUD;
                $solicitud->PUESTO_ANTERIOR = $tmp_solicitud[0]->PUESTO_SOLICITUD;
                $solicitud->ACTIVIDADES_ANTERIORES = $tmp_solicitud[0]->ACTIVIDADES_SOLICITUD;
                $solicitud->SALARIO_ANTERIOR = $tmp_solicitud[0]->SALARIO_SOLICITUD;
            }

            $dependencia = DependenciasController::ObtenerDatosDependencia($tmp_solicitud[0]->DEPENDENCIA_SOLICITUD);
            $solicitud->CODIGO_DEPENDENCIA = $dependencia->CODIGO_DEPENDENCIA;
            $solicitud->DEPENDENCIA = $dependencia->NOMBRE_DEPENDENCIA;

            switch ($tmp_solicitud[0]->TIPO_SOLICITUD_SOLICITUD) {
                case 'CONTRATACIÓN':
                    # code...
                    break;
                case 'CONTRATACIÓN POR SUSTITUCIÓN':
                    $sustitucion = SolicitudesController::ObtenerDatosSustitucion($id_solicitud);
                    if($sustitucion){
                        $solicitud->EN_SUSTITUCION_DE = $tmp_solicitud[0]->NOMBRE_SOLICITUD;

                        $solicitud->CANDIDATO = $sustitucion->NUEVO_CANDIDATO;
                        $solicitud->CATEGORIA_SOLICITADA = $sustitucion->NUEVA_CATEGORIA;
                        $solicitud->PUESTO_SOLICITADO = $sustitucion->PUESTO_NUEVO;
                        $solicitud->ACTIVIDADES_SOLICITADAS = $sustitucion->NUEVAS_ACTIVIDADES;
                        $solicitud->SALARIO_SOLICITADO = $sustitucion->NUEVO_SALARIO;
                    }
                    break;
                case 'PROMOCION':
                    $promocion = SolicitudesController::ObtenerDatosPromocion($id_solicitud);
                    if($promocion){
                        $solicitud->CATEGORIA_ANTERIOR = $promocion->NUEVA_CATEGORIA;
                        $solicitud->PUESTO_ANTERIOR = $promocion->PUESTO_NUEVO;
                        $solicitud->ACTIVIDADES_ANTERIORES = $promocion->NUEVAS_ACTIVIDADES;
                        $solicitud->SALARIO_ANTERIOR = $promocion->NUEVO_SALARIO;
                    }
                    break;
                case 'CAMBIO DE ADSCRIPCIÓN':
                    //dd($id_solicitud);
                    $adscripcion = SolicitudesController::ObtenerDatosCambioAdscripcion($id_solicitud);
                    //dd($adscripcion);
                    if($adscripcion){
                        $solicitud->DEPENDENCIA_DESTINO = $adscripcion->NUEVA_DEPENDENCIA;

                        $solicitud->CATEGORIA_ANTERIOR = $adscripcion->NUEVA_CATEGORIA;
                        $solicitud->PUESTO_ANTERIOR = $adscripcion->PUESTO_NUEVO;
                        $solicitud->ACTIVIDADES_ANTERIORES = $adscripcion->NUEVAS_ACTIVIDADES;
                        $solicitud->SALARIO_ANTERIOR = $adscripcion->NUEVO_SALARIO;//*/
                    }
                    break;
                
                default:
                    # code...
                    break;
            }


            $fechas = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();
            //dd($fechas[0]);
            $solicitud->FECHA_DE_SOLICITUD = $fechas[0]->FECHAS_CREACION_SOLICITUD;

            $datos_cga = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();

            //if()

            $solicitud->ESTATUS_SOLICITUD = $datos_cga[0]->DATOS_CGA_ESTATUS;//estatus
            $solicitud->CATEGORIA_PROPUESTA = $datos_cga[0]->DATOS_CGA_CATEGORIA_PROPUESTA;
            $solicitud->PUESTO_PROPUESTO = $datos_cga[0]->DATOS_CGA_PUESTO_PROPUESTO;
            $solicitud->SALARIO_PROPUESTO = $datos_cga[0]->DATOS_CGA_SALARIO_PROPUESTO;
            $solicitud->PROCEDE = $datos_cga[0]->DATOS_CGA_PROCEDENTE;
            //$solicitud->RESPUESTA_CGA = $datos_cga[0]->DATOS_CGA_RESPUESTA;
            /*$solicitud->CATEGORIA_SUPERIOR = $datos_cga[0]->DATOS_CGA_CATEGORIA_SUPERIOR;
            $solicitud->SALARIO_SUPERIOR = $datos_cga[0]->DATOS_CGA_SALARIO_SUPERIOR;
            $solicitud->CATEGORIA_INFERIOR = $datos_cga[0]->DATOS_CGA_CATEGORIA_INFERIOR;
            $solicitud->SALARIO_INFERIOR = $datos_cga[0]->DATOS_CGA_SALARIO_INFERIOR;//*/
            $solicitud->AHORRO_SOLICITUD = $datos_cga[0]->DATOS_CGA_AHORRO;
            $solicitud->COMPENSACION_SOLICITUD = $datos_cga[0]->DATOS_CGA_COMPENSACION;

            return $solicitud;

        }

        public function VistaAceptacionTerminosTitular(){
            date_default_timezone_set('America/Mexico_City');
            $categoria = \Session::get('categoria')[0];
            $usuario = \Session::get('usuario')[0];
            if(in_array($categoria, ['TITULAR'])){
                $existe = DB::table('REL_TITULAR_AVISO')->where('FK_USUARIO', $usuario)->get();
                $rel_titular = DB::table('REL_DEPENCENCIA_TITULAR')
                    ->where('FK_USUARIO',$usuario)
                    ->get();
                $dependencia = DependenciasController::ObtenerNombreDependencia($rel_titular[0]->FK_DEPENDENCIA);
                $fl_sistema = SolicitudesController::DatosGenerales();
                //dd($dependencia[0]);
                if($existe[0]->FL_AVISO == 0){
                    $datos = array(
                        'texto1' => (($fl_sistema['institucional'])?'de la Benemérita Universidad Autónoma de Puebla.':'.'),
                        'responsable' => \Session::get('responsable')[0], 
                        'dependencia' => $dependencia[0]->NOMBRE_DEPENDENCIA,
                        'usuario' => \Session::get('usuario')[0], 
                        'fecha' => date('d/m/Y')
                    );
                    //dd($datos);

                    return view('aceptacion_terminos_titular')->with (["datos"=>$datos]);
                }else{
                    return redirect('/listado/dependencia');
                }
            }else{
                return view('errors.505');
            }
        }

        public function AceptarTerminos(Request $request){
            date_default_timezone_set('America/Mexico_City');
            //dd('EPALE');
            $usuario = \Session::get('usuario')[0];
            $update = DB::table('REL_TITULAR_AVISO')
                ->where('FK_USUARIO', $usuario)
                ->update([
                            'FL_AVISO'=> 1,
                            'FECHA_ACEPTACION' => date('Y-m-d H:i:s')
                        ]);
            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function VistaGenerarReporte(){
            date_default_timezone_set('America/Mexico_City');
            /*$hoy = date('Y-m-d');
            return view('crear_reporte')->with (["hoy"=>$hoy]);//*/

            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA','TRABAJADOR_SPR','SECRETARIO_PARTICULAR'])){
                $hoy = date('Y-m-d');
                return view('crear_reporte')->with (["hoy"=>$hoy]);
            }else{
                return view('errors.505');
            }
        }

        public function ObtenerMovimientos(Request $request){
            //dd($request['id_solicitud']);
            $movimientos = SolicitudesController::ObtenerMovimientosId($request['id_solicitud']);

            $data = array(
                "movimientos"=>$movimientos
            );

            echo json_encode($data);//*/

        }

        public function ObtenerMovimientosId($id_solicitud){
            //dd($id_solicitud);
            $categoria = \Session::get('categoria')[0];
            $rel_movimientos;
            $movimientos = array();
            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA'])){
                $rel_movimientos = DB::table('REL_MOVIMIENTOS_CGA')
                    ->where('FK_SOLICITUD_ID', $id_solicitud)
                    ->get();
            }else if(in_array($categoria, ['TRABAJADOR_SPR','SECRETARIO_PARTICULAR'])){
                $rel_movimientos = $users = DB::table('REL_MOVIMIENTOS_SPR')
                    ->where('FK_SOLICITUD_ID', $id_solicitud)
                    ->get();
            }
            //dd($rel_movimientos);
            foreach ($rel_movimientos as $movimiento) {
                $tmp_movimiento = DB::table('SOLICITUDES_MOVIMIENTOS')
                    ->where('MOVIMIENTOS_ID', $movimiento->FK_MOVIMIENTO)
                    ->select(
                                'MOVIMIENTOS_ID as ID_MOVIMIENTO',
                                'MOVIMIENTOS_MOVIMIENTO as MOVIMIENTO',
                                'created_at as FECHA_MOVIMIENTO'
                            )
                    ->get();
                $movimientos[]=$tmp_movimiento[0];
            }
            //dd($movimientos);
            return $movimientos;

        }

        public function GuardarComentarioGeneral(Request $request){
            $id_comentario = SolicitudesController::GuardaComentario($request['comentario']);
            DB::table('REL_OBSERVACIONES_GENERALES')->insert(
                [
                    'FK_OBSERVACION' => $id_comentario,
                    'FK_SOLICITUD_ID' => $request['id_solicitud']
                ]
            );
            //dd($request);

            $data = array(
                "id_comentario"=>$id_comentario
            );

            echo json_encode($data);//*/
        }

        public function GuardarComentarioCGA(Request $request){
            $id_comentario = SolicitudesController::GuardaComentario($request['comentario']);
            DB::table('REL_OBSERVACIONES_CGA')->insert(
                [
                    'FK_OBSERVACION' => $id_comentario,
                    'FK_SOLICITUD_ID' => $request['id_solicitud']
                ]
            );
            //dd($request);

            $data = array(
                "id_comentario"=>$id_comentario
            );

            echo json_encode($data);//*/
        }

        public function GuardarComentarioSPR(Request $request){
            $id_comentario = SolicitudesController::GuardaComentario($request['comentario']);
            DB::table('REL_OBSERVACIONES_SPR')->insert(
                [
                    'FK_OBSERVACION' => $id_comentario,
                    'FK_SOLICITUD_ID' => $request['id_solicitud']
                ]
            );
            //dd($request);

            $data = array(
                "id_comentario"=>$id_comentario
            );

            echo json_encode($data);//*/
        }

        public function GuardaComentario($comentario){
            date_default_timezone_set('America/Mexico_City');
            $id_comentario = DB::table('SOLICITUDES_OBSERVACIONES')->insertGetId(
                [
                    'OBSERVACIONES_OBSERVACION' => $comentario,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
            return $id_comentario;
        }

        public function EliminarComentario(Request $request){
            //dd($request);
            if($request['tipo_comentario']==1){
                //dd('comentario general');
                DB::table('REL_OBSERVACIONES_GENERALES')->where('FK_OBSERVACION', $request['id_comentario'])->delete();
            }else if($request['tipo_comentario']==2){
                DB::table('REL_OBSERVACIONES_CGA')->where('FK_OBSERVACION', $request['id_comentario'])->delete();
            }else{
                DB::table('REL_OBSERVACIONES_SPR')->where('FK_OBSERVACION', $request['id_comentario'])->delete();
            }
            $delete = DB::table('SOLICITUDES_OBSERVACIONES')->where('OBSERVACIONES_ID', $request['id_comentario'])->delete();
            $data = array(
                "delete"=>$delete
            );

            echo json_encode($data);//*/
        }

        public function RegresarComentarios(Request $request){
            $comentarios = SolicitudesController::ObtenerComentariosGenerales($request['id_solicitud']);
            if(in_array(\Session::get('categoria')[0],['COORDINADOR_CGA','ANALISTA_CGA','ADMINISTRADOR_CGA'])){
                $comentariosInternos = SolicitudesController::ObtenerComentariosCGA($request['id_solicitud']);
                $rol = 2;
            }
            if(in_array(\Session::get('categoria')[0],['SECRETARIO_PARTICULAR','TRABAJADOR_SPR'])){
                $comentariosInternos = SolicitudesController::ObtenerComentariosSPR($request['id_solicitud']);
                $rol = 3;
            }

            $data = array(
                "comentarios"=>$comentarios,
                "comentariosInternos"=>$comentariosInternos,
                "rol"=>$rol,
            );

            echo json_encode($data);//*/
        }

        public function ObtenerComentariosGenerales($id_solicitud){
            date_default_timezone_set('America/Mexico_City');
            $comentarios = array();
            $rel_comentarios = DB::table('REL_OBSERVACIONES_GENERALES')
                ->select('FK_OBSERVACION')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();
            foreach ($rel_comentarios as $relacion) {
                $comentario = DB::table('SOLICITUDES_OBSERVACIONES')
                ->select(
                            'OBSERVACIONES_ID as ID_OBSERVACION',
                            'OBSERVACIONES_OBSERVACION as OBSERVACION',
                            'created_at as FECHA_OBSERVACION'
                        )
                ->where('OBSERVACIONES_ID',$relacion->FK_OBSERVACION)
                ->get();
                $comentarios[] = $comentario[0];
            }
            //dd($comentarios);
            return $comentarios;
        }

        public function ObtenerComentariosCGA($id_solicitud){
            date_default_timezone_set('America/Mexico_City');
            $comentarios = array();
            $rel_comentarios = DB::table('REL_OBSERVACIONES_CGA')
                ->select('FK_OBSERVACION')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();
            foreach ($rel_comentarios as $relacion) {
                $comentario = DB::table('SOLICITUDES_OBSERVACIONES')
                ->select(
                            'OBSERVACIONES_ID as ID_OBSERVACION',
                            'OBSERVACIONES_OBSERVACION as OBSERVACION',
                            'created_at as FECHA_OBSERVACION'
                        )
                ->where('OBSERVACIONES_ID',$relacion->FK_OBSERVACION)
                ->get();
                $comentarios[] = $comentario[0];
            }
            //dd($comentarios);
            return $comentarios;
        }

        public function ObtenerComentariosSPR($id_solicitud){
            date_default_timezone_set('America/Mexico_City');
            $comentarios = array();
            $rel_comentarios = DB::table('REL_OBSERVACIONES_SPR')
                ->select('FK_OBSERVACION')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();
            foreach ($rel_comentarios as $relacion) {
                $comentario = DB::table('SOLICITUDES_OBSERVACIONES')
                ->select(
                            'OBSERVACIONES_ID as ID_OBSERVACION',
                            'OBSERVACIONES_OBSERVACION as OBSERVACION',
                            'created_at as FECHA_OBSERVACION'
                        )
                ->where('OBSERVACIONES_ID',$relacion->FK_OBSERVACION)
                ->get();
                $comentarios[] = $comentario[0];
            }
            //dd($comentarios);
            return $comentarios;
        }

        public function ObtenerFechasSolicitud(Request $request){

            $fechas = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID',$request['id_sol'])
                ->get();
            $cabeceras = array(
                    'CREACIÓN',
                    'EXPIRACIÓN',
                    'INFORMACION COMPLETA',
                    'TURNADO A CGA',
                    'LIMITE AGENDAR CITA',
                    'LIMITE LEVANTAMIENTO',
                    'LIMITE ANALISIS',
                    'LIMITE REVISION',
                    'LIMITE FIRMAS',
                    'LIMITE FINALIZAR',
                    'PUESTO REVISION',
                    'PUESTO FIRMAS',
                    'FIRMA COORDINADOR GENERAL ADMINISTRATIVO',
                    'FIRMA TITULAR',
                    'FIRMA SECRETARIO PARTICULAR',
                    'TURNADO SPR PARA APROVACIÓN'
                );
            $datos_tabla = array(
                    'CREACIÓN' => (($fechas[0]->FECHAS_CREACION_SOLICITUD)?date("d/m/Y", strtotime($fechas[0]->FECHAS_CREACION_SOLICITUD)):null),
                    'EXPIRACIÓN' => (($fechas[0]->FECHAS_EXPIRACION)?date("d/m/Y", strtotime($fechas[0]->FECHAS_EXPIRACION)):null),
                    'INFORMACION COMPLETA' => (($fechas[0]->FECHAS_INFORMACION_COMPLETA)?date("d/m/Y", strtotime($fechas[0]->FECHAS_INFORMACION_COMPLETA)):null),
                    'TURNADO A CGA' => (($fechas[0]->FECHAS_TURNADO_CGA)?date("d/m/Y", strtotime($fechas[0]->FECHAS_TURNADO_CGA)):null),
                    'LIMITE AGENDAR CITA' => (($fechas[0]->FECHAS_LIMITE_AGENDAR_CITA)?date("d/m/Y", strtotime($fechas[0]->FECHAS_LIMITE_AGENDAR_CITA)):null),
                    'LIMITE LEVANTAMIENTO' => (($fechas[0]->FECHAS_LIMITE_LEVANTAMIENTO)?date("d/m/Y", strtotime($fechas[0]->FECHAS_LIMITE_LEVANTAMIENTO)):null),
                    'LIMITE ANALISIS' => (($fechas[0]->FECHAS_LIMITE_ANALISIS)?date("d/m/Y", strtotime($fechas[0]->FECHAS_LIMITE_ANALISIS)):null),
                    'LIMITE REVISION' => (($fechas[0]->FECHAS_LIMITE_REVISION)?date("d/m/Y", strtotime($fechas[0]->FECHAS_LIMITE_REVISION)):null),
                    'LIMITE FIRMAS' => (($fechas[0]->FECHAS_LIMITE_FIRMAS)?date("d/m/Y", strtotime($fechas[0]->FECHAS_LIMITE_FIRMAS)):null),
                    'LIMITE FINALIZAR' => (($fechas[0]->FECHAS_LIMITE_FINALIZAR)?date("d/m/Y", strtotime($fechas[0]->FECHAS_LIMITE_FINALIZAR)):null),
                    'PUESTO REVISION' => (($fechas[0]->FECHAS_PUESTO_REVISION)?date("d/m/Y", strtotime($fechas[0]->FECHAS_PUESTO_REVISION)):null),
                    'PUESTO FIRMAS' => (($fechas[0]->FECHAS_PUESTO_FIRMAS)?date("d/m/Y", strtotime($fechas[0]->FECHAS_PUESTO_FIRMAS)):null),
                    'FIRMA COORDINADOR GENERAL' => (($fechas[0]->FECHAS_FIRMA_CGA)?date("d/m/Y", strtotime($fechas[0]->FECHAS_FIRMA_CGA)):null),
                    'FIRMA TITULAR' => (($fechas[0]->FECHAS_FIRMA_TITULAR)?date("d/m/Y", strtotime($fechas[0]->FECHAS_FIRMA_TITULAR)):null),
                    'FIRMA SECRETARIO PARTICULAR' => (($fechas[0]->FECHAS_FIRMA_SPR)?date("d/m/Y", strtotime($fechas[0]->FECHAS_FIRMA_SPR)):null),
                    'TURNADO SPR PARA APROVACIÓN' => (($fechas[0]->FECHAS_TURNADO_SPR)?date("d/m/Y", strtotime($fechas[0]->FECHAS_TURNADO_SPR)):null)
                );

            //dd($datos_tabla);
            $data = array(
                "cabeceras"=>$cabeceras,
                "datos"=>$datos_tabla
            );

            echo json_encode($data);//*/
        }

        public function ObtenerPropuesta(Request $request){
            $tipo_solicitud = $request['tipo_solicitud'];
            $sol = $request['id_solicitud'];
            $propuesta = null;
            switch ($tipo_solicitud) {
                case 'CONTRATACIÓN':
                    $propuesta = SolicitudesController::ObtenerPropuestaContratacion($sol);
                    break;
                case 'CONTRATACIÓN POR SUSTITUCIÓN':
                    $propuesta = SolicitudesController::ObtenerPropuestaSustitucion($sol);
                    break;
                case 'PROMOCION':
                    $propuesta = SolicitudesController::ObtenerPropuestaPromocion($sol);
                    break;
                case 'CAMBIO DE ADSCRIPCIÓN':
                    $propuesta = SolicitudesController::ObtenerPropuestaCambioAdscripcion($sol);
                    break;
                
                default:
                    # code...
                    break;
            }
            return $propuesta;
        }

        public function ObtenerPropuestaContratacion($id_solicitud){
            //dd($id_solicitud);
            $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
            $extra = array();
            $diferencias = SolicitudesController::ObtenerDiferencias($solicitud,$extra);
            //dd($diferencias);
            $cabeceras = array(
                'Número de solicitud',
                //'Estatus',
                'Candidato',
                'Dependencia',
                //'Fecha de solicitud',
                'Actividades',
                'Categoría solicitada',
                'Puesto solicitado',
                'Salario solicitado',
                'Categoría propuesta',
                'Salario neto quincenal propuesto',
                'Diferencia quincenal (Propuesta)',
                '% de diferencia (Propuesta)',
                'Compensación neto quincenal',
                'Compensación más salario quincenal',
                'Fuente de recursos',
                'Respuesta de la CGA'
            );
            $datos_tabla = array(
                'Número de solicitud' => $solicitud->ID_SOLICITUD,
                'Candidato' => $solicitud->NOMBRE_SOLICITUD, 
                'Dependencia' => $solicitud->NOMBRE_DEPENDENCIA,
                'Actividades' => $solicitud->ACTIVIDADES_SOLICITUD,
                'Categoría solicitada' => $solicitud->CATEGORIA_SOLICITUD,
                'Puesto solicitado' => $solicitud->PUESTO_SOLICITUD,
                'Salario solicitado' => '$ '. $solicitud->SALARIO_FORMATO,

                'Categoría propuesta' => $solicitud->CATEGORIA_PROPUESTA,
                'Salario neto quincenal propuesto' => '$ '. $solicitud->SALARIO_PROPUESTO,

                'Diferencia quincenal (Propuesta)' => $diferencias->dif_quincenal_2,
                '% de diferencia (Propuesta)' => $diferencias->porc_diferencia_2,
                'Compensación neto quincenal' => '$ '. number_format($solicitud->COMPENSACION_SOLICITUD,2),
                'Compensación más salario quincenal' => '$ '. $diferencias->compensacion_salario,

                'Fuente de recursos' => $solicitud->FUENTE_RECURSOS_SOLICITUD,
                'Respuesta de la CGA' => $solicitud->RESPUESTA_CGA

            );//*/
            $data = array(
                "cabeceras"=>$cabeceras,
                "datos"=>$datos_tabla
            );
            //dd($data);

            echo json_encode($data);//*/
        }

        public function ObtenerPropuestaSustitucion($id_solicitud){
            //dd($id_solicitud);
            $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
            $extra = SolicitudesController::ObtenerDatosSustitucion($id_solicitud);
            //dd($extra);
            $diferencias = SolicitudesController::ObtenerDiferencias($solicitud,$extra);
            //dd($extra);
            $cabeceras = array(
                'Número de solicitud',
                'Candidato',
                'Actividades',
                'Categoría solicitada',
                'Puesto solicitado',
                'Salario solicitado',

                'Diferencia quincenal solicitada',
                '% de diferencia solicitada',

                'Nombre de quien se sustituye',
                'Salario quincenal de quien se sustituye',

                'Categoría propuesta',
                'Salario neto quincenal propuesto',
                'Diferencia quincenal (propuesta)',
                '% de diferencia (propuesta)',
                'Compensación neto quincenal',
                'Compensación más salario quincenal',
                'Fuente de recursos',
                'Respuesta de la CGA'
            );
            $datos_tabla = array(
                'Número de solicitud' => $solicitud->ID_SOLICITUD,
                'Candidato' => $solicitud->NOMBRE_SOLICITUD,
                'Actividades' => $extra->NUEVAS_ACTIVIDADES,
                'Categoría solicitada' => $extra->NUEVA_CATEGORIA,
                'Puesto solicitado' => $extra->PUESTO_NUEVO,
                'Salario solicitado' => '$ '. $extra->NUEVO_SALARIO,

                'Diferencia quincenal solicitada' => $diferencias->dif_quincenal_1,
                '% de diferencia solicitada' => $diferencias->porc_diferencia_1,

                'Nombre de quien se sustituye' => $solicitud->EN_SUSTITUCION_DE,
                'Salario quincenal de quien se sustituye' => '$ '. $solicitud->SALARIO_FORMATO,

                'Categoría propuesta' => $solicitud->CATEGORIA_PROPUESTA,
                'Salario neto quincenal propuesto' => '$ '. $solicitud->SALARIO_PROPUESTO,
                'Diferencia quincenal (propuesta)' => $diferencias->dif_quincenal_2,
                '% de diferencia (propuesta)' => $diferencias->porc_diferencia_2,
                'Compensación neto quincenal' => '$ '. number_format($solicitud->COMPENSACION_SOLICITUD,2),
                'Compensación más salario quincenal' => '$ '. $diferencias->compensacion_salario,

                'Fuente de recursos' => $solicitud->FUENTE_RECURSOS_SOLICITUD,
                'Respuesta de la CGA' => $solicitud->RESPUESTA_CGA

            );//*/
            $data = array(
                "cabeceras"=>$cabeceras,
                "datos"=>$datos_tabla
            );
            //dd($data);

            echo json_encode($data);//*/
        }

        public function ObtenerPropuestaPromocion($id_solicitud){
            //dd($id_solicitud);
            $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
            $extra = SolicitudesController::ObtenerDatosPromocion($id_solicitud);
            //dd($solicitud);
            $diferencias = SolicitudesController::ObtenerDiferencias($solicitud,$extra);
            //dd($extra);
            $cabeceras = array(
                'Número de solicitud',
                'Candidato',
                'Categoría actual',
                'Salario neto actual',
                'Actividades',
                'Categoría solicitada',
                'Puesto solicitado',
                'Salario solicitado',

                'Diferencia quincenal solicitada',
                '% de diferencia solicitada',

                'Categoría propuesta',
                'Salario neto quincenal propuesto',
                'Diferencia quincenal (propuesta)',
                '% de diferencia (propuesta)',
                'Compensación neto quincenal',
                'Compensación más salario quincenal',
                'Respuesta de la CGA'
            );
            $datos_tabla = array(
                'Número de solicitud' => $solicitud->ID_SOLICITUD,
                'Candidato' => $solicitud->NOMBRE_SOLICITUD,
                'Categoría actual' => $solicitud->CATEGORIA_SOLICITUD,
                'Salario neto actual' => $solicitud->SALARIO_SOLICITUD,
                'Actividades' => $extra->NUEVAS_ACTIVIDADES,
                'Categoría solicitada' => $extra->NUEVA_CATEGORIA,
                'Puesto solicitado' => $extra->PUESTO_NUEVO,
                'Salario solicitado' => '$ '. $extra->NUEVO_SALARIO,

                'Diferencia quincenal solicitada' => $diferencias->dif_quincenal_1,
                '% de diferencia solicitada' => $diferencias->porc_diferencia_1,

                'Categoría propuesta' => $solicitud->CATEGORIA_PROPUESTA,
                'Salario neto quincenal propuesto' => '$ '. $solicitud->SALARIO_PROPUESTO,
                'Diferencia quincenal (propuesta)' => $diferencias->dif_quincenal_2,
                '% de diferencia (propuesta)' => $diferencias->porc_diferencia_2,
                'Compensación neto quincenal' => '$ '. number_format($solicitud->COMPENSACION_SOLICITUD,2),
                'Compensación más salario quincenal' => '$ '. $diferencias->compensacion_salario,

                'Respuesta de la CGA' => $solicitud->RESPUESTA_CGA

            );//*/
            $data = array(
                "cabeceras"=>$cabeceras,
                "datos"=>$datos_tabla
            );
            //dd($data);

            echo json_encode($data);//*/

        }

        public function ObtenerPropuestaCambioAdscripcion($id_solicitud){
            $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
            $cambio_adscripcion = SolicitudesController::ObtenerDatosCambioAdscripcion($id_solicitud);
            //dd($cambio_adscripcion);
            $cabeceras = array(
                'Número de solicitud',
                'Candidato', 

                'Dependencia actual',
                'Categoría actual',  
                'Puesto actual',  
                'Salario actual',  
                'Actividades actuales',

                'Categoría propuesta',
                'Salario neto quincenal propuesto',
                'Puesto en '.ucwords(strtolower($cambio_adscripcion->NUEVA_DEPENDENCIA)),
                'Funciones desempeñadas en '.ucwords(strtolower($cambio_adscripcion->NUEVA_DEPENDENCIA)),

            );
            //dd($cabeceras);
            $datos_tabla = array(
                'Número de solicitud' => $solicitud->ID_SOLICITUD,
                'Candidato' => $solicitud->NOMBRE_SOLICITUD,

                'Dependencia actual' => $solicitud->NOMBRE_DEPENDENCIA,
                'Categoría actual' => $solicitud->CATEGORIA_SOLICITUD,  
                'Puesto actual' => $solicitud->PUESTO_SOLICITUD,  
                'Salario actual' => '$ '.$solicitud->SALARIO_FORMATO,  
                'Actividades actuales' => $solicitud->ACTIVIDADES_SOLICITUD,

                'Categoría propuesta' => $solicitud->CATEGORIA_PROPUESTA,
                'Salario neto quincenal propuesto' => '$ '. $solicitud->SALARIO_PROPUESTO,
                'Puesto en '.ucwords(strtolower($cambio_adscripcion->NUEVA_DEPENDENCIA)) => $solicitud->PUESTO_PROPUESTO,
                'Funciones desempeñadas en '.ucwords(strtolower($cambio_adscripcion->NUEVA_DEPENDENCIA)) => $cambio_adscripcion->NUEVAS_ACTIVIDADES,

            );//*/
            $data = array(
                "cabeceras"=>$cabeceras,
                "datos"=>$datos_tabla
            );

            echo json_encode($data);//*/

        }

        public static function ObtenerDiferencias($solicitud,$extra){

            //Salario propuesto - Salario solicitados
            $dif_quincenal_1=null;
            $porc_diferencia_1=null;
            $dif_quincenal_2=null;
            $porc_diferencia_2=null;
            $compensacion_salario=null;
            if(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD, 'CONTRATACIÓN')==0){
                //dd('Entra');
                $dif_quincenal_2 = (double)((($solicitud->SALARIO_PROPUESTO_SF)?$solicitud->SALARIO_PROPUESTO_SF:0) - (($solicitud->SALARIO_SOLICITUD)?$solicitud->SALARIO_SOLICITUD:0));
                $porc_diferencia_2 = (($solicitud->SALARIO_SOLICITUD!=0)?(round((($dif_quincenal_2/$solicitud->SALARIO_SOLICITUD)*100),1)).'%':'');

            }else if(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD, 'CONTRATACIÓN POR SUSTITUCIÓN')==0){
                $dif_quincenal_1 = (double)($extra->NUEVO_SALARIO - $solicitud->SALARIO_SOLICITUD);
                $porc_diferencia_1=round(($dif_quincenal_1/$solicitud->SALARIO_SOLICITUD)*100,1).'%';

                $dif_quincenal_2 = (double)((($solicitud->SALARIO_PROPUESTO_SF)?$solicitud->SALARIO_PROPUESTO_SF:0) - (($solicitud->SALARIO_SOLICITUD)?$solicitud->SALARIO_SOLICITUD:0));
                $porc_diferencia_2 = (($solicitud->SALARIO_SOLICITUD!=0)?(round((($dif_quincenal_2/$solicitud->SALARIO_SOLICITUD)*100),1)).'%':'');

            }else if(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD, 'PROMOCION')==0){
                //dd()
                $dif_quincenal_1 = (double)(($extra->NUEVO_SALARIO-$solicitud->SALARIO_SOLICITUD));
                $porc_diferencia_1=round(($dif_quincenal_1/$solicitud->SALARIO_SOLICITUD)*100,1).'%';

                $dif_quincenal_2 = (double)((($solicitud->SALARIO_PROPUESTO_SF)?$solicitud->SALARIO_PROPUESTO_SF:0) - (($solicitud->SALARIO_SOLICITUD)?$solicitud->SALARIO_SOLICITUD:0));
                //dd(round((($dif_quincenal_2 / $solicitud->SALARIO_SOLICITUD)*100),1));
                $porc_diferencia_2 = (($solicitud->SALARIO_SOLICITUD!=0)?(round((($dif_quincenal_2 / $solicitud->SALARIO_SOLICITUD)*100),1)).'%':'');
                //dd($porc_diferencia_2);
            }else{

            }

            if($dif_quincenal_1<0){
                $dif_quincenal_1 ='-$ '.number_format(($dif_quincenal_1*(-1)),2);
            }else{
                $dif_quincenal_1 = '$ '.number_format($dif_quincenal_1,2);
            }

            if($dif_quincenal_2<0){
                $dif_quincenal_2 ='-$ '.number_format(($dif_quincenal_2*(-1)),2);
            }else{
                $dif_quincenal_2 = '$ '.number_format($dif_quincenal_2,2);
            }

            if($solicitud->COMPENSACION_SOLICITUD){
                $compensacion_salario = number_format(($solicitud->COMPENSACION_SOLICITUD + $solicitud->SALARIO_PROPUESTO_SF),2);
            }
            
            $diferencias = array(
                'dif_quincenal_1' => $dif_quincenal_1,
                'porc_diferencia_1' => $porc_diferencia_1,
                'dif_quincenal_2' => $dif_quincenal_2,
                'porc_diferencia_2' => $porc_diferencia_2,
                'compensacion_salario' => $compensacion_salario
            );
            return (object)$diferencias;
        }

        public function ObtenerCambioAdscripcion(Request $request){
            $solicitud = SolicitudesController::ObtenerSolicitudId($request['id_sol']);
            $cambio_adscripcion = SolicitudesController::ObtenerDatosCambioAdscripcion($request['id_sol']);
            //dd($cambio_adscripcion);
            $cabeceras = array(
                'Número de solicitud', 
                'Estatus', 
                'Candidato', 
                'Dependencia',  
                'Fecha de solicitud',  
                'Fecha de información completa',

                'Dependencia destino',
                'Categoría solicitada',  
                'Puesto solicitado',  
                'Salario solicitado',  
                'Actividades solicitadas',

                'Categoría actual',  
                'Puesto actual',  
                'Salario actual',  
                'Actividades actuales',
                'Justificación',
                'Escape'
            );
            $datos_tabla = array(
                'Número de solicitud' => $solicitud->ID_SOLICITUD,
                'Estatus' => $solicitud->ESTATUS_SOLICITUD,
                'Candidato' => $solicitud->NOMBRE_SOLICITUD,
                'Dependencia' => $solicitud->NOMBRE_DEPENDENCIA,
                'Fecha de solicitud' => $solicitud->FECHA_CREACION,
                'Fecha de información completa' => $solicitud->FECHAS_INFORMACION_COMPLETA,

                'Dependencia destino' => $cambio_adscripcion->NUEVA_DEPENDENCIA,
                'Categoría solicitada' => $cambio_adscripcion->NUEVA_CATEGORIA,  
                'Puesto solicitado' => $cambio_adscripcion->PUESTO_NUEVO,  
                'Salario solicitado' => number_format($cambio_adscripcion->NUEVO_SALARIO,2),  
                'Actividades solicitadas' => $cambio_adscripcion->NUEVAS_ACTIVIDADES,

                'Categoría actual' => $solicitud->CATEGORIA_SOLICITUD,  
                'Puesto actual' => $solicitud->PUESTO_SOLICITUD,  
                'Salario actual' => $solicitud->SALARIO_FORMATO,  
                'Actividades actuales' => $solicitud->ACTIVIDADES_SOLICITUD,
                'Justificación' => $solicitud->JUSTIFICACION_SOLICITUD,
                'Escape' => $solicitud->ID_ESCAPE
            );//*/
            $data = array(
                "cabeceras"=>$cabeceras,
                "datos"=>$datos_tabla
            );

            echo json_encode($data);//*/
        }

        public function ObtenerPromocion(Request $request){
            $solicitud = SolicitudesController::ObtenerSolicitudId($request['id_sol']);
            $promocion = SolicitudesController::ObtenerDatosPromocion($request['id_sol']);
            //dd($promocion);
            $cabeceras = array(
                'Número de solicitud',
                'Estatus',
                'Candidato',
                'Dependencia',
                'Fecha de solicitud',
                'Fecha de información completa',
                'Categoría solicitada',
                'Puesto solicitado',
                'Nuevas actividades',
                'Salario solicitado',
                'Categoría actual',
                'Puesto actual',
                'Salario actual',
                'Actividades actuales',
                'Justificación',
                'Escape'
            );
            $datos_tabla = array(
                'Número de solicitud' => $solicitud->ID_SOLICITUD,
                'Estatus' => $solicitud->ESTATUS_SOLICITUD,
                'Candidato' => $solicitud->NOMBRE_SOLICITUD,
                'Dependencia' => $solicitud->NOMBRE_DEPENDENCIA,
                'Fecha de solicitud' => $solicitud->FECHA_CREACION,
                'Fecha de información completa' => $solicitud->FECHAS_INFORMACION_COMPLETA,
                'Categoría solicitada' => $promocion->NUEVA_CATEGORIA,
                'Puesto solicitado' => $promocion->PUESTO_NUEVO,
                'Nuevas actividades' => $promocion->NUEVAS_ACTIVIDADES,
                'Salario solicitado' => number_format($promocion->NUEVO_SALARIO,2),
                'Categoría actual' => $solicitud->CATEGORIA_SOLICITUD,
                'Puesto actual' => $solicitud->PUESTO_SOLICITUD,
                'Salario actual' => $solicitud->SALARIO_FORMATO,
                'Actividades actuales' => $solicitud->ACTIVIDADES_SOLICITUD,
                'Justificación' => $solicitud->JUSTIFICACION_SOLICITUD,
                'Escape' => $solicitud->ID_ESCAPE
            );//*/
            //dd($sustitucion);
            $data = array(
                "cabeceras"=>$cabeceras,
                "datos"=>$datos_tabla
            );

            echo json_encode($data);//*/
        }

        public function ObtenerSustitucion(Request $request){
            $solicitud = SolicitudesController::ObtenerSolicitudId($request['id_sol']);
            $sustitucion = SolicitudesController::ObtenerDatosSustitucion($request['id_sol']);
            //dd($solicitud);
            $cabeceras = array(
                'Número de solicitud',
                'Estatus',
                'Candidato',
                'Dependencia',
                'Fecha de solicitud',
                'Fecha de información completa', 
                'Categoría solicitada',
                'Puesto solicitado',
                'Salario solicitado',
                'Actividades',
                'Nombre de quien causa baja',
                'Categoría de quien causa baja',
                'Puesto de quien causa baja',
                'Actividades de quien causa baja', 
                'Salario de quien causa baja',
                'Justificación',
                'Escape'
            );
            $datos_tabla = array(
                'Número de solicitud' => $solicitud->ID_SOLICITUD,
                'Estatus' => $solicitud->ESTATUS_SOLICITUD,
                'Candidato' => $sustitucion->NUEVO_CANDIDATO,//
                'Dependencia' => $solicitud->NOMBRE_DEPENDENCIA,
                'Fecha de solicitud' => $solicitud->FECHA_CREACION,
                'Fecha de información completa' => $solicitud->FECHAS_INFORMACION_COMPLETA, 
                'Categoría solicitada' => $sustitucion->NUEVA_CATEGORIA,//
                'Puesto solicitado' => $sustitucion->PUESTO_NUEVO,//
                'Salario solicitado' => number_format($sustitucion->NUEVO_SALARIO,2),//
                'Actividades' => $sustitucion->NUEVAS_ACTIVIDADES,
                'Nombre de quien causa baja' => $solicitud->NOMBRE_SOLICITUD,
                'Categoría de quien causa baja' => $solicitud->CATEGORIA_SOLICITUD,
                'Puesto de quien causa baja' => $solicitud->PUESTO_SOLICITUD,
                'Actividades de quien causa baja' => $solicitud->ACTIVIDADES_SOLICITUD, 
                'Salario de quien causa baja' => $solicitud->SALARIO_FORMATO,
                'Justificación' => $solicitud->JUSTIFICACION_SOLICITUD,
                'Escape' => $solicitud->ID_ESCAPE
            );//*/
            //dd($sustitucion);
            $data = array(
                "cabeceras"=>$cabeceras,
                "datos"=>$datos_tabla
            );

            echo json_encode($data);//*/
        }

        public function ObtenerContratacion(Request $request){
            //$arreglos = SolicitudesController::ObtenerDatosSolicitudModal($request['id_sol']);
            //dd($solicitud);
            $solicitud = SolicitudesController::ObtenerSolicitudId($request['id_sol']);
            $cabeceras = array(
                'Número de solicitud',
                'Estatus',
                'Candidato', 
                'Dependencia',  
                'Fecha de solicitud',  
                'Fecha de información completa',  
                'Categoría solicitada',  
                'Puesto solicitado',  
                'Salario solicitado',  
                'Actividades',
                'Justificación',
                'Escape'
            );
            $datos_tabla = array(
                'Número de solicitud' => $solicitud->ID_SOLICITUD,
                'Estatus' => $solicitud->ESTATUS_SOLICITUD,
                'Candidato' => $solicitud->NOMBRE_SOLICITUD, 
                'Dependencia' => $solicitud->NOMBRE_DEPENDENCIA,  
                'Fecha de solicitud' => $solicitud->FECHA_CREACION,  
                'Fecha de información completa' => $solicitud->FECHAS_INFORMACION_COMPLETA,  
                'Categoría solicitada' => $solicitud->CATEGORIA_SOLICITUD,  
                'Puesto solicitado' => $solicitud->PUESTO_SOLICITUD,
                'Salario solicitado' => $solicitud->SALARIO_FORMATO, 
                'Actividades' => $solicitud->ACTIVIDADES_SOLICITUD,
                'Justificación' => $solicitud->JUSTIFICACION_SOLICITUD,
                'Escape' => $solicitud->ID_ESCAPE
            );//*/
            $data = array(
                "cabeceras"=>$cabeceras,
                "datos"=>$datos_tabla
            );

            echo json_encode($data);//*/
        }

        public function AsignarAnalista(Request $request){
            date_default_timezone_set('America/Mexico_City');
            $IdAnalista = $request['analista'];
            $IdSolicitud = $request['id_solicitud'];
            //dd($request);

            $existeRelacion = $users = DB::table('REL_SOLICITUDES_ANALISTA')
                ->where('FK_SOLICITUD_ID', $IdSolicitud)
                ->get();

            //si existe una relación con anterioridad, se borra la relación existente
            if(count($existeRelacion)>0){
                DB::table('REL_SOLICITUDES_ANALISTA')
                    ->where('FK_SOLICITUD_ID', $IdSolicitud)
                    ->delete();
            }
            $insert = DB::table('REL_SOLICITUDES_ANALISTA')
                ->insert(
                    [
                        'FK_SOLICITUD_ID' => $IdSolicitud, 
                        'FK_USUARIO' => $IdAnalista,
                        'FECHA_ASIGNACION' => date('Y-m-d H:i:s')
                    ]
                );

            $responsable = \Session::get('responsable')[0];
            $movimiento = $responsable.' ha asignado la solicitud a '.$IdAnalista;
            SolicitudesController::InsertaMovimientoCGA($responsable,$movimiento,$IdSolicitud);

            $data = array(
                "insert"=>$insert
            );

            echo json_encode($data);//*/

        }

        public function CambiarPrioridad(Request $request){
            date_default_timezone_set('America/Mexico_City');

            $update = DB::table('SOLICITUDES_SOLICITUD')
                ->where('SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'SOLICITUD_URGENCIA' => $request['prioridad'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                //dd('Cambio');
            $responsable = \Session::get('responsable')[0];
            $movimiento = $responsable.' ha marcado la solicitud  como '.$request['prioridad'];
            SolicitudesController::InsertaMovimientoSPR($responsable,$movimiento,$request['id_sol']);

            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function VerCuadroElaborado($id_solicitud){
            $sustitucion = array();
            $promocion = array();
            $adscripcion = array();
            $id_solicitud = str_replace('_','/',$id_solicitud);
            $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
            //$sustitucion = SolicitudesController::ObtenerDatosSustitucion($id_solicitud);
            //$promocion = SolicitudesController::ObtenerDatosPromocion($id_solicitud);
            $adscripcion = SolicitudesController::ObtenerDatosCambioAdscripcion($id_solicitud);
            //dd($solicitud);
            $datos = SolicitudesController::DatosGenerales();
            //dd($datos);
            if($datos['institucional']){
                return view('pdf.cuadro_cambio_adscripcion_institucional') ->with (["solicitud"=>$solicitud,"adscripcion"=>$adscripcion]);
            }else{
                return view('pdf.cuadro_cambio_adscripcion_nps') ->with (["solicitud"=>$solicitud,"adscripcion"=>$adscripcion]);
            }
            //return view('pdf.cuadro_cambio_adscripcion_nps') ->with (["solicitud"=>$solicitud,"adscripcion"=>$adscripcion]);
        }

        public function PDFContratacion($id_solicitud){
            $categoria = \Session::get('categoria')[0];
            $id_solicitud = str_replace('_','/',$id_solicitud);

            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','CONTRATACIÓN')
                    ->get();
                if(count($val)>0){
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    //dd($solicitud);
                    $extra = array();
                    $diferencias = SolicitudesController::ObtenerDiferencias($solicitud,$extra);
                    //dd($diferencias);
                    $pdf = \PDF::loadView('pdf.cuadro_contratacion',['solicitud'=>$solicitud,'diferencias'=>$diferencias])->setPaper('letter', 'landscape');
                    //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
                    return $pdf->stream($id_solicitud.'.pdf', array("Attachment" => 0));
                }else{
                    return view('errors.404');
                }
            }else if(in_array($categoria, ['TITULAR','SECRETARIO_PARTICULAR','TRABAJADOR_SPR'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','CONTRATACIÓN')
                    ->get();
                if(count($val)>0){
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    if(in_array($solicitud->ESTATUS_SOLICITUD, ['FIRMAS','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR'])){
                        //$solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                        //dd($solicitud);
                        $extra = array();
                        $diferencias = SolicitudesController::ObtenerDiferencias($solicitud,$extra);
                        //dd($diferencias);
                        $pdf = \PDF::loadView('pdf.cuadro_contratacion',['solicitud'=>$solicitud,'diferencias'=>$diferencias])->setPaper('letter', 'landscape');
                        //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
                        return $pdf->stream($id_solicitud.'.pdf', array("Attachment" => 0));
                        
                    }else{
                        return view('errors.404');
                    }
                }
            }else{
                return view('errors.505');
            }
        }

        public function PDFSustitucion($id_solicitud){
            $categoria = \Session::get('categoria')[0];
            $id_solicitud = str_replace('_','/',$id_solicitud);

            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','CONTRATACIÓN POR SUSTITUCIÓN')
                    ->get();
                if(count($val)>0){
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    $sustitucion = SolicitudesController::ObtenerDatosSustitucion($id_solicitud);
                    //dd($sustitucion);
                    $extra = $sustitucion;
                    $diferencias = SolicitudesController::ObtenerDiferencias($solicitud,$extra);

                    $pdf = \PDF::loadView('pdf.cuadro_sustitucion',['solicitud'=>$solicitud,'sustitucion'=>$sustitucion,'diferencias'=>$diferencias])->setPaper('letter', 'landscape');
                    //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
                    return $pdf->stream($id_solicitud.'.pdf', array("Attachment" => 0));
                }else{
                    return view('errors.404');
                }
            }else if(in_array($categoria, ['TITULAR','SECRETARIO_PARTICULAR','TRABAJADOR_SPR'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','CONTRATACIÓN POR SUSTITUCIÓN')
                    ->get();
                if(count($val)>0){
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    if(in_array($solicitud->ESTATUS_SOLICITUD, ['FIRMAS','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR'])){
                        
                        //$solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                        $sustitucion = SolicitudesController::ObtenerDatosSustitucion($id_solicitud);
                        //dd($sustitucion);

                        $pdf = \PDF::loadView('pdf.cuadro_sustitucion',['solicitud'=>$solicitud,'sustitucion'=>$sustitucion])->setPaper('letter', 'landscape');
                        //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
                        return $pdf->stream($id_solicitud.'.pdf', array("Attachment" => 0));
                        
                    }else{
                        return view('errors.404');
                    }
                }
            }else{
                return view('errors.505');
            }
        }

        public function PDFPromocion($id_solicitud){
            $categoria = \Session::get('categoria')[0];
            $id_solicitud = str_replace('_','/',$id_solicitud);

            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','PROMOCION')
                    ->get();
                if(count($val)>0){
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    $promocion = SolicitudesController::ObtenerDatosPromocion($id_solicitud);
                    //dd($sustitucion);
                    $extra = $promocion;
                    $diferencias = SolicitudesController::ObtenerDiferencias($solicitud,$extra);

                    $pdf = \PDF::loadView('pdf.cuadro_promocion',['solicitud'=>$solicitud,'promocion'=>$promocion,'diferencias'=>$diferencias])->setPaper('letter', 'landscape');
                    //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
                    return $pdf->stream($id_solicitud.'.pdf', array("Attachment" => 0));
                }else{
                    return view('errors.404');
                }
            }else if(in_array($categoria, ['TITULAR','SECRETARIO_PARTICULAR','TRABAJADOR_SPR'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','PROMOCION')
                    ->get();
                if(count($val)>0){
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    if(in_array($solicitud->ESTATUS_SOLICITUD, ['FIRMAS','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR'])){
                        
                        $promocion = SolicitudesController::ObtenerDatosPromocion($id_solicitud);
                        //dd($sustitucion);
                        $extra = $promocion;
                        $diferencias = SolicitudesController::ObtenerDiferencias($solicitud,$extra);
                        $pdf = \PDF::loadView('pdf.cuadro_promocion',['solicitud'=>$solicitud,'promocion'=>$promocion,'diferencias'=>$diferencias])->setPaper('letter', 'landscape');
                        //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
                        return $pdf->stream($id_solicitud.'.pdf', array("Attachment" => 0));
                        
                    }else{
                        return view('errors.404');
                    }
                }
            }else{
                return view('errors.505');
            }
            /*
            $id_solicitud = str_replace('_','/',$id_solicitud);
            //hay que validar que exista la solicitud
            $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
            $promocion = SolicitudesController::ObtenerDatosPromocion($id_solicitud);
            //dd($promocion);
            if(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD, 'PROMOCION')==0){
                $pdf = \PDF::loadView('pdf.cuadro_promocion',['solicitud'=>$solicitud,'promocion'=>$promocion])->setPaper('letter', 'landscape');
                //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
                return $pdf->stream($id_solicitud.'.pdf', array("Attachment" => 0));
            }else{
                return view('errors.404');
            }//*/
        }

        public function PDFCambioAdscripcion($id_solicitud){
            $categoria = \Session::get('categoria')[0];
            $id_solicitud = str_replace('_','/',$id_solicitud);

            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','CAMBIO DE ADSCRIPCIÓN')
                    ->get();
                if(count($val)>0){
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    $adscripcion = SolicitudesController::ObtenerDatosCambioAdscripcion($id_solicitud);
                    //dd($sustitucion);
                    
                    $datos = SolicitudesController::DatosGenerales();   
                    if($datos['institucional']){
                        $pdf = \PDF::loadView('pdf.cuadro_cambio_adscripcion_institucional',['solicitud'=>$solicitud,'adscripcion'=>$adscripcion]);
                    }else{
                        $pdf = \PDF::loadView('pdf.cuadro_cambio_adscripcion_nps',['solicitud'=>$solicitud,'adscripcion'=>$adscripcion]);
                    }
                    //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
                    return $pdf->stream($id_solicitud.'.pdf', array("Attachment" => 0));
                }else{
                    return view('errors.404');
                }
            }else if(in_array($categoria, ['TITULAR','SECRETARIO_PARTICULAR','TRABAJADOR_SPR'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','CAMBIO DE ADSCRIPCIÓN')
                    ->get();
                if(count($val)>0){
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    if(in_array($solicitud->ESTATUS_SOLICITUD, ['FIRMAS','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR'])){
                        
                        $adscripcion = SolicitudesController::ObtenerDatosCambioAdscripcion($id_solicitud);
                        //dd($sustitucion);
                        $datos = SolicitudesController::DatosGenerales();   
                        if($datos['institucional']){
                            $pdf = \PDF::loadView('pdf.cuadro_cambio_adscripcion_institucional',['solicitud'=>$solicitud,'adscripcion'=>$adscripcion]);
                        }else{
                            $pdf = \PDF::loadView('pdf.cuadro_cambio_adscripcion_nps',['solicitud'=>$solicitud,'adscripcion'=>$adscripcion]);
                        }
                        //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
                        return $pdf->stream($id_solicitud.'.pdf', array("Attachment" => 0));
                        
                    }else{
                        return view('errors.404');
                    }
                }
            }else{
                return view('errors.505');
            }



            /*
            $id_solicitud = str_replace('_','/',$id_solicitud);
            //hay que validar que exista la solicitud
            $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
            $adscripcion = SolicitudesController::ObtenerDatosCambioAdscripcion($id_solicitud);
            //dd($promocion);
            if(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD, 'CAMBIO DE ADSCRIPCIÓN')==0){

                $datos = SolicitudesController::DatosGenerales();   
                if($datos['institucional']){
                    $pdf = \PDF::loadView('pdf.cuadro_cambio_adscripcion_institucional',['solicitud'=>$solicitud,'adscripcion'=>$adscripcion]);
                }else{
                    $pdf = \PDF::loadView('pdf.cuadro_cambio_adscripcion_nps',['solicitud'=>$solicitud,'adscripcion'=>$adscripcion]);
                }
                //$pdf = \PDF::loadView('pdf.cuadro_cambio_adscripcion',['solicitud'=>$solicitud,'adscripcion'=>$adscripcion]);
                //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
                return $pdf->stream($id_solicitud.'.pdf', array("Attachment" => 0));
            }else{
                return view('errors.404');
            }//*/
        }

        public function GuardaDatosCambioAdscripcion(Request $request){
            //dd($request);
            $update = SolicitudesController::UpdateDatosCGA($request);
            //dd($request['empresa_nps']);
            $update = DB::table('SOLICITUDES_CAMBIO_ADSCRIPCION')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'CAMBIO_ADSCRIPCION_CATEGORIA_NUEVA' => $request['categoria_solicitada'],
                            'CAMBIO_ADSCRIPCION_PUESTO_NUEVO' => $request['puesto_solicitado'],
                            'CAMBIO_ADSCRIPCION_SALARIO_NUEVO' => $request['salario_solicitado'],
                            'CAMBIO_ADSCRIPCION_ACTIVIDADES_NUEVAS' => $request['actividades'],
                            'CAMBIO_ADSCRIPCION_EMPRESA' => $request['empresa_nps'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
            $update = DB::table('SOLICITUDES_SOLICITUD')
                ->where('SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'SOLICITUD_NOMBRE' => $request['nombre_candidato'],
                            'SOLICITUD_CATEGORIA' => $request['categoria_actual'],
                            'SOLICITUD_PUESTO' => $request['puesto_actual'],
                            'SOLICITUD_SALARIO' => $request['salario_actual'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

            $responsable = \Session::get('responsable')[0];
            $movimiento = $responsable.' ha modificado los datos de la solicitud '.$request['id_sol'];
            SolicitudesController::InsertaMovimientoCGA($responsable,$movimiento,$request['id_sol']);

            $data = array(
                "update"=>$update
            );
            echo json_encode($data);//*/

        }

        public function GuardaDatosPromocion(Request $request){
            //dd($request);
            $update = SolicitudesController::UpdateDatosCGA($request);

            $update = DB::table('SOLICITUDES_PROMOCION')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'PROMOCION_CATEGORIA_SOLICITADA' => $request['categoria_solicitada'],
                            'PROMOCION_ACTIVIDADES_NUEVAS' => $request['actividades'],
                            'PROMOCION_SALARIO_NUEVO' => $request['salario_solicitado'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
            $update = DB::table('SOLICITUDES_SOLICITUD')
                ->where('SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'SOLICITUD_NOMBRE' => $request['nombre_candidato'],
                            'SOLICITUD_CATEGORIA' => $request['categoria_actual'],
                            'SOLICITUD_PUESTO' => $request['puesto_actual'],
                            'SOLICITUD_SALARIO' => $request['salario_actual'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

            $responsable = \Session::get('responsable')[0];
            $movimiento = $responsable.' ha modificado los datos de la solicitud '.$request['id_sol'];
            SolicitudesController::InsertaMovimientoCGA($responsable,$movimiento,$request['id_sol']);

            $data = array(
                "update"=>$update
            );
            echo json_encode($data);//*/

        }

        public function GuardaDatosSustitucion(Request $request){
            //dd($request);
            $update = SolicitudesController::UpdateDatosCGA($request);

            $update = DB::table('SOLICITUDES_SUSTITUCION')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'SUSTITUCION_CANDIDATO_NUEVO' => $request['candidato'],
                            'SUSTITUCION_CATEGORIA_NUEVA' => $request['categoria_solicitada'],
                            'SUSTITUCION_PUESTO_NUEVO' => $request['puesto_solicitado'],
                            'SUSTITUCION_ACTIVIDADES_NUEVAS' => $request['actividades'],
                            'SUSTITUCION_SALARIO_NUEVO' => $request['salario_solicitado'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
            $update = DB::table('SOLICITUDES_SOLICITUD')
                ->where('SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'SOLICITUD_NOMBRE' => $request['en_sustitucion_de'],
                            'SOLICITUD_SALARIO' => $request['salario_persona_anterior'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

            $responsable = \Session::get('responsable')[0];
            $movimiento = $responsable.' ha modificado los datos de la solicitud '.$request['id_sol'];
            SolicitudesController::InsertaMovimientoCGA($responsable,$movimiento,$request['id_sol']);

            $data = array(
                "update"=>$update
            );
            echo json_encode($data);//*/

        }

        public function GuardaDatosContratacion(Request $request){
            //dd($request['compensacion_solicitud']);
            //dd($request);
            $update = SolicitudesController::UpdateDatosCGA($request);
            //dd($request['actividades']);
            $update = DB::table('SOLICITUDES_SOLICITUD')
                ->where('SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'SOLICITUD_NOMBRE' => $request['candidato'],
                            'SOLICITUD_CATEGORIA' => $request['categoria_solicitada'],
                            'SOLICITUD_PUESTO' => $request['puesto_solicitado'],
                            'SOLICITUD_ACTIVIDADES' => $request['actividades'],
                            'SOLICITUD_SALARIO' => $request['salario_solicitado'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

            $responsable = \Session::get('responsable')[0];
            $movimiento = $responsable.' ha modificado los datos de la solicitud '.$request['id_sol'];
            SolicitudesController::InsertaMovimientoCGA($responsable,$movimiento,$request['id_sol']);

            $data = array(
                "update"=>$update
            );
            echo json_encode($data);//*/
        }

        public function UpdateDatosCGA($request){
            //dd($request['actividades']);
            date_default_timezone_set('America/Mexico_City');
            $update = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'DATOS_CGA_SALARIO_PROPUESTO' => $request['salario'],
                            'DATOS_CGA_CATEGORIA_PROPUESTA' => $request['categoria'],
                            'DATOS_CGA_PUESTO_PROPUESTO' => $request['puesto'],
                            'DATOS_CGA_PROCEDENTE' => $request['procede'],
                            'DATOS_CGA_RESPUESTA' => $request['respuesta'],
                            'DATOS_CGA_SALARIO_SUPERIOR' => $request['salario_superior'],
                            'DATOS_CGA_CATEGORIA_SUPERIOR' => $request['categoria_superior'],
                            'DATOS_CGA_SALARIO_INFERIOR' => $request['salario_inferior'],
                            'DATOS_CGA_CATEGORIA_INFERIOR' => $request['categoria_inferior'],
                            'DATOS_CGA_COMPENSACION' => $request['compensacion_solicitud'],
                            'DATOS_CGA_AHORRO' => $request['ahorro_solicitud'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

            return $update;
        }

        public function AbrirContratacion($id_solicitud){
            $categoria = \Session::get('categoria')[0];
            $id_solicitud = str_replace('_','/',$id_solicitud);
            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','CONTRATACIÓN')
                    ->get();
                //dd($val);
                if(count($val)>0){
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    //dd($solicitud);
                    return view('edicion_contratacion')->with("solicitud",$solicitud);
                }else{
                    return view('errors.404');
                }
            }else{
                return view('errors.505');
            }
            //dd($id_solicitud);

        }

        public function AbrirContratacionSustitucion($id_solicitud){
            $categoria = \Session::get('categoria')[0];
            $id_solicitud = str_replace('_','/',$id_solicitud);
            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','CONTRATACIÓN POR SUSTITUCIÓN')
                    ->get();
                //dd($val);
                if(count($val)>0){

                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    $datos_extra = SolicitudesController::ObtenerDatosSustitucion($id_solicitud);
                    //dd($datos_extra);
                    return view('edicion_contratacion_sustitucion') ->with (["solicitud"=>$solicitud,"datos_extra"=>$datos_extra]);
                }else{
                    return view('errors.404');
                }
            }else{
                return view('errors.505');
            }
        }

        public function AbrirPromocion($id_solicitud){
            $categoria = \Session::get('categoria')[0];
            $id_solicitud = str_replace('_','/',$id_solicitud);
            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','PROMOCION')
                    ->get();
                //dd($val);
                if(count($val)>0){
                    
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    $datos_extra = SolicitudesController::ObtenerDatosPromocion($id_solicitud);
                    //dd($datos_extra);
                    return view('edicion_promocion') ->with (["solicitud"=>$solicitud,"datos_extra"=>$datos_extra]);
                }else{
                    return view('errors.404');
                }
            }else{
                return view('errors.505');
            }
        }

        public function AbrirCambioAdscripcion($id_solicitud){
            $categoria = \Session::get('categoria')[0];
            $id_solicitud = str_replace('_','/',$id_solicitud);
            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA'])){
                $val = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->where('SOLICITUD_TIPO_SOLICITUD','CAMBIO DE ADSCRIPCIÓN')
                    ->get();
                //dd($val);
                if(count($val)>0){
                    
                    $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
                    $datos_extra = SolicitudesController::ObtenerDatosCambioAdscripcion($id_solicitud);
                    //dd($datos_extra);
                    return view('edicion_cambio_adscripcion') ->with (["solicitud"=>$solicitud,"datos_extra"=>$datos_extra]);//*/
                }else{
                    return view('errors.404');
                }
            }else{
                return view('errors.505');
            }
        }

        public function ObtenerDatosCambioAdscripcion($id_solicitud){
            //dd($id_solicitud);
            $datos = DB::table('SOLICITUDES_CAMBIO_ADSCRIPCION')
                ->where('FK_SOLICITUD_ID', $id_solicitud)
                ->select(
                            'CAMBIO_ADSCRIPCION_DEPENDENCIA_DESTINO as NUEVA_DEPENDENCIA',
                            'CAMBIO_ADSCRIPCION_CATEGORIA_NUEVA as NUEVA_CATEGORIA',
                            'CAMBIO_ADSCRIPCION_PUESTO_NUEVO as PUESTO_NUEVO',
                            'CAMBIO_ADSCRIPCION_ACTIVIDADES_NUEVAS as NUEVAS_ACTIVIDADES',
                            'CAMBIO_ADSCRIPCION_SALARIO_NUEVO as NUEVO_SALARIO',
                            'CAMBIO_ADSCRIPCION_EMPRESA as EMPRESA_NPS'
                        )
                ->get();
            //dd($datos);
            if(count($datos)>0){
                $dependencia = DependenciasController::ObtenerNombreDependencia($datos[0]->NUEVA_DEPENDENCIA);
                $datos[0]->NUEVA_DEPENDENCIA = $dependencia[0]->NOMBRE_DEPENDENCIA;
            }else{
                $datos[0]=null;
            }
            //dd($datos[0]->NUEVA_DEPENDENCIA);
            //dd($datos[0]);
            return $datos[0];
         }

        public function ObtenerDatosPromocion($id_solicitud){
            $datos = DB::table('SOLICITUDES_PROMOCION')
                ->where('FK_SOLICITUD_ID', $id_solicitud)
                ->select(
                            'PROMOCION_CATEGORIA_SOLICITADA as NUEVA_CATEGORIA',
                            'PROMOCION_PUESTO_NUEVO as PUESTO_NUEVO',
                            'PROMOCION_ACTIVIDADES_NUEVAS as NUEVAS_ACTIVIDADES',
                            'PROMOCION_SALARIO_NUEVO as NUEVO_SALARIO'
                        )
                ->get();
            if(count($datos)==0){
                $datos[0]==null;
            }
            return $datos[0];
         }

        public function ObtenerDatosSustitucion($id_solicitud){
            $datos = DB::table('SOLICITUDES_SUSTITUCION')
                ->where('FK_SOLICITUD_ID', $id_solicitud)
                ->select(
                            'SUSTITUCION_CANDIDATO_NUEVO as NUEVO_CANDIDATO',
                            'SUSTITUCION_CATEGORIA_NUEVA as NUEVA_CATEGORIA',
                            'SUSTITUCION_PUESTO_NUEVO as PUESTO_NUEVO',
                            'SUSTITUCION_ACTIVIDADES_NUEVAS as NUEVAS_ACTIVIDADES',
                            'SUSTITUCION_SALARIO_NUEVO as NUEVO_SALARIO'
                        )
                ->get();
            if(count($datos)==0){
                $datos[0]==null;
            }
            return $datos[0];
        }

        public function ObtenerSolicitudId($id_solicitud){
            date_default_timezone_set('America/Mexico_City');
            $DatosGenerales = SolicitudesController::DatosGenerales();
            $institucional = $DatosGenerales['institucional'];
            //dd($id_solicitud);
            $solicitud = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$id_solicitud)
                    ->select(
                                'SOLICITUD_ID as ID_SOLICITUD',
                                'SOLICITUD_OFICIO as OFICIO_SOLICITUD',
                                'SOLICITUD_NOMBRE as NOMBRE_SOLICITUD',
                                'SOLICITUD_DEPENDENCIA as DEPENDENCIA_SOLICITUD',
                                'SOLICITUD_CATEGORIA as CATEGORIA_SOLICITUD',
                                'SOLICITUD_PUESTO as PUESTO_SOLICITUD',
                                'SOLICITUD_ACTIVIDADES as ACTIVIDADES_SOLICITUD',
                                'SOLICITUD_NOMINA as NOMINA_SOLICITUD',
                                'SOLICITUD_SALARIO as SALARIO_SOLICITUD',
                                'SOLICITUD_JUSTIFICACION as JUSTIFICACION_SOLICITUD',
                                'SOLICITUD_TIPO_SOLICITUD as TIPO_SOLICITUD_SOLICITUD',
                                'SOLICITUD_FUENTE_RECURSOS as FUENTE_RECURSOS_SOLICITUD',
                                'SOLICITUD_URGENCIA as PRIORIDAD_SOLICITUD'
                            )
                    ->get();

            $dependencia = DependenciasController::ObtenerDatosDependencia($solicitud[0]->DEPENDENCIA_SOLICITUD);
            if($institucional){
                //dd('Modo Institucional');
                $solicitud[0]->NOMBRE_DEPENDENCIA = $dependencia->NOMBRE_DEPENDENCIA;
                $solicitud[0]->NOMBRE_INTERNO_DEPENDENCIA = $dependencia->NOMBRE_DEPENDENCIA;
            }else{
                //dd('Modo NPS');
                $solicitud[0]->NOMBRE_DEPENDENCIA = $dependencia->CODIGO_DEPENDENCIA;
                $solicitud[0]->NOMBRE_INTERNO_DEPENDENCIA = $dependencia->NOMBRE_DEPENDENCIA;
            }

            //dd($solicitud[0]);

            if(strcmp($solicitud[0]->TIPO_SOLICITUD_SOLICITUD, 'CONTRATACIÓN POR SUSTITUCIÓN')==0){
                $sustitucion = SolicitudesController::ObtenerDatosSustitucion($id_solicitud);
                //dd($sustitucion);
                $solicitud[0]->EN_SUSTITUCION_DE = $solicitud[0]->NOMBRE_SOLICITUD;
                $solicitud[0]->NOMBRE_SOLICITUD = $sustitucion->NUEVO_CANDIDATO;
            }
            //dd($dependencia);
            $solicitud[0]->ID_ESCAPE = str_replace('/','_',$solicitud[0]->ID_SOLICITUD);
            $solicitud[0]->SALARIO_FORMATO = number_format($solicitud[0]->SALARIO_SOLICITUD,2);
            //$solicitud[0]->SALARIO_SOLICITUD = 0;
            //echo 'DE: ', $formatter->formatCurrency($amount, 'EUR'), PHP_EOL;
            $fechas = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();
            //dd($fechas[0]);
            $solicitud[0]->FECHA_CREACION = date("d/m/Y", strtotime($fechas[0]->FECHAS_CREACION_SOLICITUD));
            $solicitud[0]->FECHA_CREACION_SF = $fechas[0]->FECHAS_CREACION_SOLICITUD;
            $solicitud[0]->FECHAS_INFORMACION_COMPLETA = (($fechas[0]->FECHAS_INFORMACION_COMPLETA)?date("d/m/Y", strtotime($fechas[0]->FECHAS_INFORMACION_COMPLETA)):'');

            $solicitud[0]->FECHA_TURNADO_CGA = (($fechas[0]->FECHAS_TURNADO_CGA)?date("d/m/Y", strtotime($fechas[0]->FECHAS_TURNADO_CGA)):'');

            $solicitud[0]->FECHA_ENVIO = date("d/m/Y", strtotime($fechas[0]->FECHAS_TURNADO_SPR));

            $datos_cga = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();

            $solicitud[0]->CATEGORIA_PROPUESTA = $datos_cga[0]->DATOS_CGA_CATEGORIA_PROPUESTA;
            $solicitud[0]->PUESTO_PROPUESTO = $datos_cga[0]->DATOS_CGA_PUESTO_PROPUESTO;
            $solicitud[0]->SALARIO_PROPUESTO = number_format($datos_cga[0]->DATOS_CGA_SALARIO_PROPUESTO,2);
            $solicitud[0]->SALARIO_PROPUESTO_SF = $datos_cga[0]->DATOS_CGA_SALARIO_PROPUESTO;
            $solicitud[0]->ESTATUS_PROCEDE = $datos_cga[0]->DATOS_CGA_PROCEDENTE;
            //dd($solicitud[0]->ESTATUS_PROCEDE);
            $solicitud[0]->RESPUESTA_CGA = $datos_cga[0]->DATOS_CGA_RESPUESTA;
            $solicitud[0]->CATEGORIA_SUPERIOR = $datos_cga[0]->DATOS_CGA_CATEGORIA_SUPERIOR;
            $solicitud[0]->SALARIO_SUPERIOR = $datos_cga[0]->DATOS_CGA_SALARIO_SUPERIOR;
            $solicitud[0]->CATEGORIA_INFERIOR = $datos_cga[0]->DATOS_CGA_CATEGORIA_INFERIOR;
            $solicitud[0]->SALARIO_INFERIOR = $datos_cga[0]->DATOS_CGA_SALARIO_INFERIOR;
            $solicitud[0]->ESTATUS_SOLICITUD = $datos_cga[0]->DATOS_CGA_ESTATUS;//estatus
            $solicitud[0]->AHORRO_SOLICITUD = $datos_cga[0]->DATOS_CGA_AHORRO;
            $solicitud[0]->COMPENSACION_SOLICITUD = $datos_cga[0]->DATOS_CGA_COMPENSACION;
            $solicitud[0]->HOY = date('d/m/Y');

            $solicitud[0]->CLASE_TR = SolicitudesController::VerificaTiempo($datos_cga[0]->DATOS_CGA_ESTATUS,$id_solicitud,$solicitud[0]->PRIORIDAD_SOLICITUD);

            $rel_analista = DB::table('REL_SOLICITUDES_ANALISTA')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->select('FK_USUARIO')
                ->get();
            if(count($rel_analista)>0){
                $analista = DB::table('SOLICITUDES_LOGIN')
                ->where('LOGIN_USUARIO',$rel_analista[0]->FK_USUARIO)
                ->select('LOGIN_RESPONSABLE')
                ->get();
                $solicitud[0]->ANALISTA_SOLICITUD = $analista[0]->LOGIN_RESPONSABLE;
            }else{
                $solicitud[0]->ANALISTA_SOLICITUD = 'SIN ASIGNAR';
            }

            $firmas = DB::table('SOLICITUDES_FIRMAS')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();
            if(count($firmas)>0){
                $solicitud[0]->FIRMA_CGA = $firmas[0]->FIRMAS_CGA;
                $solicitud[0]->FIRMA_TITULAR = $firmas[0]->FIRMAS_TITULAR;
                $solicitud[0]->FIRMA_SPR = $firmas[0]->FIRMAS_SPR;
            }/*else{
                $solicitud[0]->FIRMA_CGA = null;
                $solicitud[0]->FIRMA_TITULAR = null;
                $solicitud[0]->FIRMA_SPR = null;
            }//*/

            return $solicitud[0];
        }

        public function VerificaTiempo($estatus,$solicitud,$prioridad){
            //$solicitud = 'SOL/2/2019';
            //dd($prioridad);
            date_default_timezone_set('America/Mexico_City');
            //dd($estatus);
            $estatus_fechas='NO IDENTIFICADO';//estatus que arroja la tabla fechas
            $color = '--';
            $retraso = 'danger';
            $adelanto = 'success';
            if(in_array($estatus, ['RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','TURNADO A SPR'])){
                $fechas = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID',$solicitud)
                    ->get();
                //dd($fechas[0]);
                $hoy = date('Y-m-d');
                //dd($hoy);
                //$hoy = '2019-03-17';
                //$hoy = '2019-04-04';
                $fechas = $fechas[0];
                //$estatus = 'FIRMAS';
                //if(strcmp($prioridad, 'PRIORIDAD 2')==0){
                if(true){
                    //dd($estatus);
                    //dd($fechas->FECHAS_LIMITE_AGENDAR_CITA);
                    if(SolicitudesController::check_in_range($fechas->FECHAS_INFORMACION_COMPLETA, $fechas->FECHAS_LIMITE_AGENDAR_CITA, $hoy,'RECIBIDO')){
                        //dd('Estamos en tiempo, el limite es: '.$fechas->FECHAS_LIMITE_AGENDAR_CITA);
                        $estatus_fechas = "RECIBIDO";
                        if(in_array($estatus, ['LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','TURNADO A SPR'])){
                            $color = $adelanto;
                            //dd('Solicitud ADELANTADA: '.$estatus_fechas);
                        }else{
                            //dd('Solicitud EN TIEMPO: '.$estatus_fechas);
                        }
                        //dd($estatus_fechas);
                    }else if(SolicitudesController::check_in_range($fechas->FECHAS_LIMITE_AGENDAR_CITA, $fechas->FECHAS_LIMITE_LEVANTAMIENTO, $hoy,'LEVANTAMIENTO')){
                        $estatus_fechas = "LEVANTAMIENTO";
                        if(in_array($estatus, ['RECIBIDO'])){
                            //dd('Solicitud RETRASADA '.$estatus_fechas);
                            $color = $retraso;
                        }else if(in_array($estatus, ['ANÁLISIS','REVISIÓN','FIRMAS','TURNADO A SPR'])){
                            //dd('Solicitud ADELANTADA: '.$estatus_fechas);
                            $color = $adelanto;
                        }else{
                            //dd('Solicitud EN TIEMPO: '.$estatus_fechas);
                        }
                        //dd($estatus_fechas);
                        //dd('Estamos en tiempo, el limite es: '.$fechas->FECHAS_LIMITE_AGENDAR_CITA);
                    }else if(SolicitudesController::check_in_range($fechas->FECHAS_LIMITE_LEVANTAMIENTO, $fechas->FECHAS_LIMITE_ANALISIS, $hoy,'ANÁLISIS')){
                        $estatus_fechas = "ANÁLISIS";
                        if(in_array($estatus, ['RECIBIDO','LEVANTAMIENTO'])){
                            //dd('Solicitud RETRASADA '.$estatus_fechas);
                            $color = $retraso;
                        }else if(in_array($estatus, ['REVISIÓN','FIRMAS','TURNADO A SPR'])){
                            //dd('Solicitud ADELANTADA: '.$estatus_fechas);
                            $color = $adelanto;
                        }else{
                            //dd('Solicitud EN TIEMPO: '.$estatus_fechas);
                        }
                        //dd($estatus_fechas);
                        //dd('Estamos en tiempo, el limite es: '.$fechas->FECHAS_LIMITE_AGENDAR_CITA);
                    }else if(SolicitudesController::check_in_range($fechas->FECHAS_LIMITE_ANALISIS, $fechas->FECHAS_LIMITE_REVISION, $hoy,'REVISIÓN')){
                        $estatus_fechas = "REVISIÓN";
                        if(in_array($estatus, ['RECIBIDO','LEVANTAMIENTO','ANÁLISIS'])){
                            //dd('Solicitud RETRASADA '.$estatus_fechas);
                            $color = $retraso;
                        }else if(in_array($estatus, ['FIRMAS','TURNADO A SPR'])){
                            //dd('Solicitud ADELANTADA: '.$estatus_fechas);
                            $color = $adelanto;
                        }else{
                            //dd('Solicitud EN TIEMPO: '.$estatus_fechas);
                        }
                        //dd($estatus_fechas);
                        //dd('Estamos en tiempo, el limite es: '.$fechas->FECHAS_LIMITE_AGENDAR_CITA);
                    }else if(SolicitudesController::check_in_range($fechas->FECHAS_LIMITE_REVISION, $fechas->FECHAS_LIMITE_FIRMAS, $hoy,'FIRMAS')){
                        $estatus_fechas = "FIRMAS";
                        if(in_array($estatus, ['RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN'])){
                            //dd('Solicitud RETRASADA '.$estatus_fechas);
                            $color = $retraso;
                        }else if(in_array($estatus, ['TURNADO A SPR'])){
                            //dd('Solicitud ADELANTADA: '.$estatus_fechas);
                            $color = $adelanto;
                        }else{
                            //dd('Solicitud EN TIEMPO: '.$estatus_fechas);
                        }
                        //dd($estatus_fechas);
                        //dd('Estamos en tiempo, el limite es: '.$fechas->FECHAS_LIMITE_AGENDAR_CITA);
                    }else if(SolicitudesController::check_in_range($fechas->FECHAS_LIMITE_FIRMAS, $fechas->FECHAS_LIMITE_FINALIZAR, $hoy,'FINALIZAR SPR')){
                        $estatus_fechas = "FINALIZAR SPR";
                        if(in_array($estatus, ['RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','TURNADO A SPR'])){
                            //dd('Solicitud RETRASADA: '.$estatus_fechas);
                            $color = $retraso;
                        }else{
                            //dd('Solicitud EN TIEMPO: '.$estatus_fechas);
                        }
                        //dd($estatus_fechas);
                        //dd('Estamos en tiempo, el limite es: '.$fechas->FECHAS_LIMITE_AGENDAR_CITA);
                    }else{
                        //este estatus es cuando la solicitud ya debió haber sido atendida
                        $estatus_fechas = "COMPLETADO POR SPR";
                        if(in_array($estatus, ['RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','TURNADO A SPR'])){
                            //dd('Solicitud RETRASADA: '.$estatus_fechas);
                            $color = $retraso;
                        }
                        //dd('epale');
                    }
                }else{
                    //dd($fechas);
                }
                //dd($estatus_fechas);

            }else if(in_array($estatus, ['CANCELADO POR TITULAR'])){
                $color = 'warning';
            }
            return $color;
            //dd('No es apto para estatus');
        }
        function check_in_range($fecha_inicio, $fecha_fin, $fecha,$estatus){
            if(strcmp($estatus, 'RECIBIDO')!=0){
                //dd($estatus);
                $fecha_inicio = strtotime($fecha_inicio."+ 1 days");
            }else{
                //dd($estatus);
                $fecha_inicio = strtotime($fecha_inicio);
            }
            $fecha_fin = strtotime($fecha_fin);
            $fecha = strtotime($fecha);

            if(($fecha >= $fecha_inicio) && ($fecha <= $fecha_fin)) {

                return true;

            }else{

                return false;

            }
        }

        public function ValidacionRectoria(Request $request){
            
            $update = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['DATOS_CGA_ESTATUS' => 'COMPLETADO POR SPR']);

            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/

        }

        public function ValidarSolicitudDependencia(Request $request){
            date_default_timezone_set('America/Mexico_City');
            $usuario = \Session::get('responsable')[0];
            //$usuario = 'USUARIO TITULAR';//aqui se debe poner el nombre del usuario de SPR

            $update = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['FECHAS_FIRMA_TITULAR' => date('Y-m-d H:i:s')]);

            $existeFirma = DB::table('SOLICITUDES_FIRMAS')->where('FK_SOLICITUD_ID', $request['id_sol'])->get();
            if(count($existeFirma)==0){
                //dd('nuevo');
                DB::table('SOLICITUDES_FIRMAS')
                    ->insert(
                                [
                                    'FK_SOLICITUD_ID' => $request['id_sol'], 
                                    'FIRMAS_TITULAR' => $usuario
                                ]
                            );
            }else{
                //dd('update');
                $update = DB::table('SOLICITUDES_FIRMAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FIRMAS_TITULAR' => $usuario]);
                    
                $verificaCompletado = DB::table('SOLICITUDES_FIRMAS')->where('FK_SOLICITUD_ID', $request['id_sol'])->get();
                //dd($verificaCompletado);
                if($verificaCompletado[0]->FIRMAS_CGA&&$verificaCompletado[0]->FIRMAS_TITULAR&&$verificaCompletado[0]->FIRMAS_SPR){
                    //dd('SE HA COMPLETADO LAS FIRMAS');
                    $update = DB::table('SOLICITUDES_DATOS_CGA')
                        ->where('FK_SOLICITUD_ID', $request['id_sol'])
                        ->update(['DATOS_CGA_ESTATUS' => 'TURNADO A SPR']);
                    $update = DB::table('SOLICITUDES_FECHAS')
                        ->where('FK_SOLICITUD_ID', $request['id_sol'])
                        ->update(['FECHAS_TURNADO_SPR' => date('Y-m-d H:i:s')]);
                }else{
                    //dd('FALTAN FIRMAS');
                }
            }

            $responsable = \Session::get('responsable')[0];
            $movimiento = 'Titular '.$responsable.' ha validado la solicitud';
            SolicitudesController::InsertaMovimientoGeneral($responsable,$movimiento,$request['id_sol']);


            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function ValidarSolicitudCGA(Request $request){
            date_default_timezone_set('America/Mexico_City');
            $usuario = \Session::get('responsable')[0];
            //$usuario = 'USUARIO COORDINADOR';//aqui se debe poner el nombre del usuario de SPR

            $update = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['FECHAS_FIRMA_CGA' => date('Y-m-d H:i:s')]);

            $existeFirma = DB::table('SOLICITUDES_FIRMAS')->where('FK_SOLICITUD_ID', $request['id_sol'])->get();
            if(count($existeFirma)==0){
                //dd('nuevo');
                DB::table('SOLICITUDES_FIRMAS')
                    ->insert(
                                [
                                    'FK_SOLICITUD_ID' => $request['id_sol'], 
                                    'FIRMAS_CGA' => $usuario
                                ]
                            );
            }else{
                //dd('update');
                $update = DB::table('SOLICITUDES_FIRMAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FIRMAS_CGA' => $usuario]);
                    
                $verificaCompletado = DB::table('SOLICITUDES_FIRMAS')->where('FK_SOLICITUD_ID', $request['id_sol'])->get();
                //dd($verificaCompletado);
                if($verificaCompletado[0]->FIRMAS_CGA&&$verificaCompletado[0]->FIRMAS_TITULAR&&$verificaCompletado[0]->FIRMAS_SPR){
                    //dd('SE HA COMPLETADO LAS FIRMAS');
                    $update = DB::table('SOLICITUDES_DATOS_CGA')
                        ->where('FK_SOLICITUD_ID', $request['id_sol'])
                        ->update(['DATOS_CGA_ESTATUS' => 'TURNADO A SPR']);
                    $update = DB::table('SOLICITUDES_FECHAS')
                        ->where('FK_SOLICITUD_ID', $request['id_sol'])
                        ->update(['FECHAS_TURNADO_SPR' => date('Y-m-d H:i:s')]);
                }else{
                    //dd('FALTAN FIRMAS');
                }
            }

            $responsable = \Session::get('responsable')[0];
            $movimiento = 'Coordinador General Administrativo '.$responsable.' ha validado la solicitud';
            SolicitudesController::InsertaMovimientoGeneral($responsable,$movimiento,$request['id_sol']);


            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }


        public function ValidarSolicitudSPR(Request $request){
            date_default_timezone_set('America/Mexico_City');
            $usuario = \Session::get('responsable')[0];
            //$usuario = 'USUARIO SPR';//aqui se debe poner el nombre del usuario de SPR

            /*$update = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['DATOS_CGA_ESTATUS' => 'FIRMAS']);//*/

            $update = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['FECHAS_FIRMA_SPR' => date('Y-m-d H:i:s')]);

            $existeFirma = DB::table('SOLICITUDES_FIRMAS')->where('FK_SOLICITUD_ID', $request['id_sol'])->get();
            if(count($existeFirma)==0){
                //dd('nuevo');
                DB::table('SOLICITUDES_FIRMAS')
                    ->insert(
                                [
                                    'FK_SOLICITUD_ID' => $request['id_sol'], 
                                    'FIRMAS_SPR' => $usuario
                                ]
                            );//*/
                //if($existeFirma[0]->)
            }else{
                //dd('update');
                $update = DB::table('SOLICITUDES_FIRMAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FIRMAS_SPR' => $usuario]);

                $verificaCompletado = DB::table('SOLICITUDES_FIRMAS')->where('FK_SOLICITUD_ID', $request['id_sol'])->get();
                //dd($verificaCompletado);
                if($verificaCompletado[0]->FIRMAS_CGA&&$verificaCompletado[0]->FIRMAS_TITULAR&&$verificaCompletado[0]->FIRMAS_SPR){
                    //dd('SE HA COMPLETADO LAS FIRMAS');
                    $update = DB::table('SOLICITUDES_DATOS_CGA')
                        ->where('FK_SOLICITUD_ID', $request['id_sol'])
                        ->update(['DATOS_CGA_ESTATUS' => 'TURNADO A SPR']);
                    $update = DB::table('SOLICITUDES_FECHAS')
                        ->where('FK_SOLICITUD_ID', $request['id_sol'])
                        ->update(['FECHAS_TURNADO_SPR' => date('Y-m-d H:i:s')]);
                }else{
                    //dd('FALTAN FIRMAS');
                }
            }

            $responsable = \Session::get('responsable')[0];
            $movimiento = 'Secretario Particular '.$responsable.' ha validado la solicitud';
            SolicitudesController::InsertaMovimientoGeneral($responsable,$movimiento,$request['id_sol']);


            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function EliminarFirmas($id_solicitud){

            $existeFirma = DB::table('SOLICITUDES_FIRMAS')->where('FK_SOLICITUD_ID', $id_solicitud)->get();
            if(count($existeFirma)!=0){
                DB::table('SOLICITUDES_FIRMAS')
                    ->where('FK_SOLICITUD_ID', $id_solicitud)
                    ->delete();//*/
                //dd('Epale');
                $update = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID', $id_solicitud)
                    ->update([
                                'FECHAS_PUESTO_FIRMAS' => null,
                                'FECHAS_FIRMA_CGA' => null,
                                'FECHAS_FIRMA_TITULAR' => null,
                                'FECHAS_FIRMA_SPR' => null
                            ]);
            }
        }

        public function ObtenerTitularDeSolicitud($id_solicitud){
            $titular = null;
            $rel_dep = DB::table('REL_DEPENCENCIA_SOLICITUD')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();
            //dd($rel_dep);
            if(count($rel_dep)>0){
                $rel_titular = DB::table('REL_DEPENCENCIA_TITULAR')
                    ->where('FK_DEPENDENCIA',$rel_dep[0]->FK_DEPENDENCIA)
                    ->get();
                    //dd($rel_titular);
                if(count($rel_titular)>0){
                    $titular = $rel_titular[0]->FK_USUARIO;
                }
            }
            return $titular;
        }

        public function NotificarFirmasTitular($id_solicitud){
            $asunto = 'Cambio de estatus';
            $titulo = 'Cambio de estatus';
            $mensaje = 'Buen día, le notificamos que el estatus de la solicitud '.$id_solicitud.' ha cambiado a FIRMAS, ya está disponible la opinión de la Coordinación General Administrativa';
            $usuario = SolicitudesController::ObtenerTitularDeSolicitud($id_solicitud);
            //dd($usuario);
            $mail = MailsController::MandarMensajeGenerico($asunto,$titulo,$mensaje,$usuario);
            return $usuario;
        }

        public function CancelacionNormalTitular(Request $request){
            $update = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['DATOS_CGA_ESTATUS' => 'CANCELADO']);
            //dd($request['motivo']);
            $responsable = \Session::get('responsable')[0];
            $movimiento ='Titular '.$responsable.' ha cancelado la solicitud, el motivo de la cancelación es: '.$request['motivo'];
            //dd($movimiento);
            SolicitudesController::InsertaMovimientoGeneral($responsable,$movimiento,$request['id_sol']);
            $analista = DB::table('REL_SOLICITUDES_ANALISTA')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->get();
            if(count($analista)>0){
                //dd($analista[0]->FK_USUARIO);
                $usuario = $analista[0]->FK_USUARIO;
                $asunto = 'Cancelación de solicitud';
                $titulo = 'Cancelación de solicitud';
                $mensaje = 'Buen día, le notificamos que la solicitud '.$request['id_sol'].' ha sido cancelada por el titular de la dependencia, si desea saber más detalles, por favor utilice la función de movimientos.';
                //dd($usuario);
                $mail = MailsController::MandarMensajeGenerico($asunto,$titulo,$mensaje,$usuario);
            }


            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/

        }

        public function CambiarEstadoCGA(Request $request){
            date_default_timezone_set('America/Mexico_City');
            //dd($request['estatus']);
            $update = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['DATOS_CGA_ESTATUS' => $request['estatus']]);
            //dd($update);
            $mail = null;

            if(strcmp($request['estatus'],'TURNADO A SPR')==0){
                $update_turnadospr = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FECHAS_TURNADO_SPR' => date('Y-m-d H:i:s')]);
            }//*/

            if(strcmp($request['estatus'],'REVISIÓN')==0){
                $update_revision = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FECHAS_PUESTO_REVISION' => date('Y-m-d H:i:s')]);//*/
                    //reseteando las firmas

                //SolicitudesController::EliminarFirmas($request['id_sol']);
            }//*/
            $fl_usr = null;
            if(strcmp($request['estatus'],'FIRMAS')==0){
                $update_firmas = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FECHAS_PUESTO_FIRMAS' => date('Y-m-d H:i:s')]);//*
                $fl_usr = SolicitudesController::NotificarFirmasTitular($request['id_sol']);
                //SolicitudesController::EliminarFirmas($request['id_sol']);
                //enviar coorreo electrónico
            }//*/

            if(in_array($request['estatus'], ['RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','CANCELADO POR TITULAR','CANCELADO','OTRO'])){
                SolicitudesController::EliminarFirmas($request['id_sol']);
            }

            if($update==1){
                //dd('Hubo Cambio');
                if(strcmp($request['estatus'], 'VALIDACIÓN DE INFORMACIÓN')==0){
                    $responsable = \Session::get('responsable')[0];
                    $movimiento = $responsable.' ha turnado la solicitud a CGA';
                    $id_mov = SolicitudesController::InsertaMovimientoSPR($responsable,$movimiento,$request['id_sol']);
                }

                //verificar si informacion correcta se marca o es en recibido directamente
                if(in_array($request['estatus'], ['INFORMACIÓN CORRECTA','RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','CANCELADO','OTRO'])){
                    $responsable = \Session::get('responsable')[0];
                    $categoria = \Session::get('categoria')[0];
                    $movimiento = $responsable.' ha cambiado el estatus a '.$request['estatus'];
                    if(in_array($categoria, ['TRABAJADOR_SPR']) && strcmp($request['estatus'], 'REVISIÓN')){
                        $movimiento = $responsable.' ha regresado la solicitud a CGA para su revisión';
                        SolicitudesController::InsertaMovimientoGeneral($responsable,$movimiento,$request['id_sol']);

                    }else{
                        SolicitudesController::InsertaMovimientoCGA($responsable,$movimiento,$request['id_sol']);
                    }
                }

                if(strcmp($request['estatus'], 'CANCELADO POR TITULAR')==0){
                    $responsable = \Session::get('responsable')[0];
                    $movimiento = 'Titular '.$responsable.' ha cambiado el estatus a '.$request['estatus'];
                    SolicitudesController::InsertaMovimientoCGA($responsable,$movimiento,$request['id_sol']);
                }

                if(strcmp($request['estatus'], 'COMPLETADO POR SPR')==0){
                    $responsable = \Session::get('responsable')[0];
                    $movimiento = $responsable.' ha marcado la solicitud como válida';
                    SolicitudesController::InsertaMovimientoSPR($responsable,$movimiento,$request['id_sol']);
                }

                if(strcmp($request['estatus'], 'COMPLETADO POR RECTOR')==0){
                    $responsable = \Session::get('responsable')[0];
                    $movimiento = $responsable.' ha marcado la solicitud como entregada al rector';
                    SolicitudesController::InsertaMovimientoSPR($responsable,$movimiento,$request['id_sol']);
                }
            }

            $data = array(
                "update"=>$update,
                "fl_usr"=>$fl_usr,
                "mail"=>$mail
            );

            echo json_encode($data);//*/
        }


        public function InsertaMovimientoGeneral($responsable,$movimiento,$id_solicitud){
            date_default_timezone_set('America/Mexico_City');
            $id_mov = DB::table('SOLICITUDES_MOVIMIENTOS')->insertGetId(
                [
                    'MOVIMIENTOS_RESPONSABLE' => $responsable,
                    'MOVIMIENTOS_MOVIMIENTO' => $movimiento,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
            DB::table('REL_MOVIMIENTOS_CGA')->insert(
                [
                    'FK_MOVIMIENTO' => $id_mov,
                    'FK_SOLICITUD_ID' => $id_solicitud
                ]
            );
            DB::table('REL_MOVIMIENTOS_SPR')->insert(
                [
                    'FK_MOVIMIENTO' => $id_mov,
                    'FK_SOLICITUD_ID' => $id_solicitud
                ]
            );
            return $id_mov;
        }


        public function InsertaMovimientoCGA($responsable,$movimiento,$id_solicitud){
            date_default_timezone_set('America/Mexico_City');
            $id_mov = DB::table('SOLICITUDES_MOVIMIENTOS')->insertGetId(
                [
                    'MOVIMIENTOS_RESPONSABLE' => $responsable,
                    'MOVIMIENTOS_MOVIMIENTO' => $movimiento,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
            DB::table('REL_MOVIMIENTOS_CGA')->insert(
                [
                    'FK_MOVIMIENTO' => $id_mov,
                    'FK_SOLICITUD_ID' => $id_solicitud
                ]
            );
            return $id_mov;
        }

        public function InsertaMovimientoSPR($responsable,$movimiento,$id_solicitud){
            date_default_timezone_set('America/Mexico_City');
            $id_mov = DB::table('SOLICITUDES_MOVIMIENTOS')->insertGetId(
                [
                    'MOVIMIENTOS_RESPONSABLE' => $responsable,
                    'MOVIMIENTOS_MOVIMIENTO' => $movimiento,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
            DB::table('REL_MOVIMIENTOS_SPR')->insert(
                [
                    'FK_MOVIMIENTO' => $id_mov,
                    'FK_SOLICITUD_ID' => $id_solicitud
                ]
            );
        }//*/

        public function VistaCrearContratacion(){
            $categoria = \Session::get('categoria')[0];
            $fl_horario = SolicitudesController::VerificarHorario();
            if(in_array($categoria, ['TITULAR','TRABAJADOR_SPR'])){
                if(!$fl_horario){
                    return view('errors.timeout');
                }else{
                    $dependencias = DependenciasController::ObtenerSoloDependencias();
                    return view('nuevo_contratacion')->with(["dependencias"=>$dependencias]);
                }
            }else{
                return view('errors.505');
            }
        }

        public function VistaCrearSustitucion(){
            $categoria = \Session::get('categoria')[0];
            $fl_horario = SolicitudesController::VerificarHorario();
            if(in_array($categoria, ['TITULAR','TRABAJADOR_SPR'])){
                if(!$fl_horario){
                    return view('errors.timeout');
                }else{
                    $dependencias = DependenciasController::ObtenerSoloDependencias();
                    return view('nuevo_sustitucion')->with(["dependencias"=>$dependencias]);
                }
            }else{
                return view('errors.505');
            }
        }

        public function VistaCrearPromocion(){
            $categoria = \Session::get('categoria')[0];
            $fl_horario = SolicitudesController::VerificarHorario();
            if(in_array($categoria, ['TITULAR','TRABAJADOR_SPR'])){
                if(!$fl_horario){
                    return view('errors.timeout');
                }else{
                    $dependencias = DependenciasController::ObtenerSoloDependencias();
                    return view('nuevo_promocion')->with(["dependencias"=>$dependencias]);
                }
            }else{
                return view('errors.505');
            }
        }

        public function VistaCrearCambioAdscripcion(){
            $fl_horario = SolicitudesController::VerificarHorario();
            $categoria = \Session::get('categoria')[0];
            $datos = SolicitudesController::DatosGenerales();
            $institucional = $datos['institucional'];
            //dd($institucional);
            if(in_array($categoria, ['TITULAR','TRABAJADOR_SPR'])){
                if(!$fl_horario){
                    return view('errors.timeout');
                }else{
                    $dependencias = DependenciasController::ObtenerSoloDependencias();
                    return view('nuevo_cambio_adscripcion') ->with (["dependencias"=>$dependencias,"institucional"=>$institucional]);
                }
            }else{
                return view('errors.505');
            }
        }

        public function VistaUsuarios(){
            $categoria = \Session::get('categoria')[0];
            if(strcmp($categoria, 'ADMINISTRADOR_CGA')==0){

                $dependencias = DependenciasController::ObtenerSoloDependencias();
                $usuarios = DB::table('SOLICITUDES_LOGIN')
                    ->select(
                                'LOGIN_USUARIO as NOMBRE_USUARIO',
                                'LOGIN_RESPONSABLE as RESPONSABLE_USUARIO',
                                'LOGIN_CATEGORIA as CATEGORIA_USUARIO'
                            )
                    ->get();
                foreach ($usuarios as $usuario) {
                    switch ($usuario->CATEGORIA_USUARIO) {
                        case 'ADMINISTRADOR_CGA':
                                $usuario->CATEGORIA_USUARIO = 'ADMINISTRADOR CGA';
                            break;
                        case 'COORDINADOR_CGA':
                                $usuario->CATEGORIA_USUARIO = 'COORDINADOR CGA';
                            break;
                        case 'ANALISTA_CGA':
                                $usuario->CATEGORIA_USUARIO = 'ANALISTA CGA';
                            break;
                        case 'SECRETARIO_PARTICULAR':
                                $usuario->CATEGORIA_USUARIO = 'SECRETARIO PARTICULAR';
                            break;
                        case 'TRABAJADOR_SPR':
                                $usuario->CATEGORIA_USUARIO = 'ENCARGADO DE SPR';
                            break;
                        case 'TITULAR':
                                $usuario->CATEGORIA_USUARIO = 'TITULAR DE DEPENDENCIA';
                            break;
                        
                        default:
                            
                            break;
                    }
                }
                //dd($usuarios);
                return view('listado_usuarios') ->with (["usuarios"=>$usuarios,"dependencias"=>$dependencias]);
                //return view('listado_nuevas') ->with ("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }

        public function VistaNuevasSPR(){

            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['TRABAJADOR_SPR','SECRETARIO_PARTICULAR'])){
                $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('RECIBIDO SPR');
                return view('listado_nuevas') ->with ("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }

        public function VistaPorRevisarSPR(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['TRABAJADOR_SPR','SECRETARIO_PARTICULAR'])){
                $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('TURNADO A SPR');
                return view('listado_por_revisar') ->with ("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }

        public function VistaCompletadasRector(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['TRABAJADOR_SPR','SECRETARIO_PARTICULAR'])){
                $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('COMPLETADO POR RECTOR');
                return view('listado_completadas_rector') ->with ("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }

        public function VistaRevisadasSPR(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['TRABAJADOR_SPR','SECRETARIO_PARTICULAR'])){
                $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('COMPLETADO POR SPR');
                return view('listado_revisadas') ->with ("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }

        
        public function VistaListadoRevisionInformacion(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['ADMINISTRADOR_CGA','ANALISTA_CGA'])){
                $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('VALIDACION DE INFORMACION');
                return view('listado_revision_informacion') ->with ("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }
        
        public function VistaListadoDependencia(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['TITULAR'])){
                $id_dependencia = \Session::get('id_dependencia')[0];
                $solicitudes = SolicitudesController::ObtenerSolicitudesDependencia($id_dependencia);
                return view('listado_dependencia')->with("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }
        
        public function VistaListadoSecretarioParticular(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['SECRETARIO_PARTICULAR'])){
                //$solicitudes = SolicitudesController::ObtenerSolicitudes();
                $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('FIRMAS');
                return view('listado_secretario_particular')->with("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }
        
        public function VistaListadoSprFirmadas(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['SECRETARIO_PARTICULAR'])){
                //$solicitudes = SolicitudesController::ObtenerSolicitudes();
                //$solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('FIRMAS');
                $solicitudes = SolicitudesController::ObtenerSolicitudesFirmadas('SPR');
                //dd($solicitudes);
                return view('listado_solicitudes_firmadas')->with("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }
        
        public function VistaListadoCGA(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['COORDINADOR_CGA'])){
                $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('FIRMAS');
                return view('listado_cga')->with("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }

        public function VistaListadoEnProceso(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['TRABAJADOR_SPR'])){
                $solicitudes = SolicitudesController::ObtenerSolicitudes();
                return view('listado_en_proceso') ->with ("solicitudes",$solicitudes);
            }else{
                return view('errors.505');
            }
        }


        public function ObtenerSolicitudesEstatus($estatus){

            $datos_cga = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('DATOS_CGA_ESTATUS',$estatus)
                ->orderBy('created_at', 'asc')
                ->get();
            $solicitud = array();
            //dd($datos_cga);
            foreach ($datos_cga as $datos) {
                $solicitud[$datos->FK_SOLICITUD_ID]=SolicitudesController::ObtenerSolicitudId($datos->FK_SOLICITUD_ID);
            }
            return $solicitud;
        }


        public function VistaListadoCompleto(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['ADMINISTRADOR_CGA','COORDINADOR_CGA'])){
                $solicitudes = SolicitudesController::ObtenerSolicitudes();
                $analistas = LoginController::ObtenerListadoAnalistas();
                return view('listado_completo') ->with (["solicitudes"=>$solicitudes,"analistas"=>$analistas]);
            }else{
                return view('errors.505');
            }
        }

        public function VistaGeneralEstatus($estatus){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA'])){

                if(strcasecmp($estatus, 'turnado_spr')==0){
                    $estatus = 'turnado a spr';
                }else if(strcasecmp($estatus, 'completado_rector')==0){
                    $estatus = 'completado por rector';
                }
                //dd($estatus);
                $permitidos = ['recibido','levantamiento','analisis','revision','firmas','turnado a spr','completado por rector'];
                if(in_array($estatus, $permitidos)){
                    $analista = \Session::get('usuario')[0];
                    $categoria = \Session::get('categoria')[0];
                    if(strcmp($categoria, 'ADMINISTRADOR_CGA')==0){
                        $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus(strtoupper($estatus));
                    }else{
                        $solicitudes = SolicitudesController::ObtenerSolicitudesEstatusAnalista($analista,strtoupper($estatus));

                    }
                    $modulo = ucfirst($estatus);
                    //$solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('RECIBIDO');
                    $analistas = LoginController::ObtenerListadoAnalistas();
                    //return view('listado_general_estatus') ->with ("solicitudes",$solicitudes);
                    return view('listado_general_estatus') ->with (["solicitudes"=>$solicitudes,"analistas"=>$analistas,"modulo"=>$modulo]);
                }else{
                    return view('errors.404');
                }
            }else{
                return view('errors.505');
            }
        }

        public function VistaListadoAnalista(){
            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['ANALISTA_CGA'])){
                $analista = \Session::get('usuario')[0];
                $solicitudes = SolicitudesController::ObtenerSolicitudesAnalista($analista);
                //$analistas = 'SIN PERMISOS';
                $analistas = array();

                return view('listado_completo') ->with (["solicitudes"=>$solicitudes,"analistas"=>$analistas]);
            }else{
                return view('errors.505');
            }
        }

        public function ObtenerSolicitudesAnalista($analista){
            $solicitudes = array();
            //dd($id_dependencia);
            $rel_solicitudes = DB::table('REL_SOLICITUDES_ANALISTA')
                ->where('FK_USUARIO',$analista)
                ->get();
            foreach ($rel_solicitudes as $solicitud) {
            //dd($solicitud);
                $solicitudes[$solicitud->FK_SOLICITUD_ID] = SolicitudesController::ObtenerSolicitudId($solicitud->FK_SOLICITUD_ID);
            }
            //dd($solicitudes);
            return $solicitudes;

        }

        public function ObtenerSolicitudesEstatusAnalista($analista,$estatus){
            //dd($estatus);
            $solicitudes = array();
            $id_sol = array();
            //dd($id_dependencia);
            $rel_solicitudes = DB::table('REL_SOLICITUDES_ANALISTA')
                ->where('FK_USUARIO',$analista)
                ->get();
            //dd($rel_solicitudes);
            //$solicitudes_estatus = SolicitudesController::ObtenerSolicitudesEstatus($estatus);
            foreach ($rel_solicitudes as $solicitud) {
            //dd($solicitud);
                $tmp_solicitud = DB::table('SOLICITUDES_DATOS_CGA')
                    ->select('FK_SOLICITUD_ID')
                    ->where('DATOS_CGA_ESTATUS', $estatus)
                    ->where('FK_SOLICITUD_ID', $solicitud->FK_SOLICITUD_ID)
                    ->get();
                //$id_sol[]=$tmp_solicitud[0]->FK_SOLICITUD_ID;
                if(count($tmp_solicitud)>0){
                    $solicitudes[$solicitud->FK_SOLICITUD_ID] = SolicitudesController::ObtenerSolicitudId($tmp_solicitud[0]->FK_SOLICITUD_ID);
                }
            }
            //dd($solicitudes);
            //dd($solicitudes);
            return $solicitudes;

        }

        public function ObtenerSolicitudesDependencia($id_dependencia){
            $solicitudes = array();
            $fecha_arranque = '2019-01-01';
            $fecha_arranque = '2019-04-04';
            //dd($id_dependencia);
            $rel_solicitudes = DB::table('REL_DEPENCENCIA_SOLICITUD')
                                ->where('FK_DEPENDENCIA',$id_dependencia)
                                ->get();
            //dd($rel_solicitudes);
            foreach ($rel_solicitudes as $solicitud) {
                $tmp_solicitud = SolicitudesController::ObtenerSolicitudId($solicitud->FK_SOLICITUD_ID);
                //dd($tmp_solicitud);
                if(strtotime($tmp_solicitud->FECHA_CREACION_SF) >= strtotime($fecha_arranque)){
                    $solicitudes[$solicitud->FK_SOLICITUD_ID] = $tmp_solicitud;
                }else{
                    if(in_array($tmp_solicitud->ESTATUS_SOLICITUD, ['FIRMAS','CANCELADO POR TITULAR','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR'])){
                        $solicitudes[$solicitud->FK_SOLICITUD_ID] = $tmp_solicitud;
                    }
                }
                //dd($tmp_solicitud);
            }
            //dd($solicitudes);
            return $solicitudes;
        }

        public function ObtenerSolicitudesFirmadas($entidad){
            if(strcmp($entidad, 'SPR')==0){
                //dd('ES SPR');
                $res_solicitudes = DB::table('SOLICITUDES_FIRMAS')
                                ->whereNotNull('FIRMAS_SPR')
                                ->select('FK_SOLICITUD_ID')
                                ->get();
            }else if(strcmp($entidad, 'CGA')==0){
                $res_solicitudes = DB::table('SOLICITUDES_FIRMAS')
                                ->whereNotNull('FIRMAS_CGA')
                                ->select('FK_SOLICITUD_ID')
                                ->get();
            }else{
                $res_solicitudes = DB::table('SOLICITUDES_FIRMAS')
                                ->whereNotNull('FIRMAS_TITULAR')
                                ->select('FK_SOLICITUD_ID')
                                ->get();
            }
            $solicitudes = array();
            foreach ($res_solicitudes as $solicitud){
                $solicitudes[$solicitud->FK_SOLICITUD_ID]=SolicitudesController::ObtenerSolicitudId($solicitud->FK_SOLICITUD_ID);
                //$solicitudes[$solicitud->SOLICITUD_ID] = (object)$tmpSol;
            }
            return $solicitudes;//*/
        }

        public function ObtenerSolicitudes(){

            $categoria = \Session::get('categoria')[0];
            if(in_array($categoria, ['TRABAJADOR_SPR','SECRETARIO_PARTICULAR'])){
                $res_solicitudes = DB::table('SOLICITUDES_DATOS_CGA')
                                    ->whereNotIn('DATOS_CGA_ESTATUS',['RECIBIDO SPR'])
                                    ->orderBy('created_at', 'asc')
                                    ->select('FK_SOLICITUD_ID')
                                    ->get();
                $solicitudes = array();

            }else{
                $res_solicitudes = DB::table('SOLICITUDES_DATOS_CGA')
                                    ->whereNotIn('DATOS_CGA_ESTATUS',['RECIBIDO SPR','VALIDACIÓN DE INFORMACIÓN'])
                                    ->select('FK_SOLICITUD_ID')
                                    ->orderBy('created_at', 'asc')
                                    ->get();
                $solicitudes = array();
            }
            foreach ($res_solicitudes as $solicitud){
                $solicitudes[$solicitud->FK_SOLICITUD_ID]=SolicitudesController::ObtenerSolicitudId($solicitud->FK_SOLICITUD_ID);
                //$solicitudes[$solicitud->SOLICITUD_ID] = (object)$tmpSol;
            }
            //dd($solicitudes);
            return $solicitudes;
        }

        public function MarcarInformacionCorrecta(Request $request){
            //dd($request['estatus']);
            date_default_timezone_set('America/Mexico_City');
            //dd($request['id_sol']);
            
            $res_solicitudes = DB::table('SOLICITUDES_SOLICITUD')
                                ->where('SOLICITUD_ID', $request['id_sol'])
                                ->select('SOLICITUD_URGENCIA')
                                ->get();
            //dd($res_solicitudes[0]->SOLICITUD_URGENCIA);
            if(strcmp($res_solicitudes[0]->SOLICITUD_URGENCIA,'PRIORIDAD 2')==0){
                $fechas = array(
                        //'tiempo_revision_informacion' => SolicitudesController::CalculaFecha(1),
                        'tiempo_GenerarCita' => SolicitudesController::CalculaFecha(3),
                        'tiempo_levantamiento' => SolicitudesController::CalculaFecha(5),
                        'tiempo_analisis' => SolicitudesController::CalculaFecha(7),
                        'tiempo_revision_cuadro' => SolicitudesController::CalculaFecha(9),
                        'tiempo_firmas' => SolicitudesController::CalculaFecha(11),
                        'tiempo_AprovacionSpr' => SolicitudesController::CalculaFecha(14)
                    );
            }else{
                $fechas = array(
                        //'tiempo_revision_informacion' => SolicitudesController::CalculaFecha(1),
                        'tiempo_GenerarCita' => SolicitudesController::CalculaFecha(1),
                        'tiempo_levantamiento' => SolicitudesController::CalculaFecha(2),
                        'tiempo_analisis' => SolicitudesController::CalculaFecha(3),
                        'tiempo_revision_cuadro' => SolicitudesController::CalculaFecha(4),
                        'tiempo_firmas' => SolicitudesController::CalculaFecha(5),
                        'tiempo_AprovacionSpr' => SolicitudesController::CalculaFecha(6)
                    );
            }
            //dd($fechas);

            $updateFecha = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update([
                    'FECHAS_INFORMACION_COMPLETA' =>  date('Y-m-d H:i:s'),
                    'FECHAS_LIMITE_AGENDAR_CITA' =>  $fechas['tiempo_GenerarCita'],
                    'FECHAS_LIMITE_LEVANTAMIENTO' =>  $fechas['tiempo_levantamiento'],
                    'FECHAS_LIMITE_ANALISIS' =>  $fechas['tiempo_analisis'],
                    'FECHAS_LIMITE_REVISION' =>  $fechas['tiempo_revision_cuadro'],
                    'FECHAS_LIMITE_FIRMAS' =>  $fechas['tiempo_firmas'],
                    'FECHAS_LIMITE_FINALIZAR' =>  $fechas['tiempo_AprovacionSpr']
                ]);

            //Aquí cambiamos el estatus de la solicitud
            $update = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['DATOS_CGA_ESTATUS' => $request['estatus']]);

            $responsable = \Session::get('responsable')[0];
            if(strcmp($request['estatus'], 'RECIBIDO')==0){
                $movimiento = $responsable.' ha marcado la información como CORRECTA y el estatus de la solicitud ha cambiado a RECIBIDO';
            }else{
                $movimiento = $responsable.' ha marcado la información como INCORRECTA y el estatus de la solicitud ha cambiado a CANCELADO';
            }
            SolicitudesController::InsertaMovimientoCGA($responsable,$movimiento,$request['id_sol']);
            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function TurnarSolicitudCGA(Request $request){
            date_default_timezone_set('America/Mexico_City');
            //dd($request['id_sol']);
            $update = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['DATOS_CGA_ESTATUS' => 'VALIDACIÓN DE INFORMACIÓN']);

            $updateFecha = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['FECHAS_TURNADO_CGA' =>  date('Y-m-d H:i:s')]);

            $responsable = \Session::get('responsable')[0];
            $movimiento = $responsable.' ha turnado la solicitud a CGA';
            $id_mov = SolicitudesController::InsertaMovimientoSPR($responsable,$movimiento,$request['id_sol']);
            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function InsertarRelacionDependenciaSolicitud($id_dependencia,$id_solicitud){
            DB::table('REL_DEPENCENCIA_SOLICITUD')->insert(
                [
                    'FK_DEPENDENCIA' => $id_dependencia,
                    'FK_SOLICITUD_ID' => $id_solicitud
                ]
            );
        }

        public function ObtenerConsecutivo(){
            $sol = '';
            $ultima_solicitud = DB::table('SOLICITUDES_SOLICITUD')->latest()->get();
            if(count($ultima_solicitud)==0){//es la primera solicitud de la base de datos
                //dd('Primera Solicitud');
                $año = date('Y');
                $sol = 'SOL/1/'.$año;
                //dd($sol);
            }else{
                $separa = explode("/", $ultima_solicitud[0]->SOLICITUD_ID);
                //dd($separa);
                if(strcmp(date('Y'),$separa[2])==0){//en caso de que el año sea el mismo
                    $consecutivo = ((int)$separa[1])+1;
                }else{//en caso de que el año haya cambiado, primera solicitud del año en curso
                    $consecutivo = '1';
                }
                $sol = 'SOL/'.$consecutivo.'/'.date('Y');
            }
             return $sol;   
        }

        public function esFestivo($time) {
            date_default_timezone_set('America/Mexico_City');
            /*global $dias_saltados;
            global $dias_festivos;//*/
            // Guardamos en una variable los dias festivos en varios arrays con formato
            // $dias_festivos[año][mes] = [dias festivos];
            $dias_festivos = array(
                "2019"=>array(
                  3 => [8,18],
                  4 => [15,16,17,28,19,20],
                  5 => [1,5,10,15],
                  6 => [8],
                  7 => [8,9,10,11,12,15,16,17,18,19,22,23,24,25,26],
                  9 => [15],
                  11 => [1,2,18],
                  12 => [14,18,19,20,23,24,25,26,27,30,31],
                ),
                "2020"=>array(1 => [1])
            );
            $dias_saltados = array(0,6); // 0: domingo, 1: lunes... 6:sabado

            $w = date("w",$time); // dia de la semana en formato 0-6
            if(in_array($w, $dias_saltados)) return true;
            $j = date("j",$time); // dia en formato 1 - 31
            $n = date("n",$time); // mes en formato 1 - 12
            $y = date("Y",$time); // año en formato XXXX
            if(isset($dias_festivos[$y]) && isset($dias_festivos[$y][$n]) && in_array($j,$dias_festivos[$y][$n])) return true;

            return false;
        }

        public function CalculaFecha($dias){
            date_default_timezone_set('America/Mexico_City');
            $dias_saltados = array(0,6); // 0: domingo, 1: lunes... 6:sabado
            // dias a sumar
            $dias = $dias_origin = $dias;
            // dias que el programa ha contado
            $dias_contados = 0;
            // timestamp actual
            $time = time();
            // duracion (en segundos) que tiene un día
            $dia_time = 3600*24; //3600 segundos en una hora * 24 horas que tiene un dia.

            while($dias != 0) {
              $dias_contados++;
              $tiempoContado = $time+($dia_time*$dias_contados); // Sacamos el timestamp en la que estamos ahora mismo comprobando
              if(SolicitudesController::esFestivo($tiempoContado) == false)
                  $dias--;
            }
            //return date("d/m/Y",$tiempoContado);
            return date("Y-m-d",$tiempoContado);
        }

        public function AlmacenarSolicitud($datos_solicitud){
            date_default_timezone_set('America/Mexico_City');
            $sol = '';
            $nomina = '';
            //print_r($datos_solicitud);
            $datos = SolicitudesController::DatosGenerales();
            if($datos['institucional']){
                $nomina = 'INSTITUCIONAL';
            }else{
                $nomina = 'PRESTACION DE SERVICIOS';
            }
            //dd($datos_solicitud['candidato']);
            //dd($nomina);
            //Se bloquea la base de datos para que otro usuario no genere un folio repetido
            DB::raw('lock tables SOLICITUDES_SOLICITUD write');
                $sol = SolicitudesController::ObtenerConsecutivo();
                //dd($sol);
                $insert = DB::table('SOLICITUDES_SOLICITUD')->insert(
                    [
                        'SOLICITUD_ID' => $sol,
                        'SOLICITUD_OFICIO' => '',
                        'SOLICITUD_NOMBRE' => $datos_solicitud['candidato'],
                        'SOLICITUD_DEPENDENCIA' => $datos_solicitud['id_dependencia'],
                        'SOLICITUD_CATEGORIA' => $datos_solicitud['categoria'],
                        'SOLICITUD_PUESTO' => $datos_solicitud['puesto'],
                        'SOLICITUD_ACTIVIDADES' => $datos_solicitud['actividades'],
                        //'SOLICITUD_NOMINA' => $datos_solicitud['nomina'],
                        'SOLICITUD_NOMINA' => $nomina,
                        'SOLICITUD_SALARIO' => $datos_solicitud['salario'],
                        'SOLICITUD_JUSTIFICACION' => $datos_solicitud['justificacion'],
                        'SOLICITUD_TIPO_SOLICITUD' => $datos_solicitud['tipo_solicitud'],
                        'SOLICITUD_URGENCIA' => 'PRIORIDAD 2',
                        'SOLICITUD_FUENTE_RECURSOS' => $datos_solicitud['fuente_recursos'],
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );//*/
                //sleep(30);
            DB::raw('unlock tables');
            if($insert){
                DB::table('SOLICITUDES_DATOS_CGA')->insert(
                    [
                        'FK_SOLICITUD_ID' => $sol,
                        'DATOS_CGA_ESTATUS' => 'RECIBIDO SPR',
                        'DATOS_CGA_PRIORIDAD' => 'PRIORIDAD 2',
                         'created_at' => date('Y-m-d H:i:s')
                    ]
                );

                DB::table('SOLICITUDES_FECHAS')->insert(
                    [
                        'FK_SOLICITUD_ID' => $sol,
                        'FECHAS_CREACION_SOLICITUD' => date('Y-m-d H:i:s'),
                         'created_at' => date('Y-m-d H:i:s')
                    ]
                );
                
            }
            return $sol;
        }

        public function AlmacenaArchivoBD($id_solicitud,$path,$tipo){
            date_default_timezone_set('America/Mexico_City');
            $id_archivo = DB::table('SOLICITUDES_ARCHIVOS')->insertGetId(
                [
                    'ARCHIVOS_RUTA' => $path,
                    'ARCHIVOS_NOMBRE' => str_replace('/', '-', $id_solicitud).'_'.$tipo ,
                    'ARCHIVOS_MENSAJE' => '',
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
            $insert_rel = DB::table('REL_ARCHIVOS_SOLICITUD')->insert(
                [
                    'FK_ARCHIVO' => $id_archivo,
                    'FK_SOLICITUD_ID' => $id_solicitud,
                    'TIPO_ARCHIVO' => $tipo,
                ]
            );
            return $insert_rel;
        }

        public function AlmacenarContratacion(Request $request){
            date_default_timezone_set('America/Mexico_City');
            //dd($request);
            $candidato = $request['candidato'];
            $categoria = $request['categoria'];
            $puesto = $request['puesto'];
            $actividades = $request['actividades'];
            $nomina = $request['nomina'];
            $salario = $request['salario'];
            $justificacion = $request['justificacion'];
            $consecutivo = 0;
            $usuario = 'marvineliosa';
            //$id_dependencia = \Session::get('id_dependencia')[0];
            $fuente_recursos = $request['fuente_recursos'];

            $dependencia_spr = $request['dependencia_spr'];
            if(strcasecmp($dependencia_spr, "undefined")==0){
                $id_dependencia = \Session::get('id_dependencia')[0];
                //dd('no tiene empresa por ser institucional');
            }else{
                $id_dependencia = $dependencia_spr;

            }

            //dd($id_dependencia);

            //se crea un array para enviar por parametro
            $datos_solicitud = array(
                'candidato' => $candidato,
                'id_dependencia' => $id_dependencia,
                'categoria' => $categoria,
                'puesto' => $puesto,
                'actividades' => $actividades,
                'nomina' => $nomina,
                'salario' => $salario,
                'justificacion' => $justificacion,
                'tipo_solicitud' => 'CONTRATACIÓN',
                'fuente_recursos' => $fuente_recursos
            );
            //almacenando solicitud
            $sol = SolicitudesController::AlmacenarSolicitud($datos_solicitud);
            //Insertando relacion con la dependencia
            SolicitudesController::InsertarRelacionDependenciaSolicitud($id_dependencia,$sol);

            //Insertar Archivos
            $path = Storage::putFile('public/organigramas', $request->file('archivo_organigrama'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'ORGANIGRAMA');

            $path = Storage::putFile('public/plantillas', $request->file('archivo_plantilla'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'PLANTILLA DE PERSONAL');

            $path = Storage::putFile('public/descripciones_puestos', $request->file('archivo_descripcion'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'DESCRIPCION DE PUESTO');

            $path = Storage::putFile('public/curriculum', $request->file('archivo_curriculum'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'CURRICULUM');

            if ($request->hasFile('archivo_mapa_ubicacion')){
                $path = Storage::putFile('public/mapas_ubicacion', $request->file('archivo_mapa_ubicacion'));
                SolicitudesController::AlmacenaArchivoBD($sol,$path,'MAPA DE UBICACIÓN');
            }

            if(strcasecmp($dependencia_spr, "undefined")!=0){
                $responsable = \Session::get('responsable')[0];
                $movimiento = $responsable.' ha creado la solicitud '.$sol;
                $id_mov = SolicitudesController::InsertaMovimientoSPR($responsable,$movimiento,$sol);

            }

            $data = array(
                "solicitud"=>$sol
            );

            echo json_encode($data);//*/
        }

        public function AlmacenarContratacionSustitucion(Request $request){
            date_default_timezone_set('America/Mexico_City');
            //dd($request);
            $persona_anterior = $request['persona_anterior'];
            $categoria_anterior = $request['categoria_anterior'];
            $puesto_anterior = $request['puesto_anterior'];
            $actividades_anterior = $request['actividades_anterior'];
            $salario_anterior = $request['salario_anterior'];

            $persona_solicitada = $request['persona_solicitada'];
            $categoria_solicitada = $request['categoria_solicitada'];
            $puesto_solicitado = $request['puesto_solicitado'];
            $actividades_solicitadas = $request['actividades_solicitadas'];
            $salario_solicitado = $request['salario_solicitado'];

            $nomina = $request['nomina'];
            $justificacion = $request['justificacion'];
            //$id_dependencia = \Session::get('id_dependencia')[0];
            $fuente_recursos = $request['fuente_recursos'];
            
            $dependencia_spr = $request['dependencia_spr'];
            if(strcasecmp($dependencia_spr, "undefined")==0){
                $id_dependencia = \Session::get('id_dependencia')[0];
                //dd('no tiene empresa por ser institucional');
            }else{
                $id_dependencia = $dependencia_spr;

            }

            //dd($id_dependencia);

            $datos_solicitud = array(
                'candidato' => $persona_anterior,
                'id_dependencia' => $id_dependencia,
                'categoria' => $categoria_anterior,
                'puesto' => $puesto_anterior,
                'actividades' => $actividades_anterior,
                'nomina' => $nomina,
                'salario' => $salario_anterior,
                'justificacion' => $justificacion,
                'tipo_solicitud' => 'CONTRATACIÓN POR SUSTITUCIÓN',
                'fuente_recursos' => $fuente_recursos
            );
            //dd($datos_solicitud);
            $sol = SolicitudesController::AlmacenarSolicitud($datos_solicitud);
            SolicitudesController::InsertarRelacionDependenciaSolicitud($id_dependencia,$sol);

            DB::table('SOLICITUDES_SUSTITUCION')->insert(
                [
                    'FK_SOLICITUD_ID' => $sol,
                    'SUSTITUCION_CANDIDATO_NUEVO' => $persona_solicitada,
                    'SUSTITUCION_CATEGORIA_NUEVA' => $categoria_solicitada,
                    'SUSTITUCION_PUESTO_NUEVO' => $puesto_solicitado,
                    'SUSTITUCION_ACTIVIDADES_NUEVAS' => $actividades_solicitadas,
                    'SUSTITUCION_SALARIO_NUEVO' => $salario_solicitado,
                     'created_at' => date('Y-m-d H:i:s')
                ]
            );

            //Insertar Archivos
            $path = Storage::putFile('public/organigramas', $request->file('archivo_organigrama'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'ORGANIGRAMA');

            $path = Storage::putFile('public/plantillas', $request->file('archivo_plantilla'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'PLANTILLA DE PERSONAL');

            $path = Storage::putFile('public/descripciones_puestos', $request->file('archivo_descripcion'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'DESCRIPCION DE PUESTO');

            $path = Storage::putFile('public/curriculum', $request->file('archivo_curriculum'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'CURRICULUM');

            if ($request->hasFile('archivo_mapa_ubicacion')){
                $path = Storage::putFile('public/mapas_ubicacion', $request->file('archivo_mapa_ubicacion'));
                SolicitudesController::AlmacenaArchivoBD($sol,$path,'MAPA DE UBICACIÓN');
            }

            if(strcasecmp($dependencia_spr, "undefined")!=0){
                $responsable = \Session::get('responsable')[0];
                $movimiento = $responsable.' ha creado la solicitud '.$sol;
                $id_mov = SolicitudesController::InsertaMovimientoSPR($responsable,$movimiento,$sol);

            }
            //dd('Listo: '.$sol);
            //dd($descripciones);
            $data = array(
                "solicitud"=>$sol
            );

            echo json_encode($data);//*/
        }


        public function AlmacenarPromocion(Request $request){
            date_default_timezone_set('America/Mexico_City');
            //dd($request);
            $Candidato = $request['Candidato'];
            $CategoriaActual = $request['CategoriaActual'];
            $PuestoActual = $request['PuestoActual'];
            $ActividadesActuales = $request['ActividadesActuales'];
            $SalarioActual = $request['SalarioActual'];

            $CategoriaSolicitada = $request['CategoriaSolicitada'];
            $PuestoNuevo = $request['PuestoNuevo'];
            $ActividadesNuevas = $request['ActividadesNuevas'];
            $SalarioSolicitado = $request['SalarioSolicitado'];

            $nomina = $request['nomina'];
            $justificacion = $request['justificacion'];
            //$id_dependencia = \Session::get('id_dependencia')[0];
            $fuente_recursos = 'NA';
            
            $dependencia_spr = $request['dependencia_spr'];
            if(strcasecmp($dependencia_spr, "undefined")==0){
                $id_dependencia = \Session::get('id_dependencia')[0];
                //dd('no tiene empresa por ser institucional');
            }else{
                $id_dependencia = $dependencia_spr;

            }

            //dd($id_dependencia);

            $datos_solicitud = array(
                'candidato' => $Candidato,
                'id_dependencia' => $id_dependencia,
                'categoria' => $CategoriaActual,
                'puesto' => $PuestoActual,
                'actividades' => $ActividadesActuales,
                'nomina' => $nomina,
                'salario' => $SalarioActual,
                'justificacion' => $justificacion,
                'tipo_solicitud' => 'PROMOCION',
                'fuente_recursos' => $fuente_recursos
            );
            //dd($datos_solicitud);
            $sol = SolicitudesController::AlmacenarSolicitud($datos_solicitud);
            SolicitudesController::InsertarRelacionDependenciaSolicitud($id_dependencia,$sol);

            DB::table('SOLICITUDES_PROMOCION')->insert(
                [
                    'FK_SOLICITUD_ID' => $sol,
                    'PROMOCION_CATEGORIA_SOLICITADA' => $CategoriaSolicitada,
                    'PROMOCION_PUESTO_NUEVO' => $PuestoNuevo,
                    'PROMOCION_ACTIVIDADES_NUEVAS' => $ActividadesNuevas,
                    'PROMOCION_SALARIO_NUEVO' => $SalarioSolicitado,
                     'created_at' => date('Y-m-d H:i:s')
                ]
            );

            //Insertar Archivos
            $path = Storage::putFile('public/organigramas', $request->file('archivo_organigrama'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'ORGANIGRAMA');

            $path = Storage::putFile('public/plantillas', $request->file('archivo_plantilla'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'PLANTILLA DE PERSONAL');

            $path = Storage::putFile('public/descripciones_puestos', $request->file('archivo_descripcion'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'DESCRIPCION DE PUESTO');

            $path = Storage::putFile('public/curriculum', $request->file('archivo_curriculum'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'CURRICULUM');

            if ($request->hasFile('archivo_mapa_ubicacion')){
                $path = Storage::putFile('public/mapas_ubicacion', $request->file('archivo_mapa_ubicacion'));
                SolicitudesController::AlmacenaArchivoBD($sol,$path,'MAPA DE UBICACIÓN');
            }

            if(strcasecmp($dependencia_spr, "undefined")!=0){
                $responsable = \Session::get('responsable')[0];
                $movimiento = $responsable.' ha creado la solicitud '.$sol;
                $id_mov = SolicitudesController::InsertaMovimientoSPR($responsable,$movimiento,$sol);

            }
            //dd('Listo: '.$sol);
            //dd($descripciones);
            $data = array(
                "solicitud"=>$sol
            );

            echo json_encode($data);//*/
        }


        public function AlmacenarCambioAdscripcion(Request $request){
            date_default_timezone_set('America/Mexico_City');
            //dd($request);
            $NombreCandidato = $request['NombreCandidato'];
            $CategoriaActual = $request['CategoriaActual'];
            $PuestoActual = $request['PuestoActual'];
            $ActividadesActuales = $request['ActividadesActuales'];
            $SalarioActual = $request['SalarioActual'];

            $DependenciaDestino = $request['DependenciaDestino'];
            $CategoriaNueva = $request['CategoriaNueva'];
            $PuestoNuevo = $request['PuestoNuevo'];
            $ActividadesNuevas = $request['ActividadesNuevas'];
            $SalarioSolicitado = $request['SalarioSolicitado'];
            
            $nomina = $request['Nomina'];
            $justificacion = $request['Justificacion'];
            //$id_dependencia = \Session::get('id_dependencia')[0];
            $fuente_recursos = 'NA';
            $empresa = $request['empresa'];
            //dd($empresa);
            //dd(gettype($empresa));
            if(strcasecmp($empresa, "undefined")==0){
                $empresa = null;
                //dd('no tiene empresa por ser institucional');
            }
            
            $dependencia_spr = $request['dependencia_spr'];
            if(strcasecmp($dependencia_spr, "undefined")==0){
                $id_dependencia = \Session::get('id_dependencia')[0];
                //dd('no tiene empresa por ser institucional');
            }else{
                $id_dependencia = $dependencia_spr;

            }

            //dd($id_dependencia);

            $datos_solicitud = array(
                'candidato' => $NombreCandidato,
                'id_dependencia' => $id_dependencia,
                'categoria' => $CategoriaActual,
                'puesto' => $PuestoActual,
                'actividades' => $ActividadesActuales,
                'nomina' => $nomina,
                'salario' => $SalarioActual,
                'justificacion' => $justificacion,
                'tipo_solicitud' => 'CAMBIO DE ADSCRIPCIÓN',
                'fuente_recursos' => $fuente_recursos
            );
            //dd($datos_solicitud);
            $sol = SolicitudesController::AlmacenarSolicitud($datos_solicitud);
            SolicitudesController::InsertarRelacionDependenciaSolicitud($id_dependencia,$sol);

            DB::table('SOLICITUDES_CAMBIO_ADSCRIPCION')->insert(
                [
                    'FK_SOLICITUD_ID' => $sol,
                    'CAMBIO_ADSCRIPCION_DEPENDENCIA_DESTINO' => $DependenciaDestino,
                    'CAMBIO_ADSCRIPCION_CATEGORIA_NUEVA' => $CategoriaNueva,
                    'CAMBIO_ADSCRIPCION_PUESTO_NUEVO' => $PuestoNuevo,
                    'CAMBIO_ADSCRIPCION_ACTIVIDADES_NUEVAS' => $ActividadesNuevas,
                    'CAMBIO_ADSCRIPCION_SALARIO_NUEVO' => $SalarioSolicitado,
                    'CAMBIO_ADSCRIPCION_SALARIO_NUEVO' => $SalarioSolicitado,
                    'CAMBIO_ADSCRIPCION_EMPRESA' => $empresa,
                     'created_at' => date('Y-m-d H:i:s')
                ]
            );

            //Insertar Archivos
            $path = Storage::putFile('public/organigramas', $request->file('archivo_organigrama'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'ORGANIGRAMA');

            $path = Storage::putFile('public/plantillas', $request->file('archivo_plantilla'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'PLANTILLA DE PERSONAL');

            $path = Storage::putFile('public/descripciones_puestos', $request->file('archivo_descripcion'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'DESCRIPCION DE PUESTO');

            $path = Storage::putFile('public/descripciones_puestos', $request->file('archivo_descripcion_destino'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'DESCRIPCION DE PUESTO DESTINO');

            $path = Storage::putFile('public/curriculum', $request->file('archivo_curriculum'));
            SolicitudesController::AlmacenaArchivoBD($sol,$path,'CURRICULUM');

            if ($request->hasFile('archivo_mapa_ubicacion')){
                $path = Storage::putFile('public/mapas_ubicacion', $request->file('archivo_mapa_ubicacion'));
                SolicitudesController::AlmacenaArchivoBD($sol,$path,'MAPA DE UBICACIÓN');
            }

            if(strcasecmp($dependencia_spr, "undefined")!=0){
                $responsable = \Session::get('responsable')[0];
                $movimiento = $responsable.' ha creado la solicitud '.$sol;
                $id_mov = SolicitudesController::InsertaMovimientoSPR($responsable,$movimiento,$sol);

            }
            //dd('Listo: '.$sol);
            //dd($descripciones);
            $data = array(
                "solicitud"=>$sol
            );

            echo json_encode($data);//*/
        }
        public function BloquearSql(Request $request){

            //dd('epale');
            DB::raw('lock tables SOLICITUDES_SOLICITUD write');//*/
        }

        public function DesbloquearSql(Request $request){

            //dd('epale');
            DB::raw('unlock tables');//*/
        }

        public function RefrescarListadoCompleto(){
            $analista = \Session::get('usuario')[0];
            $categoria = \Session::get('categoria')[0];
            if(strcmp($categoria, 'ADMINISTRADOR_CGA')==0){
                $solicitudes = SolicitudesController::ObtenerSolicitudes();
            }else{
                $solicitudes = SolicitudesController::ObtenerSolicitudesAnalista($analista);

            }
            //dd($solicitudes);
            return View('tablas.listado_completo') ->with ("solicitudes",$solicitudes);
            //return View::make("tablas.listado_completo", ["solicitudes" => $solicitudes]);
        }

        public function RefrescarListadoGeneralEstatus($modulo){
            //dd($modulo);
            $analista = \Session::get('usuario')[0];
            $categoria = \Session::get('categoria')[0];
            if(strcmp($categoria, 'ADMINISTRADOR_CGA')==0){
                $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus(strtoupper($modulo));
            }else{
                $solicitudes = SolicitudesController::ObtenerSolicitudesEstatusAnalista($analista,$modulo);

            }
            //dd($solicitudes);
            return View('tablas.listado_general_estatus') ->with ("solicitudes",$solicitudes);
            //return View::make("tablas.listado_completo", ["solicitudes" => $solicitudes]);
        }

        public function RefrescarNuevasSPR(){
            $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('RECIBIDO SPR');
            return View('tablas.listado_nuevas') ->with ("solicitudes",$solicitudes);
        }

        public function RefrescarRevisionInformacion(){
            $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('VALIDACION DE INFORMACION');
            return View('tablas.listado_revision_informacion') ->with ("solicitudes",$solicitudes);
        }

        public function RefrescarCoordinacion(){
            $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('FIRMAS');
            return View('tablas.listado_cga') ->with ("solicitudes",$solicitudes);
        }

        public function RefrescarDependencia(){
            $id_dependencia = \Session::get('id_dependencia')[0];
            $solicitudes = SolicitudesController::ObtenerSolicitudesDependencia($id_dependencia);
            //return view('listado_dependencia')->with("solicitudes",$solicitudes);
            return View('tablas.listado_dependencia') ->with ("solicitudes",$solicitudes);
        }

        public function RefrescarSPR(){
            //$solicitudes = SolicitudesController::ObtenerSolicitudes();
            //$solicitudes = SolicitudesController::ObtenerSolicitudesFirmadas('SPR');
            $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('FIRMAS');
            return View('tablas.listado_secretario_particular') ->with ("solicitudes",$solicitudes);
        }

        public function RefrescarPorRevisar(){
            $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('TURNADO A SPR');
            return View('tablas.listado_por_revisar') ->with ("solicitudes",$solicitudes);
        }

        public function RefrescarRevisadas(){
            $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('COMPLETADO POR SPR');
            return View('tablas.listado_revisadas') ->with ("solicitudes",$solicitudes);
        }

        public static function VerificarHorario(){
            $datos = SolicitudesController::DatosGenerales();


            date_default_timezone_set('America/Mexico_City');
            $ahora = strtotime(date('H:i'));
            $fl_horario = false;
            //dd($ahora);
            $inicio = strtotime( $datos['horar_inicio'] );
            $fin = strtotime( $datos['horar_fin'] );
            //dd($inicio.' --- '.$fin);
            if($ahora > $inicio && $ahora < $fin) {
                //dd($ahora.' es mayor que '.$fin);
                //dd('Esta en tiempo');
                $fl_horario = true;
            }
            return $fl_horario;
        }

        public static function DatosGenerales(){
            //en este método se sabrá si el sistema está funcionando de modo institucional o prestación de servicios
            $datos = array(
                            'institucional' => true,
                            'horar_inicio' => "09:00",
                            'horar_fin' => "20:00",
                        );
            return $datos;
        }

    }