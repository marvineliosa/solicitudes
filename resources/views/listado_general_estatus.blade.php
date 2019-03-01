@extends('plantillas.menu')
@section('titulo', $modulo)
@section('content')
<div class="col-lg-12">
	<section class="panel">
	  <header class="panel-heading">
	    Listado Completo
	  </header>
	  <div class="table-responsive">
	  	<div id="div_tabla_datos">
	    	@include('tablas.listado_general_estatus')
	  	</div>
	  </div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalConfiguraciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Configuraciones</h5>
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
			        <option value="SELECCIONAR">SELECCIONAR</option>
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
		    @if(strcmp(\Session::get('categoria')[0],'ADMINISTRADOR_CGA')==0)
		    <tr>
		      <th scope="row" width="50%">Asignar solicitud a un analista</th>
		      <td>
		      	<div class="form-check form-check-inline">
			      <select id="SelectAnalistas" class="form-control" id="select_status">
			        <option value="SELECCIONAR">SELECCIONAR</option>
			        @foreach($analistas as $analista)
			        	<option value="{{$analista->USUARIO_ANALISTA}}">{{$analista->NOMBRE_ANALISTA}}</option>
			        @endforeach
			      </select>
			      <br>
			      <button type="button" class="btn btn-primary" onclick="AsignarAnalista()">Asignar</button>
				</div>
		      </td>
		    </tr>
		    @endif
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
    	//console.log(gl_solicitudes);
		var gl_analistas = <?php echo json_encode($analistas) ?>;
    	//console.log(gl_analistas);
		var gl_modulo = (<?php echo json_encode($modulo) ?>).toLowerCase();
    	console.log(gl_modulo);

    	function AsignarAnalista(){
    		var analista = $("#SelectAnalistas").val();
    		var id_solicitud = $("#num_oficio").val();
    		if(analista != 'SELECCIONAR'){
	    		//console.log(estatus);
	    		var success;
				var url = "/solicitud/asignar_analista";
				var dataForm = new FormData();
				dataForm.append('id_solicitud',id_solicitud);
				dataForm.append('analista',analista);
				//lamando al metodo ajax

				metodoAjax(url,dataForm,function(success){
					//aquí se escribe todas las operaciones que se harían en el succes
					//la variable success es el json que recibe del servidor el método AJAX
					MensajeModal("¡EXITO!","La solicitud se ha asignado correctamente.");
				});//*/
    		}else{
    			MensajeModal('¡ATENCIÓN!','Debe seleccionar un analista');
    		}
    	}

    	function modalConfig(id_sol){
    		var estatus_sol = gl_solicitudes[id_sol]['ESTATUS_SOLICITUD'];
    		//if(estatus)
    		if(estatus_sol != 'TURNADO A SPR'){
    			$("#SelectEstatus").val(estatus_sol);

    		}
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
			console.log(gl_modulo);
			console.log('/refrescar/listado_general/'+gl_modulo);
			metodoAjax(url,dataForm,function(success){
				//aquí se escribe todas las operaciones que se harían en el succes
				//la variable success es el json que recibe del servidor el método AJAX
				gl_solicitudes[id_sol]['ESTATUS_SOLICITUD'] = estatus;
				//$("#td_estatus_"+gl_solicitudes[id_sol]['ID_ESCAPE']).html(estatus);
				//console.log(gl_solicitudes);
				recargarTablaAjax('/refrescar/listado_general/'+gl_modulo);
				MensajeModal("¡EXITO!","El estatus se ha cambiado correctamente.");
			});//*/
    	}

		function refreshTable() {
		  $('#div_tabla_datos').fadeOut();
		  $('#div_tabla_datos').load('/refrescar/listado_general_estatus', function() {
		      $('#div_tabla_datos').fadeIn();
		  });
		}

	</script>
@endsection