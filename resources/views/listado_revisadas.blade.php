@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
<div class="col-lg-12">
	<section class="panel">
	  <header class="panel-heading">
	    Listado de Cambios de Adscripción
	  </header>
	  <div class="table-responsive">
	    <table class="table" id="tabla_datos">
	      <thead>
	        <tr>
	          <th>Folio</th>
	          <th>Candidato</th>
	          <th>Dependencia</th>
	          <th>Fecha de recepción</th>
	          <th>Solicitud</th>
	          <th>Acciones</th>
	        </tr>
	      </thead>
	      <tbody>
	      	@foreach($solicitudes as $solicitud)
		        <tr class="">
		          <td>{{$solicitud->ID_SOLICITUD}}</td>
		          <td>{{$solicitud->NOMBRE_SOLICITUD}}</td>
		          <td>{{$solicitud->NOMBRE_DEPENDENCIA}}</td>
		          <td>{{$solicitud->FECHA_ENVIO}}</td>
		          <td>{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}</td>
		          <td>
					<div class="btn-group">
              		<a class="btn btn-primary" href="javascript:void(0)" onclick="AbreModalInformacion('{{$solicitud->ID_SOLICITUD}}','{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}')"><i class="icon_info_alt"></i></a>
              		<a class="btn btn-info" href="javascript:void(0)" onclick="modalComentarios('{{$solicitud->ID_SOLICITUD}}')"><i class="icon_comment"></i></a>
					<a class="btn btn-danger" href="#" onclick="modalConfig('{{$solicitud->ID_SOLICITUD}}')"><i class="icon_adjust-vert"></i></a>	
					</div>
		          </td>
		        </tr>
		    @endforeach
	      </tbody>
	    </table>
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
		  <tbody>
		    <tr>
		      <th scope="row" width="50%">Turnar nuevamente a CGA</th>
		      <td>
		      	<div class="form-check form-check-inline">
			      <select id="SelectEstatus" class="form-control">
			        <option value="RECIBIDO" selected>RECIBIDO A SPR</option>
			        <option value="REVISION">TURNAR A CGA</option>
			      </select>
			      <br>
			      <button type="button" class="btn btn-primary" onclick="CambiarEstado()">Guardar</button>
				</div>
		      </td>
		    </tr>
		    <!--<tr>
		      <th scope="row" width="50%">Validar cuadro</th>
		      <td>
		      	<div class="form-check form-check-inline">
			      <select id="SelectValidar" class="form-control">
			        <option value="SELECCIONAR">SELECCIONAR</option>
			        <option value="VALIDAR">VALIDAR</option>
			      </select>
			      <br>
			      <button type="button" class="btn btn-primary" onclick="ValidarSolicitud()">Guardar</button>
				</div>
		      </td>
		    </tr>-->
		  </tbody>
		</table>
		<a href="/cuadro/contratacion/SOL_1_2019" target="_blank">Ver cuadro</a>
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
    		$("#num_oficio").val(id_sol);
    		$("#ModalConfiguraciones").modal();
    	}

    	function CambiarEstado(){
    		var id_sol = $("#num_oficio").val();
    		var estatus = $("#SelectEstatus").val();
    		console.log(estatus);
    		if(estatus!='RECIBIDO'){
	    		var success;
				var url = "/solicitud/cambiar_estado";
				var dataForm = new FormData();
				dataForm.append('id_sol',id_sol);
				dataForm.append('estatus',estatus);
				//lamando al metodo ajax
				metodoAjax(url,dataForm,function(success){
					//aquí se escribe todas las operaciones que se harían en el succes
					//la variable success es el json que recibe del servidor el método AJAX
					MensajeModal("¡EXITO!","El estatus se ha turnado nuevamente a CGA.");
				});//*/
    		}
    	}

    	function ValidarSolicitud(){
    		var id_sol = $("#num_oficio").val();
    		var estatus = $("#SelectEstatus").val();

    		if(estatus != 'REVISION'){
	    		var success;
				var url = "/solicitud/validar_solicitud";
				var dataForm = new FormData();
				dataForm.append('id_sol',id_sol);
				//lamando al metodo ajax
				metodoAjax(url,dataForm,function(success){
					//aquí se escribe todas las operaciones que se harían en el succes
					//la variable success es el json que recibe del servidor el método AJAX
					MensajeModal("¡EXITO!","La solicitud ha sido validada, se ha agregado un sello digital al cuadro.");
				});//*/

    		}

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