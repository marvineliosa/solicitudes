@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Contratación por Sustitución
		  </header>
		  <div class="panel-body">
        <div class="form-horizontal " method="get">
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia" id="Sustitucion-Dependencia">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Persona anterior</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre de la persona que causa baja" id="Sustitucion-PersonaAnterior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría anterior</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría de la persona que causa baja" id="Sustitucion-CategoriaAnterior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto anterior</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto de la persona anterior" id="Sustitucion-PuestoAnterior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades anteriores</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñába la persona anterior" id="Sustitucion-ActividadesAnteriores"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario neto anterior</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario solicitado para el candidato" value="0.00" step=".01" id="Sustitucion-SalarioAnterior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Candidato propuesto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre del candidato" id="Sustitucion-CandidatoPropuesto">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría solicitada</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" id="Sustitucion-CategoriaSolicitada">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" id="Sustitucion-PuestoSolicitado">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñará" id="Sustitucion-ActividadesNuevas"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario neto solicitado</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario solicitado para el candidato" value="0.00" step=".01" id="Sustitucion-SalarioSolicitado">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nómina</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="" value="Institucional" id="Sustitucion-Nomina" disabled="disabled">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Justificación</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Justificación de la solicitud del personal" id="Sustitucion-Justificacion"></textarea>
            </div>
          </div>
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
    function autollenado(){
      $("#Sustitucion-PersonaAnterior").val('Marvin Eliosa Abaroa');
      $("#Sustitucion-CategoriaAnterior").val('Auxiliar Administrativo');
      $("#Sustitucion-PuestoAnterior").val('Auxiliar de administración');
      $("#Sustitucion-ActividadesAnteriores").val('Actividades de Marvin');
      $("#Sustitucion-SalarioAnterior").val(3200.87);


      $("#Sustitucion-CandidatoPropuesto").val('Nuevo Candidato Propuesto');
      $("#Sustitucion-CategoriaSolicitada").val('Nueva Categoria');
      $("#Sustitucion-PuestoSolicitado").val('Puesto Nuevo');
      $("#Sustitucion-ActividadesNuevas").val('Actividades Nuevas');
      $("#Sustitucion-SalarioSolicitado").val(3000);


      $("#Sustitucion-Justificacion").val('Es necesario puesto que el departamento tiene sobre carga de trabajo');//*/
      //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
    }
    function AlmacenarSolicitud(){
      //datos de la persona que deja el puesto
      var persona_anterior = $("#Sustitucion-PersonaAnterior").val();
      var categoria_anterior = $("#Sustitucion-CategoriaAnterior").val();
      var puesto_anterior = $("#Sustitucion-PuestoAnterior").val();
      var actividades_anterior = $("#Sustitucion-ActividadesAnteriores").val();
      var salario_anterior = $("#Sustitucion-SalarioAnterior").val();
      //datos de la persona que sustituye
      var persona_solicitada = $("#Sustitucion-CandidatoPropuesto").val();
      var categoria_solicitada = $("#Sustitucion-CategoriaSolicitada").val();
      var puesto_solicitado = $("#Sustitucion-PuestoSolicitado").val();
      var actividades_solicitadas = $("#Sustitucion-ActividadesNuevas").val();
      var salario_solicitado = $("#Sustitucion-SalarioSolicitado").val();
      //
      var nomina = $("#Sustitucion-Nomina").val();
      var justificacion = $("#Sustitucion-Justificacion").val();

      var success;
      var url = "/contratacion_sustitucion/insertar";
      var dataForm = new FormData();
      dataForm.append('persona_anterior',persona_anterior);
      dataForm.append('categoria_anterior',categoria_anterior);
      dataForm.append('puesto_anterior',puesto_anterior);
      dataForm.append('actividades_anterior',actividades_anterior);
      dataForm.append('salario_anterior',salario_anterior);

      dataForm.append('persona_solicitada',persona_solicitada);
      dataForm.append('categoria_solicitada',categoria_solicitada);
      dataForm.append('puesto_solicitado',puesto_solicitado);
      dataForm.append('actividades_solicitadas',actividades_solicitadas);
      dataForm.append('salario_solicitado',salario_solicitado);

      dataForm.append('nomina',nomina);
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