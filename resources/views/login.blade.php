<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="img/favicon.png">

  <title>Solicitudes</title>

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
</head>

<body class="login-buap-body">
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <div class="container">

    <div class="login-form">
      <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" class="form-control" placeholder="Usuario" id="usuario" autofocus>
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" class="form-control" placeholder="Contraseña" id="contrasena">
        </div>
        <div align="center">SISTEMA DE CONTROL DE SOLICITUDES DE PERSONAL</div>
        
        <label class="checkbox">
                <!--<span class="pull-right"> <a href="#"> Recuperar Contraseña</a></span>-->
            </label>
        <button class="btn btn-primary btn-lg btn-block" type="submit" onclick="ingresar()">Ingresar</button>
      </div>
    </div>
    <div class="text-right" align="center">
      <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
          <a href="https://bootstrapmade.com/">Free Bootstrap Templates</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>
  </div>


</body>
  <!-- container section end -->
  <!-- javascripts -->
  <script src="{{ asset('js/jquery.js')}}"></script>
  <script src="{{ asset('js/bootstrap.min.js')}}"></script>
  <!-- nice scroll -->
  <script src="{{ asset('js/jquery.scrollTo.min.js')}}"></script>
  <script src="{{ asset('js/jquery.nicescroll.js')}}" type="text/javascript"></script>
  <!--custome script for all page-->
  <script src="{{ asset('js/scripts.js')}}"></script>

</html>

<script type="text/javascript">
  function ingresar(){
    var usuario = $("#usuario").val();
    var pass = $("#contrasena").val();
    //console.log(estatus);
    var success;
    var url = "/login/validar";
    var dataForm = new FormData();
    dataForm.append('usuario',usuario);
    dataForm.append('pass',pass);
    console.log(usuario);
    console.log(pass);
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
        //resultado = json;
        if(!json['exito']){
          $("#tituloModalMensaje").text('ATENCION');
          $("#textoModalMensaje").text('Usuario o contraseña incorrecta.');
          alert('Usuario o contraseña incorrecta.');
          $("#modalMensaje").modal();
        }else{
          /*if(json['categoria']=='DIRECTOR_DRH'){
            location.href='/dependencias'
          }else if(json['categoria']=='FACILITADOR'){
            location.href='/dependencias'
          }else if(json['categoria']=='DIRECTOR_D/UA'){
            location.href='/descripciones'
          }else if(json['categoria']=='ENCARGADO_D/UA'){
            location.href='/descripciones'
          }else if(json['categoria']=='CGA'){
            location.href='/dependencias'
          }else{
            $("#textoModalMensaje").text("No existe la categoría: "+json['categoria']);
            $("#modalMensaje").modal();
          }//*/
          if(json['categoria']=='TRABAJADOR_CGA'){
            location.href='/listado/completo';
          }else if(json['categoria']=='TRABAJADOR_SPR'){
            location.href='/listado/nuevas';
          }else if(json['categoria']=='COORDINADOR_CGA'){
            location.href='/listado/coordinacion';
          }else if(json['categoria']=='TITULAR'){
            location.href='/listado/dependencia';
          }else if(json['categoria']=='SECRETARIO_PARTICULAR'){
            location.href='/listado/spr';
          }
        }
      },
      error : function(xhr, status) {
        $("#textoModalMensaje").text('Existió un problema con la operación');
        $("#modalMensaje").modal();
      },
      complete : function(xhr, status){
         $("#modalCarga").modal('hide');
      }
    });//*/
  }
</script>
