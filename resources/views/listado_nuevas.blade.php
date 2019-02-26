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
		          <td>{{$solicitud->FECHA_CREACION}}</td>
		          <td>{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}</td>
		          <td>
					<div class="btn-group">
					<a class="btn btn-primary" href="#" onclick="AbreModalContratacion('{{$solicitud->ID_SOLICITUD}}')"><i class="icon_info_alt"></i></a>
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
<div class="modal fade" id="ModalDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		      <th scope="row" width="50%">Prioridad</th>
		      <td>
		      	<div class="form-check form-check-inline">
			      <select id="SelectPrioridad" class="form-control">
			        <option value="PRIORIDAD 1">PRIORIDAD 1</option>
			        <option value="PRIORIDAD 2">PRIORIDAD 2</option>
			      </select>
			      <br>
			      <button type="button" class="btn btn-primary" onclick="CambiarPrioridad()">Guardar</button>
				</div>
		      </td>
		    </tr>
		    <tr>
		      <th scope="row" width="50%">Turnar</th>
		      <td>
		      	<div class="form-check form-check-inline">
			      <select id="SelectEstatus" class="form-control">
			        <option value="RECIBIDO" selected>RECIBIDO A SPR</option>
			        <option value="TURNAR A CGA">TURNAR A CGA</option>
			      </select>
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
    		$("#num_oficio").val(id_sol);
    		$("#SelectPrioridad").val(gl_solicitudes[id_sol]['PRIORIDAD_SOLICITUD']);
    		
    		$("#ModalConfiguraciones").modal();
    	}

    	function CambiarEstado(){
    		var id_sol = $("#num_oficio").val();
    		var estatus = $("#SelectEstatus").val();
    		//console.log(id_sol);
    		if(estatus == 'TURNAR A CGA'){
	    		var success;
				var url = "/nuevas/turnar_cga";
				var dataForm = new FormData();
				dataForm.append('id_sol',id_sol);
				//lamando al metodo ajax
				metodoAjax(url,dataForm,function(success){
					//aquí se escribe todas las operaciones que se harían en el succes
					//la variable success es el json que recibe del servidor el método AJAX
					MensajeModal("¡EXITO!","El estatus se ha cambiado correctamente, la solicitud se ha turnado a CGA.");
				});//*/
    		}
    	}

    	function CambiarPrioridad(){
    		var id_sol = $("#num_oficio").val();
    		var prioridad = $("#SelectPrioridad").val();
    		//console.log(id_sol);
    		var success;
			var url = "/solicitudes/cambiar_prioridad";
			var dataForm = new FormData();
			dataForm.append('id_sol',id_sol);
			dataForm.append('prioridad',prioridad);
			//lamando al metodo ajax
			metodoAjax(url,dataForm,function(success){
				//aquí se escribe todas las operaciones que se harían en el succes
				//la variable success es el json que recibe del servidor el método AJAX
				MensajeModal("¡EXITO!","El estatus se ha cambiado correctamente, la solicitud ahora es " + prioridad + '.');
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