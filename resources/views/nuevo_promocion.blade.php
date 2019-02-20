@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Promoción
		  </header>
		  <div class="panel-body">
        <form class="form-horizontal " method="get">
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia" id="Dependencia">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Candidato</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre del candidato" id="Promocion-Candidato">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Actual</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría actual" id="Promocion-CategoriaActual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto Actual</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del candidato" id="Promocion-PuestoActual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades actuales</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeña actualmente" id="Promocion-ActividadesActuales"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario neto actual</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario solicitado para el candidato" value="0.00" id="Promocion-SalarioActual" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Solicitada</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nueva categoría solicitada" id="Promocion-CategoriaSolicitada">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nuevo Puesto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nuevo puesto que desempeñará" id="Promocion-PuestoNuevo">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nuevas Actividades</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Nuevas actividades que desempeñará" id="Promocion-ActividadesNuevas"></textarea>
            </div>
          </div>
          <!--<div class="form-group">
            <label class="col-sm-2 control-label">Nómina</label>
            <div class="col-sm-6">
              <select class="form-control m-bot15">
                  <option>Prestación de Servicios</option>
                  <option>Institucional</option>
              </select>
            </div>
          </div>-->
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario neto solicitado</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario solicitado para el candidato" value="0.00" id="Promocion-SalarioSolicitado" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Justificación</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Justificación de la solicitud de promoción" id="Promocion-Justificacion"></textarea>
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
    function autollenado(){
      $("#Promocion-Candidato").val('Marvin Eliosa Abaroa');
      $("#Promocion-CategoriaActual").val('Auxiliar Administrativo');
      $("#Promocion-PuestoActual").val('Auxiliar de administración');
      $("#Promocion-ActividadesActuales").val('Actividades de Marvin');
      $("#Promocion-SalarioActual").val(3200.87);

      $("#Promocion-CategoriaSolicitada").val('Nuevo Candidato Propuesto');
      $("#Promocion-PuestoNuevo").val('Nueva Categoria');
      $("#Promocion-ActividadesNuevas").val('Puesto Nuevo');
      $("#Promocion-SalarioSolicitado").val(5000);

      $("#Promocion-Justificacion").val('Es necesario puesto que el departamento tiene sobre carga de trabajo');//*/
      //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
    }
    function AlmacenarSolicitud(){
      //datos de la persona que deja el puesto
      var Candidato = $("#Promocion-Candidato").val();
      var CategoriaActual = $("#Promocion-CategoriaActual").val();
      var PuestoActual = $("#Promocion-PuestoActual").val();
      var ActividadesActuales = $("#Promocion-ActividadesActuales").val();
      var SalarioActual = $("#Promocion-SalarioActual").val();
      //datos de la persona que sustituye
      var CategoriaSolicitada = $("#Promocion-CategoriaSolicitada").val();
      var PuestoNuevo = $("#Promocion-PuestoNuevo").val();
      var ActividadesNuevas = $("#Promocion-ActividadesNuevas").val();
      var SalarioSolicitado = $("#Promocion-SalarioSolicitado").val();
      //
      var nomina = 'NA'
      var justificacion = $("#Promocion-Justificacion").val();

      var success;
      var url = "/promocion/insertar";
      var dataForm = new FormData();
      dataForm.append('Candidato',Candidato);
      dataForm.append('CategoriaActual',CategoriaActual);
      dataForm.append('PuestoActual',PuestoActual);
      dataForm.append('ActividadesActuales',ActividadesActuales);
      dataForm.append('SalarioActual',SalarioActual);

      dataForm.append('CategoriaSolicitada',CategoriaSolicitada);
      dataForm.append('PuestoNuevo',PuestoNuevo);
      dataForm.append('ActividadesNuevas',ActividadesNuevas);
      dataForm.append('SalarioSolicitado',SalarioSolicitado);

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