<table class="table" id="tabla_datos">
  <thead>
    <tr>
      <th>Folio</th>
      <th>Candidato</th>
      <th>Dependencia</th>
      <th>Fecha de turnado a CGA</th>
      <th>Solicitud</th>
      <!--<th>Estatus</th>-->
      <th>Acciones</th>
      <th>Solicitud</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($solicitudes as $solicitud)
        <tr class="">
          <td>{{$solicitud->ID_SOLICITUD}}</td>
          <td>{{$solicitud->NOMBRE_SOLICITUD}}</td>
          <td>{{$solicitud->NOMBRE_DEPENDENCIA}}</td>
          <td>{{$solicitud->FECHA_TURNADO_CGA}}</td>
          <td>{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}</td>
          <!--<td>{{$solicitud->ESTATUS_SOLICITUD}}</td>-->
          <td>
            <div class="btn-group">
      			<a class="btn btn-primary" href="javascript:void(0)" onclick="AbreModalInformacion('{{$solicitud->ID_SOLICITUD}}','{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}')"><i class="icon_info_alt"></i></a></div>
          	@if(strcmp($solicitud->ESTATUS_SOLICITUD,'VALIDACIÓN DE INFORMACIÓN')==0)
    					<a class="btn btn-warning" href="#" onclick="modalArchivosDependencia('{{$solicitud->ID_SOLICITUD}}')"><i class="icon_link_alt"></i></a>
    				@endif
            @if(strcmp($solicitud->ESTATUS_SOLICITUD,'FIRMAS')==0)
              <a class="btn btn-success" href="javascript:void(0)" onclick="VerDatosCuadro('{{$solicitud->ID_SOLICITUD}}','{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}')" style="background-color: YellowGreen;"><i class="icon_menu-square_alt2"></i></a>
            @endif
              </div>
          </td>
          <td>
            @if(strcmp($solicitud->ESTATUS_SOLICITUD,'FIRMAS')==0)
              @if(!isset( $solicitud->FIRMA_TITULAR))
              <div class="btn-group">
                <a class="btn btn-danger" href="#" onclick="ModalCancelarSolicitud('{{$solicitud->ID_SOLICITUD}}')" id="{{$solicitud->ID_SOLICITUD}}"><i class="icon_close"></i></a></div>
                <a class="btn btn-success" href="#" onclick="ModalAceptarSolicitud('{{$solicitud->ID_SOLICITUD}}')" id="{{$solicitud->ID_SOLICITUD}}"><i class="icon_check"></i></a>
              </div>
              @endif
            @endif
          </td>
        </tr>
    @endforeach
    
    <!--<tr class="success">
      <td>SOL/5/2019</td>
      <td>Ramiro Sánchez Gómez</td>
      <td>FCC</td>
      <td>27/01/2019</td>
      <td>Cambio de Adscripción</td>
      <td>Recibido</td>
      <td>
		<div class="btn-group">
		<a class="btn btn-primary" href="#" data-toggle="modal" data-target="#ModalDetalleTerminado"><i class="icon_info_alt"></i></a>
		<a class="btn btn-success" href="http://localhost:8000/solicitud/contratacion/1"><i class="icon_pencil"></i></a>
		<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#ModalConfiguraciones"><i class="icon_adjust-vert"></i></a>	
		</div>
      </td>
    </tr>-->
  </tbody>
</table>