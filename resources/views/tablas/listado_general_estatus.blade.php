<table class="table" id="tabla_datos">
  <thead>
    <tr>
      <th>Folio</th>
      <th>Candidato</th>
      <th>Dependencia</th>
      <th>Fecha de turnado a CGA</th>
      <th>Solicitud</th>
      <th>Estatus</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($solicitudes as $solicitud)
      <tr class="{{ $solicitud->CLASE_TR}}">
        <td>{{$solicitud->ID_SOLICITUD}}</td>
        <td>{{$solicitud->NOMBRE_SOLICITUD}}</td>
        <td>{{$solicitud->NOMBRE_DEPENDENCIA}}</td>
        <td>{{$solicitud->FECHA_TURNADO_CGA}}</td>
        <td>{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}</td>
        <td id="td_estatus_{{$solicitud->ID_ESCAPE}}">{{$solicitud->ESTATUS_SOLICITUD}}</td>
        <td>
            <div class="btn-group">
              	<a class="btn btn-primary" href="javascript:void(0)" onclick="AbreModalInformacion('{{$solicitud->ID_SOLICITUD}}','{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}')"><i class="icon_info_alt"></i></a></div>
                <a class="btn btn-info" href="javascript:void(0);" onclick="AbreModalFechas('{{$solicitud->ID_SOLICITUD}}')" style="background-color: DeepSkyBlue;"><i class="icon_calendar"></i></a>
                <a class="btn btn-warning" href="javascript:void(0)" onclick="modalArchivosGeneral('{{$solicitud->ID_SOLICITUD}}')"><i class="icon_link_alt"></i></a>
                <a class="btn btn-info" href="javascript:void(0)" onclick="modalComentarios('{{$solicitud->ID_SOLICITUD}}')"><i class="icon_comment"></i></a>  
            	@if(strcmp($solicitud->ESTATUS_SOLICITUD,'ANÁLISIS')==0 || strcmp($solicitud->ESTATUS_SOLICITUD,'REVISIÓN')==0)
                @if(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD,'CONTRATACIÓN')==0)
            		  <a class="btn btn-success" href="/solicitud/contratacion/{{$solicitud->ID_ESCAPE}}"><i class="icon_pencil"></i></a>
                @elseif(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD,'CONTRATACIÓN POR SUSTITUCIÓN')==0)
                  <a class="btn btn-success" href="/solicitud/contratacion_sustitucion/{{$solicitud->ID_ESCAPE}}"><i class="icon_pencil"></i></a>
                @elseif(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD,'PROMOCION')==0)
                  <a class="btn btn-success" href="/solicitud/promocion/{{$solicitud->ID_ESCAPE}}"><i class="icon_pencil"></i></a>
                @elseif(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD,'CAMBIO DE ADSCRIPCIÓN')==0)
                  <a class="btn btn-success" href="/solicitud/cambio_adscripcion/{{$solicitud->ID_ESCAPE}}"><i class="icon_pencil"></i></a>
                @endif
            	@endif
            	<a class="btn btn-danger" href="javascript:void(0)" onclick="modalConfig('{{$solicitud->ID_SOLICITUD}}','{{$solicitud->ESTATUS_SOLICITUD}}')"><i class="icon_adjust-vert"></i></a>
            </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>