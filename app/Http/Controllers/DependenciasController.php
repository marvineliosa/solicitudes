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
            $update = DB::table('SOLICITUDES_DEPENDENCIA')
                        ->where('DEPENDENCIA_ID', $request['id_dependencia'])
                        ->update(['DEPENDENCIA_TITULAR' => $request['titular']]);
            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function TraerDatosDependencia(Request $request){
            //dd($request);
            $dependencia = DependenciasController::ObtenerDatosDependencia($request['id_dependencia']);
            $data = array(
                "dependencia"=>$dependencia
            );

            echo json_encode($data);//*/

        }

        public function VistaDependencias(){
            $dependencias = DependenciasController::ObtenerSoloDependencias();
            return view('dependencias') ->with ("dependencias",$dependencias);
        }

        public function ObtenerSoloDependencias(){
            $dependencias = DB::table('SOLICITUDES_DEPENDENCIA')
                ->select(
                            'DEPENDENCIA_ID as ID_DEPENDENCIA',
                            'DEPENDENCIA_CODIGO as CODIGO_DEPENDENCIA',
                            'DEPENDENCIA_NOMBRE as NOMBRE_DEPENDENCIA'
                        )
                ->get();
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

        public function ObtenerDatosDependencia($id_dependencia){
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