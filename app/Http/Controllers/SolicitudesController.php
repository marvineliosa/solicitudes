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

            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function VistaCrearCambioAdscripcion(){
            $dependencias = DependenciasController::ObtenerSoloDependencias();
            return view('nuevo_cambio_adscripcion') ->with ("dependencias",$dependencias);

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
            $id_dependencia = \Session::get('id_dependencia')[0];
            $solicitudes = SolicitudesController::ObtenerSolicitudesDependencia($id_dependencia);
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
                $solicitud[$datos->FK_SOLICITUD_ID]=SolicitudesController::ObtenerSolicitudId($datos->FK_SOLICITUD_ID);
            }
            return $solicitud;
        }


        public function VistaListadoCompleto(){
            $solicitudes = SolicitudesController::ObtenerSolicitudes();
            $analistas = LoginController::ObtenerListadoAnalistas();
            //dd($analistas);
            return view('listado_completo') ->with (["solicitudes"=>$solicitudes,"analistas"=>$analistas]);

            /*return view('listado_usuarios') ->with (["usuarios"=>$usuarios,"dependencias"=>$dependencias]);//*/
        }

        public function VistaListadoAnalista(){
            $analista = \Session::get('usuario')[0];
            $solicitudes = SolicitudesController::ObtenerSolicitudesAnalista($analista);
            //$analistas = 'SIN PERMISOS';
            $analistas = array();

            return view('listado_completo') ->with (["solicitudes"=>$solicitudes,"analistas"=>$analistas]);
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

        public static function DatosGenerales(){
            //en este método se sabrá si el sistema está funcionando de modo institucional o prestación de servicios
            $datos = array(
                            'institucional' => true
                        );
            return $datos;
        }


    }