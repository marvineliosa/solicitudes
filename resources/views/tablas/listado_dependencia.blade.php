<table class="table" id="tabla_datos">
  <thead>
    <tr>
      <th>Folio</th>
      <th>Candidato</th>
      <th>Dependencia</th>
      <th>Fecha de creación</th>
      <th>Solicitud</th>
      <!--<th>Estatus</th>-->
      <th>Acciones</th>
      <th>Opinión de CGA</th>
    </tr>
  </thead>
  <tbody>
    <!-- {{$i=1}} -->
  	@foreach($solicitudes as $solicitud)
        <tr class="">
          <td>{{$solicitud->ID_SOLICITUD}}</td>
          <td>{{$solicitud->NOMBRE_SOLICITUD}}</td>
          <td>{{$solicitud->NOMBRE_DEPENDENCIA}}</td>
          <td>{{$solicitud->FECHA_CREACION}}</td>
          <td>{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}</td>
          <!--<td>{{$solicitud->ESTATUS_SOLICITUD}}</td>-->
          <td>
            <div class="btn-group">
      			<a class="btn btn-primary" href="javascript:void(0)" onclick="AbreModalInformacion('{{$solicitud->ID_SOLICITUD}}','{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}')" data-toggle="tooltip" data-placement="top" title="Ver información de la solicitud"><i class="icon_info_alt"></i></a></div>
          	@if(strcmp($solicitud->ESTATUS_SOLICITUD,'VALIDACIÓN DE INFORMACIÓN')==0)
    					<!--<a class="btn btn-warning" href="javascript:void(0)" onclick="modalArchivosDependencia('{{$solicitud->ID_SOLICITUD}}')"><i class="icon_link_alt"></i></a>-->
    				@endif
            @if(strcmp($solicitud->ESTATUS_SOLICITUD,'FIRMAS')==0 || strcmp($solicitud->ESTATUS_SOLICITUD,'CANCELADO POR TITULAR')==0)
              <a class="btn btn-success" href="javascript:void(0)" onclick="VerDatosCuadro('{{$solicitud->ID_SOLICITUD}}','{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}')" style="background-color: YellowGreen;" data-toggle="tooltip" data-placement="top" title="Ver opinión de la Coordinación General Administrativa"><i class="icon_menu-square_alt2"></i></a>
            @else
              @if(strcmp($solicitud->ESTATUS_SOLICITUD,'CANCELADO')!=0)
              <a class="btn btn-warning" href="javascript:void(0)" onclick="ModalCancelacionNormal('{{$solicitud->ID_SOLICITUD}}','{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}')" data-toggle="tooltip" data-placement="top" title="Cancelar solicitud" style="background-color: rgb(255, 103, 13)"><i class="icon_close"></i></a>
              @endif
            @endif
          </td>
          <td>
            @if(strcmp($solicitud->ESTATUS_SOLICITUD,'FIRMAS')==0)
              @if(!isset( $solicitud->FIRMA_TITULAR))
              <div class="btn-group">
                <a class="btn btn-danger" href="javascript:void(0)" onclick="ModalCancelarSolicitud('{{$solicitud->ID_SOLICITUD}}')" id="{{$solicitud->ID_SOLICITUD}}" data-toggle="tooltip" data-placement="top" title="Cancelar solicitud y solicitar cita"><i class="icon_close"></i></a></div>
                <a class="btn btn-success" href="javascript:void(0)" onclick="ModalAceptarSolicitud('{{$solicitud->ID_SOLICITUD}}')" id="{{$solicitud->ID_SOLICITUD}}" data-toggle="tooltip" data-placement="top" title="Aceptar opinión de la Coordinación General Administrativa"><i class="icon_check"></i></a>
              </div>
              @else
                SOLICITUD FIRMADA
              @endif
            @endif
            @if(strcmp($solicitud->ESTATUS_SOLICITUD,'CANCELADO POR TITULAR')==0)
              CANCELADO POR TITULAR
            @endif
            @if(strcmp($solicitud->ESTATUS_SOLICITUD,'CANCELADO')==0)
              CANCELADO
            @endif
            @if(in_array($solicitud->ESTATUS_SOLICITUD,['INFORMACIÓN CORRECTA','RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN']))
              EN PROCESO
            @endif
          </td>
        </tr>
      <!-- {{$i++}} -->
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