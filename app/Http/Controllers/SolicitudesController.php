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

            //si existe una relación con anterioridad, la solicitud se borra la relación existente
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
                    $pdf = \PDF::loadView('pdf.cuadro_contratacion',['solicitud'=>$solicitud])->setPaper('letter', 'landscape');
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
                        $pdf = \PDF::loadView('pdf.cuadro_contratacion',['solicitud'=>$solicitud])->setPaper('letter', 'landscape');
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

                    $pdf = \PDF::loadView('pdf.cuadro_sustitucion',['solicitud'=>$solicitud,'sustitucion'=>$sustitucion])->setPaper('letter', 'landscape');
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

                    $pdf = \PDF::loadView('pdf.cuadro_promocion',['solicitud'=>$solicitud,'promocion'=>$promocion])->setPaper('letter', 'landscape');
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
                        $pdf = \PDF::loadView('pdf.cuadro_promocion',['solicitud'=>$solicitud,'promocion'=>$promocion])->setPaper('letter', 'landscape');
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
            //dd($request['actividades']);
            $update = SolicitudesController::UpdateDatosCGA($request);

            $update = DB::table('SOLICITUDES_CAMBIO_ADSCRIPCION')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'CAMBIO_ADSCRIPCION_ACTIVIDADES_NUEVAS' => $request['actividades'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
            $data = array(
                "update"=>$update
            );
            echo json_encode($data);//*/

        }

        public function GuardaDatosPromocion(Request $request){
            //dd($request['actividades']);
            $update = SolicitudesController::UpdateDatosCGA($request);

            $update = DB::table('SOLICITUDES_PROMOCION')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'PROMOCION_ACTIVIDADES_NUEVAS' => $request['actividades'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
            $data = array(
                "update"=>$update
            );
            echo json_encode($data);//*/

        }

        public function GuardaDatosSustitucion(Request $request){
            //dd($request['actividades']);
            $update = SolicitudesController::UpdateDatosCGA($request);

            $update = DB::table('SOLICITUDES_SUSTITUCION')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'SUSTITUCION_ACTIVIDADES_NUEVAS' => $request['actividades'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
            $data = array(
                "update"=>$update
            );
            echo json_encode($data);//*/

        }

        public function GuardaDatosContratacion(Request $request){
            //dd($request['compensacion_solicitud']);
            $update = SolicitudesController::UpdateDatosCGA($request);
            //dd($request['actividades']);
            $update = DB::table('SOLICITUDES_SOLICITUD')
                ->where('SOLICITUD_ID', $request['id_sol'])
                ->update([
                            'SOLICITUD_ACTIVIDADES' => $request['actividades'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

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
            $datos = DB::table('SOLICITUDES_CAMBIO_ADSCRIPCION')
                ->where('FK_SOLICITUD_ID', $id_solicitud)
                ->select(
                            'CAMBIO_ADSCRIPCION_DEPENDENCIA_DESTINO as NUEVA_DEPENDENCIA',
                            'CAMBIO_ADSCRIPCION_CATEGORIA_NUEVA as NUEVA_CATEGORIA',
                            'CAMBIO_ADSCRIPCION_PUESTO_NUEVO as PUESTO_NUEVO',
                            'CAMBIO_ADSCRIPCION_ACTIVIDADES_NUEVAS as NUEVAS_ACTIVIDADES',
                            'CAMBIO_ADSCRIPCION_SALARIO_NUEVO as NUEVO_SALARIO'
                        )
                ->get();
            $dependencia = DependenciasController::ObtenerNombreDependencia($datos[0]->NUEVA_DEPENDENCIA);
            $datos[0]->NUEVA_DEPENDENCIA = $dependencia[0]->NOMBRE_DEPENDENCIA;
            //dd($datos[0]->NUEVA_DEPENDENCIA);
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
            }else{
                //dd('Modo NPS');
                $solicitud[0]->NOMBRE_DEPENDENCIA = $dependencia->CODIGO_DEPENDENCIA;
            }
            //dd($dependencia);
            $solicitud[0]->ID_ESCAPE = str_replace('/','_',$solicitud[0]->ID_SOLICITUD);
            $solicitud[0]->SALARIO_FORMATO = number_format($solicitud[0]->SALARIO_SOLICITUD,2);
            //$solicitud[0]->SALARIO_SOLICITUD = 0;
            //echo 'DE: ', $formatter->formatCurrency($amount, 'EUR'), PHP_EOL;
            $fechas = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();
            $solicitud[0]->FECHA_CREACION = date("d/m/Y", strtotime($fechas[0]->FECHAS_CREACION_SOLICITUD));
            $solicitud[0]->FECHAS_INFORMACION_COMPLETA = date("d/m/Y", strtotime($fechas[0]->FECHAS_INFORMACION_COMPLETA));
            $solicitud[0]->FECHA_TURNADO_CGA = date("d/m/Y", strtotime($fechas[0]->FECHAS_TURNADO_CGA));
            $solicitud[0]->FECHA_ENVIO = date("d/m/Y", strtotime($fechas[0]->FECHAS_TURNADO_SPR));

            $datos_cga = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();

            $solicitud[0]->CATEGORIA_PROPUESTA = $datos_cga[0]->DATOS_CGA_CATEGORIA_PROPUESTA;
            $solicitud[0]->PUESTO_PROPUESTO = $datos_cga[0]->DATOS_CGA_PUESTO_PROPUESTO;
            $solicitud[0]->SALARIO_PROPUESTO = number_format($datos_cga[0]->DATOS_CGA_SALARIO_PROPUESTO,2);
            $solicitud[0]->SALARIO_PROPUESTO_SF = $datos_cga[0]->DATOS_CGA_SALARIO_PROPUESTO;
            $solicitud[0]->ESTATUS_PROCEDE = $datos_cga[0]->DATOS_CGA_PROCEDENTE;
            $solicitud[0]->RESPUESTA_CGA = $datos_cga[0]->DATOS_CGA_RESPUESTA;
            $solicitud[0]->CATEGORIA_SUPERIOR = $datos_cga[0]->DATOS_CGA_CATEGORIA_SUPERIOR;
            $solicitud[0]->SALARIO_SUPERIOR = $datos_cga[0]->DATOS_CGA_SALARIO_SUPERIOR;
            $solicitud[0]->CATEGORIA_INFERIOR = $datos_cga[0]->DATOS_CGA_CATEGORIA_INFERIOR;
            $solicitud[0]->SALARIO_INFERIOR = $datos_cga[0]->DATOS_CGA_SALARIO_INFERIOR;
            $solicitud[0]->ESTATUS_SOLICITUD = $datos_cga[0]->DATOS_CGA_ESTATUS;
            $solicitud[0]->AHORRO_SOLICITUD = $datos_cga[0]->DATOS_CGA_AHORRO;
            $solicitud[0]->COMPENSACION_SOLICITUD = $datos_cga[0]->DATOS_CGA_COMPENSACION;
            $solicitud[0]->HOY = date('d/m/Y');

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
            }

            return $solicitud[0];
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

            $mail = null;
            if(in_array($request['estatus'], ['VALIDACIÓN DE INFORMACIÓN','INFORMACIÓN CORRECTA','RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR','CANCELADO','OTRO'])){
                $asunto = 'Cambio de estatus';
                $titulo = 'Cambio de estatus';
                $mensaje = 'El estatus de la solicitud '.$request['id_sol'].' ha cambiado a '.$request['estatus'];
                $usuario = 'marvineliosa@hotmail.com';
                $mail = MailsController::MandarMensajeGenerico($asunto,$titulo,$mensaje,$usuario);
                //dd($mail);
            }//*/

            if(strcmp($request['estatus'],'TURNADO A SPR')==0){
                $update = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FECHAS_TURNADO_SPR' => date('Y-m-d H:i:s')]);
                }//*/

            if(strcmp($request['estatus'],'REVISIÓN')==0){
                $update = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FECHAS_PUESTO_REVISION' => date('Y-m-d H:i:s')]);//*/
                    //reseteando las firmas
                $existeFirma = DB::table('SOLICITUDES_FIRMAS')->where('FK_SOLICITUD_ID', $request['id_sol'])->get();
                if(count($existeFirma)!=0){
                    //dd('Limpiando Firmas');
                    $update = DB::table('SOLICITUDES_FIRMAS')
                        ->where('FK_SOLICITUD_ID', $request['id_sol'])
                        ->update([
                                    'FIRMAS_CGA' => null,
                                    'FIRMAS_TITULAR' => null,
                                    'FIRMAS_SPR' => null
                                ]);
                }
            }//*/

            if(strcmp($request['estatus'],'FIRMAS')==0){
                $update = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FECHAS_PUESTO_FIRMAS' => date('Y-m-d H:i:s')]);//*/

                //enviar coorreo electrónico
            }//*/

            //ahora eliminamos las posibles firmas que existen
            $verificaCompletado = DB::table('SOLICITUDES_FIRMAS')->where('FK_SOLICITUD_ID', $request['id_sol'])->get();
            //dd($verificaCompletado);
            if($verificaCompletado[0]->FIRMAS_CGA||$verificaCompletado[0]->FIRMAS_TITULAR||$verificaCompletado[0]->FIRMAS_SPR){
                //dd('SE HA COMPLETADO LAS FIRMAS');
                $update = DB::table('SOLICITUDES_DATOS_CGA')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['DATOS_CGA_ESTATUS' => 'TURNADO A SPR']);
                $update = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FECHAS_TURNADO_SPR' => date('Y-m-d H:i:s')]);
            }



            $data = array(
                "update"=>$update,
                "mail"=>$mail

            );

            echo json_encode($data);//*/
        }

        public function VistaCrearContratacion(){
            $categoria = \Session::get('categoria')[0];
            if(strcmp($categoria, 'TITULAR')==0){
                return view('nuevo_contratacion');
            }else{
                return view('errors.505');
            }
        }

        public function VistaCrearSustitucion(){
            $categoria = \Session::get('categoria')[0];
            if(strcmp($categoria, 'TITULAR')==0){
                return view('nuevo_sustitucion');
            }else{
                return view('errors.505');
            }
        }

        public function VistaCrearPromocion(){
            $categoria = \Session::get('categoria')[0];
            if(strcmp($categoria, 'TITULAR')==0){
                $dependencias = DependenciasController::ObtenerSoloDependencias();
                return view('nuevo_promocion');
            }else{
                return view('errors.505');
            }
        }

        public function VistaCrearCambioAdscripcion(){
            $categoria = \Session::get('categoria')[0];
            if(strcmp($categoria, 'TITULAR')==0){
                $dependencias = DependenciasController::ObtenerSoloDependencias();
                return view('nuevo_cambio_adscripcion') ->with ("dependencias",$dependencias);
            }else{
                return view('errors.505');
            }
        }

        public function VistaUsuarios(){
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
                $solicitudes = SolicitudesController::ObtenerSolicitudes();
                return view('listado_secretario_particular')->with("solicitudes",$solicitudes);
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
                ->get();
            $solicitud = array();
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
            //dd($id_dependencia);
            $rel_solicitudes = DB::table('REL_DEPENCENCIA_SOLICITUD')
                                ->where('FK_DEPENDENCIA',$id_dependencia)
                                ->get();
            //dd($rel_solicitudes);
            foreach ($rel_solicitudes as $solicitud) {
                $tmp_solicitud = SolicitudesController::ObtenerSolicitudId($solicitud->FK_SOLICITUD_ID);
                $solicitudes[$solicitud->FK_SOLICITUD_ID] = $tmp_solicitud;
                //dd($tmp_solicitud);
            }
            //dd($solicitudes);
            return $solicitudes;
        }

        public function ObtenerSolicitudes(){
            $res_solicitudes = DB::table('SOLICITUDES_DATOS_CGA')
                                ->whereNotIn('DATOS_CGA_ESTATUS',['RECIBIDO SPR','VALIDACIÓN DE INFORMACIÓN'])
                                ->select('FK_SOLICITUD_ID')
                                ->get();
            $solicitudes = array();
            foreach ($res_solicitudes as $solicitud){
                $solicitudes[$solicitud->FK_SOLICITUD_ID]=SolicitudesController::ObtenerSolicitudId($solicitud->FK_SOLICITUD_ID);
                //$solicitudes[$solicitud->SOLICITUD_ID] = (object)$tmpSol;
            }
            //dd($solicitudes);
            return $solicitudes;
        }

        public function MarcarInformacionCorrecta(Request $request){
            date_default_timezone_set('America/Mexico_City');
            //dd($request['id_sol']);
            $update = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['DATOS_CGA_ESTATUS' => 'RECIBIDO']);

            $updateFecha = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID', $request['id_sol'])
                ->update(['FECHAS_INFORMACION_COMPLETA' =>  date('Y-m-d H:i:s')]);

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

        public function AlmacenarSolicitud($datos_solicitud){
            date_default_timezone_set('America/Mexico_City');
            $sol = '';
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
                        'SOLICITUD_NOMINA' => $datos_solicitud['nomina'],
                        'SOLICITUD_SALARIO' => $datos_solicitud['salario'],
                        'SOLICITUD_JUSTIFICACION' => $datos_solicitud['justificacion'],
                        'SOLICITUD_TIPO_SOLICITUD' => $datos_solicitud['tipo_solicitud'],
                        'SOLICITUD_URGENCIA' => 'PRIORIDAD 1',
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
                        'DATOS_CGA_PRIORIDAD' => 'PRIORIDAD 1',
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
            $id_dependencia = \Session::get('id_dependencia')[0];
            $fuente_recursos = $request['fuente_recursos'];

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
            $id_dependencia = \Session::get('id_dependencia')[0];
            $fuente_recursos = $request['fuente_recursos'];

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
            $id_dependencia = \Session::get('id_dependencia')[0];
            $fuente_recursos = 'NA';

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
            $id_dependencia = \Session::get('id_dependencia')[0];
            $fuente_recursos = 'NA';

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
            $solicitudes = SolicitudesController::ObtenerSolicitudes();
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

        public static function DatosGenerales(){
            //en este método se sabrá si el sistema está funcionando de modo institucional o prestación de servicios
            $datos = array(
                            'institucional' => true
                        );
            return $datos;
        }

    }