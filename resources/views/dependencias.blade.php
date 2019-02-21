@extends('plantillas.menu')
@section('titulo','Dependencias')
@section('content')
<div class="col-lg-12">
	<section class="panel">
	  <header class="panel-heading">
	    Listado de Cambios de Adscripción
	  </header>
	  <div class="table-responsive">
	  	<div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-6">
              <select class="form-control m-bot15" id="select-dependencias" onchange="CambioDependencia()">
                  <option value="SELECCIONAR">--SELECCIONAR DEPENDENCIA--</option>
                  @foreach($dependencias as $dependencia)
                  	<option value="{{$dependencia->ID_DEPENDENCIA}}">{{$dependencia->NOMBRE_DEPENDENCIA}}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Titular</label>
            <div class="col-sm-6">
            	<input type="text" class="form-control" placeholder="NOMBRE DEL TITULAR" id="nombre_titular">
            </div>
          </div>

          <hr>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-2">
              <button type="button" class="btn btn-primary" onclick="GuardarDatosDependencia()">Guardar</button>
            </div>
          </div>
      	</div>
	  </div>
	</section>
</div>

<!-- Modales -->
<div class="modal fade" id="EjemploModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Configuraciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	MODAL
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
		var gl_dependencias = <?php echo json_encode($dependencias) ?>;
    	console.log(gl_dependencias);

    	function CambioDependencia(){
    		var id_dependencia = $("#select-dependencias").val();
    		//console.log(id_dependencia);
    		if(id_dependencia!='SELECCIONAR'){
				var success;
				var url = "/dependencias/trae_dependencia";
				var dataForm = new FormData();
				dataForm.append('id_dependencia',id_dependencia);
				//lamando al metodo ajax
				metodoAjax(url,dataForm,function(success){
					//aquí se escribe todas las operaciones que se harían en el succes
					//la variable success es el json que recibe del servidor el método AJAX
					//MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
					$("#nombre_titular").val(success['dependencia']['TITULAR_DEPENDENCIA']);
				});
    		}else{
    			$("#nombre_titular").val('');
    		}
    	}

    	function GuardarDatosDependencia(){
    		var id_dependencia = $("#select-dependencias").val();
    		var titular = $("#nombre_titular").val();
    		//console.log(id_dependencia);
    		if(id_dependencia!='SELECCIONAR'){
				var success;
				var url = "/dependencias/editar";
				var dataForm = new FormData();
				dataForm.append('id_dependencia',id_dependencia);
				dataForm.append('titular',titular);
				//lamando al metodo ajax
				metodoAjax(url,dataForm,function(success){
					//aquí se escribe todas las operaciones que se harían en el succes
					//la variable success es el json que recibe del servidor el método AJAX
					MensajeModal("¡EXITO!","Los datos se han guardado correctamente.");

				});
    		}else{
    			MensajeModal("¡ATENCIÓN!","Debe seleccionar una dependencia.");
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