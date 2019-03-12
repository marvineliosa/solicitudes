@extends('plantillas.menu')
@section('titulo','Nueva Contratación')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Contratación
		  </header>
		  <div class="panel-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia" id="nombre_dependencia" value="" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Candidato*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre del Candidato" id="Contratacion-Candidato">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Solicitada</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" id="Contratacion-CategoriaSolicitada">
            </div>
          </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Puesto Solicitado</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" placeholder="Puesto del Candidato" id="Contratacion-PuestoSolicitado">
                </div>
              </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades*</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñará" id="Contratacion-Actividades" maxlength="830"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario neto solicitado</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario solicitado para el candidato" id="Contratacion-SalarioSolicitado" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nómina</label>
            
            <div class="col-sm-6">
              <input type="text" class="form-control" name="" value="INSTITUCIONAL" id="Contratacion-Nomina" disabled="disabled">
            </div>
            <!--<div class="col-sm-6">
              <select class="form-control m-bot15">
                  <option>Prestación de Servicios</option>
                  <option>Institucional</option>
              </select>
            </div>-->
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Fuente de Recursos*</label>
            <div class="col-sm-6">
              <select class="form-control m-bot15" id="SelectFuenteRecursos">
                  <option value="NADA">SELECCIONAR</option>
                  <option value="ADMINISTRACIÓN CENTRAL">ADMINISTRACIÓN CENTRAL</option>
                  <option value="RECURSOS PROPIOS">RECURSOS PROPIOS</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Justificación*</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Justificación de la solicitud del personal" id="Contratacion-Justificacion"></textarea>
            </div>
          </div>
          <hr>
          <!-- ARCHIVOS -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Organigrama*</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-organigrama">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Plantilla de Personal*
              <!--<br>
              <a href="#">Descargar Formato</a>-->
            </label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="archivo-plantilla">
              <br>
              <a href="/descargas/anexo_plantilla" target="_blank">DESCARGAR ANEXO DE PLANTILLA</a>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Descripción del Puesto a Cubrir*</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-descripcion">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Curriculum Actualizado*</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-curriculum">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Mapa de Ubicación Física</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-mapa_ubicacion">
            </div>
          </div>

          <hr>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-2" id="btn_registrar">
              <button type="button" class="btn btn-primary" onclick="AlmacenarSolicitud()">Registrar</button>
            </div>
            <div class="col-sm-2" hidden="true" id="btn_regresar">
              <button type="button" class="btn btn-primary" onclick="Regresar()">Salir</button>
            </div>
          </div>
        </div>
      </div>
		</section>
	</div>
	  
@endsection

@section('script')
  <script type="text/javascript">
    autollenado();

    function Regresar(){
      location.href='/listado/dependencia';
    }

    id_dependencia = <?php echo json_encode(\Session::get('id_dependencia')[0]) ?>;
    //console.log(id_dependencia);
    function autollenado(){
      $("#Contratacion-Candidato").val('Marvin Eliosa Abaroa');
      $("#Contratacion-CategoriaSolicitada").val('Auxiliar Administrativo');
      $("#Contratacion-PuestoSolicitado").val('Auxiliar de administración');
      $("#Contratacion-Actividades").val('Actividades destinadas para Marvin');
      $("#Contratacion-SalarioSolicitado").val(3200.87);
      $("#Contratacion-Justificacion").val('Es necesario puesto que el departamento tiene sobre carga de trabajo');//*/
      //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
    }
    function AlmacenarSolicitud(){
      var candidato = $("#Contratacion-Candidato").val();
      var categoria = $("#Contratacion-CategoriaSolicitada").val();
      var puesto = $("#Contratacion-PuestoSolicitado").val();
      var actividades = $("#Contratacion-Actividades").val();
      var nomina = $("#Contratacion-Nomina").val();
      var salario = $("#Contratacion-SalarioSolicitado").val();
      var justificacion = $("#Contratacion-Justificacion").val();
      var fuente_recursos = $("#SelectFuenteRecursos").val();

      var archivo_organigrama = document.getElementById('archivo-organigrama');
      var archivo_plantilla = document.getElementById('archivo-plantilla');
      var archivo_descripcion = document.getElementById('archivo-descripcion');
      var archivo_curriculum = document.getElementById('archivo-curriculum');
      var archivo_mapa_ubicacion = document.getElementById('archivo-mapa_ubicacion');
      if(candidato==''){
        MensajeModal("¡ATENCIÓN!",'El nombre del candidato es un campo obligatorio');
      }else if(actividades==''){
        MensajeModal("¡ATENCIÓN!",'Las actividades son un campo obligatorio');
      }else if(actividades==''){
        MensajeModal("¡ATENCIÓN!",'Las actividades son un campo obligatorio');
      }else if(salario==''){
        MensajeModal("¡ATENCIÓN!",'Debe proponer un salario para el candidato');
      }else if(justificacion==''){
        MensajeModal("¡ATENCIÓN!",'La justificación es un campo obligatorio');
      }else if(fuente_recursos=='NADA'){
        MensajeModal("¡ATENCIÓN!",'La fuente de recursos es un campo obligatorio');
      }else if(archivo_organigrama.value==""){
        console.log('falta organigrama');
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar el organigrama de la dependencia');
      }else if(archivo_plantilla.value==''){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar la plantilla de personal de la dependencia');
      }else if(archivo_descripcion.value==''){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar la descripción del puesto a desempeñar');
      }else if(archivo_curriculum.value==''){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar el curriculum del candidato');
      }else{
        console.log('Enviando');
        var success;
        var url = "/contratacion/insertar";
        var dataForm = new FormData();
        dataForm.append('candidato',candidato);
        dataForm.append('categoria',categoria);
        dataForm.append('puesto',puesto);
        dataForm.append('actividades',actividades);
        dataForm.append('nomina',nomina);
        dataForm.append('salario',salario);
        dataForm.append('justificacion',justificacion);
        dataForm.append('fuente_recursos',fuente_recursos);

        dataForm.append('archivo_organigrama',archivo_organigrama.files[0]);
        dataForm.append('archivo_plantilla',archivo_plantilla.files[0]);
        dataForm.append('archivo_descripcion',archivo_descripcion.files[0]);
        dataForm.append('archivo_curriculum',archivo_curriculum.files[0]);

        if(archivo_mapa_ubicacion.value !=''){
          dataForm.append('archivo_mapa_ubicacion',archivo_mapa_ubicacion.files[0]);
        }else{
          dataForm.append('archivo_mapa_ubicacion',null);
        }
        //lamando al metodo ajax
        metodoAjax(url,dataForm,function(success){
          //aquí se escribe todas las operaciones que se harían en el succes
          //la variable success es el json que recibe del servidor el método AJAX
          var mensaje = "El número de solicitud asignado es: "+success['solicitud'];
          $("#btn_registrar").remove();
          $("#btn_regresar").show();
          MensajeModal("¡Solicitud almacenada!",mensaje);
        });//*/
      }

      
    }


    ObtenerNombreDependencia();
    function ObtenerNombreDependencia(){
      var success;
      var url = "/dependencias/obtener_nombre";
      var dataForm = new FormData();
      dataForm.append('id_dependencia',id_dependencia);
      //lamando al metodo ajax
      metodoAjax(url,dataForm,function(success){
        //aquí se escribe todas las operaciones que se harían en el succes
        //la variable success es el json que recibe del servidor el método AJAX
        //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
        //console.log(success['dependencia']);
        $("#nombre_dependencia").val(success['dependencia']['NOMBRE_DEPENDENCIA']);
      });
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