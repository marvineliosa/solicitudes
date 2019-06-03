@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Promoción
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
            <label class="col-sm-2 control-label">Candidato (Tal como aparece en INE)*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre del candidato" id="Promocion-Candidato">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Actual*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría actual" id="Promocion-CategoriaActual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto Actual*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del candidato" id="Promocion-PuestoActual">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades actuales*</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeña actualmente" id="Promocion-ActividadesActuales"></textarea>
            </div>
          </div>
          <div class="form-group">
            @if($institucional)
              <label class="col-sm-2 control-label">Salario bruto quincenal actual*</label>
            @else
              <label class="col-sm-2 control-label">Salario neto quincenal actual*</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario actual del candidato" id="Promocion-SalarioActual" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría Solicitada*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nueva categoría solicitada" id="Promocion-CategoriaSolicitada">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nuevo Puesto*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nuevo puesto que desempeñará" id="Promocion-PuestoNuevo">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nuevas Actividades*</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Nuevas actividades que desempeñará" id="Promocion-ActividadesNuevas"></textarea>
            </div>
          </div>
          <div class="form-group">
            @if($institucional)
              <label class="col-sm-2 control-label">Salario bruto quincenal solicitado*</label>
            @else
              <label class="col-sm-2 control-label">Salario neto quincenal solicitado*</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario solicitado para el candidato" id="Promocion-SalarioSolicitado" step=".01">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Justificación*</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Justificación de la solicitud de promoción" id="Promocion-Justificacion"></textarea>
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
            <label class="col-sm-3 control-label">Descripción del Puesto del Candidato*</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-descripcion" onchange="VerificarTamanio(this)">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Curriculum Actualizado del Candidato (Debe tener el comprobante del último grado de estudios)*</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-curriculum" onchange="VerificarTamanio(this)">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Mapa de Ubicación Física</label>
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
    //autollenado();
    tipo_usuario = <?php echo json_encode(\Session::get('categoria')[0]) ?>;
    //console.log(tipo_usuario);
    function autollenado(){
      $("#Promocion-Candidato").val('Marvin Eliosa Abaroa');
      $("#Promocion-CategoriaActual").val('Auxiliar Administrativo');
      $("#Promocion-PuestoActual").val('Auxiliar de administración');
      $("#Promocion-ActividadesActuales").val('Actividades de Marvin');
      $("#Promocion-SalarioActual").val(3200.87);

      $("#Promocion-CategoriaSolicitada").val('Nueva Categoría solicitada');
      $("#Promocion-PuestoNuevo").val('Nuevo Puesto a desempeñar');
      $("#Promocion-ActividadesNuevas").val('NUEVAS ACTIVIDADES A DESEMPEÑAR');
      $("#Promocion-SalarioSolicitado").val(5000);

      $("#Promocion-Justificacion").val('Es necesaria la promoción puesto que el departamento tiene sobre carga de trabajo');//*/
      //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
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
    function AlmacenarSolicitud(){
      var dependencia_spr = $("#select-dependencia_spr").val();
      //datos de la persona que deja el puesto
      var Candidato = $("#Promocion-Candidato").val();
      var CategoriaActual = $("#Promocion-CategoriaActual").val();
      var PuestoActual = $("#Promocion-PuestoActual").val();
      var ActividadesActuales = $("#Promocion-ActividadesActuales").val();
      var SalarioActual = $("#Promocion-SalarioActual").val();
      //datos de la persona que sustituye
      var CategoriaSolicitada = $("#Promocion-CategoriaSolicitada").val();
      var PuestoNuevo = $("#Promocion-PuestoNuevo").val();
      var ActividadesNuevas = $("#Promocion-ActividadesNuevas").val();
      var SalarioSolicitado = $("#Promocion-SalarioSolicitado").val();
      //
      var nomina = 'NA'
      var justificacion = $("#Promocion-Justificacion").val();
      //archivos
      var archivo_organigrama = document.getElementById('archivo-organigrama');
      var archivo_plantilla = document.getElementById('archivo-plantilla');
      var archivo_descripcion = document.getElementById('archivo-descripcion');
      var archivo_curriculum = document.getElementById('archivo-curriculum');
      var archivo_mapa_ubicacion = document.getElementById('archivo-mapa_ubicacion');
      if(Candidato==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el nombre del candidato');
      }else if(dependencia_spr=='SELECCIONAR'&&tipo_usuario=='TRABAJADOR_SPR'){
        MensajeModal("¡ATENCIÓN!",'Debe seleccionar la depencia');
      }else if(CategoriaActual==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar la categoría actual del candidato');
      }else if(PuestoActual==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el puesto actual del candidato');
      }else if(ActividadesActuales==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar las actividades actuales del candidato');
      }else if(SalarioActual=='' || SalarioActual < 1){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el salario actual del candidato');
      }else if(PuestoNuevo==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el puesto solicitado');
      }else if(CategoriaSolicitada==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar la categoría solicitada');
      }else if(ActividadesNuevas==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar las actividades que tendrá el candidato');
      }else if(SalarioSolicitado=='' || SalarioSolicitado < 1){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el salario solicitado');
      }else if(justificacion==''){
        MensajeModal("¡ATENCIÓN!",'Debe justificar la razón de la solicitud');
      }else if(archivo_organigrama.value==""){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar el organigrama de la dependencia');
      }else if(archivo_plantilla.value==''){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar la plantilla de personal de la dependencia');
      }else if(archivo_descripcion.value==''){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar la descripción del puesto a desempeñar');
      }else if(archivo_curriculum.value==''){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar el curriculum del candidato');
      }else{

        var success;
        var url = "/promocion/insertar";
        var dataForm = new FormData();
        dataForm.append('dependencia_spr',dependencia_spr);
        dataForm.append('Candidato',Candidato);
        dataForm.append('CategoriaActual',CategoriaActual);
        dataForm.append('PuestoActual',PuestoActual);
        dataForm.append('ActividadesActuales',ActividadesActuales);
        dataForm.append('SalarioActual',SalarioActual);

        dataForm.append('CategoriaSolicitada',CategoriaSolicitada);
        dataForm.append('PuestoNuevo',PuestoNuevo);
        dataForm.append('ActividadesNuevas',ActividadesNuevas);
        dataForm.append('SalarioSolicitado',SalarioSolicitado);

        dataForm.append('nomina',nomina);
        dataForm.append('justificacion',justificacion);


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
        });
      }
    }

    ObtenerNombreDependencia();
    function ObtenerNombreDependencia(){
      if(tipo_usuario=='TITULAR'){
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