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
                @yield('barra_superior')
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
    <!-- Sweet Alert -->
    <!--<script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>-->

    <!-- opcion 2 -->
    <script src="{{ asset('sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <link href="{{asset('sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet" />

    <!-- datatables -->

    <script src="{{ asset('js/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.js')}}"></script>
    <link href="{{asset('js/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" />

    <!-- modales -->
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

    <!-- MODAL MOSTRAR CONTRATACION -->
    <!-- Modal -->
    <div class="modal fade" id="ModalDetalleContratacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table">
          <thead>
            <tr>
              <th scope="col">Concepto</th>
              <th scope="col">Descripción</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Número de Solicitud</th>
              <td id="ModalCont-id_sol"></td>
            </tr>
            <tr>
              <th scope="row">Candidato</th>
              <td id="ModalCont-candidato"></td>
            </tr>
            <tr>
              <th scope="row">Dependencia</th>
              <td id="ModalCont-dependencia"></td>
            </tr>
            <tr>
              <th scope="row">Fecha de Solicitud</th>
              <td id="ModalCont-fehca_solicitud"></td>
            </tr>
            <tr>
              <th scope="row">Fecha de información completa</th>
              <td id="ModalCont-fecha_informacion_conpleta"></td>
            </tr>
            <tr>
              <th scope="row">Categoría Solicitada</th>
              <td id="ModalCont-categoria_solicitada"></td>
            </tr>
            <tr>
              <th scope="row">Puesto Solicitado</th>
              <td id="ModalCont-puesto_solicitado"></td>
            </tr>
            <tr>
              <th scope="row">Salario Solicitado</th>
              <td id="ModalCont-salario_solicitado"></td>
            </tr>
          </tbody>
        </table>
        <div align="center">
          <a href="" target="_blank" id="verCuadro">Ver cuadro</a>
          
        </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <!--<button type="button" class="btn btn-primary">Save changes</button>-->
          </div>
        </div>
      </div>
    </div>

  </body>

</html>


<script type="text/javascript">
  crearDatatable();
  function crearDatatable(){
    $('#tabla_datos').DataTable({
        //responsive: true,
        "searching": true,
        "paging":   true,
        "info":     true,
        //"pageLength": false,
        language: {
          emptyTable: "No hay datos para mostrar en la tabla",
          zeroRecords: "No hay datos para mostrar en la tabla",
          "search": "Buscar:",
          "info":"Se muestra los registros _START_ a _END_ de _TOTAL_ totales.",
          "infoEmpty":"No se ha encontrado registros.",
          "lengthMenu":"Mostrando _MENU_ registros",
          "infoFiltered":"(Filtrado de un total de _MAX_ registros)",
          "search": "Buscar: ",
          paginate: {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
          },
        }
      });//*/
  }

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

  //señor ajax de las recargas de tablas
  function recargarTablaAjax(url) {
      
      var dataForm = new FormData();
      dataForm.append('id_sol','id_sol');
      $.ajax({
          method: "POST",
          url: url,
        headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
          success: function (response) {
              $('.collapse').collapse('show');
              $('#div_tabla_datos').html(response);
              crearDatatable();
          },                               
      }); 
    }

  function MensajeModal(titulo,mensaje){
    $("#TituloModalMensaje").text(titulo);
    $("#CuerpoModalMensaje").text(mensaje);
    $("#ModalMensaje").modal();
  }

  function formatoMoneda(numero) {
    numero = '3258.56';
    if(numero>999999){
      conPunto = numero.substring(0, numero.length-9);
      conPunto2 = numero.substring(numero.length-9, numero.length-6);
      conPunto3 = numero.substring(numero.length-6, numero.length);
      numero = conPunto + ',' + conPunto2 + ',' + conPunto3;
    }else{
      if(numero>999){
        conPunto = numero.substring(0, numero.length-6);
        conPunto2 = numero.substring(numero.length-6, numero.length);
        numero = conPunto + ',' + conPunto2;
      }       
    }
    return numero;
  }

  function AbreModalContratacion(id_sol){
    console.log(gl_solicitudes[id_sol]);
    $("#ModalCont-id_sol").html(gl_solicitudes[id_sol]['ID_SOLICITUD']);
    $("#ModalCont-candidato").html(gl_solicitudes[id_sol]['NOMBRE_SOLICITUD']);
    $("#ModalCont-dependencia").html(gl_solicitudes[id_sol]['DEPENDENCIA_SOLICITUD']);
    $("#ModalCont-fehca_solicitud").html(gl_solicitudes[id_sol]['FECHA_CREACION']);
    $("#ModalCont-fecha_informacion_conpleta").html(gl_solicitudes[id_sol]['FECHA_TURNADO_SPR']);
    $("#ModalCont-categoria_solicitada").html(gl_solicitudes[id_sol]['CATEGORIA_SOLICITUD']);
    $("#ModalCont-puesto_solicitado").html(gl_solicitudes[id_sol]['PUESTO_SOLICITUD']);
    $("#ModalCont-salario_solicitado").html('$ '+formatoMoneda(gl_solicitudes[id_sol]['SALARIO_SOLICITUD']));
    $("#verCuadro").attr('href','/cuadro/contratacion/'+gl_solicitudes[id_sol]['ID_ESCAPE']);
    $("#ModalDetalleContratacion").modal();
  }

</script>
@yield('script');