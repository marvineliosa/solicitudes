<?php
  namespace App\Http\Controllers;

    use App\User;
    use App\Http\Controllers\Controller;
    use PhpOffice\PhpSpreadsheet\Reader\Xls;
    use Illuminate\Http\Request; //indispensable para usar Request de los JSON
    use Illuminate\Support\Facades\Storage;
    use App\Mail\EnvioMail;
    use Illuminate\Support\Facades\Mail;

    class MailsController extends Controller
    {   

    	//Ejemplo de enviar un EMAIL FUNCIONANDO
    	public function pruebamail(){
    		$data = array('pass'=>"123456789");
	        // Path or name to the blade template to be rendered
	        $template_path = 'mails.enviar_contrasena';
            $nombre_usuario = 'Marvin Eliosa Abaroa';
            $destinatario = 'marvineliosa@hotmail.com';
	        Mail::send($template_path,$data, function($message) use ($nombre_usuario,$destinatario) {
	            // Set the receiver and subject of the mail.
	            $message->to('marvineliosa@hotmail.com', $nombre_usuario)->subject('[Sistema de Solicitudes]Envío de contraseña');
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