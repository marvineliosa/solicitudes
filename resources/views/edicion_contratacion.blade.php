@extends('plantillas.menu')
@section('titulo','Editar Contratación')
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
            <label class="col-sm-2 control-label">Categoría</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" value="{{$solicitud->CATEGORIA_SOLICITUD}}" id="categoria_solicitada">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" value="{{$solicitud->PUESTO_SOLICITUD}}" id="puesto_solicitado">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñará" id="Actividades_candidato" maxlength="830">{{$solicitud->ACTIVIDADES_SOLICITUD}}</textarea>
            </div>
          </div>
          <div class="form-group">
            @if($solicitud->INSTITUCIONAL)
              <label class="col-sm-2 control-label">Salario Bruto Quincenal Solicitado</label>
            @else
              <label class="col-sm-2 control-label">Salario Neto Quincenal Solicitado</label>
            @endif

            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Puesto del Candidato" value="{{$solicitud->SALARIO_SOLICITUD}}" step=".01" id="salario_solicitado">
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
              <input type="number" class="form-control" placeholder="Salario Propuesto" value="{{$solicitud->SALARIO_PROPUESTO_SF}}" id="propuesta-salario" step=".01">
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
              <label class="col-sm-2 control-label">Salario Bruto Quincenal Superior Propuesto</label>
            @else
              <label class="col-sm-2 control-label">Salario Neto Quincenal Superior Propuesto</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario Superior Propuesto" value="{{$solicitud->SALARIO_SUPERIOR}}" id="propuesta-salario_superior" step=".01">
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
              <label class="col-sm-2 control-label">Salario Bruto Quincenal Inferior Propuesto</label>
            @else
              <label class="col-sm-2 control-label">Salario Neto Quincenal Inferior Propuesto</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario Inferior Propuesto" value="{{$solicitud->SALARIO_INFERIOR}}" id="propuesta-salario_inferior" step=".01">
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
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Descripción de la respuesta por parte de la CGA" id="respuesta" maxlength="830">{{$solicitud->RESPUESTA_CGA}}</textarea>
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
      var candidato = $("#nombre_candidato").val();
      var categoria_solicitada = $("#categoria_solicitada").val();
      var puesto_solicitado = $("#puesto_solicitado").val();
      var actividades = $("#Actividades_candidato").val();
      var salario_solicitado = $("#salario_solicitado").val();
      var fuente_recursos = $("#SelectFuenteRecursos").val();
      //console.log(fuente_recursos);
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
      var url = "/contratacion/guardar_datos_contratacion";
      var dataForm = new FormData();
      dataForm.append('id_sol',id_solicitud);
      dataForm.append('candidato',candidato);
      dataForm.append('categoria_solicitada',categoria_solicitada);
      dataForm.append('puesto_solicitado',puesto_solicitado);
      dataForm.append('actividades',actividades);
      dataForm.append('salario_solicitado',salario_solicitado);
      dataForm.append('fuente_recursos',fuente_recursos);

      dataForm.append('titulo_cuadro',titulo_cuadro);
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

      if(candidato==''){
        MensajeModal('¡ATENCIÓN!','El nombre del candidato no puede estar vacío');
      }else if(actividades == ''){
        MensajeModal('¡ATENCIÓN!','Las actividades no pueden estar vacías');

      }else if(salario_solicitado == '' || salario_solicitado < 1){
        MensajeModal('¡ATENCIÓN!','El salario no puede estar vacío y debe ser mayor a 0');

      }else{
        //MensajeModal('epale','ENVIADO');
        metodoAjax(url,dataForm,function(success){
          //aquí se escribe todas las operaciones que se harían en el succes
          //la variable success es el json que recibe del servidor el método AJAX
          MensajeModal("¡EXITO!","La información se ha actualizado correctamente.");
        });//*/
      }

      /*metodoAjax(url,dataForm,function(success){
        //aquí se escribe todas las operaciones que se harían en el succes
        //la variable success es el json que recibe del servidor el método AJAX
        MensajeModal("¡EXITO!","La información se ha actualizado correctamente.");
      });//*/
    }
  </script>

@endsection