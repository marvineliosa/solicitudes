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
            $id_solicitud = str_replace('_','/',$id_solicitud);
            $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
            return view('pdf.cuadro') ->with ("solicitud",$solicitud);
        }

        public function PDFContratacion($id_solicitud){
            $id_solicitud = str_replace('_','/',$id_solicitud);
            //hay que validar que exista la solicitud
            $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
            $pdf = \PDF::loadView('pdf.cuadro',['solicitud'=>$solicitud])->setPaper('a4', 'landscape');
            //return $pdf->download($descripcion['DATOS']->NOM_DESC.'.pdf');
            return $pdf->stream();

            //return view('error.404') ->with ("solicitud",$solicitud);
        }

        public function GuardaDatosCGA(Request $request){
            //dd($request);
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
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function AbrirContratacion($id_solicitud){
            $id_solicitud = str_replace('_','/',$id_solicitud);
            $solicitud = SolicitudesController::ObtenerSolicitudId($id_solicitud);
            //dd($solicitud);
            return view('edicion_contratacion') ->with ("solicitud",$solicitud);
            //dd($id_solicitud);

        }


        public function ObtenerSolicitudId($id_solicitud){
            date_default_timezone_set('America/Mexico_City');
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
                                'SOLICITUD_TIPO_SOLICITUD as TIPO_SOLICITUD_SOLICITUD'
                            )
                    ->get();

            $solicitud[0]->ID_ESCAPE = str_replace('/','_',$solicitud[0]->ID_SOLICITUD);
            $solicitud[0]->SALARIO_FORMATO = number_format($solicitud[0]->SALARIO_SOLICITUD,2);
            //echo 'DE: ', $formatter->formatCurrency($amount, 'EUR'), PHP_EOL;
            $fechas = DB::table('SOLICITUDES_FECHAS')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();
            //dd($fechas);
            $solicitud[0]->FECHA_CREACION = $fechas[0]->FECHAS_CREACION_SOLICITUD;
            $solicitud[0]->FECHAS_INFORMACION_COMPLETA = $fechas[0]->FECHAS_INFORMACION_COMPLETA;
            $solicitud[0]->FECHA_TURNADO_CGA = $fechas[0]->FECHAS_TURNADO_CGA;
            $solicitud[0]->FECHA_ENVIO = $fechas[0]->FECHAS_TURNADO_SPR;

            $datos_cga = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('FK_SOLICITUD_ID',$id_solicitud)
                ->get();

            $solicitud[0]->CATEGORIA_PROPUESTA = $datos_cga[0]->DATOS_CGA_CATEGORIA_PROPUESTA;
            $solicitud[0]->PUESTO_PROPUESTO = $datos_cga[0]->DATOS_CGA_PUESTO_PROPUESTO;
            $solicitud[0]->SALARIO_PROPUESTO = $datos_cga[0]->DATOS_CGA_SALARIO_PROPUESTO;
            $solicitud[0]->ESTATUS_PROCEDE = $datos_cga[0]->DATOS_CGA_PROCEDENTE;
            $solicitud[0]->RESPUESTA_CGA = $datos_cga[0]->DATOS_CGA_RESPUESTA;
            $solicitud[0]->CATEGORIA_SUPERIOR = $datos_cga[0]->DATOS_CGA_CATEGORIA_SUPERIOR;
            $solicitud[0]->SALARIO_SUPERIOR = $datos_cga[0]->DATOS_CGA_SALARIO_SUPERIOR;
            $solicitud[0]->CATEGORIA_INFERIOR = $datos_cga[0]->DATOS_CGA_CATEGORIA_INFERIOR;
            $solicitud[0]->SALARIO_INFERIOR = $datos_cga[0]->DATOS_CGA_SALARIO_INFERIOR;
            $solicitud[0]->ESTATUS_SOLICITUD = $datos_cga[0]->DATOS_CGA_ESTATUS;
            $solicitud[0]->HOY = date('d/m/Y');

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
            $usuario = 'USUARIO TITULAR';//aqui se debe poner el nombre del usuario de SPR

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
            $usuario = 'USUARIO COORDINADOR';//aqui se debe poner el nombre del usuario de SPR

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
            $usuario = 'USUARIO SPR';//aqui se debe poner el nombre del usuario de SPR

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

            if(strcmp($request['estatus'],'TURNADO A SPR')==0){
                $update = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FECHAS_TURNADO_SPR' => date('Y-m-d H:i:s')]);
                }//*/

            if(strcmp($request['estatus'],'FIRMAS')==0){
                /*$update = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID', $request['id_sol'])
                    ->update(['FECHAS_TURNADO_SPR' => date('Y-m-d H:i:s')]);//*/
                }//*/

            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function VistaNuevasSPR(){
            $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('RECIBIDO SPR');
            return view('listado_nuevas') ->with ("solicitudes",$solicitudes);
        }

        public function VistaPorRevisarSPR(){
            $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('TURNADO A SPR');
            return view('listado_por_revisar') ->with ("solicitudes",$solicitudes);
        }

        public function VistaRevisadasSPR(){
            $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('COMPLETADO POR SPR');
            return view('listado_revisadas') ->with ("solicitudes",$solicitudes);
        }

        
        public function VistaListadoRevisionInformacion(){
            $solicitudes = SolicitudesController::ObtenerSolicitudesEstatus('VALIDACION DE INFORMACION');
            return view('listado_revision_informacion') ->with ("solicitudes",$solicitudes);
        }
        
        public function VistaListadoDependencia(){
            $solicitudes = SolicitudesController::ObtenerSolicitudes();
            return view('listado_dependencia')->with("solicitudes",$solicitudes);
        }
        
        public function VistaListadoSecretarioParticular(){
            $solicitudes = SolicitudesController::ObtenerSolicitudes();
            return view('listado_secretario_particular')->with("solicitudes",$solicitudes);
        }
        
        public function VistaListadoCGA(){
            $solicitudes = SolicitudesController::ObtenerSolicitudes();
            return view('listado_cga')->with("solicitudes",$solicitudes);
        }

        public function VistaListadoEnProceso(){
            $solicitudes = SolicitudesController::ObtenerSolicitudes();
            return view('listado_en_proceso') ->with ("solicitudes",$solicitudes);
        }


        public function ObtenerSolicitudesEstatus($estatus){

            $datos_cga = DB::table('SOLICITUDES_DATOS_CGA')
                ->where('DATOS_CGA_ESTATUS',$estatus)
                ->get();
            $solicitud = array();
            foreach ($datos_cga as $datos) {
                $tmp_solicitud = DB::table('SOLICITUDES_SOLICITUD')
                    ->where('SOLICITUD_ID',$datos->FK_SOLICITUD_ID)
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
                                'SOLICITUD_URGENCIA as PRIORIDAD_SOLICITUD'
                            )
                    ->get();
                $tmp_solicitud[0]->ESTATUS_SOLICITUD = $datos->DATOS_CGA_ESTATUS;
                $tmp_solicitud[0]->ID_ESCAPE = str_replace('/','_',$tmp_solicitud[0]->ID_SOLICITUD);

                $fechas = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID',$datos->FK_SOLICITUD_ID)
                    ->get();
                //dd($fechas);
                $tmp_solicitud[0]->FECHA_CREACION = $fechas[0]->FECHAS_CREACION_SOLICITUD;
                $tmp_solicitud[0]->FECHA_TURNADO_SPR = $fechas[0]->FECHAS_INFORMACION_COMPLETA;
                $tmp_solicitud[0]->FECHA_TURNADO_CGA = $fechas[0]->FECHAS_TURNADO_CGA;

                $solicitud[$datos->FK_SOLICITUD_ID]=$tmp_solicitud[0];

            }
            return $solicitud;
        }

        public function VistaListadoCompleto(){
            $solicitudes = SolicitudesController::ObtenerSolicitudes();
            //dd($solicitudes);
            return view('listado_completo') ->with ("solicitudes",$solicitudes);
        }

        public function ObtenerSolicitudes(){
            $res_solicitudes = DB::table('SOLICITUDES_SOLICITUD')->get();
            $solicitudes = array();
            foreach ($res_solicitudes as $solicitud){
                $tmpSol = array();
                $tmpSol['ID_SOLICITUD'] = $solicitud->SOLICITUD_ID;
                $tmpSol['OFICIO_SOLICITUD'] = $solicitud->SOLICITUD_OFICIO;
                $tmpSol['NOMBRE_SOLICITUD'] = $solicitud->SOLICITUD_NOMBRE;
                $tmpSol['DEPENDENCIA_SOLICITUD'] = $solicitud->SOLICITUD_DEPENDENCIA;
                $tmpSol['CATEGORIA_SOLICITUD'] = $solicitud->SOLICITUD_CATEGORIA;
                $tmpSol['PUESTO_SOLICITUD'] = $solicitud->SOLICITUD_PUESTO;
                $tmpSol['ACTIVIDADES_SOLICITUD'] = $solicitud->SOLICITUD_ACTIVIDADES;
                $tmpSol['NOMINA_SOLICITUD'] = $solicitud->SOLICITUD_NOMINA;
                $tmpSol['SALARIO_SOLICITUD'] = $solicitud->SOLICITUD_SALARIO;
                $tmpSol['JUSTIFICACION_SOLICITUD'] = $solicitud->SOLICITUD_JUSTIFICACION;
                $tmpSol['TIPO_SOLICITUD_SOLICITUD'] = $solicitud->SOLICITUD_TIPO_SOLICITUD;
                $tmpSol['ID_ESCAPE'] = str_replace('/','_',$solicitud->SOLICITUD_ID);
                $datos_cga = DB::table('SOLICITUDES_DATOS_CGA')
                    ->where('FK_SOLICITUD_ID',$solicitud->SOLICITUD_ID)
                    ->get();
                //$solicitud->ESTATUS_SOLICITUD = $datos_cga[0]->DATOS_CGA_ESTATUS;
                $tmpSol['ESTATUS_SOLICITUD'] = $datos_cga[0]->DATOS_CGA_ESTATUS;
                $fechas = DB::table('SOLICITUDES_FECHAS')
                    ->where('FK_SOLICITUD_ID',$solicitud->SOLICITUD_ID)
                    ->get();
                //dd($fechas);

                $tmpSol['FECHA_CREACION'] = $fechas[0]->FECHAS_CREACION_SOLICITUD;
                $tmpSol['FECHA_TURNADO_SPR'] = $fechas[0]->FECHAS_INFORMACION_COMPLETA;
                $tmpSol['FECHA_TURNADO_CGA'] = $fechas[0]->FECHAS_TURNADO_CGA;

                /*$solicitud->FECHA_CREACION = $fechas[0]->FECHAS_CREACION_SOLICITUD;
                $solicitud->FECHA_TURNADO_SPR = $fechas[0]->FECHAS_INFORMACION_COMPLETA;
                $solicitud->FECHA_TURNADO_CGA = $fechas[0]->FECHAS_TURNADO_CGA;//*/
                $solicitudes[$solicitud->SOLICITUD_ID] = (object)$tmpSol;
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
            $id_dependencia = 106;
            //dd($request);
            //Se bloquea la base de datos para que otro usuario no genere un folio repetido
            DB::raw('lock tables SOLICITUDES_SOLICITUD write');
                $ultima_solicitud = DB::table('SOLICITUDES_SOLICITUD')->latest()->get();
                //$ultima_solicitud = DB::table('SOLICITUDES_SOLICITUD')->get();
                //dd(gettype($ultima_solicitud));
                //dd(count($ultima_solicitud));
                //dd(gettype($request['categoria']));
                if(count($ultima_solicitud)==0){//es la primera solicitud de la base de datos
                    //dd('Primera Solicitud');
                    $año = date('Y');
                    $sol = 'SOL/1/'.$año;
                    //dd($sol);
                }else{
                    //dd('NO ES PRIMERA SOLICITUD');
                    $separa = explode("/", $ultima_solicitud[0]->SOLICITUD_ID);
                    //dd($separa);
                    if(strcmp(date('Y'),$separa[2])==0){//en caso de que el año sea el mismo
                        $consecutivo = ((int)$separa[1])+1;
                    }else{//en caso de que el año haya cambiado, primera solicitud del año en curso
                        //dd('Nuevo año');
                        $consecutivo = '1';
                    }
                    $sol = 'SOL/'.$consecutivo.'/'.date('Y');
                    //dd($sol);
                    //dd(gettype($consecutivo));
                    //dd($ultima_solicitud[0]->SOLICITUD_ID);
                }
                DB::table('SOLICITUDES_SOLICITUD')->insert(
                    [
                        'SOLICITUD_ID' => $sol,
                        'SOLICITUD_OFICIO' => '',
                        'SOLICITUD_NOMBRE' => $candidato,
                        'SOLICITUD_DEPENDENCIA' => $id_dependencia,
                        'SOLICITUD_CATEGORIA' => $categoria,
                        'SOLICITUD_PUESTO' => $puesto,
                        'SOLICITUD_ACTIVIDADES' => $actividades,
                        'SOLICITUD_NOMINA' => $nomina,
                        'SOLICITUD_SALARIO' => $salario,
                        'SOLICITUD_JUSTIFICACION' => $justificacion,
                        'SOLICITUD_TIPO_SOLICITUD' => 'CONTRATACIÓN',
                        'SOLICITUD_URGENCIA' => 'PRIORIDAD 1',
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );//*/
            DB::raw('unlock tables');

            DB::table('SOLICITUDES_DATOS_CGA')->insert(
                [
                    'FK_SOLICITUD_ID' => $sol,
                    'DATOS_CGA_ESTATUS' => 'RECIBIDO SPR',
                    'DATOS_CGA_PRIORIDAD' => 'NORMAL',
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
            //dd('Listo: '.$sol);
            //dd($descripciones);
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
            $id_dependencia = 106;

            
            //Se bloquea la base de datos para que otro usuario no genere un folio repetido
            DB::raw('lock tables SOLICITUDES_SOLICITUD write');
                $ultima_solicitud = DB::table('SOLICITUDES_SOLICITUD')->latest()->get();
                //$ultima_solicitud = DB::table('SOLICITUDES_SOLICITUD')->get();
                //dd(gettype($ultima_solicitud));
                //dd(count($ultima_solicitud));
                //dd(gettype($request['categoria']));
                if(count($ultima_solicitud)==0){//es la primera solicitud de la base de datos
                    //dd('Primera Solicitud');
                    $año = date('Y');
                    $sol = 'SOL/1/'.$año;
                    //dd($sol);
                }else{
                    //dd('NO ES PRIMERA SOLICITUD');
                    $separa = explode("/", $ultima_solicitud[0]->SOLICITUD_ID);
                    //dd($separa);
                    if(strcmp(date('Y'),$separa[2])==0){//en caso de que el año sea el mismo
                        $consecutivo = ((int)$separa[1])+1;
                    }else{//en caso de que el año haya cambiado, primera solicitud del año en curso
                        //dd('Nuevo año');
                        $consecutivo = '1';
                    }
                    $sol = 'SOL/'.$consecutivo.'/'.date('Y');
                    //dd($sol);
                    //dd(gettype($consecutivo));
                    //dd($ultima_solicitud[0]->SOLICITUD_ID);
                }
                DB::table('SOLICITUDES_SOLICITUD')->insert(
                    [
                        'SOLICITUD_ID' => $sol,
                        'SOLICITUD_OFICIO' => '',
                        'SOLICITUD_NOMBRE' => $persona_anterior,
                        'SOLICITUD_DEPENDENCIA' => $id_dependencia,
                        'SOLICITUD_CATEGORIA' => $categoria_anterior,
                        'SOLICITUD_PUESTO' => $puesto_anterior,
                        'SOLICITUD_ACTIVIDADES' => $actividades_anterior,
                        'SOLICITUD_NOMINA' => $nomina,
                        'SOLICITUD_SALARIO' => $salario_anterior,
                        'SOLICITUD_JUSTIFICACION' => $justificacion,
                        'SOLICITUD_TIPO_SOLICITUD' => 'CONTRATACIÓN POR SUSTITUCIÓN',
                        'SOLICITUD_URGENCIA' => 'PRIORIDAD 1',
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );//*/
            DB::raw('unlock tables');

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

            DB::table('SOLICITUDES_DATOS_CGA')->insert(
                [
                    'FK_SOLICITUD_ID' => $sol,
                    'DATOS_CGA_ESTATUS' => 'RECIBIDO SPR',
                    'DATOS_CGA_PRIORIDAD' => 'NORMAL',
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
            $id_dependencia = 106;
            
            //Se bloquea la base de datos para que otro usuario no genere un folio repetido
            DB::raw('lock tables SOLICITUDES_SOLICITUD write');
                $ultima_solicitud = DB::table('SOLICITUDES_SOLICITUD')->latest()->get();
                //$ultima_solicitud = DB::table('SOLICITUDES_SOLICITUD')->get();
                //dd(gettype($ultima_solicitud));
                //dd(count($ultima_solicitud));
                //dd(gettype($request['categoria']));
                if(count($ultima_solicitud)==0){//es la primera solicitud de la base de datos
                    //dd('Primera Solicitud');
                    $año = date('Y');
                    $sol = 'SOL/1/'.$año;
                    //dd($sol);
                }else{
                    //dd('NO ES PRIMERA SOLICITUD');
                    $separa = explode("/", $ultima_solicitud[0]->SOLICITUD_ID);
                    //dd($separa);
                    if(strcmp(date('Y'),$separa[2])==0){//en caso de que el año sea el mismo
                        $consecutivo = ((int)$separa[1])+1;
                    }else{//en caso de que el año haya cambiado, primera solicitud del año en curso
                        //dd('Nuevo año');
                        $consecutivo = '1';
                    }
                    $sol = 'SOL/'.$consecutivo.'/'.date('Y');
                    //dd($sol);
                    //dd(gettype($consecutivo));
                    //dd($ultima_solicitud[0]->SOLICITUD_ID);
                }
                DB::table('SOLICITUDES_SOLICITUD')->insert(
                    [
                        'SOLICITUD_ID' => $sol,
                        'SOLICITUD_OFICIO' => '',
                        'SOLICITUD_NOMBRE' => $Candidato,
                        'SOLICITUD_DEPENDENCIA' => $id_dependencia,
                        'SOLICITUD_CATEGORIA' => $CategoriaActual,
                        'SOLICITUD_PUESTO' => $PuestoActual,
                        'SOLICITUD_ACTIVIDADES' => $ActividadesActuales,
                        'SOLICITUD_NOMINA' => $nomina,
                        'SOLICITUD_SALARIO' => $SalarioActual,
                        'SOLICITUD_JUSTIFICACION' => $justificacion,
                        'SOLICITUD_TIPO_SOLICITUD' => 'PROMOCION',
                        'SOLICITUD_URGENCIA' => 'PRIORIDAD 1',
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );//*/
            DB::raw('unlock tables');

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

            DB::table('SOLICITUDES_DATOS_CGA')->insert(
                [
                    'FK_SOLICITUD_ID' => $sol,
                    'DATOS_CGA_ESTATUS' => 'RECIBIDO SPR',
                    'DATOS_CGA_PRIORIDAD' => 'NORMAL',
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

            $DependenciaDestino = 120;
            $CategoriaNueva = $request['CategoriaNueva'];
            $PuestoNuevo = $request['PuestoNuevo'];
            $ActividadesNuevas = $request['ActividadesNuevas'];
            $SalarioSolicitado = $request['SalarioSolicitado'];
            
            $nomina = $request['Nomina'];
            $justificacion = $request['Justificacion'];
            $id_dependencia = 106;
            //dd($ActividadesNuevas);
            //Se bloquea la base de datos para que otro usuario no genere un folio repetido
            DB::raw('lock tables SOLICITUDES_SOLICITUD write');
                $ultima_solicitud = DB::table('SOLICITUDES_SOLICITUD')->latest()->get();
                //$ultima_solicitud = DB::table('SOLICITUDES_SOLICITUD')->get();
                //dd(gettype($ultima_solicitud));
                //dd(count($ultima_solicitud));
                //dd(gettype($request['categoria']));
                if(count($ultima_solicitud)==0){//es la primera solicitud de la base de datos
                    //dd('Primera Solicitud');
                    $año = date('Y');
                    $sol = 'SOL/1/'.$año;
                    //dd($sol);
                }else{
                    //dd('NO ES PRIMERA SOLICITUD');
                    $separa = explode("/", $ultima_solicitud[0]->SOLICITUD_ID);
                    //dd($separa);
                    if(strcmp(date('Y'),$separa[2])==0){//en caso de que el año sea el mismo
                        $consecutivo = ((int)$separa[1])+1;
                    }else{//en caso de que el año haya cambiado, primera solicitud del año en curso
                        //dd('Nuevo año');
                        $consecutivo = '1';
                    }
                    $sol = 'SOL/'.$consecutivo.'/'.date('Y');
                    //dd($sol);
                    //dd(gettype($consecutivo));
                    //dd($ultima_solicitud[0]->SOLICITUD_ID);
                }
                DB::table('SOLICITUDES_SOLICITUD')->insert(
                    [
                        'SOLICITUD_ID' => $sol,
                        'SOLICITUD_OFICIO' => '',
                        'SOLICITUD_NOMBRE' => $NombreCandidato,
                        'SOLICITUD_DEPENDENCIA' => $id_dependencia,
                        'SOLICITUD_CATEGORIA' => $CategoriaActual,
                        'SOLICITUD_PUESTO' => $PuestoActual,
                        'SOLICITUD_ACTIVIDADES' => $ActividadesActuales,
                        'SOLICITUD_NOMINA' => $nomina,
                        'SOLICITUD_SALARIO' => $SalarioActual,
                        'SOLICITUD_JUSTIFICACION' => $justificacion,
                        'SOLICITUD_TIPO_SOLICITUD' => 'CAMBIO DE ADSCRIPCIÓN',
                        'SOLICITUD_URGENCIA' => 'PRIORIDAD 1',
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );//*/
            DB::raw('unlock tables');

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

            DB::table('SOLICITUDES_DATOS_CGA')->insert(
                [
                    'FK_SOLICITUD_ID' => $sol,
                    'DATOS_CGA_ESTATUS' => 'RECIBIDO SPR',
                    'DATOS_CGA_PRIORIDAD' => 'NORMAL',
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
            //dd('Listo: '.$sol);
            //dd($descripciones);
            $data = array(
                "solicitud"=>$sol
            );

            echo json_encode($data);//*/
        }

        public function CerrarSql(Request $request){

            dd('epale');
            //DB::raw('unlock tables');//*/
        }

        public function RefrescarListadoCompleto(){
            $solicitudes = SolicitudesController::ObtenerSolicitudes();
            //dd($solicitudes);
            return View('tablas.listado_completo') ->with ("solicitudes",$solicitudes);
            //return View::make("tablas.listado_completo", ["solicitudes" => $solicitudes]);
    
        }


    }