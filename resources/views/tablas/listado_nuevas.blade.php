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
          <td>{{$solicitud->NOMBRE_INTERNO_DEPENDENCIA}}</td>
          <td>{{$solicitud->FECHA_CREACION}}</td>
          <td>{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}</td>
          <td>
      			<div class="btn-group">
              <a class="btn btn-primary" href="javascript:void(0)" onclick="AbreModalInformacion('{{$solicitud->ID_SOLICITUD}}','{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}')"><i class="icon_info_alt"></i></a>
              @if(in_array(\Session::get('categoria')[0], ['TRABAJADOR_SPR']))
              <a class="btn btn-info" href="javascript:void(0)" onclick="modalComentarios('{{$solicitud->ID_SOLICITUD}}')"><i class="icon_comment"></i></a>
              <a class="btn btn-warning" href="javascript:void(0);" onclick="ObtenerHistorial('{{$solicitud->ID_SOLICITUD}}')" style="background-color: ORANGE;"><i class="icon_archive_alt"></i></a>
              <a class="btn btn-danger" href="javascript:void(0)" onclick="modalConfig('{{$solicitud->ID_SOLICITUD}}')"><i class="icon_adjust-vert"></i></a>
              @endif
      			</div>
          </td>
        </tr>
    @endforeach
  </tbody>
</table>