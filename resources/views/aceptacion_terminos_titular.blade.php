<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Aceptación de Terminos</title>

    <!-- javascripts -->
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="{{asset('css/bootstrap-theme.css')}}" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="{{asset('css/elegant-icons-style.css')}}" rel="stylesheet" />
    <link href="{{asset('css/font-awesome.css')}}" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->

      <!-- =======================================================
        Theme Name: NiceAdmin
        Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        Author: BootstrapMade
        Author URL: https://bootstrapmade.com
      ======================================================= -->
      <style type="text/css">
       
        aside, article {
          overflow-y: scroll;
          padding: 2em;
        }
      </style>
  </head>

  <body>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div align="center">
      <h1>CARTA RESPONSIVA SOBRE EL USO ADECUADO DEL SISTEMA</h1>
      <div class="panel panel-default" style="width: 90%; height: 80%;">
        <!--<div class="panel panel-default" style="width: 90%; height: 450px; overflow-y: scroll;">-->
        <div class="panel-body">
          <div class="wrap">
            <main style="text-align: justify;">
              La presente carta tiene como objetivo la definición de las reglas de operación de la cuenta y contraseña del sistema de solicitudes {{$datos['texto1']}} <br>

              <!--<br>
              El cumplimiento de estas reglas es responsabilidad de las personas que tienen acceso a una cuenta dentro del sistema, asignada por la Coordinación General Administrativa Tel. 01 (222) 2 29 55 00 Ext. 5885 y 5897<br>-->
              <br>
              <!--1. El correo electrónico que se proporcione, para entrar al sistema, deberá usarse exclusivamente para asuntos relacionados con la institución. <br>
              2. Las cuentas y claves del sistema son personales. Por lo cual, los titulares de las cuentas son responsables directos de que se haga buen uso de las mismas. <br>-->
              1. La cuenta y clave de acceso es para uso exclusivo del director/a académico o titular de la dependencia administrativa, por lo que su custodia y correcta utilización son su responsabilidad. Queda prohibido permitir su utilización a personas no autorizadas tales como coordinadores/as administrativos u otros.<br>
              2. Queda prohibido la delegación de la cuenta a coordinadores/as administrativos u otros por parte del titular de la dependencia administrativa ya que la cuenta y contraseña es personal e intransferible.<br>
              3. Esta cuenta es un medio de seguimiento a las solicitudes realizadas, por lo que el titular está obligado a consultarla y realizar revisiones periódicas al buzón con la finalidad de asegurar la buena recepción de mensajes.<br>
              <br>
              <b>He leído cada una de las reglas que rigen al sistema y las acepto de conformidad.</b> <br>
              <br>
              <b>Nombre del usuario: </b>{{ $datos['responsable'] }} <br>
              <b>Dependencia: </b>{{ $datos['dependencia'] }} <br>
              <b>Cuenta de correo electrónico: </b>{{ $datos['usuario'] }} <br>
              <b>Cuenta del sistema: </b>{{ $datos['usuario'] }} <br>
              <b>Fecha: </b>{{ $datos['fecha'] }} <br>

            </main>
           
           </div>
         </div>
      </div>
      <div class="col-md-8"></div>

    <button type="button" class="btn btn-secondary" onclick="Salir()">Salir</button>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-primary" onclick="AceptarTerminos()">ACEPTO REGLAS DE USO</button>

    </div>

    <br>
    <div class="credits" align="center" align="center">
      <!--
        All the links in the footer should remain intact.
        You can delete the links only if you purchased the pro version.
        Licensing information: https://bootstrapmade.com/license/
        Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
      -->
      <a href="https://bootstrapmade.com/">Free Bootstrap Templates</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </body>
  <!-- Modal mensaje -->
  <div class="modal fade" id="ModalMensaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="TituloModalMensaje" align="center"></h2>
          <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>-->
        </div>
        <div class="modal-body">
          <h3  id="CuerpoModalMensaje" align="center"> </h3>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Carga-->
    <div class="modal fade" id="modalCarga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div align="center">
          <img src="{{ asset('img/carga3.gif') }}" class="img-rounded" alt="Cinque Terre">
        </div>
      </div>
    </div>
</html>

<script type="text/javascript">
  function Salir(){
    location.href='/salir';
  }

  function AceptarTerminos(){
    var dataForm = new FormData();
    dataForm.append('usuario','usuario');
    var url = "/dependencias/aceptar_terminos";
    $.ajax({
      url :url,
      data : dataForm,
      contentType:false,
      processData:false,
      headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      type: 'POST',
      dataType : 'json',
      beforeSend: function (){
        $("#modalCarga").modal();
      },
      success : function(json){
        if(json['update']){
          //$("#textoModalMensaje").text('Existió un problema con la operación');
          location.href='/listado/dependencia';
        }
      },
      error : function(xhr, status) {
        $("#TituloModalMensaje").text('¡ERROR!');
        $("#CuerpoModalMensaje").text('Existió un problema con la operación');
        $("#ModalMensaje").modal();
      },
      complete : function(xhr, status){
         $("#modalCarga").modal('hide');
      }
    });//*/
  }
</script>
