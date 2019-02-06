@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Contratación por Sustitución
		  </header>
		  <div class="panel-body">
        <form class="form-horizontal " method="get">
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Persona anterior</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre de la persona que causa baja">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría anterior</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría de la persona que causa baja">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto anterior</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del candidato anterior">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades anteriores</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñába la persona anterior"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Candidato propuesto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre del candidato">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría solicitada</label>
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
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-2">
              <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
          </div>
        </form>
      </div>
		</section>
	</div>
	  
@endsection