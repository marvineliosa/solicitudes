<?php
  namespace App\Http\Controllers;

    use App\User;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request; //indispensable para usar Request de los JSON
    use Illuminate\Support\Facades\Storage;//gestion de archivos
    use Illuminate\Support\Facades\DB;//consulta a la base de datos

    class LoginController extends Controller
    {
        /**
         * Show the profile for the given user.
         *
         * @param  int  $id
         * @return Response
         */

        public function ValidarUsuario(Request $request){
            //dd("epale");
            $usr = $request['usuario'];
            $contrasena = $request['pass'];
            $fl = false;
            $usuario = "";
            $existe = DB::table('SOLICITUDES_LOGIN')->where(['LOGIN_USUARIO'=> $usr, 'LOGIN_CONTRASENIA' => $contrasena])->get();
            //dd($existe);
            if(count($existe)>0){
                //$n_usuario = DB::table('DP_USUARIOS')->where('USUARIOS_USUARIO', $usr)->get();
                $fl = true;
                //$usuario = $existe[0]->LOGIN_USUARIO;
                if(\Session::get('usuario')!=null){
                    \Session::forget('usuario');
                    \Session::forget('categoria');
                    //\Session::forget('nombre');
                }
                \Session::push('usuario',$existe[0]->LOGIN_USUARIO);
                \Session::push('categoria',$existe[0]->CATEGORIA);
                //\Session::push('nombre',$n_usuario[0]->USUARIOS_NOMBRE_RESPONSABLE);
            }
            $data = array(
                "usuario"=>\Session::get('usuario')[0],
                "categoria"=>\Session::get('categoria')[0],
                "exito" => $fl
              );

            echo json_encode($data);//*/
        }

        public function cerrarSesion(){
            \Session::forget('usuario');
            \Session::forget('categoria');
            //\Session::forget('nombre');
            return redirect('/');
        }

    }