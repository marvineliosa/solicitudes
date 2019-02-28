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
<body style="size: landscape">
	<div id="div-dependencia" align="center" class=""><h3>{{$solicitud->NOMBRE_DEPENDENCIA}}</h3></div>
	@if(strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD,'CONTRATACIÓN')==0||strcmp($solicitud->TIPO_SOLICITUD_SOLICITUD,'CONTRATACIÓN POR SUSTITUCIÓN')==0)
		<div id="div-subtitulo" align="center" class="">{{$solicitud->TIPO_SOLICITUD_SOLICITUD}} EN NÓMINA {{$solicitud->NOMINA_SOLICITUD}}</div>
	@else
		<div id="div-subtitulo" align="center" class="">{{$solicitud->TIPO_SOLICITUD_SOLICITUD}}</div>
	@endif
	<div id="div-fecha" align="right" class="">FECHA: {{$solicitud->HOY}}</div>
	<div id="div-solicitud" align="right" class="">SOLICITUD: {{$solicitud->ID_SOLICITUD}}</div>
	<div id="div-tabla_datos" align="right" class="">
		<table style="width:100%;" class="table table-bordered">
		  <tr>
		    <th style="font-size: 13px;border:1px solid black;" class="bloque">NOMBRE</th>
		    <th style="font-size: 13px;border:1px solid black;" class="bloque">FUNCIONES</th> 
		    <th style="font-size: 13px;border:1px solid black;" class="bloque">CATEGORÍA/PUESTO SOLICITADO</th>
		    <th style="font-size: 13px;border:1px solid black;" class="bloque">SALARIO NETO SOLICITADO</th>
		    <th style="font-size: 13px;border:1px solid black;" class="bloque">DIFERENCIA QUINCENAL</th>
		    <th style="font-size: 13px;border:1px solid black;" class="bloque">% DIFERENCIA</th>
		  </tr>
		  <tr>
		    <td style="font-size: 10px;border:1px solid black;" align="center">{{$solicitud->NOMBRE_SOLICITUD}}</td>
		    <td style="font-size: 8px;border:1px solid black;" align="justify">{{$solicitud->ACTIVIDADES_SOLICITUD}}</td>
		    <td style="font-size: 10px;border:1px solid black;" align="center">{{$solicitud->PUESTO_SOLICITUD}}</td>
		    <td style="font-size: 10px;border:1px solid black;" align="center">{{$solicitud->SALARIO_FORMATO}}</td>
		    <td style="font-size: 10px;border:1px solid black;" align="center"></td>
		    <td style="font-size: 10px;border:1px solid black;" align="center"></td>
		  </tr>
		</table>
	</div>
	<div id="div-tabla_cantidades" align="right" class="">
		<table style="width:75%" class="table table-bordered" align="center">
		  <tr>
		    <th style="font-size: 8px;border:1px solid black; visibility: hidden" class="bloque"></th>
		    <th style="font-size: 8px;border:1px solid black;" class="bloque">CATEGORÍAS INMEDIATAS</th> 
		    <th style="font-size: 8px;border:1px solid black;" class="bloque">SALARIO NETO QUINCENAL</th>
		    <th style="font-size: 8px;border:1px solid black;" class="bloque">DIFERENCIA QUINCENAL</th>
		    <th style="font-size: 8px;border:1px solid black;" class="bloque">% DE DIFERENCIA</th>
		  </tr>
		  <tr>
		    <td style="font-size: 8px;border:1px solid black;" align="center">PROPUESTA DE LA COORDINACIÓN GENERAL ADMINISTRATIVA</td>
		    <td style="font-size: 8px;border:1px solid black; background-color: rgb(255, 230, 153);" align="center">{{$solicitud->PUESTO_PROPUESTO}}</td>
		    <td style="font-size: 8px;border:1px solid black; background-color: rgb(255, 230, 153);" align="center">{{$solicitud->SALARIO_PROPUESTO}}</td>
		    <td style="font-size: 8px;border:1px solid black; background-color: rgb(255, 230, 153);" align="center"></td>
		    <td style="font-size: 8px;border:1px solid black; background-color: rgb(255, 230, 153);" align="center"></td>
		  </tr>
		</table>
	</div>
	<div id="div-tabla_respuesta" align="right" class="">
		<table style="width:100%" class="table table" border="0">
		  <tr>
		    <th style="font-size: 10px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" class="">NOTA:</th>
		  </tr>
		  <tr>
		    <td style="font-size: 10px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="justify">{{$solicitud->RESPUESTA_CGA}}</td>
		  </tr>
		</table>
	</div>
	
		<div id="div-tabla_sellos" align="right" class="">
			<table style="width:100%" class="table table" border="0">
			  <tr>
			  	<td style="width: 33%; font-size: 8px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="center">
			  		<img src="img/qr_titular.png" width="100" height="100">
			  	</td>
			    <td style="width: 33%; font-size: 8px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="center">
			    	<img src="img/qr_coordinador.png" width="100" height="100">
			    </td>
			    <td style="width: 33%; font-size: 8px;border-top: 0px;border-right: 0px;border-bottom: 0px solid black;border-left: 0px;" align="center">
			    	<img src="img/qr_spr.png" width="100" height="100">
			    </td>
			  </tr>
			</table>
		</div>
	

	<div id='mydiv1'></div>

</body>
</html>
<script type="text/javascript">
    document.getElementById('mydiv1').innerHTML = 'this is a test';
</script>
<script type="text/javascript">
    var gl_solicitud = <?php echo json_encode($solicitud) ?>;
    console.log(gl_solicitud);
    //sellos();
    function formatoMoneda(numero) {
    	numero = '3258.56';
	    if(numero>999999){
			  conPunto = numero.substring(0, numero.length-9);
			  conPunto2 = numero.substring(numero.length-9, numero.length-6);
			  conPunto3 = numero.substring(numero.length-6, numero.length);
			  numero = conPunto + ',' + conPunto2 + ',' + conPunto3;
			}else{
				if(numero>999){
				  conPunto = numero.substring(0, numero.length-6);
				  conPunto2 = numero.substring(numero.length-6, numero.length);
				  numero = conPunto + ',' + conPunto2;
				}			 	
			}
			return numero;
	}
	function sellos(){
		var sello1 = document.getElementById('sello_titular');
		sello1.innerHTML='EPALE';
	}



</script>