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

        public function RecuperarContrasena(Request $request){
            $usuario = $request['usuario'];
            $categoria = DB::table('SOLICITUDES_LOGIN')
                ->where('LOGIN_USUARIO',$usuario)
                ->select('LOGIN_CATEGORIA')
                ->get();
            //dd($categoria[0]->LOGIN_CATEGORIA);
            if(in_array($categoria[0]->LOGIN_CATEGORIA, ['ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA','TRABAJADOR_SPR','SECRETARIO_PARTICULAR'])){
                //dd('Mail usuario normal');
                $exito = MailsController::FuncionEnviarContrasena($usuario);
            }else{
                //dd('Mail titular');
                $exito = MailsController::FuncionEnviarContrasenaDependencia($usuario);
            }


            //$exito = MailsController::FuncionEnviarContrasena($usuario);
            $mensaje = '';
            $titulo = '';
            if($exito){
                $titulo = '¡ÉXITO!';
                $mensaje = 'Se ha enviado la contraseña satisfactoriamente';
            }else{
                $titulo = '¡ATENCIÓN!';
                $exito = 'Existió un problema al enviar la contraseña, si el problema persiste, por favor verifique si la cuenta de correo es';
            }
            
            $data = array(
                "mensaje" => $mensaje,
                "titulo" => $titulo
              );

            echo json_encode($data);//*/
        }

        public function ExisteCoordinador(){
            $existe_coordinador = DB::table('SOLICITUDES_LOGIN')
                ->where('LOGIN_CATEGORIA','COORDINADOR_CGA')
                ->get();
            if(count($existe_coordinador)>0){
                return true;
            }else{
                return false;
            }
        }

        public function ExisteAdministrador(){
            $existe_coordinador = DB::table('SOLICITUDES_LOGIN')
                ->where('LOGIN_CATEGORIA','ADMINISTRADOR_CGA')
                ->get();
            if(count($existe_coordinador)>0){
                return true;
            }else{
                return false;
            }
        }

        public function ExisteSecretario(){
            $existe_coordinador = DB::table('SOLICITUDES_LOGIN')
                ->where('LOGIN_CATEGORIA','SECRETARIO_PARTICULAR')
                ->get();
            if(count($existe_coordinador)>0){
                return true;
            }else{
                return false;
            }
        }

        public function CrearUsuarioGeneral(Request $request){
            date_default_timezone_set('America/Mexico_City');
            //dd($request->tipo_usuario);
            if((strcmp($request->tipo_usuario, 'COORDINADOR_CGA')==0) && LoginController::ExisteCoordinador()){
                //dd('coordinador');
                $mensaje = 'Ya se encuentra registrado un usuario Coordinador General Administrativo en el sistema. Para registrar otro, borre el que existe.';
            }else if((strcmp($request->tipo_usuario, 'SECRETARIO_PARTICULAR')==0) && LoginController::ExisteSecretario()){
                //dd('Secretario');
                $mensaje = 'Ya se encuentra registrado un usuario Secretario Particular de Rectoría en el sistema. Para registrar otro, borre el que existe.';
            }else if((strcmp($request->tipo_usuario, 'ADMINISTRADOR_CGA')==0) && LoginController::ExisteAdministrador()){
                //dd('Secretario');
                $mensaje = 'Ya se encuentra registrado un usuario Administrador en el sistema. Para registrar otro, borre el que existe.';
            }else{
                //dd('nuevo');
                $existe_usuario = DB::table('SOLICITUDES_LOGIN')
                    ->where('LOGIN_USUARIO',$request['usuario'])
                    ->get();
                $mensaje = '';
                if(count($existe_usuario)==0){
                    $contrasena = LoginController::randomPassword();
                    $insert = DB::table('SOLICITUDES_LOGIN')
                        ->insert([
                                    'LOGIN_USUARIO' => $request['usuario'],
                                    'LOGIN_CONTRASENIA' => $contrasena,
                                    'LOGIN_CATEGORIA' => $request['tipo_usuario'],
                                    'LOGIN_RESPONSABLE' => $request['responsable'],
                                    'created_at' => date('Y-m-d H:i:s')
                                ]);
                    $mensaje = 'El usuario ha sido registrado satirfacotiamente, se ha enviado la contraseña a '.$request['usuario'];
                    $exito_mail = MailsController::FuncionEnviarContrasena($request['usuario']);
                }else{
                    $mensaje = 'El usuario ya se encuentra registrado, para cualquier cambio favor de eliminarlo e intentarlo nuevamente';
                } 
            }
            
            $data = array(
                "mensaje" => $mensaje
              );

            echo json_encode($data);//*/
        }

        public static function ObtenerListadoAnalistas(){
            $usuarios = array();
            $tmp_usuarios = DB::table('SOLICITUDES_LOGIN')
                ->where(['LOGIN_CATEGORIA'=>'ANALISTA_CGA'])
                ->select([
                            'LOGIN_USUARIO AS USUARIO_LOGIN',
                            'LOGIN_RESPONSABLE AS NOMBRE_ANALISTA',
                            'LOGIN_USUARIO AS USUARIO_ANALISTA'
                        ])
                ->get();
            //dd($tmp_usuarios);
            foreach ($tmp_usuarios as $usuario) {
                $cant_sol = DB::table('REL_SOLICITUDES_ANALISTA')
                ->where(['FK_USUARIO'=>$usuario->USUARIO_LOGIN])
                ->select([
                            'FK_SOLICITUD_ID'
                        ])
                ->get();
                $usuario->CANTIDAD_SOLICITUDES = count($cant_sol);
                $usuarios[] = $usuario;

            }
            //dd($usuarios);
            return $usuarios;
        }

        public function EliminarUsuario(Request $request){

            $delete2 = DB::table('REL_DEPENCENCIA_TITULAR')->where('FK_USUARIO', $request['usuario'])->delete();
            $delete2 = DB::table('REL_SOLICITUDES_ANALISTA')->where('FK_USUARIO', $request['usuario'])->delete();
            $delete2 = DB::table('REL_TITULAR_AVISO')->where('FK_USUARIO', $request['usuario'])->delete();
            $delete = DB::table('SOLICITUDES_LOGIN')->where('LOGIN_USUARIO', $request['usuario'])->delete();
            $data = array(
                "delete" => $delete,
                "delete2" => $delete2
              );

            echo json_encode($data);//*/
        }

        public function VerificaAceptacionCondiciones($usuario){
            $existe = DB::table('REL_TITULAR_AVISO')->where('FK_USUARIO', $usuario)->get();
            $fl_aviso = 0;
            if(count($existe)==0){
                //dd('CREANDO NUEVO');
                DB::table('REL_TITULAR_AVISO')
                    ->insert([
                                'FK_USUARIO' => $usuario,
                                'FL_AVISO' => $fl_aviso
                            ]);//
            }else{
                //dd('YA EXISTE');
                $fl_aviso = $existe[0]->FL_AVISO;
            }
            //dd($fl_aviso);
            return $fl_aviso;
        }

        public function ValidarUsuario(Request $request){
            // dd("epale");
            \Session::forget('usuario');
            \Session::forget('categoria');
            \Session::forget('id_dependencia');
            \Session::forget('responsable');
            \Session::forget('horario');
            \Session::forget('sistema_inst');
            $usr = $request['usuario'];
            $contrasena = $request['pass'];
            $fl = false;
            $usuario = "";
            $id_dependencia = null;
            $fl_horario = false;
            $sistema = SolicitudesController::DatosGenerales();
            //dd($sistema);
            $existe = DB::table('SOLICITUDES_LOGIN')->where(['LOGIN_USUARIO'=> $usr, 'LOGIN_CONTRASENIA' => $contrasena])->get();
            $fl_aviso = 0;
            // dd($existe);
            if(count($existe)>0){
                //dd($existe[0]->LOGIN_CATEGORIA);
                //$n_usuario = DB::table('DP_USUARIOS')->where('USUARIOS_USUARIO', $usr)->get();
                $fl = true;
                // if(strcmp($existe[0]->LOGIN_CATEGORIA, 'TITULAR')==0){
                if(in_array($existe[0]->LOGIN_CATEGORIA, ['TITULAR'])){
                    // dd('TITULAR');
                    // dd($existe[0]->LOGIN_CATEGORIA);
                    $rel_dependencia = DB::table('REL_DEPENCENCIA_TITULAR')->where(['FK_USUARIO'=> $existe[0]->LOGIN_USUARIO])->get();
                    $id_dependencia = $rel_dependencia[0]->FK_DEPENDENCIA;
                    $fl_horario = SolicitudesController::VerificarHorario();
                    //$fl_aviso = LoginController::VerificaAceptacionCondiciones($usr);
                    $fl_aviso = 0;
                }else if(in_array($existe[0]->LOGIN_CATEGORIA, ['COORDINADOR_CGA'])){
                    $id_dependencia = 27;
                    $fl_horario = true;
                }else{
                    
                }

                //dd($fl_aviso);

                
                //$usuario = $existe[0]->LOGIN_USUARIO;
                if(\Session::get('usuario')!=null){
                    //dd('Aqui olvidamos');
                    \Session::forget('usuario');
                    \Session::forget('categoria');
                    \Session::forget('id_dependencia');
                    \Session::forget('responsable');
                    \Session::forget('horario');
                    \Session::forget('sistema_inst');
                    //\Session::forget('nombre');
                }
                $datos = SolicitudesController::DatosGenerales();
                //dd($existe[0]->LOGIN_RESPONSABLE);
                \Session::push('usuario',$existe[0]->LOGIN_USUARIO);
                \Session::push('categoria',$existe[0]->LOGIN_CATEGORIA);
                \Session::push('id_dependencia',$id_dependencia);
                \Session::push('responsable',$existe[0]->LOGIN_RESPONSABLE);
                \Session::push('horario',$fl_horario);
                \Session::push('sistema_inst',$sistema['institucional']);
                //\Session::push('institucional',$datos['institucional']);
                //dd(\Session::get('responsable')[0]);
                //\Session::push('nombre',$n_usuario[0]->USUARIOS_NOMBRE_RESPONSABLE);
            }
            // dd($existe);
            $data = array(
                "usuario"=>\Session::get('usuario')[0],
                "categoria"=>\Session::get('categoria')[0],
                "id_dependencia"=>\Session::get('id_dependencia')[0],
                "responsable"=>\Session::get('responsable')[0],
                "fl_aviso" => $fl_aviso,
                "exito" => $fl
              );
            //dd($data);
            echo json_encode($data);//*/
        }

        public function cerrarSesion(){
            \Session::forget('usuario');
            \Session::forget('categoria');
            //\Session::forget('nombre');
            return redirect('/');
        }

        public static function randomPassword() {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890._@';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 10; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }

    }

/*
insert into SOLICITUDES_LOGIN(LOGIN_USUARIO,LOGIN_CONTRASENIA,LOGIN_CATEGORIA,LOGIN_RESPONSABLE)values('marvineliosa','123456','ANALISTA_CGA','Marvin Eliosa Abaroa');
insert into SOLICITUDES_LOGIN(LOGIN_USUARIO,LOGIN_CONTRASENIA,LOGIN_CATEGORIA,LOGIN_RESPONSABLE)values('analista@algo.com','123456','ANALISTA_CGA','Analista 2');
insert into SOLICITUDES_LOGIN(LOGIN_USUARIO,LOGIN_CONTRASENIA,LOGIN_CATEGORIA,LOGIN_RESPONSABLE)values('coordinador','123456','COORDINADOR_CGA','Rossendo Martínez Granados');
insert into SOLICITUDES_LOGIN(LOGIN_USUARIO,LOGIN_CONTRASENIA,LOGIN_CATEGORIA,LOGIN_RESPONSABLE)values('trabajador_spr','123456','TRABAJADOR_SPR','Trabajador SPR');
insert into SOLICITUDES_LOGIN(LOGIN_USUARIO,LOGIN_CONTRASENIA,LOGIN_CATEGORIA,LOGIN_RESPONSABLE)values('secretario_particular','123456','SECRETARIO_PARTICULAR','Secretario Particular');
insert into SOLICITUDES_LOGIN(LOGIN_USUARIO,LOGIN_CONTRASENIA,LOGIN_CATEGORIA,LOGIN_RESPONSABLE)values('administrador','123456','ADMINISTRADOR_CGA','Administrador CGA');
*/