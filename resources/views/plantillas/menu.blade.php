<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>@yield('titulo')</title>

    <!-- Bootstrap CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="{{asset('css/bootstrap-theme.css')}}" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="{{asset('css/elegant-icons-style.css')}}" rel="stylesheet" />
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <script src="js/lte-ie7.js"></script>
      <![endif]-->

      <!-- =======================================================
        Theme Name: NiceAdmin
        Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        Author: BootstrapMade
        Author URL: https://bootstrapmade.com
      ======================================================= -->
  </head>

  <body>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- container section start -->
    <section id="container" class="">
      <!--header start-->

      <header class="header dark-bg">
        <div class="toggle-nav">
          <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
        </div>

        <!--logo start-->
        <a href="index.html" class="logo">Solicitudes <span class="lite">BUAP</span></a>
        <!--logo end-->


      </header>
      <!--header end-->

      @include('plantillas.navbar')

      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">
          <div class="row">
            <div class="col-lg-12">
              <h3 class="page-header">@yield('TipoUsuario')</h3>
              <ol class="breadcrumb">
                
              </ol>
            </div>
          </div>
          <!-- page start-->
          @yield('content')
          <!-- page end-->
        </section>
      </section>
      <!--main content end-->
      <div class="text-right">
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
    </section>
    <!-- container section end -->
    <!-- javascripts -->
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <!-- nice scroll -->
    <script src="{{ asset('js/jquery.scrollTo.min.js')}}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js')}}" type="text/javascript"></script>
    <!--custome script for all page-->
    <script src="{{ asset('js/scripts.js')}}"></script>


  </body>

</html>

@yield('script');
<script type="text/javascript">
  //señor metodo maestro ajax
  function metodoAjax(url,dataForm,callback){
    var resultado = null;
    
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
        callback(json);
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