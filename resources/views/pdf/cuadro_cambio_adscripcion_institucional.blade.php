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
		<div id="div-solicitud" align="left" class="" style="font-size: 13px;">{{$solicitud->ID_SOLICITUD}}</div>
		<br>
		<div id="div-solicitud" align="left" class="" style="font-size: 13px;"><b>Dr. José Alfonso Esparza Ortiz</b></div>
		<div id="div-solicitud" align="left" class="" style="font-size: 13px;"><b>Rector de la</b></div>
		<div id="div-solicitud" align="left" class="" style="font-size: 13px;"><b>Benemérita Universidad Autónoma de Puebla</b></div>
		<div id="div-solicitud" align="left" class="" style="font-size: 13px;"><b>P R E S E N T E</b></div>
		<br>
		<div id="div-solicitud" align="left" class="" style="font-size: 13px;">
			<p align="justify">Por este medio reciba un cordial saludo, asimismo, derivado del levantamiento de información en el que se recomendó el cambio de adscripción del <b>C.{{$solicitud->NOMBRE_SOLICITUD}},</b> de {{$solicitud->NOMBRE_DEPENDENCIA}}, le informo lo sigueinte:</p>
		</div>
		<div id="div-tabla_datos" align="right" class="">
			<table style="width:100%;" class="table table-bordered">
			  <tr>
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">CATEGORÍA QUE TENÍA EN LA SEDE {{$solicitud->NOMBRE_DEPENDENCIA}}</th>
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">SALARIO QNAL. NETO EN LA SEDE {{$solicitud->NOMBRE_DEPENDENCIA}}</th> 
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
		<div style="page-break-after:always;"></div>
		@if(true)
		<div id="div-tabla_datos2" align="right" class="">
			<table style="width:100%;" class="table table-bordered">
			  <tr>
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">CATEGORÍA PROPUESTA</th>
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">SALARIO QNAL. NETO PROPUESTO</th> 
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">PUESTO EN LA SEDE {{$adscripcion->NUEVA_DEPENDENCIA}}</th> 
			    <th style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153);" class="bloque">FUNCIONES DESEMPEÑADAS EN LA SEDE {{$adscripcion->NUEVA_DEPENDENCIA}}</th> 
			  </tr>
			  <tr>
			    <td style="font-size: 10px;border:1px solid black;" align="center">{{$solicitud->CATEGORIA_PROPUESTA}}</td>
			    <td style="font-size: 10px;border:1px solid black;" align="center">{{'$'.$solicitud->SALARIO_PROPUESTO}}</td>
			    <td style="font-size: 10px;border:1px solid black;" align="center">{{$adscripcion->PUESTO_NUEVO}}</td>
			    <td style="font-size: 8px;border:1px solid black;" align="justify">{{$adscripcion->NUEVAS_ACTIVIDADES}}</td>
			</table>
		</div>
		@endif
		<div id="div-tabla_datos2" align="right" class="">
			<table style="width:100%;" class="table table-bordered">
			  <tr>
			    <td style="font-size: 10px;border:1px solid black; background-color: rgb(255, 230, 153); width: 10%	" align="center"><b>OPINIÓN DE LA CGA:</b></td>
			    <td style="font-size: 8px;border:1px solid black;" align="justify">{{$solicitud->RESPUESTA_CGA}}</td>
			</table>
		<div id="div-solicitud" align="left" class="" style="font-size: 13px;"><i>Sin más por el momento, le reitero mi atenta y distinguida consideración</i></div>
		<br>
		<br>
		<br>
		<div id="div-solicitud" align="left" class="" style="font-size: 13px;"><b>
			Atentamente<br>
			"Pensar bien, para Vivir Mejor"<br>
			H. Puebla de Z., {{strftime('%d de %B de %Y')}}<br>
			<br>
			<br>
			CP. Rosendo Demetrio Martínez Granados<br>
			Coordinador General Administrativo<br>
		</b></div>
		@if(in_array($solicitud->ESTATUS_SOLICITUD, ['TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR']))
		<div id="div-tabla_sellos" align="right" class="">
			<table style="width:100%" class="table" border="0">
			  <tr>
			  	<td style="width: 33%; font-size: 8px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="center">
			  		<img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate($solicitud->FIRMA_CGA)) }} ">
			  	</td>
			    <td style="width: 33%; font-size: 8px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="center">
			  		<img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate($solicitud->FIRMA_TITULAR)) }} ">
			    </td>
			    <td style="width: 33%; font-size: 8px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="center">
			  		<img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate($solicitud->FIRMA_SPR)) }} ">
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

