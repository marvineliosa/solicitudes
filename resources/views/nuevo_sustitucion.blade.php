@extends('plantillas.menu')
@section('titulo','Nueva Sustitución')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Contratación por Sustitución
		  </header>
		  <div class="panel-body">
        <div class="form-horizontal " method="get">
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
            <label class="col-sm-2 control-label">Persona anterior*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre de la persona que causa baja" id="Sustitucion-PersonaAnterior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría anterior</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría de la persona que causa baja" id="Sustitucion-CategoriaAnterior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto anterior*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto de la persona anterior" id="Sustitucion-PuestoAnterior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades anteriores*</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñába la persona anterior" id="Sustitucion-ActividadesAnteriores"></textarea>
            </div>
          </div>
          <div class="form-group">
            @if($institucional)
              <label class="col-sm-2 control-label">Salario bruto quincenal anterior*</label>
            @else
              <label class="col-sm-2 control-label">Salario neto quincenal anterior*</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario de quien dejó el puesto" value="0.00" step=".01" id="Sustitucion-SalarioAnterior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Candidato propuesto (Tal como aparece en INE)*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre del candidato" id="Sustitucion-CandidatoPropuesto">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría solicitada</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" id="Sustitucion-CategoriaSolicitada">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto*</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" id="Sustitucion-PuestoSolicitado">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades*</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñará" id="Sustitucion-ActividadesNuevas" maxlength="830"></textarea>
            </div>
          </div>
          <div class="form-group">
            @if($institucional)
              <label class="col-sm-2 control-label">Salario bruto quincenal solicitado*</label>
            @else
              <label class="col-sm-2 control-label">Salario neto quincenal solicitado*</label>
            @endif
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Salario solicitado para el candidato" value="0.00" step=".01" id="Sustitucion-SalarioSolicitado">
            </div>
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
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Justificación de la solicitud del personal" id="Sustitucion-Justificacion"></textarea>
            </div>
          </div>
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
            <label class="col-sm-3 control-label">Descripción del Puesto a Cubrir*</label>
            <div class="col-sm-9">
              <input type="file" class="form-control-file" accept="application/pdf" id="archivo-descripcion" onchange="VerificarTamanio(this)">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Curriculum Actualizado (Debe tener el comprobante del último grado de estudios)*</label>
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
        </div>
      </div>
		</section>
	</div>
	  
@endsection

@section('script')
  <script type="text/javascript">
    id_dependencia = <?php echo json_encode(\Session::get('id_dependencia')[0]) ?>;
    // autollenado();
    tipo_usuario = <?php echo json_encode(\Session::get('categoria')[0]) ?>;
    //console.log(tipo_usuario);

      MensajeModal('¡ATENCIÓN!','Buen día, con el fin de unificar la presentación de la información, se agradecerá que la captura se realice utilizando mayúsculas y minúsculas.');

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
      $("#Sustitucion-PersonaAnterior").val('Marvin Eliosa Abaroa');
      $("#Sustitucion-CategoriaAnterior").val('Auxiliar Administrativo');
      $("#Sustitucion-PuestoAnterior").val('Auxiliar de administración');
      $("#Sustitucion-ActividadesAnteriores").val('Actividades de Marvin');
      $("#Sustitucion-SalarioAnterior").val(3200.87);


      $("#Sustitucion-CandidatoPropuesto").val('Nuevo Candidato Propuesto');
      $("#Sustitucion-CategoriaSolicitada").val('Nueva Categoria');
      $("#Sustitucion-PuestoSolicitado").val('Puesto Nuevo');
      $("#Sustitucion-ActividadesNuevas").val('Actividades Nuevas');
      $("#Sustitucion-SalarioSolicitado").val(3000);


      $("#Sustitucion-Justificacion").val('Es necesario puesto que el departamento tiene sobre carga de trabajo');//*/
      //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
    }
    function AlmacenarSolicitud(){
      var dependencia_spr = $("#select-dependencia_spr").val();
      //datos de la persona que deja el puesto
      var persona_anterior = $("#Sustitucion-PersonaAnterior").val();
      var categoria_anterior = $("#Sustitucion-CategoriaAnterior").val();
      var puesto_anterior = $("#Sustitucion-PuestoAnterior").val();
      var actividades_anterior = $("#Sustitucion-ActividadesAnteriores").val();
      var salario_anterior = $("#Sustitucion-SalarioAnterior").val();
      //datos de la persona que sustituye
      var persona_solicitada = $("#Sustitucion-CandidatoPropuesto").val();
      var categoria_solicitada = $("#Sustitucion-CategoriaSolicitada").val();
      var puesto_solicitado = $("#Sustitucion-PuestoSolicitado").val();
      var actividades_solicitadas = $("#Sustitucion-ActividadesNuevas").val();
      var salario_solicitado = $("#Sustitucion-SalarioSolicitado").val();
      //
      //var nomina = $("#Sustitucion-Nomina").val();
      var nomina = 'NA';
      var justificacion = $("#Sustitucion-Justificacion").val();
      var fuente_recursos = $("#SelectFuenteRecursos").val();

      var archivo_organigrama = document.getElementById('archivo-organigrama');
      var archivo_plantilla = document.getElementById('archivo-plantilla');
      var archivo_descripcion = document.getElementById('archivo-descripcion');
      var archivo_curriculum = document.getElementById('archivo-curriculum');
      var archivo_mapa_ubicacion = document.getElementById('archivo-mapa_ubicacion');

      if(persona_anterior==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el nombre de la persona que dejó el puesto');
      }else if(dependencia_spr=='SELECCIONAR'&&tipo_usuario=='TRABAJADOR_SPR'){
        MensajeModal("¡ATENCIÓN!",'Debe seleccionar la depencia');
      }else if(puesto_anterior==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el puesto que tenía la persona');
      }else if(actividades_anterior==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar las actividades de  la persona que dejó el puesto');
      }else if(salario_anterior=='' || salario_anterior < 1){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el salario de la persona que dejó el puesto');
      }else if(persona_solicitada==''){//datos de la nueva persona
        MensajeModal("¡ATENCIÓN!",'Debe especificar el candidato que tomará el puesto');
      }else if(puesto_solicitado==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar el puesto que tendrá el candidato');
      }else if(actividades_solicitadas==''){
        MensajeModal("¡ATENCIÓN!",'Debe especificar la categoría que tendrá el candidato');
      }else if(salario_solicitado=='' || salario_solicitado < 1){
        MensajeModal("¡ATENCIÓN!",'El salario solicitado no puede estar vacío o ser menor a 1');
      }else if(justificacion==''){
        MensajeModal("¡ATENCIÓN!",'Debe justificar la razón de la solicitud');
      }else if(fuente_recursos=='NADA'){
        MensajeModal("¡ATENCIÓN!",'Debe especificar la fuente de recursos');
      }else if(archivo_organigrama.value==""){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar el organigrama de la dependencia');
      }else if(archivo_plantilla.value==''){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar la plantilla de personal de la dependencia');
      }else if(archivo_descripcion.value==''){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar la descripción del puesto a desempeñar');
      }else if(archivo_curriculum.value==''){
        MensajeModal("¡ATENCIÓN!",'Debe adjuntar el curriculum del candidato');
      }else{
        //MensajeModal("¡ATENCIÓN!",'Enviando');
        var success;
        var url = "/contratacion_sustitucion/insertar";
        var dataForm = new FormData();
        dataForm.append('dependencia_spr',dependencia_spr);
        dataForm.append('persona_anterior',persona_anterior);
        dataForm.append('categoria_anterior',categoria_anterior);
        dataForm.append('puesto_anterior',puesto_anterior);
        dataForm.append('actividades_anterior',actividades_anterior);
        dataForm.append('salario_anterior',salario_anterior);

        dataForm.append('persona_solicitada',persona_solicitada);
        dataForm.append('categoria_solicitada',categoria_solicitada);
        dataForm.append('puesto_solicitado',puesto_solicitado);
        dataForm.append('actividades_solicitadas',actividades_solicitadas);
        dataForm.append('salario_solicitado',salario_solicitado);

        dataForm.append('nomina',nomina);
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
      if(tipo_usuario=='TITULAR' || tipo_usuario=='COORDINADOR_CGA'){
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