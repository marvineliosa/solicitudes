@extends('plantillas.menu')
@section('titulo','Reportes')
@section('content')
<div class="col-lg-12">
	<section class="panel">
	  <header class="panel-heading">
	    Seleccione los parámetros de filtrado
	  </header>
      <div class="panel-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label">Fecha inicial</label>
            <div class="col-sm-6">
              <input type="date" class="form-control" placeholder="Fecha Inicial" id="fecha_inicial" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Fecha final</label>
            <div class="col-sm-6">
              <input type="date" class="form-control" placeholder="Fecha Inicial" id="fecha_final" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Estatus</label>
            <div class="col-sm-6">
              <select class="form-control m-bot15" id="SelectEstatus">
                <option value="NADA">SELECCIONAR</option>
                <option value="TODO">TODO</option>
                <option value="VALIDACIÓN DE INFORMACIÓN">VALIDACIÓN DE INFORMACIÓN</option>
                <option value="RECIBIDO">RECIBIDO</option>
                <option value="LEVANTAMIENTO">LEVANTAMIENTO</option>
                <option value="ANÁLISIS">ANÁLISIS</option>
                <option value="REVISIÓN">REVISIÓN</option>
                <option value="FIRMAS">FIRMAS</option>
                <option value="CANCELADO POR TITULAR">CANCELADO POR TITULAR</option>
                <option value="TURNADO A SPR">POR REVISAR (SPR)</option>
                <option value="COMPLETADO POR SPR">POR AUTORIZAR (RECTOR)</option>
                <option value="COMPLETADO POR RECTOR">COMPLETADO POR RECTOR</option>
                <option value="CANCELADO">CANCELADO</option>
                <option value="OTRO">OTRO</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Tipo de solicitud</label>
            <div class="col-sm-6">
              <select class="form-control m-bot15" id="SelectTipoSolicitud">
                <option value="NADA">SELECCIONAR</option>
                <option value="TODO">TODO</option>
                <option value="CONTRATACIÓN">CONTRATACIÓN</option>
                <option value="CONTRATACIÓN POR SUSTITUCIÓN">CONTRATACIÓN POR SUSTITUCIÓN</option>
                <option value="PROMOCION">PROMOCIÓN</option>
                <option value="CAMBIO DE ADSCRIPCIÓN">CAMBIO DE ADSCRIPCIÓN</option>
              </select>
            </div>
          </div>

          <hr>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-2" id="btn_registrar">
              <button type="button" class="btn btn-primary" onclick="GenerarReporte()">Generar Reporte</button>
            </div>
          </div>
        </div>
      </div>
	</section>
</div>

<!-- Modales -->
<div class="modal fade" id="EjemploModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Generar Reporte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
	  
@endsection

@section('script')
	<script type="text/javascript">
    var hoy = <?php echo json_encode($hoy) ?>;
    console.log(hoy);
    $("#fecha_inicial").val(hoy);
    $("#fecha_final").val(hoy);

    function GenerarReporte(){
      var fecha_inicial = $("#fecha_inicial").val();
      var fecha_final = $("#fecha_final").val();
      var estatus = $("#SelectEstatus").val();
      var tipo_solicitud = $("#SelectTipoSolicitud").val();
      console.log(estatus);
      console.log(tipo_solicitud);
      if(estatus=='NADA'){
        MensajeModal('¡ATENCIÓN!','Debe seleccionar un estatus');
      }else if(tipo_solicitud=='NADA'){
        MensajeModal('¡ATENCIÓN!','Debe seleccionar un tipo de solicitud');
      }else{
        var success;
        var url = "/reportes/generar";
        var dataForm = new FormData();
        dataForm.append('fecha_inicial',fecha_inicial);
        dataForm.append('fecha_final',fecha_final);
        dataForm.append('estatus',estatus);
        dataForm.append('tipo_solicitud',tipo_solicitud);
        //lamando al metodo ajax
        metodoAjax(url,dataForm,function(success){
          console.log(success['']);
          var wb = XLSX.utils.book_new();
          wb.Props = {
                  Title: "Reporte de Solicitudes",
                  Subject: "Reporte",
                  Author: "Marvin Eliosa",
                  CreatedDate: new Date()
          };
          wb.SheetNames.push("Reporte");
          //var ws_data = [['hello' , 'world']];  //a row with 2 columns
          var ws_data = success['solicitudes'];  //a row with 2 columns


          var SolicitudesWs = XLSX.utils.json_to_sheet(ws_data) 

          // A workbook is the name given to an Excel file
          var wb = XLSX.utils.book_new() // make Workbook of Excel

          // add Worksheet to Workbook
          // Workbook contains one or more worksheets
          //XLSX.utils.book_append_sheet(wb, animalWS, 'animals') // sheetAName is name of Worksheet
          XLSX.utils.book_append_sheet(wb, SolicitudesWs, 'Solicitudes')   

          // export Excel file
          var nombre_archivo = 'Reporte_de_solicitudes'+hoy+'.xlsx';
          XLSX.writeFile(wb, nombre_archivo)
          

          //aquí se escribe todas las operaciones que se harían en el succes
          //la variable success es el json que recibe del servidor el método AJAX
          //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
        });//*/

      }//*/

    }
    function s2ab(s) { 
      var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
      var view = new Uint8Array(buf);  //create uint8array as viewer
      for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
      return buf;    
    }


    function ejemploAjax(){
        var success;
        var url = "/ruta1/ruta2";
        var dataForm = new FormData();
        dataForm.append('p1',"p1");
        dataForm.append('p2','p2');
        //lamando al metodo ajax
        metodoAjax(url,dataForm,function(success){
          //aquí se escribe todas las operaciones que se harían en el succes
          //la variable success es el json que recibe del servidor el método AJAX
          MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
        });
      }

	</script>
@endsection