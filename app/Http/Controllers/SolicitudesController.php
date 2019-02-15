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
                        'SOLICITUD_CATEGORIA' => $categoria,
                        'SOLICITUD_PUESTO' => $puesto,
                        'SOLICITUD_ACTIVIDADES' => $actividades,
                        'SOLICITUD_NOMINA' => $nomina,
                        'SOLICITUD_SALARIO' => $salario,
                        'SOLICITUD_JUSTIFICACION' => $justificacion,
                        'SOLICITUD_TIPO_SOLICITUD' => $sol,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );//*/
            DB::raw('unlock tables');

            DB::table('SOLICITUDES_DATOS_CGA')->insert(
                [
                    'FK_SOLICITUD_ID' => $sol,
                    'DATOS_CGA_ESTATUS' => 'VALIDACION_INFORMACION',
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


    }