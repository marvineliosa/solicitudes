@extends('plantillas.menu')
@section('titulo','Editar Promoción')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Llenado de información de Promociones
		  </header>
		  <div class="panel-body">
        <form class="form-horizontal " method="get">
          <div class="form-group">
            <label class="col-sm-2 control-label">Fecha de Recibido</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" placeholder="Fehca de Recibido" value="{{$solicitud->FECHA_CREACION}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Información Completa</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" placeholder="Fehca de Información Completa" value="{{$solicitud->FECHAS_INFORMACION_COMPLETA}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia" value="{{$solicitud->NOMBRE_DEPENDENCIA}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Título del cuadro</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Título del cuadro (opcional)" value="{{$solicitud->TITULO_CUADRO}}" id="titulo_cuadro">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Candidato</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre del Candidato" value="{{$solicitud->NOMBRE_SOLICITUD}}" id="nombre_candidato">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría actual</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" value="{{$solicitud->CATEGORIA_SOLICITUD}}" id="categoria_actual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto actual</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" value="{{$solicitud->PUESTO_SOLICITUD}}" id="puesto_actual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades actuales</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñará" id="" disabled>{{$solicitud->ACTIVIDADES_SOLICITUD}}</textarea>
            </div>
          </div>
          <div class="form-group">
            @if($solicitud->INSTITUCIONAL)
              <label class="col-sm-2 control-label">Salario Bruto Quincenal Actual</label>
            @else
              <label class="col-sm-2 control-label">Salario Neto Quincenal Actual</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario actual" value="{{$solicitud->SALARIO_SOLICITUD}}" step=".01" id="salario_actual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría solicitada</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nueva categoría solicitada" value="{{$datos_extra->NUEVA_CATEGORIA}}" id="categoria_solicitada">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto solicitado</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nuevo puesto que desempeñará" id="Promocion-PuestoNuevo" value="{{$datos_extra->PUESTO_NUEVO}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nuevas Actividades</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Nuevas actividades que desempeñará" value="" id="Actividades_candidato">{{$datos_extra->NUEVAS_ACTIVIDADES}}</textarea>
            </div>
          </div>
          <div class="form-group">
            @if($solicitud->INSTITUCIONAL)
              <label class="col-sm-2 control-label">Salario Bruto Quincenal Solicitado</label>
            @else
              <label class="col-sm-2 control-label">Salario Neto Quincenal Solicitado</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario solicitado para el candidato" value="{{$datos_extra->NUEVO_SALARIO}}" step=".01" id="salario_solicitado">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Fuente de Recursos*</label>
            <div class="col-sm-6">
              <select class="form-control m-bot15" id="SelectFuenteRecursos">
                  <option value="NA">SELECCIONAR</option>
                  <option value="ADMINISTRACIÓN CENTRAL" {{((strcmp($solicitud->FUENTE_RECURSOS_SOLICITUD,'ADMINISTRACIÓN CENTRAL')==0)?'selected':'')}}>ADMINISTRACIÓN CENTRAL</option>
                  <option value="RECURSOS PROPIOS" {{((strcmp($solicitud->FUENTE_RECURSOS_SOLICITUD,'RECURSOS PROPIOS')==0)?'selected':'')}}>RECURSOS PROPIOS</option>
              </select>
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
            @if($solicitud->INSTITUCIONAL)
              <label class="col-sm-2 control-label">Salario Bruto Quincenal Propuesto</label>
            @else
              <label class="col-sm-2 control-label">Salario Neto Quincenal Propuesto</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario quincenal propuesto" value="{{$solicitud->SALARIO_PROPUESTO_SF}}" id="propuesta-salario" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Superior Propuesta</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría Superior Propuesta" value="{{$solicitud->CATEGORIA_SUPERIOR}}" id="propuesta-categoria_superior">
            </div>
          </div>
          <div class="form-group">
            @if($solicitud->INSTITUCIONAL)
              <label class="col-sm-2 control-label">Salario Bruto Superior Quincenal Propuesto</label>
            @else
              <label class="col-sm-2 control-label">Salario Neto Superior Quincenal Propuesto</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario Superior" value="{{$solicitud->SALARIO_SUPERIOR}}" id="propuesta-salario_superior" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Inferior Propuesta</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría Inferior Propuesta" value="{{$solicitud->CATEGORIA_INFERIOR}}" id="propuesta-categoria_inferior">
            </div>
          </div>
          <div class="form-group">
            @if($solicitud->INSTITUCIONAL)
            <label class="col-sm-2 control-label">Salario Bruto Inferior Quincenal Propuesto</label>
            @else
            <label class="col-sm-2 control-label">Salario Neto Inferior Quincenal Propuesto</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario Inferior" value="{{$solicitud->SALARIO_INFERIOR}}" id="propuesta-salario_inferior" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Ahorro</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Ahorro" value="{{$solicitud->AHORRO_SOLICITUD}}" id="ahorro_solicitud" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Compensación</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Compensación" value="{{$solicitud->COMPENSACION_SOLICITUD}}" id="compensacion_solicitud" step=".01">
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
    //console.log(gl_solicitud);
    var categoria = <?php echo json_encode(\Session::get('categoria')[0]) ?>;
    //console.log(categoria);

    

    function verCuadro(id_solicitud){
      //location.href='/cuadro/contratacion/'+id_solicitud;
      window.open('/cuadro/promocion/'+id_solicitud,'_blank');

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
      var nombre_candidato = $("#nombre_candidato").val();
      var categoria_actual = $("#categoria_actual").val();
      var puesto_actual = $("#puesto_actual").val();
      var salario_actual = $("#salario_actual").val();
      var fuente_recursos = $("#SelectFuenteRecursos").val();

      var categoria_solicitada = $("#categoria_solicitada").val();
      var salario_solicitado = $("#salario_solicitado").val();
      var actividades = $("#Actividades_candidato").val();
      //console.log(actividades);
      var titulo_cuadro = $("#titulo_cuadro").val();
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
      var compensacion_solicitud = $("#compensacion_solicitud").val();
      //console.log(ahorro_solicitud);
      var success;
      var url = "/promocion/guardar_datos_promocion";
      var dataForm = new FormData();
      dataForm.append('id_sol',id_solicitud);
      dataForm.append('nombre_candidato',nombre_candidato);
      dataForm.append('categoria_actual',categoria_actual);
      dataForm.append('puesto_actual',puesto_actual);
      dataForm.append('salario_actual',salario_actual);
      dataForm.append('fuente_recursos',fuente_recursos);

      dataForm.append('titulo_cuadro',titulo_cuadro);
      dataForm.append('categoria_solicitada',categoria_solicitada);
      dataForm.append('salario_solicitado',salario_solicitado);
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
      dataForm.append('compensacion_solicitud',compensacion_solicitud);
      //lamando al metodo ajax
      if(nombre_candidato==''){
        MensajeModal('¡ATENCIÓN!','El nombre del candidato no puede estar vacío');
      }else if(categoria_actual==''){
        MensajeModal('¡ATENCIÓN!','La categoría actual del candidato no puede estar vacío');
      }else if(puesto_actual==''){
        MensajeModal('¡ATENCIÓN!','El puesto actual del candidato no puede estar vacío');
      }else if(salario_actual=='' || salario_actual < 1){
        MensajeModal('¡ATENCIÓN!','El salario actual del candidato no puede estar vacío o ser igual a 0');
      }else if(categoria_solicitada==''){
        MensajeModal('¡ATENCIÓN!','El campo de categoría solicitada no puede estar vacío');
      }else if(salario_solicitado=='' || salario_solicitado<1){
        MensajeModal('¡ATENCIÓN!','El salario solicitado no puede estar vacío o ser igual a 0');
      }else if(actividades==''){
        MensajeModal('¡ATENCIÓN!','El campo de actividades no puede estar vacío');
      }else{
        metodoAjax(url,dataForm,function(success){
          //aquí se escribe todas las operaciones que se harían en el succes
          //la variable success es el json que recibe del servidor el método AJAX
          MensajeModal("¡EXITO!","La información se ha actualizado correctamente.");
        });//*/
      }

    }
  </script>

@endsection