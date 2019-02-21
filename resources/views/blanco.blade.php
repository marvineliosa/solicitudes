@extends('plantillas.menu')
@section('titulo','Dependencias')
@section('content')
<div class="col-lg-12">
	<section class="panel">
	  <header class="panel-heading">
	    Listado de Cambios de Adscripción
	  </header>
	  <div class="table-responsive">
	  	Texto
	  </div>
	</section>
</div>

<!-- Modales -->
<div class="modal fade" id="EjemploModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Configuraciones</h5>
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