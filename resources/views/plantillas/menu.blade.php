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
        <a href="#" class="logo">Solicitudes <!--<span class="lite">BUAP</span>--></a>
        <!--logo end-->
        

      </header>
      <!--header end-->

      @include('plantillas.navbar')

      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">
          <div class="row">
            <div class="col-lg-12">
              <h3 class="page-header">{{\Session::get('responsable')[0]}}@yield('TipoUsuario')</h3>
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

    <!-- Exportar a excel -->
    <script src="{{ asset('js-xlsx/dist/xlsx.full.min.js')}}"></script>
    <script src="{{ asset('FileSaver/dist/FileSaver.min.js')}}"></script>
    <!-- modales -->

    <!-- MODAL MOSTRAR CONTRATACION -->
    <!-- Modal Detalle de solicitudes-->
    <div class="modal fade" id="ModalDetalleContratacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="TituloModalInformacion" align="center"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body table-responsive">
            <table class="table" width="50%" style="table-layout: fixed;">
              <thead>
                <tr>
                  <th scope="col">Concepto</th>
                  <th scope="col">Descripción</th>
                </tr>
              </thead>
              <tbody id="CuerpoTablaInformacion" style="padding: 5px !important;">

              </tbody>
            </table>
            <div align="center" id="div_cuadro" hidden="true">
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

    <!-- Modal Archivos -->
    <div class="modal fade" id="ModalArchivos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="TituloModalArchivos" align="center">Archivos</h2>
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>-->
          </div>
          <div class="modal-body">
            <h3  id="CuerpoModalArchivos" align="center"> </h3>
            <table class="table table-bordered">
              <thead id="HeadTablaArchivos">
                <tr>
                  <th scope="col" style="width: 30%">Archivo</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody id="CuerpoTablaArchivos">
                
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Archivos -->
    <div class="modal fade" id="ModalFechas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="TituloModalArchivos" align="center">Fechas</h2>
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>-->
          </div>
          <div class="modal-body">
            <h3  id="CuerpoModalFechas" align="center"> </h3>
            <table class="table table-bordered">
              <thead id="HeadTablaArchivos">
                <tr>
                  <th scope="col">Concepto</th>
                  <th scope="col">Fechas</th>
                </tr>
              </thead>
              <tbody id="CuerpoTablaFechas">
                
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Archivos -->
    <div class="modal fade" id="ModalMovimientos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="TituloModalMovimientos" align="center">Movimientos</h2>
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>-->
          </div>
          <div class="modal-body">
            <h3  id="CuerpoModalFechas" align="center"> </h3>
            <table class="table table-bordered">
              <thead id="HeadTablaMovimientos">
                <tr>
                  <th scope="col">Movimiento</th>
                  <th scope="col">Fecha</th>
                </tr>
              </thead>
              <tbody id="CuerpoTablaMovimientos">
                
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal mensajes -->
    <div class="modal fade" id="ModalComentarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="TituloModalMensajes" align="center">Comentarios</h2>
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>-->
          </div>
          <div class="modal-body">
            <input type="" name="" style="display: none" id="comentario_num_oficio" value="">
            <h3  id="CuerpoModalComentarios" align="center"> </h3>
            
            <b>Comentarios Generales:</b> 
            <div class="form-check form-check-inline">
              <textarea class="form-control ckeditor" name="editor1" rows="2" placeholder="Este mensaje podrá ser visto por todos los usuarios excepto las dependencias" id="TextComentarioGeneral"></textarea>
              <br>
              <button type="button" class="btn btn-primary pull-right " onclick="GuardarComentario()">Guardar comentario</button>
            </div>
            <br>
            <br>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Comentario</th>
                  <th scope="col" style="width: 20%">Acciones</th>
                </tr>
              </thead>
              <tbody id="CuerpoTablaComentariosGenerales">
                
              </tbody>
            </table>
            @if(in_array(\Session::get('categoria')[0],['COORDINADOR_CGA','ANALISTA_CGA','ADMINISTRADOR_CGA']))
              <b>Comentarios CGA:</b> 
              <div class="form-check form-check-inline">
                <textarea class="form-control ckeditor" name="editor1" rows="2" placeholder="Este mensaje solo será visto por el personal de la CGA" id="TextComentarioCGA"></textarea>
                <br>
                <button type="button" class="btn btn-primary pull-right " onclick="GuardarComentarioCGA()">Guardar comentario</button>
              </div>
              <br>
              <br>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Comentario</th>
                    <th scope="col" style="width: 20%">Acciones</th>
                  </tr>
                </thead>
                <tbody id="CuerpoTablaComentariosCGA">
                  
                </tbody>
              </table>
            @endif
            @if(in_array(\Session::get('categoria')[0],['SECRETARIO_PARTICULAR','TRABAJADOR_SPR']))
              <b>Comentarios SPR:</b> 
              <div class="form-check form-check-inline">
                <textarea class="form-control ckeditor" name="editor1" rows="2" placeholder="Este mensaje solo será visto por el personal de SPR" id="TextComentarioSPR"></textarea>
                <br>
                <button type="button" class="btn btn-primary pull-right " onclick="GuardarComentarioSPR()">Guardar comentario</button>
              </div>
              <br>
              <br>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Comentario</th>
                    <th scope="col" style="width: 20%">Acciones</th>
                  </tr>
                </thead>
                <tbody id="CuerpoTablaComentariosSPR">
                  
                </tbody>
              </table>
            @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
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

  </body>

</html>


<script type="text/javascript">

  var gl_categoria = <?php echo json_encode(\Session::get('categoria')[0]) ?>;
  //console.log(gl_categoria);

  function guardarComentario(id_archivo){
    var mensaje = $("#mensaje_archivo_"+id_archivo).val();
    //console.log(mensaje);
    var success;
    var url = "/archivos/agregar_mensaje";
    var dataForm = new FormData();
    dataForm.append('id_archivo',id_archivo);
    dataForm.append('mensaje',mensaje);
    //lamando al metodo ajax
    metodoAjax(url,dataForm,function(success){
      //aquí se escribe todas las operaciones que se harían en el succes
      //la variable success es el json que recibe del servidor el método AJAX
      MensajeModal("¡EXITO!","El mensaje se ha guardado correctamente");
    });//*/
  }

  function modalArchivos(id_solicitud){
    
    var success;
    var url = "/archivos/obtener_archivos";
    var dataForm = new FormData();
    dataForm.append('id_solicitud',id_solicitud);
    //lamando al metodo ajax
    metodoAjax(url,dataForm,function(success){
      //aquí se escribe todas las operaciones que se harían en el succes
      //la variable success es el json que recibe del servidor el método AJAX
      $("#TituloModalArchivos").text('Archivos de la solicitud '+id_solicitud);
      $("#CuerpoTablaArchivos").html('');
      for(i=0;i<success['archivos'].length;i++){
        var textarea = '<textarea class="form-control" placeholder="Ingrese un comentario" id="mensaje_archivo_'+success['archivos'][i]['ID_ARCHIVO']+'">'+
                          success['archivos'][i]['MENSAJE_ARCHIVO']+
                        '</textarea><br>';
        var button = '<button type="button" class="btn btn-primary pull-right" onclick="guardarComentario('+success['archivos'][i]['ID_ARCHIVO']+')">'+
                        'Guardar Comentario'+
                      '</button>';
        $("#CuerpoTablaArchivos").append(
          '<tr>'+
            '<td scope="col" rowspan="2" style="vertical-align: middle;">'+success['archivos'][i]['TIPO_ARCHIVO']+'</td>'+
            '<td>'+'Descargar: '+'<a href="/descargas/archivo/'+success['archivos'][i]['ID_ARCHIVO']+'"  target="_blank">'+success['archivos'][i]['TIPO_ARCHIVO']+'</a>'+'</td>'+
          '</tr>'+
          '<tr>'+
            '<td>'+
              textarea+
              button+
            '</td>'+
          '</tr>'
        );
      }
      $("#ModalArchivos").modal();
    });
  }

  function modalArchivosGeneral(id_solicitud){
    var success;
    var url = "/archivos/obtener_archivos";
    var dataForm = new FormData();
    dataForm.append('id_solicitud',id_solicitud);
    //lamando al metodo ajax
    metodoAjax(url,dataForm,function(success){
      //aquí se escribe todas las operaciones que se harían en el succes
      //la variable success es el json que recibe del servidor el método AJAX
      $("#TituloModalArchivos").text('Archivos de la solicitud '+id_solicitud);
      $("#CuerpoTablaArchivos").html('');
      for(i=0;i<success['archivos'].length;i++){
        $("#CuerpoTablaArchivos").append(
          '<tr>'+
            '<td scope="col" style="vertical-align: middle; width: 5%;">'+success['archivos'][i]['TIPO_ARCHIVO']+'</td>'+
            '<td>'+'Descargar: '+'<a href="/descargas/archivo/'+success['archivos'][i]['ID_ARCHIVO']+'"  target="_blank">'+success['archivos'][i]['TIPO_ARCHIVO']+'</a>'+'</td>'+
          '</tr>'
        );
      }
      $("#ModalArchivos").modal();
    });
  }


  crearDatatable();
  function crearDatatable(dato_busqueda,numero_pagina){
    var tabla = $('#tabla_datos').DataTable({
        //responsive: true,
        "searching": true,
        "paging":   true,
        "info":     true,
        "ordering": false,
        "pageLength": 10,
        //'displayStart': numero_pagina,
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
      if(dato_busqueda){
        tabla.search( dato_busqueda ).draw();
        $( ".paginate_button  [data-dt-idx='"+numero_pagina+"']" ).trigger("click");
      }
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
        MensajeModal('¡ERROR!','Existió un problema, intentelo de nuevo, si el problema persiste favor de reportarlo a la extensión 5897.')
      },
      complete : function(xhr, status){
         $("#modalCarga").modal('hide');
      }
    });//*/
  }

  //señor ajax de las recargas de tablas
  function recargarTablaAjax(url) {
      var dato_busqueda = (($('.dataTables_filter input').val())?$('.dataTables_filter input').val():' ');
      var table = $('#tabla_datos').DataTable()
      var pagina = (table.page.info());
      pagina = parseInt(pagina.page) + 1;
      //console.log("PAGINA: "+(pagina));
      //console.log(dato_busqueda);
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
              //console.log(response);
              crearDatatable(dato_busqueda,pagina);
          },                               
      });//*/
      //tabla.search( dato_busqueda ).draw();
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

  function AbreModalInformacion(id_solicitud,tipo_solicitud){
    //console.log(tipo_solicitud);
    //tabla.search( '2/' ).draw();
    if(tipo_solicitud=='CONTRATACIÓN'){
      var titulo = 'Detalle de Contratación';
      var url = "/solicitud/obtener_datos_contratacion";
      AbreModalInfo(id_solicitud,url,titulo,tipo_solicitud);
    }
    if(tipo_solicitud=='CONTRATACIÓN POR SUSTITUCIÓN'){
      var titulo = 'Detalle de Contratación por Sustitución';
      var url = "/solicitud/obtener_datos_sustitucion";
      AbreModalInfo(id_solicitud,url,titulo,tipo_solicitud);
    }
    if(tipo_solicitud=='PROMOCION'){
      var titulo = 'Detalle de Promoción';
      var url = "/solicitud/obtener_datos_promocion";
      AbreModalInfo(id_solicitud,url,titulo,tipo_solicitud);
    }
    if(tipo_solicitud=='CAMBIO DE ADSCRIPCIÓN'){
      var titulo = 'Detalle de Cambio de Adscripción';
      var url = "/solicitud/obtener_datos_cambio_adscripcion";
      AbreModalInfo(id_solicitud,url,titulo,tipo_solicitud);
    }
  }

  function AbreModalInfo(id_sol,url,titulo,tipo_solicitud){
    $("#div_cuadro").hide();
    var success;
    //var url = "/solicitud/obtener_datos_contratacion";
    var dataForm = new FormData();
    dataForm.append('id_sol',id_sol);
    //lamando al metodo ajax

    metodoAjax(url,dataForm,function(success){
      //aquí se escribe todas las operaciones que se harían en el succes
      //la variable success es el json que recibe del servidor el método AJAX
      //console.log(success);
      $("#CuerpoTablaInformacion").html('');
      for(var i = 0; i < success['cabeceras'].length; i++){
        //console.log(success['cabeceras'][i]);
        if(success['cabeceras'][i]!='Escape' && success['cabeceras'][i]!='Estatus'){
          $("#CuerpoTablaInformacion").append(
              '<tr>'+
                '<th scope="row">' + success['cabeceras'][i] + '</th>'+
                '<td id="ModalCont-id_sol"  style="word-wrap: break-word;">'+ success['datos'][success['cabeceras'][i]] +'</td>'+
              '<  /tr>'
          );
        }
      }
      var array_cga = ['COORDINADOR_CGA','ANALISTA_CGA','ADMINISTRADOR_CGA','ADMINISTRADOR_CGA'];
      var permitidos_cga = ['RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR','CANCELADO POR TITULAR'];
      //console.log(permitidos_cga.includes(success['datos']['Estatus']));
      if(array_cga.includes(gl_categoria)){
        if(tipo_solicitud == 'CONTRATACIÓN' && permitidos_cga.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/contratacion/'+success['datos']['Escape']);
        }else if(tipo_solicitud == 'CONTRATACIÓN POR SUSTITUCIÓN' && permitidos_cga.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/contratacion_sustitucion/'+success['datos']['Escape']);
        }else if(tipo_solicitud == 'PROMOCION' && permitidos_cga.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/promocion/'+success['datos']['Escape']);
        }else if(tipo_solicitud == 'CAMBIO DE ADSCRIPCIÓN' && permitidos_cga.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/cambio_adscripcion/'+success['datos']['Escape']);
        }
        $("#div_cuadro").show();
      }
      var array_spr = ['SECRETARIO_PARTICULAR','TRABAJADOR_SPR'];
      var permitidos_spr = ['FIRMAS','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR'];
      if(array_spr.includes(gl_categoria)){
        if(tipo_solicitud == 'CONTRATACIÓN' && permitidos_spr.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/contratacion/'+success['datos']['Escape']);
          $("#div_cuadro").show();
        }else if(tipo_solicitud == 'CONTRATACIÓN POR SUSTITUCIÓN' && permitidos_spr.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/contratacion_sustitucion/'+success['datos']['Escape']);
          $("#div_cuadro").show();
        }else if(tipo_solicitud == 'PROMOCION' && permitidos_spr.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/promocion/'+success['datos']['Escape']);
          $("#div_cuadro").show();
        }else if(tipo_solicitud == 'CAMBIO DE ADSCRIPCIÓN' && permitidos_spr.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/cambio_adscripcion/'+success['datos']['Escape']);
          $("#div_cuadro").show();
        }
      }
      /*var array_titular = ['TITULAR'];
      var permitidos_titular = ['FIRMAS','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR'];
      if(array_titular.includes(gl_categoria)){
        if(tipo_solicitud == 'CONTRATACIÓN' && permitidos_titular.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/contratacion/'+success['datos']['Escape']);
          $("#div_cuadro").show();
        }else if(tipo_solicitud == 'CONTRATACIÓN POR SUSTITUCIÓN' && permitidos_titular.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/contratacion_sustitucion/'+success['datos']['Escape']);
          $("#div_cuadro").show();
        }else if(tipo_solicitud == 'PROMOCION' && permitidos_titular.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/promocion/'+success['datos']['Escape']);
          $("#div_cuadro").show();
        }else if(tipo_solicitud == 'CAMBIO DE ADSCRIPCIÓN' && permitidos_titular.includes(success['datos']['Estatus'])){
          $("#verCuadro").attr('href','/cuadro/cambio_adscripcion/'+success['datos']['Escape']);
          $("#div_cuadro").show();
        }
      }//*/
      //$("#verCuadro").attr('href','/algo/algo')
      $("#TituloModalInformacion").text(titulo);
      $("#ModalDetalleContratacion").modal();
    });//*/
  }

  function AbreModalFechas(id_sol){
    //$("#div_cuadro").hide();
    var success;
    var url = "/solicitud/obtener_fechas";
    var dataForm = new FormData();
    dataForm.append('id_sol',id_sol);
    //lamando al metodo ajax

    metodoAjax(url,dataForm,function(success){
      //aquí se escribe todas las operaciones que se harían en el succes
      //la variable success es el json que recibe del servidor el método AJAX
      //console.log(success);
      $("#CuerpoTablaFechas").html('');
      for(var i = 0; i < success['cabeceras'].length; i++){
        //console.log(success['cabeceras'][i]);
        if(success['cabeceras'][i]!='Escape'){
          $("#CuerpoTablaFechas").append(
            '<tr>'+
              '<th scope="row">' + success['cabeceras'][i] + '</th>'+
              '<td style="word-wrap: break-word;">'+ ((success['datos'][success['cabeceras'][i]])?success['datos'][success['cabeceras'][i]]:'') +'</td>'+
            '<  /tr>'
          );
        }
      }
      //$("#verCuadro").attr('href','/algo/algo')
      //$("#TituloModalInformacion").text(titulo);
      $("#ModalFechas").modal();
    });//*/
    $("#ModalFechas").modal();
  }

  function modalComentarios(id_solicitud){
    $("#comentario_num_oficio").val(id_solicitud);
    var comentario = $("#TextComentarioGeneral").val('');
    var comentario = $("#TextComentarioCGA").val('');
    var comentario = $("#TextComentarioSPR").val('');
    var success;
    var url = '/comentarios/traer';
    //var url = "/solicitud/obtener_datos_contratacion";
    var dataForm = new FormData();
    dataForm.append('id_solicitud',id_solicitud);
    //lamando al metodo ajax

    metodoAjax(url,dataForm,function(success){
      //aquí se escribe todas las operaciones que se harían en el succes
      //la variable success es el json que recibe del servidor el método AJAX
      //console.log(success);
      $("#CuerpoTablaComentariosGenerales").html("");
      $("#CuerpoTablaComentariosCGA").html("");
      $("#CuerpoTablaComentariosSPR").html("");
      for(var i = 0; i < success['comentarios'].length; i++){
        //console.log(success['cabeceras'][i]);
        $("#CuerpoTablaComentariosGenerales").append(
          '<tr id="ComentarioGral_'+success['comentarios'][i]['ID_OBSERVACION']+'">'+
            '<td>' + success['comentarios'][i]['OBSERVACION'] + '</td>'+
            '<td>'+ '<a href="javascript:void(0);" onclick="eliminarComentario('+success['comentarios'][i]['ID_OBSERVACION']+',1)">Eliminar</a>' +'</td>'+
          '</tr>'
        );
      }
      for(var i = 0; i < success['comentariosInternos'].length; i++){
        //console.log(success['cabeceras'][i]);
        if(success['rol']==2){
          $("#CuerpoTablaComentariosCGA").append(
            '<tr id="ComentarioCGA_'+success['comentariosInternos'][i]['ID_OBSERVACION']+'">'+
              '<td>' + success['comentariosInternos'][i]['OBSERVACION'] + '</td>'+
              '<td>'+ '<a href="javascript:void(0);" onclick="eliminarComentario('+success['comentariosInternos'][i]['ID_OBSERVACION']+',2)">Eliminar</a>' +'</td>'+
            '</tr>'
          );
        }else{
          $("#CuerpoTablaComentariosSPR").append(
            '<tr id="ComentarioSPR_'+success['comentariosInternos'][i]['ID_OBSERVACION']+'">'+
              '<td>' + success['comentariosInternos'][i]['OBSERVACION'] + '</td>'+
              '<td>'+ '<a href="javascript:void(0);" onclick="eliminarComentario('+success['comentariosInternos'][i]['ID_OBSERVACION']+',3)">Eliminar</a>' +'</td>'+
            '</tr>'
          );
        }
      }
    });//*/
    $("#ModalComentarios").modal();
  }

  function eliminarComentario(id_comentario,tipo_comentario){
    var id_solicitud = $("#comentario_num_oficio").val();
    var success;
    var url = '/comentarios/eliminar';
    //var url = "/solicitud/obtener_datos_contratacion";
    var dataForm = new FormData();
    dataForm.append('id_comentario',id_comentario);
    dataForm.append('tipo_comentario',tipo_comentario);
    metodoAjax(url,dataForm,function(success){
      //console.log(success);
      if(tipo_comentario==1){
        $("#ComentarioGral_"+id_comentario).remove();
      }else if(tipo_comentario==2){
        $("#ComentarioCGA_"+id_comentario).remove();
      }else if(tipo_comentario==3){
        $("#ComentarioSPR_"+id_comentario).remove();
      }
      MensajeModal('¡EXITO!','El comentario ha sido eliminado correctamente');
    });//*/

  }

  function GuardarComentario(){
    var id_solicitud = $("#comentario_num_oficio").val();
    var comentario = $("#TextComentarioGeneral").val();
    if(comentario!=''){
      var success;
      var url = '/comentarios/guardar_general';
      //var url = "/solicitud/obtener_datos_contratacion";
      var dataForm = new FormData();
      dataForm.append('id_solicitud',id_solicitud);
      dataForm.append('comentario',comentario);
      metodoAjax(url,dataForm,function(success){
        //console.log(success);
        $("#CuerpoTablaComentariosGenerales").append(
          '<tr id="ComentarioGral_'+success['id_comentario']+'">'+
            '<td>' + comentario + '</td>'+
            '<td>'+ '<a href="javascript:void(0);" onclick="eliminarComentario('+success['id_comentario']+',1)">Eliminar</a>' +'</td>'+
          '</tr>'
        );//
        MensajeModal('¡EXITO!','El comentario ha sido almacenado correctamente');
      });//*/
    }
    //console.log(id_solicitud);
  }

  function GuardarComentarioCGA(){
    var id_solicitud = $("#comentario_num_oficio").val();
    var comentario = $("#TextComentarioCGA").val();
    if(comentario!=''){
      var success;
      var url = '/comentarios/guardar_cga';
      //var url = "/solicitud/obtener_datos_contratacion";
      var dataForm = new FormData();
      dataForm.append('id_solicitud',id_solicitud);
      dataForm.append('comentario',comentario);
      metodoAjax(url,dataForm,function(success){
        //console.log(success);
        $("#CuerpoTablaComentariosCGA").append(
          '<tr id="ComentarioCGA_'+success['id_comentario']+'">'+
            '<td>' + comentario + '</td>'+
            '<td>'+ '<a href="javascript:void(0);" onclick="eliminarComentario('+success['id_comentario']+',2)">Eliminar</a>' +'</td>'+
          '</tr>'
        );//
        MensajeModal('¡EXITO!','El comentario ha sido almacenado correctamente');
      });//*/
    }
    //console.log(id_solicitud);
  }

  function GuardarComentarioSPR(){
    var id_solicitud = $("#comentario_num_oficio").val();
    var comentario = $("#TextComentarioSPR").val();
    if(comentario!=''){
      var success;
      var url = '/comentarios/guardar_spr';
      //var url = "/solicitud/obtener_datos_contratacion";
      var dataForm = new FormData();
      dataForm.append('id_solicitud',id_solicitud);
      dataForm.append('comentario',comentario);
      metodoAjax(url,dataForm,function(success){
        //console.log(success);
        $("#CuerpoTablaComentariosSPR").append(
          '<tr id="ComentarioSPR_'+success['id_comentario']+'">'+
            '<td>' + comentario + '</td>'+
            '<td>'+ '<a href="javascript:void(0);" onclick="eliminarComentario('+success['id_comentario']+',3)">Eliminar</a>' +'</td>'+
          '</tr>'
        );//
        MensajeModal('¡EXITO!','El comentario ha sido almacenado correctamente');
      });//*/
    }
    //console.log(id_solicitud);
  }

  function ObtenerHistorial(id_solicitud){
    var success;
    var url = '/movimientos/obtener';
    //var url = "/solicitud/obtener_datos_contratacion";
    var dataForm = new FormData();
    dataForm.append('id_solicitud',id_solicitud);
    $("#CuerpoTablaMovimientos").html('');
    metodoAjax(url,dataForm,function(success){
      //console.log(success);
      for(var i = 0; i < success['movimientos'].length;i++){
        $("#CuerpoTablaMovimientos").append(
          '<tr>'+
            '<td>' + success['movimientos'][i]['MOVIMIENTO'] + '</td>'+
            '<td>'+ success['movimientos'][i]['FECHA_MOVIMIENTO'] +'</td>'+
          '</tr>'
        );//*/
      }
      $("#ModalMovimientos").modal();
    });//*/
  }


</script>
@yield('script');