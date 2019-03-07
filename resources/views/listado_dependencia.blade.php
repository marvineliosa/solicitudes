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
	  		@include('tablas.listado_dependencia')
	  	</div>
	  </div>
	</section>
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
		      <th scope="row" width="50%">Validar Solicitud</th>
		      <td>
		      	<div class="form-check form-check-inline">
			      <select id="SelectValidar" class="form-control" id="select_status">
			        <option value="SELECCIONAR">--SELECCIONAR--</option>
			        <option value="VALIDAR">VALIDAR</option>
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
    	//console.log(gl_solicitudes);
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
    		var estatus = $("#SelectValidar").val();
    		//console.log(estatus);
    		var success;
			var url = "/solicitud/validacion_titular";
			var dataForm = new FormData();
			dataForm.append('id_sol',id_sol);
			dataForm.append('estatus',estatus);
			//lamando al metodo ajax

			metodoAjax(url,dataForm,function(success){
				//aquí se escribe todas las operaciones que se harían en el succes
				//la variable success es el json que recibe del servidor el método AJAX
				gl_solicitudes[id_sol]['ESTATUS_SOLICITUD'] = estatus;
				$("#td_estatus_"+gl_solicitudes[id_sol]['ID_ESCAPE']).html(estatus);
				//console.log(gl_solicitudes);
				recargarTablaAjax('/refrescar/dependencia');
				MensajeModal("¡EXITO!","El estatus se ha cambiado correctamente.");
			});//*/
    	}
    	//$("#ModalArchivos").modal();

    	function modalArchivosDependencia(id_solicitud){
		    var success;
		    var url = "/archivos/obtener_archivos";
		    var dataForm = new FormData();
		    dataForm.append('id_solicitud',id_solicitud);
		    //lamando al metodo ajax
		    metodoAjax(url,dataForm,function(success){
		      //aquí se escribe todas las operaciones que se harían en el succes
		      //la variable success es el json que recibe del servidor el método AJAX
		      $("#TituloModalArchivos").text('Archivos de la solicitud '+id_solicitud);
		      $("#CuerpoTablaArchivos").html('');
		      //console.log(success)
		      for(i=0;i<success['archivos'].length;i++){

		        var mensaje = ((success['archivos'][i]['MENSAJE_ARCHIVO']!='')?'<span style="color: black;">Mensaje: '+success['archivos'][i]['MENSAJE_ARCHIVO']+'</span>':'Sin mensaje')+'<hr style="border: 1px solid #DDDDDD;">';

		        if(success['archivos'][i]['TIPO_ARCHIVO']=='PLANTILLA DE PERSONAL'){
		        	var input = '<input type="file" class="form-control-file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" style="width:400px" id="file_modal_'+success['archivos'][i]['ID_ARCHIVO']+'"><br>'+
	        					'<button type="button" class="btn btn-primary" center="center" onclick="ActualizarArchivo('+success['archivos'][i]['ID_ARCHIVO']+')">Actualizar Archivo</button>';
		        }else{
			        var input = '<input type="file" class="form-control-file" accept="application/pdf" style="width:400px" id="file_modal_'+success['archivos'][i]['ID_ARCHIVO']+'"><br>'+
	        					'<button type="button" class="btn btn-primary" center="center" onclick="ActualizarArchivo('+success['archivos'][i]['ID_ARCHIVO']+')">Actualizar Archivo</button>';
	        	}

		        $("#CuerpoTablaArchivos").append(
		          '<tr>'+
		            '<td scope="col" rowspan="2" style="vertical-align: middle;">'+success['archivos'][i]['TIPO_ARCHIVO']+'</td>'+
		            '<td>'+'Descargar: '+'<a href="/descargas/archivo/'+success['archivos'][i]['ID_ARCHIVO']+'"  target="_blank">'+success['archivos'][i]['TIPO_ARCHIVO']+'</a>'+'</td>'+
		          '</tr>'+
		          '<tr>'+
		            '<td>'+
		              mensaje+
		              input+
		            '</td>'+
		          '</tr>'
		        );
		      }
		      $("#ModalArchivos").modal();
		    });
    	}

    	function ActualizarArchivo(id_archivo){
    		//console.log(id_archivo);
    		var archivo = document.getElementById('file_modal_'+id_archivo);
    		//console.log(archivo.files[0]);
    		//console.log(estatus);
    		if(archivo.value!=''){
	    		var success;
				var url = "/archivos/actualizar_archivo";
				var dataForm = new FormData();
				dataForm.append('id_archivo',id_archivo);
				dataForm.append('archivo',archivo.files[0]);
				//lamando al metodo ajax

				metodoAjax(url,dataForm,function(success){
					//aquí se escribe todas las operaciones que se harían en el succes
					//la variable success es el json que recibe del servidor el método AJAX
					MensajeModal("¡EXITO!","El archivo se ha actualizado correctamente");
				});//*/
    		}else{
    			MensajeModal("¡ATENCIÓN!","No se ha seleccionado ningún archivo");
    		}
    	}



	</script>
@endsection