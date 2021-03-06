@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Cambio de Adscripción
		  </header>
		  <div class="panel-body">
        <form class="form-horizontal " method="get">

          @if(in_array(\Session::get('categoria')[0],['TRABAJADOR_SPR']))
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia*</label>
              <div class="col-sm-6">
                <!--<input type="text" class="form-control" placeholder="Dependencia destino" id="CambioAdscripcion-DependenciaDestino">-->
                <select class="form-control m-bot15" id="select-dependencia_spr">
                    <option value="SELECCIONAR">--SELECCIONAR DEPENDENCIA--</option>
                    @foreach($dependencias as $dependencia)
                      <option value="{{$dependencia->ID_DEPENDENCIA}}">{{$dependencia->NOMBRE_DEPENDENCIA}}</option>
                    @endforeach
                </select>
              </div>
            </div>
          @else
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia" id="nombre_dependencia" value="" disabled>
            </div>
          </div>
          @endif
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia destino*</label>
            <div class="col-sm-6">
              <!--<input type="text" class="form-control" placeholder="Dependencia destino" id="CambioAdscripcion-DependenciaDestino">-->
              <select class="form-control m-bot15" id="select-dependencia_destino"">
                  <option value="SELECCIONAR">--SELECCIONAR DEPENDENCIA--</option>
                  @foreach($dependencias as $dependencia)
                    <option value="{{$dependencia->ID_DEPENDENCIA}}">{{$dependencia->NOMBRE_DEPENDENCIA}}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Candidato (Tal como aparece en INE)*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre de la persona que hace el cambio de adscripción" id="CambioAdscripcion-NombreCandidato">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría actual*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" id="CambioAdscripcion-CategoriaActual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto actual*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" id="CambioAdscripcion-PuestoActual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades actuales*</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeña" id="CambioAdscripcion-ActividadesActuales" maxlength="830"></textarea>
            </div>
          </div>
          <div class="form-group">
            @if($institucional)
              <label class="col-sm-2 control-label">Salario bruto quincenal actual*</label>
            @else
              <label class="col-sm-2 control-label">Salario neto quincenal actual*</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario actual del candidato" id="CambioAdscripcion-SalarioActual" step=".01">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Nueva categoría*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" id="CambioAdscripcion-CategoriaNueva">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nuevo puesto*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" id="CambioAdscripcion-PuestoNuevo">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nuevas actividades*</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeña" id="CambioAdscripcion-ActividadesNuevas" maxlength="830"></textarea>
            </div>
          </div>
          <div class="form-group">
            @if($institucional)
              <label class="col-sm-2 control-label">Salario bruto quincenal solicitado*</label>
            @else
              <label class="col-sm-2 control-label">Salario neto quincenal solicitado*</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario solicitado" id="CambioAdscripcion-SalarioSolicitado" step=".01">
            </div>
          </div>
          @if(!$institucional)
          <div class="form-group">
            <label class="col-sm-2 control-label">Empresa de prestación de servicios*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Escriba aquí el nombre de la empresa de prestación de servicios" id="CambioAdscripcion-Empresa_nps">
            </div>
          </div>
          @endif
          <div class="form-group">
            <label class="col-sm-2 control-label">Justificación*</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Justificación de la solicitud del cambio de adscripción" id="CambioAdscripcion-Justificacion"></textarea>
            </div>
          </div>
          <!-- ARCHIVOS -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Organigrama*</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-organigrama" onchange="VerificarTamanio(this)">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Plantilla de Personal*
              <!--<br>
              <a href="#">Descargar Formato</a>-->
            </label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="archivo-plantilla" onchange="VerificarTamanio(this)">
              <br>
              <a href="/descargas/anexo_plantilla" target="_blank">DESCARGAR ANEXO DE PLANTILLA</a>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Descripción de Puesto Actual*</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-descripcion" onchange="VerificarTamanio(this)">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Descripción de Puesto que Desempeñará*</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-descripcion-desempeñara" onchange="VerificarTamanio(this)">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Curriculum Actualizado del Candidato (Debe tener el comprobante del último grado de estudios)*</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-curriculum" onchange="VerificarTamanio(this)">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Mapa de Ubicación Física de la Dependencia Destino</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-mapa_ubicacion" onchange="VerificarTamanio(this)">
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
        </form>
      </div>
		</section>
	</div>
	  
@endsection

@section('script')
  <script type="text/javascript">
    id_dependencia = <?php echo json_encode(\Session::get('id_dependencia')[0]) ?>;
    institucional = <?php echo json_encode($institucional) ?>;
    //console.log(institucional);
    tipo_usuario = <?php echo json_encode(\Session::get('categoria')[0]) ?>;
    //console.log(tipo_usuario);
    autollenado();

      MensajeModal('¡ATENCIÓN!','Buen día, con el fin de unificar la presentación de la información, se agradecerá que la captura se realice utilizando mayúsculas y minúsculas.');

    function listado(){
      location.href="/listado/completo";
    }

    function VerificarTamanio(archivo){
      arch = archivo.value;
      if(archivo.value!=''){
        var size = archivo.files[0].size
        //console.log(archivo.files[0].size);
        if(size>2097152){
          MensajeModal('¡ATENCIÓN!','El tamaño del archivo no debe exceder los 2MB');
          archivo.value = '';
        }
      }
    }

    function autollenado(){
      $("#CambioAdscripcion-NombreCandidato").val('Marvin Eliosa Abaroa');
      $("#CambioAdscripcion-CategoriaActual").val('Auxiliar Administrativo');
      $("#CambioAdscripcion-PuestoActual").val('Auxiliar de administración');
      $("#CambioAdscripcion-ActividadesActuales").val('Actividades destinadas para Marvin');
      $("#CambioAdscripcion-SalarioActual").val(3200.87);
      $("#CambioAdscripcion-Justificacion").val('Es necesario puesto que el departamento tiene sobre carga de trabajo');//*/
      //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");

      $("#CambioAdscripcion-DependenciaDestino").val('DASU');
      $("#CambioAdscripcion-CategoriaNueva").val('Nueva Categoria');
      $("#CambioAdscripcion-PuestoNuevo").val('Nuevo Puesto');
      $("#CambioAdscripcion-SalarioSolicitado").val(3020.67);
      $("#CambioAdscripcion-ActividadesNuevas").val('Nuevas Actividades a desempeñar en la otra dependencia');
    }

    function AlmacenarSolicitud(){
      var dependencia_spr = $("#select-dependencia_spr").val();
      var NombreCandidato = $("#CambioAdscripcion-NombreCandidato").val();
      var CategoriaActual = $("#CambioAdscripcion-CategoriaActual").val();
      var PuestoActual = $("#CambioAdscripcion-PuestoActual").val();
      var ActividadesActuales = $("#CambioAdscripcion-ActividadesActuales").val();
      var Nomina = 'NA';
      var SalarioActual = $("#CambioAdscripcion-SalarioActual").val();
      var Justificacion = $("#CambioAdscripcion-Justificacion").val();

      var DependenciaDestino = $("#select-dependencia_destino").val();
      //console.log(DependenciaDestino);
      var CategoriaNueva = $("#CambioAdscripcion-CategoriaNueva").val();
      var PuestoNuevo = $("#CambioAdscripcion-PuestoNuevo").val();
      var SalarioSolicitado = $("#CambioAdscripcion-SalarioSolicitado").val();
      var ActividadesNuevas = $("#CambioAdscripcion-ActividadesNuevas").val();
      var empresa = $("#CambioAdscripcion-Empresa_nps").val();
      //console.log(empresa);
      //archivos
      var archivo_organigrama = document.getElementById('archivo-organigrama');
      var archivo_plantilla = document.getElementById('archivo-plantilla');
      var archivo_descripcion = document.getElementById('archivo-descripcion');
      var archivo_descripcion_destino = document.getElementById('archivo-descripcion-desempeñara');
      var archivo_curriculum = document.getElementById('archivo-curriculum');
      var archivo_mapa_ubicacion = document.getElementById('archivo-mapa_ubicacion');

      if(NombreCandidato==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el nombre del candidato');
      }else if(dependencia_spr=='SELECCIONAR'&&tipo_usuario=='TRABAJADOR_SPR'){
        MensajeModal("¡ATENCIÓN!",'Debe seleccionar la depencia');
      }else if(DependenciaDestino=='SELECCIONAR'){
        MensajeModal("¡ATENCIÓN!",'Debe especificar en nombre de la dependencia destino');
      }else if(!institucional&&empresa==''){
        MensajeModal("¡ATENCIÓN!",'El campo "Empresa" se encuentra vacío, los campos marcados con * son obligatorios. Este campo corresponde al nombre de la empresa en la que está contratado el candidato.');
      }else if(CategoriaActual==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar la categoría actual del candidato');
      }else if(PuestoActual==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el puesto actual del candidato');
      }else if(ActividadesActuales==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar las actividades actuales del candidato');
      }else if(SalarioActual=='' || SalarioActual < 1){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el salario actual del candidato');
      }else if(CategoriaNueva==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar la categoría solicitada');
      }else if(PuestoNuevo==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el puesto solicitado');
      }else if(ActividadesNuevas==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar las actividades que tendrá el candidato');
      }else if(SalarioSolicitado=='' || SalarioSolicitado < 1){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el salario solicitado');
      }else if(Justificacion==''){
        MensajeModal("¡ATENCIÓN!",'Debe justificar la razón de la solicitud');
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
        var success;
        var url = "/cambio_adscripcion/insertar";
        var dataForm = new FormData();
        dataForm.append('dependencia_spr',dependencia_spr);
        dataForm.append('NombreCandidato',NombreCandidato);
        dataForm.append('CategoriaActual',CategoriaActual);
        dataForm.append('PuestoActual',PuestoActual);
        dataForm.append('ActividadesActuales',ActividadesActuales);
        dataForm.append('Nomina',Nomina);
        dataForm.append('SalarioActual',SalarioActual);
        dataForm.append('Justificacion',Justificacion);

        dataForm.append('DependenciaDestino',DependenciaDestino);
        dataForm.append('CategoriaNueva',CategoriaNueva);
        dataForm.append('PuestoNuevo',PuestoNuevo);
        dataForm.append('SalarioSolicitado',SalarioSolicitado);
        dataForm.append('ActividadesNuevas',ActividadesNuevas);
        dataForm.append('empresa',empresa);
        //console.log(ActividadesNuevas);


          dataForm.append('archivo_organigrama',archivo_organigrama.files[0]);
          dataForm.append('archivo_plantilla',archivo_plantilla.files[0]);
          dataForm.append('archivo_descripcion',archivo_descripcion.files[0]);
          dataForm.append('archivo_descripcion_destino',archivo_descripcion_destino.files[0]);
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
      if(tipo_usuario=='TITULAR',tipo_usuario=='COORDINADOR_CGA'){
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
    }

    function Regresar(){
      location.href='/listado/dependencia';
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