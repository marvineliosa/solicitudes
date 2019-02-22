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
  		@if(strcmp($solicitud->ESTATUS_SOLICITUD,'RECIBIDO SPR')!=0 && strcmp($solicitud->ESTATUS_SOLICITUD,'VALIDACIÓN DE INFORMACIÓN')!=0)
        <tr class="">
          <td>{{$solicitud->ID_SOLICITUD}}</td>
          <td>{{$solicitud->NOMBRE_SOLICITUD}}</td>
          <td>{{$solicitud->DEPENDENCIA_SOLICITUD}}</td>
          <td>{{$solicitud->FECHA_TURNADO_CGA}}</td>
          <td>{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}</td>
          <td id="td_estatus_{{$solicitud->ID_ESCAPE}}">{{$solicitud->ESTATUS_SOLICITUD}}</td>
          <td>
              <div class="btn-group">
              	@if(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD,'CONTRATACIÓN')==0)
                	<a class="btn btn-primary" href="#" onclick="AbreModalContratacion('{{$solicitud->ID_SOLICITUD}}')"><i class="icon_info_alt"></i></a>
              	@endif
                @if(strcmp($solicitud->ESTATUS_SOLICITUD,'VALIDACIÓN DE INFORMACIÓN')!=0)
                	@if(strcmp($solicitud->ESTATUS_SOLICITUD,'ANÁLISIS')==0 || strcmp($solicitud->ESTATUS_SOLICITUD,'REVISIÓN')==0)
                		<a class="btn btn-success" href="/solicitud/contratacion/{{$solicitud->ID_ESCAPE}}"><i class="icon_pencil"></i></a>
                	@endif
                	<a class="btn btn-danger" href="#" onclick="modalConfig('{{$solicitud->ID_SOLICITUD}}','{{$solicitud->ESTATUS_SOLICITUD}}')"><i class="icon_adjust-vert"></i></a>
                @endif
              </div>
          </td>
        </tr>
        @endif
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