<?php
  namespace App\Http\Controllers;

    use App\User;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request; //indispensable para usar Request de los JSON
    use Illuminate\Support\Facades\Storage;//gestion de archivos
    use Illuminate\Support\Facades\DB;//consulta a la base de datos

    class ArchivosController extends Controller
    {
        /**
         * Show the profile for the given user.
         *
         * @param  int  $id
         * @return Response
         */

        public function AgregarMensaje(Request $request){
            //dd($request);
            $update = DB::table('SOLICITUDES_ARCHIVOS')
                ->where('ARCHIVOS_ID', $request['id_archivo'])
                ->update(['ARCHIVOS_MENSAJE' => $request['mensaje']]);
            
            $data = array(
                "update"=>$update
            );

            echo json_encode($data);//*/
        }

        public function DescargarArchivo($id_archivo){
            $archivo = DB::table('SOLICITUDES_ARCHIVOS')
                ->where('ARCHIVOS_ID',$id_archivo)
                ->get();
            $ext = pathinfo($archivo[0]->ARCHIVOS_RUTA, PATHINFO_EXTENSION);
            //dd($ext);
            $nombre_archivo = $archivo[0]->ARCHIVOS_NOMBRE.'.'.$ext;

            $path = str_replace('\\', '/',storage_path('app')).'/'.$archivo[0]->ARCHIVOS_RUTA;
            return response()->download($path,$nombre_archivo);
        }

        public function RegresarArchivosSolicitud(Request $request){
            $id_solicitud = $request['id_solicitud'];
            $archivos = ArchivosController::ObtenerArchivosSolicitud($id_solicitud);

            $data = array(
                "archivos"=>$archivos
            );

            echo json_encode($data);//*/
        }

        public function ObtenerArchivosSolicitud($id_solicitud){
            $archivos = array();
            $rel_archivos = DB::table('REL_ARCHIVOS_SOLICITUD')
                ->where('FK_SOLICITUD_ID', $id_solicitud)
                ->get();
            foreach ($rel_archivos as $relacion) {
                $tmp_archivo = DB::table('SOLICITUDES_ARCHIVOS')
                    ->where('ARCHIVOS_ID',$relacion->FK_ARCHIVO)
                    ->select(
                                'ARCHIVOS_ID as ID_ARCHIVO',
                                'ARCHIVOS_MENSAJE as MENSAJE_ARCHIVO'
                            )
                    ->get();
                if(count($tmp_archivo)>0){
                    $tmp_archivo[0]->TIPO_ARCHIVO = $relacion->TIPO_ARCHIVO;
                }
                $archivos[] = $tmp_archivo[0];
            }
            //dd($archivos);
            return $archivos;
        }

        public function DescargarAnexoPlantilla(){
            //dd('Epale');
            $path = str_replace('\\', '/',storage_path('app')).'/public/formatos/Anexo_Plantilla.xlsx';
            //dd($path);
            //return response()->download($path, '$name.xlsx');
            return response()->download($path);
        }

    }