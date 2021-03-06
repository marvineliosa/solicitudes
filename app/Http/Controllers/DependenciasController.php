<?php
  namespace App\Http\Controllers;

    use App\User;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request; //indispensable para usar Request de los JSON
    use Illuminate\Support\Facades\Storage;//gestion de archivos
    use Illuminate\Support\Facades\DB;//consulta a la base de datos

    class DependenciasController extends Controller
    {
        /**
         * Show the profile for the given user.
         *
         * @param  int  $id
         * @return Response
         */

        public function EditarDependencia(Request $request){
            date_default_timezone_set('America/Mexico_City');
            //dd($request);
            $mensaje = "";
            $update = null;
            $insert = null;
            //dd('VINCULACION NUEVA');
            $update = DB::table('SOLICITUDES_DEPENDENCIA')
                        ->where('DEPENDENCIA_ID', $request['id_dependencia'])
                        ->update([
                                    'DEPENDENCIA_NOMBRE' => $request['dependencia'],
                                    'DEPENDENCIA_TITULAR' => $request['titular']
                                ]);
            $update_responsable = DB::table('SOLICITUDES_LOGIN')
                        ->where('LOGIN_USUARIO', $request['usuario'])
                        ->update([
                                    'LOGIN_RESPONSABLE' => $request['titular']
                                ]);
            $existeUsuario = DB::table('SOLICITUDES_LOGIN')
                ->where('LOGIN_USUARIO',$request['usuario'])
                ->get();
            //dd($existeUsuario);
            if(count($existeUsuario)==0 && $request['usuario']){
                //verificamos si la dependencia ya tiene asignado a otro titular
                $existeRelacion = DB::table('REL_DEPENCENCIA_TITULAR')
                    ->where('FK_DEPENDENCIA',$request['id_dependencia'])
                    ->get();

                if(count($existeRelacion)==0){
                    //dd('paso el filtro 2');
                    $contrasena = LoginController::randomPassword($request['id_dependencia']);
                    //dd($contrasena);
                    $insert = DB::table('SOLICITUDES_LOGIN')
                        ->insert([
                                    'LOGIN_USUARIO' => $request['usuario'],
                                    'LOGIN_CONTRASENIA' => $contrasena,
                                    'LOGIN_CATEGORIA' => 'TITULAR',
                                    'LOGIN_RESPONSABLE' => $request['titular'],
                                ]);
                    //dd($insert);
                    if($insert){
                        DB::table('REL_DEPENCENCIA_TITULAR')
                            ->insert([
                                        'FK_USUARIO' => $request['usuario'],
                                        'FK_DEPENDENCIA' => $request['id_dependencia'],
                                        'FECHA_RELACION' => date('Y-m-d H:i:s'),
                                    ]);//*/
                        DB::table('REL_TITULAR_AVISO')
                            ->insert([
                                        'FK_USUARIO' => $request['usuario'],
                                        'FL_AVISO' => 0
                                    ]);//*/
                    }
                }else{
                    $mensaje = "La dependencia ya está enlazada al usuario: ".$existeRelacion[0]->FK_USUARIO;
                }
                
            }else{
                $mensaje = "El usuario ya se encuentra vinculado a otra dependencia o tiene otra categoría, para vincularlo o editarlo es necesario borrarlo";
            }

            $data = array(
                "update"=>$update,
                "mensaje"=>$mensaje,
                "insert"=>$insert   
            );

            echo json_encode($data);//*/
        }

        public function TraerDatosDependencia(Request $request){
            //dd($request);
            $dependencia = DependenciasController::ObtenerDatosDependencia($request['id_dependencia']);
            $usuario = DB::table('REL_DEPENCENCIA_TITULAR')
                ->where('FK_DEPENDENCIA',$request['id_dependencia'])
                ->get();
            $data = array(
                "dependencia"=>$dependencia,
                "usuario"=>((count($usuario)>0)?$usuario[0]:null)
            );
            echo json_encode($data);//*/

        }

        public function RegresarNombreDependencia(Request $request){
            $dependencia = DependenciasController::ObtenerNombreDependencia($request['id_dependencia']);
            $data = array(
                "dependencia"=>$dependencia[0]
            );

            echo json_encode($data);//*/
        }

        public static function ObtenerNombreDependencia($id_dependencia){
            $fl_sistema = SolicitudesController::DatosGenerales();
            $dependencias = null;
            if($fl_sistema['institucional']){
                $dependencia = DB::table('SOLICITUDES_DEPENDENCIA')
                    ->where('DEPENDENCIA_ID',$id_dependencia)
                    ->select(
                                'DEPENDENCIA_CODIGO as CODIGO_DEPENDENCIA',
                                'DEPENDENCIA_NOMBRE as NOMBRE_DEPENDENCIA'
                            )
                    ->get();
            }else{
                $dependencia = DB::table('SOLICITUDES_DEPENDENCIA')
                    ->where('DEPENDENCIA_ID',$id_dependencia)
                    ->select(
                                'DEPENDENCIA_CODIGO as NOMBRE_DEPENDENCIA',
                                'DEPENDENCIA_NOMBRE as NOMBRE_INTERNO_DEPENDENCIA'
                            )
                    ->get();
            }
            //dd($dependencia);
            return $dependencia;

        }

        public static function ObtenerCodigoDependencia($id_dependencia){
            $fl_sistema = SolicitudesController::DatosGenerales();
            $dependencia = DB::table('SOLICITUDES_DEPENDENCIA')
                ->where('DEPENDENCIA_ID',$id_dependencia)
                ->select(
                            'DEPENDENCIA_CODIGO as NOMBRE_DEPENDENCIA'
                        )
                ->get();
            return $dependencia[0];

        }

        public function VistaDependencias(){
            $dependencias = DependenciasController::ObtenerSoloDependencias();
            return view('dependencias') ->with ("dependencias",$dependencias);
        }

        public static function ObtenerSoloDependencias(){
            $categoria = \Session::get('categoria')[0];
            $fl_sistema = SolicitudesController::DatosGenerales();
            $dependencias = null;
            if($fl_sistema['institucional'] || in_array($categoria, ['TRABAJADOR_SPR'])){
                $dependencias = DB::table('SOLICITUDES_DEPENDENCIA')
                    ->select(
                                'DEPENDENCIA_ID as ID_DEPENDENCIA',
                                'DEPENDENCIA_CODIGO as CODIGO_DEPENDENCIA',
                                'DEPENDENCIA_NOMBRE as NOMBRE_DEPENDENCIA'
                            )
                    ->where([['DEPENDENCIA_CODIGO', '<>', 2103],['DEPENDENCIA_CODIGO', '<>', 2104]])
                    ->orderBy('NOMBRE_DEPENDENCIA','asc')
                    ->get();
            }else{
                $dependencias = DB::table('SOLICITUDES_DEPENDENCIA')
                    ->select(
                                'DEPENDENCIA_ID as ID_DEPENDENCIA',
                                'DEPENDENCIA_CODIGO as NOMBRE_DEPENDENCIA'
                            )
                    //->where([['DEPENDENCIA_CODIGO', '<>', 2103],['DEPENDENCIA_CODIGO', '<>', 2104]])
                    ->orderBy('DEPENDENCIA_CODIGO', 'asc')
                    ->get();
            }
            return $dependencias;
        }

        public function ObtenerTodasDependencias(){
            $dependencias = DB::table('SOLICITUDES_DEPENDENCIA')
                ->select(
                            'DEPENDENCIA_ID as ID_DEPENDENCIA',
                            'DEPENDENCIA_CODIGO as CODIGO_DEPENDENCIA',
                            'DEPENDENCIA_NOMBRE as NOMBRE_DEPENDENCIA',
                            'DEPENDENCIA_TITULAR as TITULAR_DEPENDENCIA'
                        )
                ->get();
            return $dependencias;
        }

        public static function ObtenerDatosDependencia($id_dependencia){
            //dd($id_dependencia);
            $dependencia = DB::table('SOLICITUDES_DEPENDENCIA')
                ->where('DEPENDENCIA_ID',$id_dependencia)
                ->select(
                            'DEPENDENCIA_ID as ID_DEPENDENCIA',
                            'DEPENDENCIA_CODIGO as CODIGO_DEPENDENCIA',
                            'DEPENDENCIA_NOMBRE as NOMBRE_DEPENDENCIA',
                            'DEPENDENCIA_TITULAR as TITULAR_DEPENDENCIA'
                        )
                ->get();
            return $dependencia[0];
        }

    }

/*

insert into SOLICITUDES_DEPENDENCIA (DEPENDENCIA_CODIGO,DEPENDENCIA_NOMBRE,created_at) values(2104,'DEPENDENCIA PRUEBA 2','2019-03-07 11:16:58');

insert into SOLICITUDES_DEPENDENCIA (DEPENDENCIA_CODIGO,DEPENDENCIA_NOMBRE,created_at) values(504,'MUSEO UNIVERSITARIO','2019-07-04 11:16:58');

*/
