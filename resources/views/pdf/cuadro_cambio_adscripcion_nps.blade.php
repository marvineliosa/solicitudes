<!DOCTYPE html>
<html>
	<head>
		<title></title>
	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

		<style type="text/css">
			th.fondo{
				background-color: rgb(255, 230, 153);
				color: white;
			}
			.bloque{
				text-align:center;
			}
			.ui-helper-center {
			    text-align: center;
			}
			.tabla-nobs{
				border: 1px solid #ddd;
			}
			.nivelar{
				vertical-align: middle;
			}
		</style>
	</head>
	<body style="height:420px; overflow:auto;">
		<!--{{date_default_timezone_set('America/Mexico_City')}}-->
		<!--{{setlocale(LC_ALL,"es_ES")}}-->
		<div id="div-solicitud" align="right" class="" style="font-size: 13px;">{{$solicitud->ID_SOLICITUD}}</div>
		<div id="div-solicitud" align="right" class="" style="font-size: 13px;">H. Puebla de Z, a {{strftime('%d de %B de %Y')}} </div>
		<div id="div-solicitud" align="left" class="" style="font-size: 13px;">
			<p><b>A quien corresponda:</b></p>
			<p align="justify">Por este medio reciba un cordial saludo, asimismo, en atención a la solicitud de {{(($adscripcion->EMPRESA_NPS)?$adscripcion->EMPRESA_NPS:"FALTA AGREGAR NOMBRE DE EMPRESA NPS")}} , la cual solicita el cambio de adscripción del <b>C.{{$solicitud->NOMBRE_SOLICITUD}},</b> que presta sus servicios en la sede {{$solicitud->NOMBRE_DEPENDENCIA}} a la sede {{$adscripcion->NUEVA_DEPENDENCIA}}, le informo lo siguiente:</p>
		</div>
		<div id="div-tabla_datos" align="right" class="">
			<table style="width:100%;" class="table table-bordered">
			  <tr>
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">CATEGORÍA QUE TENÍA EN LA SEDE {{$solicitud->NOMBRE_DEPENDENCIA}}</th>
			    @if($solicitud->INSTITUCIONAL)
			    	<th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">SALARIO QNAL. BRUTO EN LA SEDE {{$solicitud->NOMBRE_DEPENDENCIA}}</th>
			    @else
			    	<th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">SALARIO QNAL. NETO EN LA SEDE {{$solicitud->NOMBRE_DEPENDENCIA}}</th>
			    @endif
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">PUESTO EN LA SEDE {{$solicitud->NOMBRE_DEPENDENCIA}}</th> 
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">FUNCIONES DESEMPEÑADAS EN LA SEDE {{$solicitud->NOMBRE_DEPENDENCIA}}</th> 
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">MOTIVO DE SOLICITUD DEL CAMBIO</th>
			  </tr>
			  <tr>
			    <td style="font-size: 10px;border:1px solid black;" align="center">{{$solicitud->CATEGORIA_SOLICITUD}}</td>
			    <td style="font-size: 10px;border:1px solid black;" align="center">{{'$'.$solicitud->SALARIO_FORMATO}}</td>
			    <td style="font-size: 10px;border:1px solid black;" align="center">{{$solicitud->PUESTO_SOLICITUD}}</td>
			    <td style="font-size: 8px;border:1px solid black;" align="justify">{{$solicitud->ACTIVIDADES_SOLICITUD}}</td>
			    <td style="font-size: 10px;border:1px solid black;" align="center">{{$solicitud->JUSTIFICACION_SOLICITUD}}</td>
			</table>
		</div>
		<div id="div-tabla_datos2" align="right" class="">
			<table style="width:100%;" class="table table-bordered">
			  <tr>
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">CATEGORÍA PROPUESTA</th>
			    @if($solicitud->INSTITUCIONAL)
			    	<th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">SALARIO QNAL. BRUTO PROPUESTO</th> 
			    @else
			    	<th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">SALARIO QNAL. NETO PROPUESTO</th> 
			    @endif
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">PUESTO EN LA SEDE {{$adscripcion->NUEVA_DEPENDENCIA}}</th> 
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">FUNCIONES A DESEMPEÑAR EN LA SEDE {{$adscripcion->NUEVA_DEPENDENCIA}}</th> 
			  </tr>
			  <tr>
			    <td style="font-size: 10px;border:1px solid black;" align="center">{{$solicitud->CATEGORIA_PROPUESTA}}</td>
			    <td style="font-size: 10px;border:1px solid black;" align="center">{{'$'.$solicitud->SALARIO_PROPUESTO}}</td>
			    <td style="font-size: 10px;border:1px solid black;" align="center">{{$adscripcion->PUESTO_NUEVO}}</td>
			    <td style="font-size: 8px;border:1px solid black;" align="justify">{{$adscripcion->NUEVAS_ACTIVIDADES}}</td>
			</table>
		</div>
		<div id="div-tabla_datos2" align="right" class="">
			<table style="width:100%;" class="table table-bordered">
			  <tr>
			    <td style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153); width: 10%	" align="center"><b>OPINIÓN DE LA CGA:</b></td>
			    <td style="font-size: 8px;border:1px solid black;" align="justify">{{$solicitud->RESPUESTA_CGA}}</td>
			</table>
		<div id="div-solicitud" align="left" class="" style="font-size: 13px;">Sin más por el momento, le reitero mi atenta y distinguida consideración</div>
		</div>
		@if(in_array($solicitud->ESTATUS_SOLICITUD, ['TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR']))
		<div id="div-tabla_sellos" align="right" class="">
			<table style="width:100%" class="table" border="0">
			  <tr>
			  	<td style="width: 33%; font-size: 8px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="center">
			  		<img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(150)->generate($solicitud->FIRMA_CGA)) }} ">
			  	</td>
			  </tr>
			</table>
		</div>
		@endif

	</body>
</html>
<script type="text/javascript">
    var gl_solicitud = <?php echo json_encode($solicitud) ?>;
    console.log(gl_solicitud);
    var gl_adscripcion = <?php echo json_encode($adscripcion) ?>;
    console.log(gl_adscripcion);
</script>

