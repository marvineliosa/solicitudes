@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Contratación
		  </header>
		  <div class="panel-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia" id="Contratacion-Dependencia">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Candidato</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre del Candidato" id="Contratacion-Candidato">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Solicitada</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" id="Contratacion-CategoriaSolicitada">
            </div>
          </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Puesto Solicitado</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" placeholder="Puesto del Candidato" id="Contratacion-PuestoSolicitado">
                </div>
              </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñará" id="Contratacion-Actividades"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario neto solicitado</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario solicitado para el candidato" value="0.00" id="Contratacion-SalarioSolicitado" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nómina</label>
            
            <div class="col-sm-6">
              <input type="text" class="form-control" name="" value="INSTITUCIONAL" id="Contratacion-Nomina" disabled="disabled">
            </div>
            <!--<div class="col-sm-6">
              <select class="form-control m-bot15">
                  <option>Prestación de Servicios</option>
                  <option>Institucional</option>
              </select>
            </div>-->
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Justificación</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Justificación de la solicitud del personal" id="Contratacion-Justificacion"></textarea>
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label class="col-sm-2 control-label">Subir Organigramas</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Subir Plantilla de Personal</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Subir Descripción de Puesto a Cubrir</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Subir Curriculum Actualizado</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Mapa de Ubicación Física</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Fuente de Recursos</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
          </div>

          <hr>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-2">
              <button type="button" class="btn btn-primary" onclick="AlmacenarSolicitud()">Registrar</button>
            </div>
          </div>
        </div>
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
      $("#Contratacion-Candidato").val('Marvin Eliosa Abaroa');
      $("#Contratacion-CategoriaSolicitada").val('Auxiliar Administrativo');
      $("#Contratacion-PuestoSolicitado").val('Auxiliar de administración');
      $("#Contratacion-Actividades").val('Actividades destinadas para Marvin');
      $("#Contratacion-SalarioSolicitado").val(3200.87);
      $("#Contratacion-Justificacion").val('Es necesario puesto que el departamento tiene sobre carga de trabajo');//*/
      //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
    }
    function AlmacenarSolicitud(){
      var candidato = $("#Contratacion-Candidato").val();
      var categoria = $("#Contratacion-CategoriaSolicitada").val();
      var puesto = $("#Contratacion-PuestoSolicitado").val();
      var actividades = $("#Contratacion-Actividades").val();
      var nomina = $("#Contratacion-Nomina").val();
      var salario = $("#Contratacion-SalarioSolicitado").val();
      var justificacion = $("#Contratacion-Justificacion").val();


      var success;
      var url = "/contratacion/insertar";
      var dataForm = new FormData();
      dataForm.append('candidato',candidato);
      dataForm.append('categoria',categoria);
      dataForm.append('puesto',puesto);
      dataForm.append('actividades',actividades);
      dataForm.append('nomina',nomina);
      dataForm.append('salario',salario);
      dataForm.append('justificacion',justificacion);
      //lamando al metodo ajax
      metodoAjax(url,dataForm,function(success){
        //aquí se escribe todas las operaciones que se harían en el succes
        //la variable success es el json que recibe del servidor el método AJAX
        var mensaje = "El número de solicitud asignado es: "+success['solicitud'];
        MensajeModal("¡Solicitud almacenada!",mensaje);
      });
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