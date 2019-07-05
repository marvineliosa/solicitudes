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
		      <th scope="row" width="75%"><b style="font-size: 15px">Acepto la propuesta.</b><br><em>Esta opción agregará un sello digital al cuadro.</em></th>
		      <td>
		      	<div class="form-check form-check-inline">
			      <!--<select id="SelectValidar" class="form-control" id="select_status">
			        <option value="SELECCIONAR">--SELECCIONAR--</option>
			        <option value="VALIDAR">VALIDAR</option>
			      </select>
			      <br>
			      <button type="button" class="btn btn-primary" onclick="CambiarEstado()">Aceptar</button>-->
			      <button type="button" class="btn btn-primary" onclick="ModalAceptarSolicitud()">Aceptar Solicitud</button>
				</div>
		      </td>
		    </tr>
		    <tr>
		      <th scope="row" width="75%"><b style="font-size: 15px">No acepto la propuesta y solicito cita con la Coordinación General Administrativa.</b><br><em>Esta opción cancelará la solicitud y posteriormente podrá obtener una cita por parte de la Coordinación General Adminsitrativa para obtener más detalles.</th>
		      <td>
			      <button type="button" class="btn btn-danger" onclick="ModalCancelarSolicitud()">Cancelar Solicitud</button>
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

<!-- MODAL DE ACEPTAR SOLICITUD -->
<div class="modal fade" id="ModalAceptarSolicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <h3 align="center" id="mensaje_aceptar_solicitud"></h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="AceptarSolicitud()">Aceptar Propuesta</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DE CANCELAR SOLICITUD POR NO ACEPTAR PROPUESTA -->
<div class="modal fade" id="ModalCancelarSolicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <h3 align="center" id="mensaje_cancelar_solicitud"></h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="CancelarSolicitud()">Cancelar Solicitud</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DE CANCELACION NORMAL DE SOLICITUD -->
<div class="modal fade" id="ModalCancelacionNormal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel" align="center">¡ATENCIÓN!</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 align="center" id="mensaje_cancelar_solicitud_normal"></h3>
        <h4 align="center" id="">Por favor especifique el motivo de la cancelación</h4>
        <textarea class="form-control ckeditor" name="editor1" rows="3" id="MotivoCancelacion"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="CancelacionNormalSolicitud()">Cancelar Solicitud</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Detalle de Propuesta-->
    <div class="modal fade" id="ModalDetallePropuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="TituloModalPropuesta" align="center"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          	<div class="modal-body table-responsive">
            	<table class="table" width="100%" style="table-layout: fixed;">
					<thead>
						<tr>
							<th scope="col">Concepto</th>
							<th scope="col">Descripción</th>
						</tr>
					</thead>
					<tbody id="CuerpoTablaPropuesta" style="padding: 5px !important;">

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


	  
@endsection

@section('script')
	<script type="text/javascript">
		var gl_solicitudes = <?php echo json_encode($solicitudes) ?>;
    	//console.log(gl_solicitudes);

    	//MensajeModal('¡ATENCIÓN!','Se les comunica que el día de hoy, a partir de las 16:30 horas, se dará mantenimiento al Sistema de Solicitudes, por lo que su uso se reanudará mañana a las 9:00 horas. De antemano agradecemos su comprensión y apoyo.');
    	//$("#SaludoModalMensaje").text('Buen día');

    	function CancelacionNormalSolicitud(){
    		var id_sol = $("#hide_solicitud").val();
    		var motivo = $('#MotivoCancelacion').val();
    		//console.log(id_sol);
    		var success;
			var url = "/solicitud/cancelacion_normal";
			var dataForm = new FormData();
			dataForm.append('id_sol',id_sol);
			dataForm.append('motivo',motivo);
			//lamando al metodo ajax
			//console.log(motivo);
			if(motivo == ''){
				MensajeModal('¡ATENCIÓN!','Favor de especificar el motivo de la cancelación');
			}else{
				metodoAjax(url,dataForm,function(success){
					//aquí se escribe todas las operaciones que se harían en el succes
					//la variable success es el json que recibe del servidor el método AJAX
					//console.log(gl_solicitudes);
					recargarTablaAjax('/refrescar/dependencia');
					$("#ModalCancelacionNormal").modal('hide');
					MensajeModal("¡EXITO!","La solicitud ha sido cancelada satisfactoriamente.");
				});//*/
			}
    	}

    	function ModalCancelacionNormal(id_solicitud){
    		var motivo = $('#MotivoCancelacion').val('');
    		$("#mensaje_cancelar_solicitud_normal").text('¿Desea cancelar la solicitud '+id_solicitud+'?')
    		$("#hide_solicitud").val(id_solicitud);
    		$("#ModalCancelacionNormal").modal();

    	}

		function VerDatosCuadro(id_solicitud,tipo_solicitud){
			//$("#div_cuadro").hide();
    		url = '/solicitud/obtener_propuesta';
			var success;
			var dataForm = new FormData();
			dataForm.append('id_solicitud',id_solicitud);
			dataForm.append('tipo_solicitud',tipo_solicitud);
			//lamando al metodo ajax

			metodoAjax(url,dataForm,function(success){
				//aquí se escribe todas las operaciones que se harían en el succes
				//la variable success es el json que recibe del servidor el método AJAX
				//console.log(success);
				$("#CuerpoTablaPropuesta").html('');
				for(var i = 0; i < success['cabeceras'].length; i++){
					//console.log(success['cabeceras'][i]);
					if(success['cabeceras'][i]!='Escape'){
						$("#CuerpoTablaPropuesta").append(
						'<tr>'+
						'<th scope="row">' + success['cabeceras'][i] + '</th>'+
						'<td id=""  style="word-wrap: break-word;">'+ ((success['datos'][success['cabeceras'][i]])?success['datos'][success['cabeceras'][i]]:'') +'</td>'+
						'</tr>'
						);
					}
				}
				$("#TituloModalPropuesta").text('Opinión de la Coordinación General Administrativa');
				$("#ModalDetallePropuesta").modal();
			});//
		}//*/

    	function ModalAceptarSolicitud(id_solicitud){
    		$("#hide_solicitud").val(id_solicitud);
    		$("#mensaje_aceptar_solicitud").text('¿Esta seguro de aceptar la propuesta de la Coordinación General Administrativa correspondiente a la solicitud '+id_solicitud+'?');
    		$("#ModalAceptarSolicitud").modal();
    	}
    	function ModalCancelarSolicitud(id_solicitud){
    		$("#hide_solicitud").val(id_solicitud);
    		$("#mensaje_cancelar_solicitud").text('¿Esta seguro de cancelar la solicitud '+id_solicitud+' y pedir cita con la Coordinación General Administrativa?');
    		$("#ModalCancelarSolicitud").modal();
    	}

    	function modalConfig(id_sol){
    		var estatus_sol = gl_solicitudes[id_sol]['ESTATUS_SOLICITUD'];
    		//if(estatus)
    		$("#SelectEstatus").val(estatus_sol);
    		//$("#select_status option[value='" + estatus_sol + "']").attr('selected','selected');
    		//console.log(estatus_sol);
    		$("#num_oficio").val(id_sol);
    		$("#ModalConfiguraciones").modal();
    	}

    	function AceptarSolicitud(){
    		var id_sol = $("#hide_solicitud").val();
    		var estatus = 'VALIDAR';
    		//console.log(id_sol);
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
				$("#ModalAceptarSolicitud").modal('hide');
				MensajeModal("¡EXITO!","El estatus se ha cambiado correctamente.");
			});//*/
    	}

    	function CancelarSolicitud(){
    		var id_sol = $("#hide_solicitud").val();
    		var estatus = 'CANCELADO POR TITULAR';
    		//console.log(id_sol);
    		var success;
			var url = "/solicitud/cancelacion_titular";
			var dataForm = new FormData();
			dataForm.append('id_sol',id_sol);
			dataForm.append('estatus',estatus);
			//lamando al metodo ajax

			metodoAjax(url,dataForm,function(success){
				//aquí se escribe todas las operaciones que se harían en el succes
				//la variable success es el json que recibe del servidor el método AJAX
				//console.log(gl_solicitudes);
				recargarTablaAjax('/refrescar/dependencia');
				$("#ModalCancelarSolicitud").modal('hide');
				MensajeModal("¡EXITO!","La solicitud ha sido cancelada satisfactoriamente.");
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