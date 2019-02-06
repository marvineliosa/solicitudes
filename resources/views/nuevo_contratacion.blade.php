@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Contratación
		  </header>
		  <div class="panel-body">
                <div class="form-horizontal " method="get">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Dependencia</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Dependencia">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Candidato</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Nombre del Candidato">
                    </div>
                  </div>
		          <div class="form-group">
		            <label class="col-sm-2 control-label">Categoría</label>
		            <div class="col-sm-6">
		              <input type="text" class="form-control" placeholder="Categoría solicitada">
		            </div>
		          </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Puesto</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Puesto del Candidato">
                    </div>
                  </div>
		          <div class="form-group">
		            <label class="col-sm-2 control-label">Actividades</label>
		            <div class="col-sm-6">
		              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñará"></textarea>
		            </div>
		          </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Nómina</label>
                    <div class="col-sm-6">
                      <select class="form-control m-bot15">
                          <option>Prestación de Servicios</option>
                          <option>Institucional</option>
                      </select>
                    </div>
                  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Salario neto solicitado</label>
                <div class="col-sm-6">
                  <input type="number" class="form-control" placeholder="Salario solicitado para el candidato" value="0.00">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Justificación</label>
                <div class="col-sm-6">
                  <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Justificación de la solicitud del personal"></textarea>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">Subir Organigramas</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Subir Plantilla de Personal</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Subir Descripción de Puesto a Cubrir</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Subir Curriculum Actualizado</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Mapa de Ubicación Física</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Fuente de Recursos</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
              </div>

              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-2">
                  <button type="" class="btn btn-primary" onclick="listado()">Registrar</button>
                </div>
              </div>
            </div>
          </div>
		</section>
	</div>
	  
@endsection

<script type="text/javascript">
  function listado(){
    location.href="/listado/completo";
  }
</script>