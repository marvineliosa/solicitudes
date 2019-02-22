@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
<div class="col-lg-12">
	<section class="panel">
	  <header class="panel-heading">
	    Listado Completo
	  </header>
	  <div class="table-responsive">
	  	<div id="div_tabla_datos">
	    	@include('tablas.listado_completo')
	  	</div>
	  </div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalDetalleTMP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		      <th scope="row">ID</th>
		      <td>SOL/1/2018</td>
		    </tr>
		    <tr>
		      <th scope="row">Candidato</th>
		      <td>Marvin Gabriel Eliosa Abaroa</td>
		    </tr>
		    <tr>
		      <th scope="row">Dependencia</th>
		      <td>Coordinación General Administrativa</td>
		    </tr>
		    <tr>
		      <th scope="row">Fecha de Solicitud</th>
		      <td>13/12/2018</td>
		    </tr>
		    <tr>
		      <th scope="row">Fecha de información completa</th>
		      <td>22/01/2019</td>
		    </tr>
		    <tr>
		      <th scope="row">Categoría</th>
		      <td>Técnico Administrativo</td>
		    </tr>
		    <tr>
		      <th scope="row">Puesto</th>
		      <td>Encargado de Cómputo</td>
		    </tr>
		    <tr>
		      <th scope="row">Salario</th>
		      <td>$2,750.80</td>
		    </tr>
		  </tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalDetalleTerminado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		      <th scope="row">ID</th>
		      <td>SOL/4/2019</td>
		    </tr>
		    <tr>
		      <th scope="row">Candidato</th>
		      <td>Juan Pérez González</td>
		    </tr>
		    <tr>
		      <th scope="row">Dependencia</th>
		      <td>DCyTIC</td>
		    </tr>
		    <tr>
		      <th scope="row">Fecha de Solicitud</th>
		      <td>13/01/2019</td>
		    </tr>
		    <tr>
		      <th scope="row">Fecha de información completa</th>
		      <td>13/01/2019</td>
		    </tr>
		    <tr>
		      <th scope="row">Categoría</th>
		      <td>Responsable de Área</td>
		    </tr>
		    <tr>
		      <th scope="row">Puesto</th>
		      <td>Juan Pérez González</td>
		    </tr>
		    <tr>
		      <th scope="row">Salario</th>
		      <td>$6,577.63</td>
		    </tr>
		  </tbody>
		</table>
		<a href="{{asset('pdf/EjemploCuadroAprobado.pdf')}}" target="_blank">Ver cuadro</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ModalConfiguraciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<input type="" name="" style="display: none" id="num_oficio" value="">
        <table class="table table-bordered">
		  <!--<thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">First</th>
		      <th scope="col">Last</th>
		      <th scope="col">Handle</th>
		    </tr>
		  </thead>-->
		  <tbody>
		    <tr>
		      <th scope="row" width="50%">Cambiar estatus</th>
		      <td>
		      	<div class="form-check form-check-inline">
			      <select id="SelectEstatus" class="form-control" id="select_status">
			        <option value="RECIBIDO">RECIBIDO</option>
			        <option value="LEVANTAMIENTO">LEVANTAMIENTO</option>
			        <option value="ANÁLISIS">ANÁLISIS</option>
			        <option value="REVISIÓN">REVISIÓN</option>
			        <option value="FIRMAS">FIRMAS</option>
			        <!--<option value="TURNADO A SPR">TURNAR A SPR</option>-->
			        <option value="CANCELADO">CANCELADO</option>
			        <option value="OTRO">OTRO</option>
			      </select>
			      <br>
			      <button type="button" class="btn btn-primary" onclick="CambiarEstado()">Guardar</button>
				</div>
		      </td>
		    </tr>
		    <tr>
		      <th scope="row" width="50%">Observaciones</th>
		      <td>
		      	<div class="form-check form-check-inline">
		      		<textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñará" id="Contratacion-Actividades"></textarea>
			      <br>
			      <button type="button" class="btn btn-primary" onclick="CambiarEstado()">Guardar</button>
				</div>
		      </td>
		    </tr>
		  </tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
	  
@endsection

@section('script')
	<script type="text/javascript">
		var gl_solicitudes = <?php echo json_encode($solicitudes) ?>;
    	console.log(gl_solicitudes);
    	function modalConfig(id_sol){
    		var estatus_sol = gl_solicitudes[id_sol]['ESTATUS_SOLICITUD'];
    		//if(estatus)
    		$("#SelectEstatus").val(estatus_sol);
    		//$("#select_status option[value='" + estatus_sol + "']").attr('selected','selected');
    		//console.log(estatus_sol);
    		$("#num_oficio").val(id_sol);
    		$("#ModalConfiguraciones").modal();
    	}

    	

    	function CambiarEstado(){
    		var id_sol = $("#num_oficio").val();
    		var estatus = $("#SelectEstatus").val();
    		//console.log(estatus);
    		var success;
			var url = "/solicitud/cambiar_estado";
			var dataForm = new FormData();
			dataForm.append('id_sol',id_sol);
			dataForm.append('estatus',estatus);
			//lamando al metodo ajax

			metodoAjax(url,dataForm,function(success){
				//aquí se escribe todas las operaciones que se harían en el succes
				//la variable success es el json que recibe del servidor el método AJAX
				gl_solicitudes[id_sol]['ESTATUS_SOLICITUD'] = estatus;
				//$("#td_estatus_"+gl_solicitudes[id_sol]['ID_ESCAPE']).html(estatus);
				//console.log(gl_solicitudes);
				recargarTablaAjax('/refrescar/listado_completo');
				MensajeModal("¡EXITO!","El estatus se ha cambiado correctamente.");
			});//*/
    	}

		function refreshTable() {
		  $('#div_tabla_datos').fadeOut();
		  $('#div_tabla_datos').load('/refrescar/listado_completo', function() {
		      $('#div_tabla_datos').fadeIn();
		  });
		}

	</script>
@endsection