@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
<div class="col-lg-12">
	<section class="panel">
	  <header class="panel-heading">
	    Listado de Cambios de Adscripción
	  </header>
	  <div class="table-responsive">
	  	<div id="div_tabla_datos">
	  		@include('tablas.listado_revision_informacion')
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
		      <th scope="row" width="50%">Cambiar estatus (CGA)</th>
		      <td>
		      	<div class="form-check form-check-inline">
			      <select id="SelectEstatus" class="form-control">
			        <option value="VALIDACIÓN DE INFORMACIÓN" selected>VALIDACION DE INFORMACION</option>
			        <option value="RECIBIDO">INFORMACIÓN CORRECTA</option>
			        <option value="CANCELADO">CANCELAR POR INFORMACIÓN INCORRECTA</option>
			      </select>
			      <br>
			      <button type="button" class="btn btn-primary" onclick="ModalCambiarEstado()">Guardar</button>
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

<!-- Modal de verificacion de estatus -->
<div class="modal fade" id="ModalVerificacionEstatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel" align="center">¡ATENCIÓN!</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <input type="" name="" style="display: none" id="hide_solicitud" value="">
      </div>
      <div class="modal-body">
        <h3 align="center" id="mensaje_verificar_estatus"></h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="CambiarEstado()">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
	  
@endsection

@section('script')
	<script type="text/javascript">
		var gl_solicitudes = <?php echo json_encode($solicitudes) ?>;
    	//console.log(gl_solicitudes);

    	//$("#ModalArchivos").modal();


    	function modalConfig(id_sol){
    		$("#num_oficio").val(id_sol);
    		$("#ModalConfiguraciones").modal();
    	}

    	function ModalCambiarEstado(){
    		var id_sol = $("#num_oficio").val();
    		var estatus = $("#SelectEstatus").val();
    		if(estatus != 'VALIDACIÓN DE INFORMACIÓN'){
	    		if(estatus == 'RECIBIDO'){
	    			$("#mensaje_verificar_estatus").text('¿Desea marcar la solicitud como "INFORMACIÓN CORRECTA"?, la solicitud cambiará su estatus a RECIBIDO.');
	    		}else{
	    			$("#mensaje_verificar_estatus").text('¿Desea marcar la solicitud como "CANCELADO POR INFORMACIÓN INCORRECTA"?, la solicitud cambiará su estatus a CANCELADO.');

	    		}
	    		$("#ModalVerificacionEstatus").modal();
    		}
    	}

    	function CambiarEstado(){
    		var id_sol = $("#num_oficio").val();
    		var estatus = $("#SelectEstatus").val();
    		console.log(id_sol);
    		console.log(estatus);
    		console.log('----------------');
			///console.log('CAMBIANDO ESTADO');
    		var success;
			var url = "/revision_informacion/actualiza_estado";
			var dataForm = new FormData();
			dataForm.append('id_sol',id_sol);
			dataForm.append('estatus',estatus);
			//lamando al metodo ajax
			metodoAjax(url,dataForm,function(success){
				//aquí se escribe todas las operaciones que se harían en el succes
				//la variable success es el json que recibe del servidor el método AJAX
				$("#ModalVerificacionEstatus").modal('hide');
				$("#ModalConfiguraciones").modal('hide');
				recargarTablaAjax('/refrescar/revision_informacion');
				if(estatus == 'RECIBIDO'){
					MensajeModal("¡EXITO!","El estatus se ha cambiado correctamente, la solicitud se ha marcado como RECIBIDA.");
				}else{
					MensajeModal("¡EXITO!","El estatus se ha cambiado correctamente, la solicitud se ha marcado como CANCELADA.");
				}
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