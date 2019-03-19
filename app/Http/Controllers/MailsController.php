<?php
  namespace App\Http\Controllers;

    use App\User;
    use App\Http\Controllers\Controller;
    use PhpOffice\PhpSpreadsheet\Reader\Xls;
    use Illuminate\Http\Request; //indispensable para usar Request de los JSON
    use Illuminate\Support\Facades\Storage;
    use App\Mail\EnvioMail;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\DB;//consulta a la base de datos

    class MailsController extends Controller
    {   

        public static function MandarMensajeGenerico($asunto,$titulo,$mensaje, $usuario){
            $pass = DB::table('SOLICITUDES_LOGIN')
                ->where('LOGIN_USUARIO',$usuario)
                ->select('LOGIN_CONTRASENIA','LOGIN_RESPONSABLE')
                ->get();
            //dd($pass);
            if(count($pass)>0){
                $data = array('titulo'=>$titulo,'mensaje'=>$mensaje);
                // Path or name to the blade template to be rendered
                $template_path = 'mails.mail_general';
                $nombre_usuario = $pass[0]->LOGIN_RESPONSABLE;
                $destinatario = $usuario;
                $exito = false;
                $exito = Mail::send($template_path,$data, function($message) use ($nombre_usuario,$destinatario,$asunto){
                    // Set the sender
                    $message->from('solicitudesc@gmail.com','Solicitudes CGA');
                    // Set the receiver and subject of the mail.
                    $message->to($destinatario, $nombre_usuario)->subject('[Sistema de Solicitudes]'.$asunto);
                });
                return true;
            }else{
                return false;
            }

            
            //return true;
        }

        public static function NotificarCambioEstatus(){

        }

        public function EnviarContrasena(Request $request){
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
            $data = array(
                'exitoMail' => $exito
            );
            echo json_encode($data);

            //return "Mail enviado correctamente.";
        }

        public static function FuncionEnviarContrasena($usuario){
            $datos_sistema = SolicitudesController::DatosGenerales();
            $tipo_sistema = '';
            $url = '';
            if($datos_sistema['institucional']){
                $tipo_sistema = 'institucional';
                $url = '148.228.11.182';
            }else{
                $tipo_sistema = 'de prestación de servicios';
                $url = '148.228.11.181';
            }
            //dd($usuario);
            $pass = DB::table('SOLICITUDES_LOGIN')
                ->where('LOGIN_USUARIO',$usuario)
                ->select('LOGIN_CONTRASENIA','LOGIN_RESPONSABLE')
                ->get();
            //dd($pass[0]);
            $data = array(
                'pass'=>$pass[0]->LOGIN_CONTRASENIA,
                'tipo_sistema'=>$tipo_sistema,
                'user'=>$usuario,
                'url'=>$url,
            );
            // Path or name to the blade template to be rendered
            $template_path = 'mails.enviar_contrasena';
            $nombre_usuario = $pass[0]->LOGIN_RESPONSABLE;
            $destinatario = $usuario;
            $exito = false;
            $exito = Mail::send($template_path,$data, function($message) use ($nombre_usuario,$destinatario) {
                // Set the sender
                $message->from('solicitudesc@gmail.com','Solicitudes CGA');
                // Set the receiver and subject of the mail.
                $message->to($destinatario, $nombre_usuario)->subject('[Sistema de Solicitudes]Envío de contraseña');
            });
            return true;
        }

        public static function FuncionEnviarContrasenaDependencia($usuario){
        //public static function FuncionEnviarContrasenaDependencia(){
            //dd('epale');
            $usuario = "marvineliosa@hotmail.com";
            $datos_sistema = SolicitudesController::DatosGenerales();
            $tipo_sistema = '';
            $url='';
            if($datos_sistema['institucional']){
                $tipo_sistema = 'institucional';
                $url = '148.228.11.182';
            }else{
                $tipo_sistema = 'de prestación de servicios';
                $url = '148.228.11.181';
            }

            //dd($usuario);
            $pass = DB::table('SOLICITUDES_LOGIN')
                ->where('LOGIN_USUARIO',$usuario)
                ->select('LOGIN_CONTRASENIA','LOGIN_RESPONSABLE')
                ->get();
            //dd($pass);
            $rel_dependencia = DB::table('REL_DEPENCENCIA_TITULAR')
                ->where('FK_USUARIO',$usuario)
                ->get();
            $clave_dependencia = DependenciasController::ObtenerCodigoDependencia($rel_dependencia[0]->FK_DEPENDENCIA);
            //dd($clave_dependencia);

            $data = array(
                'pass'=>$pass[0]->LOGIN_CONTRASENIA,
                'tipo_sistema'=>$tipo_sistema,
                'user'=>$usuario,
                'url'=>$url,
                'codigo_dependencia'=>$clave_dependencia->NOMBRE_DEPENDENCIA
            );
            // Path or name to the blade template to be rendered
            $template_path = 'mails.enviar_password_dependencia';
            $nombre_usuario = $pass[0]->LOGIN_RESPONSABLE;
            $destinatario = $usuario;
            $exito = false;
            $exito = Mail::send($template_path,$data, function($message) use ($nombre_usuario,$destinatario) {
                // Set the sender
                $message->from('solicitudesc@gmail.com','Solicitudes CGA');
                // Set the receiver and subject of the mail.
                $message->to($destinatario, $nombre_usuario)->subject('[Sistema de Solicitudes]Envío de contraseña');
            });
            return true;
        }

    	//Ejemplo de enviar un EMAIL FUNCIONANDO
    	public function pruebamail(){
    		$data = array('pass'=>"123456789");
	        // Path or name to the blade template to be rendered
	        $template_path = 'mails.enviar_contrasena';
            $nombre_usuario = 'Coordinación General Administrativa';
            $destinatario = 'solicitudesc@hotmail.com';
	        Mail::send($template_path,$data, function($message) use ($nombre_usuario,$destinatario) {
	            // Set the receiver and subject of the mail.
	            $message->to($destinatario, $nombre_usuario)->subject('[Sistema de Solicitudes]Envío de contraseña');
	            // Set the sender
	            $message->from($destinatario,'Solicitudes CGA');
	        });

	        return "Mail enviado correctamente.";
    	}

        //adjuncion de archivos
        public function enviarFactura(Request $request){
            $destinatario = [$request['correo'],"marvineliosa@gmail.com"];//correo con copia
            $pdf = str_replace('\\', '/',storage_path('app')).'/'.$request['pdf'];
            $xml = str_replace('\\', '/',storage_path('app')).'/'.$request['xml'];
            $asunto = "Facturas";
            $containfile = ((Storage::exists($request['pdf']) && Storage::exists($request['xml']))?true:false);
            $data = array('contenido' => '');
            $fl = false;
            if($containfile){//si existen los archivos
                $fl = Mail::send('mails.facturas', $data, function ($message) use ($asunto,$destinatario,  $containfile,$pdf,$xml){
                    $message->from('marvineliosa@gmail.com', 'CGA');
                    $message->to($destinatario)->subject($asunto);
                    if($containfile){
                        $message->attach($pdf);
                        $message->attach($xml);
                    }
                });
            }
            $data = array(
                'exitoMail' => $fl,
                'archivos' => $containfile
            );
            echo json_encode($data);
            
        }

    }