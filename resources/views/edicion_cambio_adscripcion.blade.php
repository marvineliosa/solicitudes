@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Llenado de información de Contrataciones
		  </header>
		  <div class="panel-body">
        <form class="form-horizontal " method="get">
          <div class="form-group">
            <label class="col-sm-2 control-label">Fecha de Recibido</label>
            <div class="col-sm-4">
              <input type="date" class="form-control" placeholder="Fehca de Recibido" value="{{$solicitud->FECHA_CREACION}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Información Completa</label>
            <div class="col-sm-4">
              <input type="date" class="form-control" placeholder="Fehca de Información Completa" value="{{$solicitud->FECHAS_INFORMACION_COMPLETA}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia actual</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia" value="{{$solicitud->NOMBRE_DEPENDENCIA}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia destino</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia" value="{{$datos_extra->NUEVA_DEPENDENCIA}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Candidato</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre del Candidato" value="{{$solicitud->NOMBRE_SOLICITUD}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría actual</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" value="{{$solicitud->CATEGORIA_SOLICITUD}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto actual</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" value="{{$solicitud->PUESTO_SOLICITUD}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades actuales</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñará" id="" disabled>{{$solicitud->ACTIVIDADES_SOLICITUD}}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario actual</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Puesto del Candidato" value="{{$solicitud->SALARIO_SOLICITUD}}" step=".01" disabled>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría solicitada</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" id="CambioAdscripcion-CategoriaNueva" value="{{$datos_extra->NUEVA_CATEGORIA}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto solicitado</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" id="CambioAdscripcion-PuestoNuevo" value="{{$datos_extra->PUESTO_NUEVO}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nuevas actividades</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeña" id="Actividades_candidato">{{$datos_extra->NUEVAS_ACTIVIDADES}}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario neto solicitado</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Puesto del Candidato" id="CambioAdscripcion-SalarioSolicitado" step=".01" value="{{$datos_extra->NUEVO_SALARIO}}" disabled>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Justificación</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Descripción se la solicitud del personal" disabled>{{$solicitud->JUSTIFICACION_SOLICITUD}}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto Propuesto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto Propuesto" value="{{$solicitud->PUESTO_PROPUESTO}}" id="propuesta-puesto">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Propuesta</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría Propuesta" value="{{$solicitud->CATEGORIA_PROPUESTA}}" id="propuesta-categoria">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario Neto Propuesto</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Puesto del Candidato" value="{{$solicitud->SALARIO_PROPUESTO}}" id="propuesta-salario" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Superior Propuesta</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría Superior Propuesta" value="{{$solicitud->CATEGORIA_SUPERIOR}}" id="propuesta-categoria_superior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario Neto Superior Propuesto</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Puesto del Candidato" value="{{$solicitud->SALARIO_SUPERIOR}}" id="propuesta-salario_superior" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Inferior Propuesta</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría Inferior Propuesta" value="{{$solicitud->CATEGORIA_INFERIOR}}" id="propuesta-categoria_inferior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario Neto Inferior Propuesto</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Slario Neto Inferior" value="{{$solicitud->SALARIO_INFERIOR}}" id="propuesta-salario_inferior" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Ahorro</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Ahorro" value="{{$solicitud->AHORRO_SOLICITUD}}" id="ahorro_solicitud" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Procedente</label>
            <div class="col-sm-6">
              <select id="SelectProcede" class="form-control">
                <option value="">--SELECCIONAR--</option>
                <option value="SI" {{((strcmp($solicitud->ESTATUS_PROCEDE,'SI')==0)?'selected':'')}}>SI</option>
                <option value="NO" {{((strcmp($solicitud->ESTATUS_PROCEDE,'NO')==0)?'selected':'')}}>NO</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Respuesta</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Descripción de la respuesta por parte de la CGA" id="respuesta">{{$solicitud->RESPUESTA_CGA}}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-2">
              <button type="button" class="btn btn-secondary" onclick="regresar()">Regresar</button>
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-success" onclick="verCuadro('{{$solicitud->ID_ESCAPE}}')">Ver Cuadro</button>
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-primary" onclick="guardarDatos('{{$solicitud->ID_SOLICITUD}}')">Guardar</button>
            </div>
          </div>
        </form>
      </div>
		</section>
	</div>
	  
@endsection

@section('script')

  <script type="text/javascript">
    var gl_solicitud = <?php echo json_encode($solicitud) ?>;
    console.log(gl_solicitud);
    var categoria = <?php echo json_encode(\Session::get('categoria')[0]) ?>;
    console.log(categoria);

    

    function verCuadro(id_solicitud){
      //location.href='/cuadro/contratacion/'+id_solicitud;
      window.open('/cuadro/contratacion/'+id_solicitud,'_blank');

    }

    function regresar(){
      if(categoria == 'ADMINISTRADOR_CGA'){
        location.href='/listado/completo';
      }else{
        location.href='/listado/analista';
      }
    }

    function guardarDatos(id_solicitud){
      //console.log(id_solicitud);
      var actividades = $("#Actividades_candidato").val();
      //console.log(actividades);
      var categoria = $("#propuesta-categoria").val();
      var puesto = $("#propuesta-puesto").val();
      var salario = $("#propuesta-salario").val();
      var procede = $("#SelectProcede").val();
      var respuesta = $("#respuesta").val();
      
      var salario_superior = $("#propuesta-salario_superior").val();
      var categoria_superior = $("#propuesta-categoria_superior").val();

      var salario_inferior = $("#propuesta-salario_inferior").val();
      var categoria_inferior = $("#propuesta-categoria_inferior").val();

      var ahorro_solicitud = $("#ahorro_solicitud").val();
      //console.log(ahorro_solicitud);
      var success;
      var url = "/cambio_adscripcion/guardar_datos_cambio_adscripcion";
      var dataForm = new FormData();
      dataForm.append('id_sol',id_solicitud);
      dataForm.append('actividades',actividades);
      dataForm.append('categoria',categoria);
      dataForm.append('puesto',puesto);
      dataForm.append('salario',salario);
      dataForm.append('procede',procede);
      dataForm.append('respuesta',respuesta);
      dataForm.append('salario_superior',salario_superior);
      dataForm.append('categoria_superior',categoria_superior);
      dataForm.append('salario_inferior',salario_inferior);
      dataForm.append('categoria_inferior',categoria_inferior);
      dataForm.append('ahorro_solicitud',ahorro_solicitud);
      //lamando al metodo ajax

      metodoAjax(url,dataForm,function(success){
        //aquí se escribe todas las operaciones que se harían en el succes
        //la variable success es el json que recibe del servidor el método AJAX
        MensajeModal("¡EXITO!","La información se ha actualizado correctamente.");
      });//*/
    }
  </script>

@endsection