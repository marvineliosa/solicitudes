@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
	<div class="col-lg-12">
		<section class="panel">
		  <header class="panel-heading">
		    Formulario de Contratación
		  </header>
		  <div class="panel-body">
        <form class="form-horizontal " method="get">
          <div class="form-group">
            <label class="col-sm-2 control-label">Fecha de Recibido</label>
            <div class="col-sm-2">
              <input type="date" class="form-control" placeholder="Puesto del Candidato" value="2019-11-15" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Información Completa</label>
            <div class="col-sm-2">
              <input type="date" class="form-control" placeholder="Puesto del Candidato" value="2019-01-22">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Fecha de Envío</label>
            <div class="col-sm-2">
              <input type="date" class="form-control" placeholder="Puesto del Candidato" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Dependencia" value="Coordinación General Administrativa">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Candidato</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Nombre del Candidato" value="Marvin Gabriel Eliosa Abaroa">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Categoría</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Categoría solicitada" value="Técnico Administrativo">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" value="Encargado de Cómputo">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Puesto Propuesto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="Puesto del Candidato" value="Encargado de Cómputo">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Actividades</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="3" placeholder="Actividades que desempeñará">Hacer mantenimiento de cómputo preventivo y correctivo. Mantener las computadoras actualizadas. Instalar software solicitado por los usuarios.</textarea>
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
            <label class="col-sm-2 control-label">Salario</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Puesto del Candidato" value="2750.80">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Salario Propuesto</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Puesto del Candidato" value="2750.80">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Justificación</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Descripción se la solicitud del personal">Ya que en el departamento existe una gran demanda de sofware para laborar, se solicita la contratación del C. Marvin Gabriel Eliosa Abaroa por un periodo de 6 meses</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Observaciones</label>
            <div class="col-sm-6">
              <textarea class="form-control ckeditor" name="editor1" rows="6" placeholder="Descripción se la solicitud del personal"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-2">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </form>
      </div>
		</section>
	</div>
	  
@endsection