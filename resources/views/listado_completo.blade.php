@extends('plantillas.menu')
@section('titulo','Solicitudes')
@section('content')
<div class="col-lg-12">
	<section class="panel">
	  <header class="panel-heading">
	    Responsive tables
	  </header>
	  <div class="table-responsive">
	    <table class="table">
	      <thead>
	        <tr>
	          <th>ID</th>
	          <th>Candidato</th>
	          <th>Dependencia</th>
	          <th>Fecha</th>
	          <th>Solicitud</th>
	          <th>Estatus</th>
	          <th>Acciones</th>
	        </tr>
	      </thead>
	      <tbody>
	        <tr>
	          <td>SOL/1/2018</td>
	          <td>Marvin Eliosa Abaroa</td>
	          <td>Coordinación General Administrativa</td>
	          <td>13/12/2018</td>
	          <td>Contratación</td>
	          <td>Recibido</td>
	          <td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-primary" href="#"><i class="icon_info_alt" data-toggle="modal" data-target="#ModalDetalle"></i></a>
                    <a class="btn btn-success" href="http://localhost:8000/solicitud/contratacion/1"><i class="icon_pencil"></i></a>
                    <a class="btn btn-danger" href="#"><i class="icon_adjust-vert"></i></a>
                  </div>
                </td>
	          </td>
	        </tr>
	        <tr>
	          <td>SOL/2/2018</td>
	          <td>Javier Sánchez Vázquez</td>
	          <td>Facultad de Ciencias de la Computación</td>
	          <td>13/12/2018</td>
	          <td>Contratación por Sustitución</td>
	          <td>Análisis</td>
	          <td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-primary" href="#"><i class="icon_info_alt"></i></a>
                    <a class="btn btn-success" href="#"><i class="icon_pencil"></i></a>
                    <a class="btn btn-danger" href="#"><i class="icon_adjust-vert"></i></a>
                  </div>
                </td>
	          </td>
	        </tr>
	        <tr>
	          <td>SOL/3/2018</td>
	          <td>Isaac Lemus Tetzopa</td>
	          <td>Fundación BUAP</td>
	          <td>15/12/2018</td>
	          <td>Promoción</td>
	          <td>Firmas</td>
	          <td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-primary" href="#"><i class="icon_info_alt"></i></a>
                    <a class="btn btn-success" href="#"><i class="icon_pencil"></i></a>
                    <a class="btn btn-danger" href="#"><i class="icon_adjust-vert"></i></a>
                  </div>
                </td>
	          </td>
	        </tr>
	      </tbody>
	    </table>
	  </div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Concepto</th>
		      <th scope="col">Descripción</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <th scope="row">ID</th>
		      <td>SOL/1/2018</td>
		    </tr>
		    <tr>
		      <th scope="row">Candidato</th>
		      <td>Marvin Gabriel Eliosa Abaroa</td>
		    </tr>
		    <tr>
		      <th scope="row">Dependencia</th>
		      <td>Coordinación General Administrativa</td>
		    </tr>
		    <tr>
		      <th scope="row">Fecha de Solicitud</th>
		      <td>13/12/2018</td>
		    </tr>
		    <tr>
		      <th scope="row">Fecha de información completa</th>
		      <td>22/01/2019</td>
		    </tr>
		    <tr>
		      <th scope="row">Categoría</th>
		      <td>Técnico Administrativo</td>
		    </tr>
		    <tr>
		      <th scope="row">Puesto</th>
		      <td>Encargado de Cómputo</td>
		    </tr>
		    <tr>
		      <th scope="row">Salario</th>
		      <td>$2750.80</td>
		    </tr>
		  </tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
	  
@endsection