@extends('plantillas.menu')
@section('titulo','Usuarios')


@section('barra_superior')
  <div class=" pull-right"><button type="button" class="btn btn-primary btn-xs" onclick="AbrirModalDependencia()">Crear Titular</button>&nbsp<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ModalUsuario">Crear Usuario</button></div>
@endsection

@section('content')
<div class="col-lg-12">
	<section class="panel">
	  <header class="panel-heading">
	    Listado de Usuarios
	  </header>
	  <div class="table-responsive">
      <table class="table" id="tabla_datos">
        <thead>
          <tr>
            <th>Responsable</th>
            <th>Usuario</th>
            <th>Categoría</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($usuarios as $usuario)
            <tr>
              <td>{{$usuario->RESPONSABLE_USUARIO}}</td>
              <td>{{$usuario->NOMBRE_USUARIO}}</td>
              <td>{{$usuario->CATEGORIA_USUARIO}}</td>
              <td>
                <div class="btn-group">
                  <a class="btn btn-danger" href="javascript:void(0)" onclick="ModalEliminarUsuario('{{$usuario->NOMBRE_USUARIO}}','{{$usuario->CATEGORIA_USUARIO}}')" data-toggle="tooltip" data-placement="auto" title="ELIMINAR USUARIO"><i class="icon_close"></i></a>
                  <a class="btn btn-success" href="javascript:void(0)" onclick="ModalRecuperarContrasena('{{$usuario->NOMBRE_USUARIO}}')" data-toggle="tooltip" data-placement="auto" title="ENVIAR CONTRASEÑA"><i class="icon_key_alt"></i></a> 
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
	</section>
</div>

<!-- MODALES -->
<!-- MODAL DE USUARIOS -->
<div class="modal fade" id="ModalEliminarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel" align="center">¡ADVERTENCIA!</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <input type="" name="" style="display: none" id="hide_usuario" value="">
      </div>
      <div class="modal-body">
        <h3 align="center" id="mensaje_eliminar"></h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="EliminarUsuario()">Estoy seguro</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL DE RECUPERAR CONTRASENA -->
<div class="modal fade" id="ModalRecuperarContrasena" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel" align="center">ATENCIÓN!</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <input type="" name="" style="display: none" id="hide_usuario_pass" value="">
      </div>
      <div class="modal-body">
        <h3 align="center" id="mensaje_contrasena"></h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="RecuperarContrasena()">Enviar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL DE DEPENDENCIAS -->
<div class="modal fade" id="ModalDependencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gestion de Titulares</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-10">
              <select class="form-control m-bot15" id="select-dependencias" onchange="CambioDependencia()">
                  <option value="SELECCIONAR">--SELECCIONAR DEPENDENCIA--</option>
                  @foreach($dependencias as $dependencia)
                    <option value="{{$dependencia->ID_DEPENDENCIA}}">{{$dependencia->NOMBRE_DEPENDENCIA}}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Dependencia</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="NOMBRE DE LA DEPENDENCIA" id="nombre-dependencia" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Titular</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="NOMBRE DEL TITULAR" id="nombre-titular" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Usuario</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="NOMBRE DEL USUARIO" id="usuario-titular" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Contraseña</label>
            <div class="col-sm-10">
              <div hidden="true" id="div-BtnPass"><button type="button" class="btn btn-success" onclick="EnviarContrasenaTitular()">Enviar por correo</button></div>
            </div>
          </div>
          <!--<div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-2">
              <button type="button" class="btn btn-primary" onclick="GuardarDatosDependencia()">Guardar</button>
            </div>
          </div>-->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="GuardarDatosDependencia()">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL USUARIOS -->
<div class="modal fade" id="ModalUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gestion de Usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label">Tipo de usuario</label>
            <div class="col-sm-10">
              <input type="hidden" class="form-control" placeholder="NOMBRE DEL USUARIO" id="usuario-general" value="">
              <select class="form-control m-bot15" id="select-usuarios">
                  <option value="SELECCIONAR">--SELECCIONAR USUARIO--</option>
                    <option value="ANALISTA_CGA">ANALISTA</option>
                    <option value="ADMINISTRADOR_CGA">ADMINISTRADOR DE CGA</option>
                    <option value="COORDINADOR_CGA">COORDINADOR DE CGA</option>
                    <option value="TRABAJADOR_SPR">TRABAJADOR DE SPR</option>
                    <option value="SECRETARIO_PARTICULAR">SECRETARIO PARTICULAR DE RECTORÍA</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Responsable</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="NOMBRE DEL USUARIO" id="usuario_nombre" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Usuario</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="CORREO ELECTRONICO DEL USUARIO" id="usuario_general" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Contraseña</label>
            <div class="col-sm-10">
              <div hidden="true" id="div-BtnPassUsuario"><button type="button" class="btn btn-success" onclick="EnviarContrasenaUsuario()">Enviar por correo</button></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="GuardarDatosUsuario()">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
	  
@endsection

@section('script')
	<script type="text/javascript">

    var gl_usuarios = <?php echo json_encode($usuarios) ?>;
    //console.log(gl_usuarios);
    var gl_dependencias = <?php echo json_encode($dependencias) ?>;
    //console.log(gl_dependencias);
    //$("#ModalDependencia").modal();

    function ModalEliminarUsuario(usuario,categoria){
      $('#hide_usuario').val(usuario);
      $("#mensaje_eliminar").html('¿Esta seguro de eliminar el usuario: '+usuario+'?');
      $("#ModalEliminarUsuario").modal();
    }

    function EliminarUsuario(){
      var usuario = $('#hide_usuario').val();
      console.log(usuario);
      var success;
      var url = "/usuarios/eliminar";
      var dataForm = new FormData();
      dataForm.append('usuario',usuario);
      //lamando al metodo ajax
      metodoAjax(url,dataForm,function(success){
        //aquí se escribe todas las operaciones que se harían en el succes
        //la variable success es el json que recibe del servidor el método AJAX
        //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
        if(success['delete']){
          if(success['delete2']){
            MensajeModal("¡EXITO!","El titular se ha sido eliminado correctamente");
          }else{
            MensajeModal("¡EXITO!","El usuario ha sido eliminado correctamente");
          }
          $("#ModalEliminarUsuario").modal('hide');
        }else{
          MensajeModal("¡ATENCIÓN!","Existió un problema, por favor intentelo más tarde");
          //$("#contrasena-titular").val('CONTRASEÑA SECRETA');
        }
      });//*/
    }

    function ModalRecuperarContrasena(usuario){
      $('#hide_usuario').val(usuario);
      $("#mensaje_contrasena").html('¿Desea enviar la contraseña del usuario '+usuario+' por correo electrónico?');
      $("#ModalRecuperarContrasena").modal();
    }

    function RecuperarContrasena(){
      var usuario = $('#hide_usuario').val();
      console.log(usuario);
      var success;
      var url = "/usuarios/recuperar_contrasena";
      var dataForm = new FormData();
      dataForm.append('usuario',usuario);
      //lamando al metodo ajax
      metodoAjax(url,dataForm,function(success){
        //aquí se escribe todas las operaciones que se harían en el succes
        //la variable success es el json que recibe del servidor el método AJAX
        $("#ModalRecuperarContrasena").modal('hide');
        MensajeModal(success['titulo'],success['mensaje']);
        
      });//*/
    }

    function AbrirModalDependencia(){
      $("#usuario-titular").val('');
      $("#contrasena-titular").val('');//*/
      $("#ModalDependencia").modal();
    }

    function CambioDependencia(){
      var id_dependencia = $("#select-dependencias").val();
      //console.log(id_dependencia);
      if(id_dependencia!='SELECCIONAR'){
      var success;
      var url = "/dependencias/trae_dependencia";
      var dataForm = new FormData();
      dataForm.append('id_dependencia',id_dependencia);
      //lamando al metodo ajax
        metodoAjax(url,dataForm,function(success){
          //aquí se escribe todas las operaciones que se harían en el succes
          //la variable success es el json que recibe del servidor el método AJAX
          //MensajeModal("TITULO DEL MODAL","MENSAJE DEL MODAL");
          $("#nombre-dependencia").val(success['dependencia']['NOMBRE_DEPENDENCIA']);
          $("#nombre-titular").val(success['dependencia']['TITULAR_DEPENDENCIA']);
          if(success['usuario']){
            $("#usuario-titular").val(success['usuario']['FK_USUARIO']);
            $("#div-BtnPass").show();
          }else{
            $("#usuario-titular").val("");
            $("#div-BtnPass").hide();
            //$("#contrasena-titular").val('CONTRASEÑA SECRETA');
          }
        });
      }else{
        $("#nombre-dependencia").val('');
        $("#usuario-titular").val("");
        $("#nombre-titular").val('');
        $("#div-BtnPass").hide();
      }
    }

    function EnviarContrasenaTitular(){
      var usuario = $("#usuario-titular").val();
      console.log(usuario);
      var success;
        var url = "/mail/enviar_contrasena";
        var dataForm = new FormData();
        dataForm.append('usuario',usuario);
        //lamando al metodo ajax
        metodoAjax(url,dataForm,function(success){
          //aquí se escribe todas las operaciones que se harían en el succes
          //la variable success es el json que recibe del servidor el método AJAX
          
          MensajeModal("¡EXITO!",'Se ha enviado la contraseña al correo '+usuario);

        });
    }

    function GuardarDatosUsuario(){
      var usuario = $("#usuario_general").val();
      var responsable = $("#usuario_nombre").val();
      var tipo_usuario = $("#select-usuarios").val();
      var success;
        var url = "/usuarios/guardar_usuario";
        var dataForm = new FormData();
        dataForm.append('usuario',usuario);
        dataForm.append('responsable',responsable);
        dataForm.append('tipo_usuario',tipo_usuario);
        //lamando al metodo ajax
        metodoAjax(url,dataForm,function(success){
          //aquí se escribe todas las operaciones que se harían en el succes
          //la variable success es el json que recibe del servidor el método AJAX
          
          MensajeModal("¡EXITO!", success['mensaje']);

        });

    }

    function EnviarContrasenaUsuario(){
      var usuario = $("#usuario_general").val();
      console.log(usuario);
      var success;
        var url = "/mail/enviar_contrasena";
        var dataForm = new FormData();
        dataForm.append('usuario',usuario);
        //lamando al metodo ajax
        metodoAjax(url,dataForm,function(success){
          //aquí se escribe todas las operaciones que se harían en el succes
          //la variable success es el json que recibe del servidor el método AJAX
          
          MensajeModal("¡EXITO!",'Se ha enviado la contraseña al correo '+usuario);

        });
    }

    function GuardarDatosDependencia(){
      var id_dependencia = $("#select-dependencias").val();
      var titular = $("#nombre-titular").val();
      var usuario = $("#usuario-titular").val();
      //var contrasena = $("#contrasena-titular").val();
      var dependencia = $("#nombre-dependencia").val();
      //console.log(id_dependencia);
      if(id_dependencia!='SELECCIONAR' && dependencia!=''){
        var success;
        var url = "/dependencias/editar";
        var dataForm = new FormData();
        dataForm.append('id_dependencia',id_dependencia);
        dataForm.append('titular',titular);
        dataForm.append('usuario',usuario);
        //dataForm.append('contrasena',contrasena);
        dataForm.append('dependencia',dependencia);
        //lamando al metodo ajax
        metodoAjax(url,dataForm,function(success){
          //aquí se escribe todas las operaciones que se harían en el succes
          //la variable success es el json que recibe del servidor el método AJAX
          if(success['insert'] || usuario==''){
            MensajeModal("¡EXITO!","Los datos se han guardado correctamente.");
            if(success['insert']){
              $("#div-BtnPass").show();
            }
          }else{
            MensajeModal("¡ATENCIÓN!",success['mensaje']);
          }

        });
      }else{
        MensajeModal("¡ATENCIÓN!","Debe seleccionar una dependencia.");
      }
    }

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

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