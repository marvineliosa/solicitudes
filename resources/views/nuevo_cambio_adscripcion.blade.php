@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Cambio de Adscripción
		  </header>
		  <div class="panel-body">
        <form class="form-horizontal " method="get">
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia origen">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia destino</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia destino" id="CambioAdscripcion-DependenciaDestino">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre de la persona que hace el cambio de adscripción" id="CambioAdscripcion-NombreCandidato">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría actual</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" id="CambioAdscripcion-CategoriaActual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto actual</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" id="CambioAdscripcion-PuestoActual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades actuales</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeña" id="CambioAdscripcion-ActividadesActuales"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario actual</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Puesto del Candidato" value="0.00" id="CambioAdscripcion-SalarioActual" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nueva categoría</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" id="CambioAdscripcion-CategoriaNueva">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nuevo puesto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" id="CambioAdscripcion-PuestoNuevo">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nuevas actividades</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeña" id="CambioAdscripcion-ActividadesNuevas"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario neto solicitado</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Puesto del Candidato" value="0.00" id="CambioAdscripcion-SalarioSolicitado" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Justificación</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Justificación de la solicitud del cambio de adscripción" id="CambioAdscripcion-Justificacion"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-2">
              <button type="button" class="btn btn-primary" onclick="AlmacenarSolicitud()">Registrar</button>
            </div>
          </div>
        </form>
      </div>
		</section>
	</div>
	  
@endsection

@section('script')
  <script type="text/javascript">
    autollenado();
    function listado(){
      location.href="/listado/completo";
    }

    function autollenado(){
      $("#CambioAdscripcion-NombreCandidato").val('Marvin Eliosa Abaroa');
      $("#CambioAdscripcion-CategoriaActual").val('Auxiliar Administrativo');
      $("#CambioAdscripcion-PuestoActual").val('Auxiliar de administración');
      $("#CambioAdscripcion-ActividadesActuales").val('Actividades destinadas para Marvin');
      $("#CambioAdscripcion-SalarioActual").val(3200.87);
      $("#CambioAdscripcion-Justificacion").val('Es necesario puesto que el departamento tiene sobre carga de trabajo');//*/
      //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");

      $("#CambioAdscripcion-DependenciaDestino").val('DASU');
      $("#CambioAdscripcion-CategoriaNueva").val('Nueva Categoria');
      $("#CambioAdscripcion-PuestoNuevo").val('Nuevo Puesto');
      $("#CambioAdscripcion-SalarioSolicitado").val(3020.67);
      $("#CambioAdscripcion-ActividadesNuevas").val('Nuevas Actividades a desempeñar en la otra dependencia');
    }

    function AlmacenarSolicitud(){
      var NombreCandidato = $("#CambioAdscripcion-NombreCandidato").val();
      var CategoriaActual = $("#CambioAdscripcion-CategoriaActual").val();
      var PuestoActual = $("#CambioAdscripcion-PuestoActual").val();
      var ActividadesActuales = $("#CambioAdscripcion-ActividadesActuales").val();
      var Nomina = 'NA';
      var SalarioActual = $("#CambioAdscripcion-SalarioActual").val();
      var Justificacion = $("#CambioAdscripcion-Justificacion").val();

      var DependenciaDestino = $("#CambioAdscripcion-DependenciaDestino").val();
      var CategoriaNueva = $("#CambioAdscripcion-CategoriaNueva").val();
      var PuestoNuevo = $("#CambioAdscripcion-PuestoNuevo").val();
      var SalarioSolicitado = $("#CambioAdscripcion-SalarioSolicitado").val();
      var ActividadesNuevas = $("#CambioAdscripcion-ActividadesNuevas").val();

      var success;
      var url = "/cambio_adscripcion/insertar";
      var dataForm = new FormData();
      dataForm.append('NombreCandidato',NombreCandidato);
      dataForm.append('CategoriaActual',CategoriaActual);
      dataForm.append('PuestoActual',PuestoActual);
      dataForm.append('ActividadesActuales',ActividadesActuales);
      dataForm.append('Nomina',Nomina);
      dataForm.append('SalarioActual',SalarioActual);
      dataForm.append('Justificacion',Justificacion);

      dataForm.append('DependenciaDestino',DependenciaDestino);
      dataForm.append('CategoriaNueva',CategoriaNueva);
      dataForm.append('PuestoNuevo',PuestoNuevo);
      dataForm.append('SalarioSolicitado',SalarioSolicitado);
      dataForm.append('ActividadesNuevas',ActividadesNuevas);
      console.log(ActividadesNuevas);
      //lamando al metodo ajax
      metodoAjax(url,dataForm,function(success){
        //aquí se escribe todas las operaciones que se harían en el succes
        //la variable success es el json que recibe del servidor el método AJAX
        var mensaje = "El número de solicitud asignado es: "+success['solicitud'];
        MensajeModal("¡Solicitud almacenada!",mensaje);
      });//*/
    }



    function ejemploAjax(){
      var success;
      var url = "/ruta1/ruta2";
      var dataForm = new FormData();
      dataForm.append('p1',"p1");
      dataForm.append('p2','p2');
      //lamando al metodo ajax
      metodoAjax(url,dataForm,function(success){
        //aquí se escribe todas las operaciones que se harían en el succes
        //la variable success es el json que recibe del servidor el método AJAX
        MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
      });
    }
  </script>
@endsection