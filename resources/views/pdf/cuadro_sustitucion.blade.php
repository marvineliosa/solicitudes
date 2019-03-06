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
	<div id="div-dependencia" align="center" class=""><h5>{{$solicitud->NOMBRE_DEPENDENCIA}}</h5></div>
	@if(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD,'CONTRATACIÓN')==0||strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD,'CONTRATACIÓN POR SUSTITUCIÓN')==0)
		<div id="div-subtitulo" align="center" class="" style="font-size: 10px">{{$solicitud->TIPO_SOLICITUD_SOLICITUD}} EN NÓMINA {{$solicitud->NOMINA_SOLICITUD}}</div>
	@else
		<div id="div-subtitulo" align="center" class="">{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}</div>
	@endif
	<div id="div-fecha" align="right" class="" style="font-size: 13px;">FECHA: {{$solicitud->HOY}}</div>
	<div id="div-solicitud" align="right" class="" style="font-size: 13px;">SOLICITUD: {{$solicitud->ID_SOLICITUD}}</div>
	<div id="div-tabla_datos" align="right" class="">
		<table style="width:100%;" class="table table-bordered">
		  <tr>
		    <th style="font-size: 10px;border:1px solid black;" class="bloque">NOMBRE</th>
		    <th style="width: 100%; font-size: 10px;border:1px solid black;" class="bloque">FUNCIONES</th> 
		    <th style="font-size: 10px;border:1px solid black;" class="bloque">CATEGORÍA / PUESTO SOLICITADO</th>
		    <th style="font-size: 10px;border:1px solid black;" class="bloque">SALARIO NETO SOLICITADO</th>
		    <th style="font-size: 10px;border:1px solid black;" class="bloque">DIFERENCIA QUINCENAL</th>
		    <th style="font-size: 10px;border:1px solid black;" class="bloque">% DIFERENCIA</th>
		    <th style="width: 70%; font-size: 8px;border:1px solid black;" class="bloque">SALARIO NETO QUINCENALDE QUIEN SE SUSTITUYE</th>
		    <th style="font-size: 10px;border:1px solid black;" class="bloque">EN SUSTITUCIÓN DE</th>
		  </tr>
		  <tr>
		    <td style="font-size: 10px;border:1px solid black;" align="center">{{$sustitucion->NUEVO_CANDIDATO}}</td>
		    <td style="font-size: 8px;border:1px solid black;" align="justify">{{$sustitucion->NUEVAS_ACTIVIDADES}}</td>
		    <td style="font-size: 10px;border:1px solid black;" align="center">{{$sustitucion->NUEVA_CATEGORIA}}</td>
		    <td style="font-size: 10px;border:1px solid black;" align="center">{{'$ '.number_format($sustitucion->NUEVO_SALARIO,2)}}</td>
		    <td style="font-size: 10px;border:1px solid black;" align="center">{{number_format(($sustitucion->NUEVO_SALARIO - $solicitud->SALARIO_SOLICITUD),2)}}</td>
		    <td style="font-size: 10px;border:1px solid black;" align="center">{{round((($sustitucion->NUEVO_SALARIO - $solicitud->SALARIO_SOLICITUD)/$sustitucion->NUEVO_SALARIO)*100,2).'%'}}</td>
		    <td style="font-size: 10px;border:1px solid black;" align="center">{{'$ '.$solicitud->SALARIO_FORMATO}}</td>
		    <td style="font-size: 10px;border:1px solid black;" align="center">{{$solicitud->NOMBRE_SOLICITUD}}</td>
		  </tr>
		</table>
	</div>

	<div id="div-tabla_cantidades" align="right" class="">
		<table style="width:100%" class="table" align="center">
		  <tr>
		    <th style="font-size: 8px;border:1px solid black; visibility: hidden" class="bloque"></th>
		    <th style="font-size: 8px;border:1px solid black;" class="bloque">CATEGORÍAS INMEDIATAS</th> 
		    <th style="font-size: 8px;border:1px solid black;" class="bloque">SALARIO NETO QUINCENAL</th>
		    <th style="font-size: 8px;border:1px solid black;" class="bloque">DIFERENCIA QUINCENAL</th>
		    <th style="font-size: 8px;border:1px solid black;" class="bloque">% DE DIFERENCIA</th>
		    @if($solicitud->COMPENSACION_SOLICITUD)
		    <th style="font-size: 8px;border:1px solid black;" class="bloque">COMPENSACIÓN SALARIAL QUINCENAL</th>
		    <th style="font-size: 8px;border:1px solid black;" class="bloque">COMPENSACIÓN MÁS SALARIO QUINCENAL</th>
		    @endif
		  </tr>
		  <tr>
		    <td style="font-size: 8px;border:1px solid black;" align="center">PROPUESTA DE LA COORDINACIÓN GENERAL ADMINISTRATIVA</td>
		    <td style="font-size: 8px;border:1px solid black; background-color: rgb(255, 230, 153);" align="center">{{$solicitud->CATEGORIA_PROPUESTA}}</td>
		    <td style="font-size: 8px;border:1px solid black; background-color: rgb(255, 230, 153);" align="center">{{'$ '.$solicitud->SALARIO_PROPUESTO}}</td>
		    <td style="font-size: 8px;border:1px solid black; background-color: rgb(255, 230, 153);" align="center"><!--{{$dif_quincenal = (double)((($solicitud->SALARIO_PROPUESTO_SF)?$solicitud->SALARIO_PROPUESTO_SF:0) - (($solicitud->SALARIO_SOLICITUD)?$solicitud->SALARIO_SOLICITUD:0))}} -->{{number_format($dif_quincenal,2)}}</td>
		    <td style="font-size: 8px;border:1px solid black; background-color: rgb(255, 230, 153);" align="center">{{(($solicitud->SALARIO_SOLICITUD!=0)?(round((($dif_quincenal/$solicitud->SALARIO_SOLICITUD)*100),1)).'%':'')}}</td>
		    @if($solicitud->COMPENSACION_SOLICITUD)
		    <td style="font-size: 8px;border:1px solid black; background-color: rgb(255, 230, 153);" align="center">{{'$ '.number_format($solicitud->COMPENSACION_SOLICITUD,2)}}</td>
		    <td style="font-size: 8px;border:1px solid black; background-color: rgb(255, 230, 153);" align="center">{{'$ '.number_format(($solicitud->COMPENSACION_SOLICITUD + $solicitud->SALARIO_PROPUESTO_SF),2)}}</td>
		    @endif
		  </tr>
		  <tr><!-- fuente de recursos -->
		  	@if($solicitud->COMPENSACION_SOLICITUD)
		    <td style="font-size: 10px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="right" colspan="4">Fuente de Recursos:</td>
		    <td style="font-size: 10px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="left" colspan="3">{{$solicitud->FUENTE_RECURSOS_SOLICITUD}}</td>
		    @else
		    <td style="font-size: 10px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="right" colspan="3">Fuente de Recursos:</td>
		    <td style="font-size: 10px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="left" colspan="2">{{$solicitud->FUENTE_RECURSOS_SOLICITUD}}</td>
		    @endif
		  </tr>
		</table>
	</div>
	<div id="div-tabla_respuesta" align="right" class="">
		<table style="width:100%" class="" border="0">
		  <tr>
		    <th style="font-size: 10px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" class="">NOTA:</th>
		  </tr>
		  <tr>
		    <td style="font-size: 10px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="justify">{{$solicitud->RESPUESTA_CGA}}</td>
		  </tr>
		</table>
	</div>
	<br>
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
    //console.log(gl_solicitud);
    var gl_sustitucion = <?php echo json_encode($sustitucion) ?>;
    console.log(gl_sustitucion);
</script>