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

        public function DescargarAnexoPlantilla(){
            //dd('Epale');
            $path = str_replace('\\', '/',storage_path('app')).'/public/formatos/Anexo_Plantilla.xlsx';
            //dd($path);
            //return response()->download($path, '$name.xlsx');
            return response()->download($path);
        }

    }