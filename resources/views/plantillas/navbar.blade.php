<!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <!-- LISTADOS CGA -->
          @if(strcmp(\Session::get('categoria')[0],'TITULAR')!=0)
            <li class="sub-menu">
              <a href="javascript:;" class="">
                <i class="icon_table"></i>
                <span>Listados</span>
                <span class="menu-arrow arrow_carrot-right"></span>
              </a>
              <ul class="sub">
                @if(strcmp(\Session::get('categoria')[0],'ADMINISTRADOR_CGA')==0 || strcmp(\Session::get('categoria')[0],'ANALISTA_CGA')==0)
                  <li><a class="" href="/listado/revision_informacion">Revision de Información</a></li>
                  @if(strcmp(\Session::get('categoria')[0],'ADMINISTRADOR_CGA')==0)
                    <li><a class="" href="/listado/completo">Listado Completo</a></li>
                  @else
                    <li><a class="" href="/listado/analista">Listado Completo</a></li>
                  @endif
                  <li><a class="" href="/listado/estatus/recibido">Recibido</a></li>
                  <li><a class="" href="/listado/estatus/levantamiento">Levantamiento</a></li>
                  <li><a class="" href="/listado/estatus/analisis">Análisis</a></li>
                  <li><a class="" href="/listado/estatus/revision">Revisión</a></li>
                  <li><a class="" href="/listado/estatus/firmas">Firmas</a></li>
                  <li><a class="" href="/listado/estatus/turnado_spr">Turnado a SPR</a></li>
                  <li><a class="" href="/listado/estatus/completado_rector">Completado por Rector</a></li>
                  <li><a class="" href="/listado/estatus/limpieza_vigilancia">Limpieza y Vigilancia</a></li>
                  <!--<li><a class="" href="/listado/contratacion">Contratación</a></li>
                  <li><a class="" href="/listado/contratacion_sustitucion">Sustitución</a></li>
                  <li><a class="" href="/listado/promocion">Promoción</a></li>
                  <li><a class="" href="/listado/cambio_adscripcion">Cambio de Adscripción</a></li>-->
                @endif
                @if(strcmp(\Session::get('categoria')[0],'TRABAJADOR_SPR')==0 || strcmp(\Session::get('categoria')[0],'CONSULTOR')==0)
                  <li><a class="" href="/listado/nuevas">Nuevas (SPR)</a></li>
                  <li><a class="" href="/listado/en_proceso">En Proceso (CGA)</a></li>
                  <li><a class="" href="/listado/por_revisar">Por Revisar (SPR)</a></li>
                  <li><a class="" href="/listado/revisadas">Por Autorizar (SPR)</a></li>
                  <li><a class="" href="/listado/completadas">Completadas (SPR)</a></li>

                @endif
                @if(strcmp(\Session::get('categoria')[0],'SECRETARIO_PARTICULAR')==0)
                  <li><a class="" href="/listado/spr">Por Firmar (SPR)</a></li>
                  <li><a class="" href="/listado/spr_firmadas">Firmadas (SPR)</a></li>
                @endif
                @if(strcmp(\Session::get('categoria')[0],'COORDINADOR_CGA')==0)
                  <li><a class="" href="/listado/completo">Listado Completo</a></li>
                  <li><a class="" href="/listado/coordinacion">En firmas</a></li>
                @endif
              </ul>
            </li>
          @endif

          @if(in_array(\Session::get('categoria')[0], ['ANALISTA_CGA','CONSULTOR']))
            <li class="">
              <a class="" href="/listado/consultor">
                <i class="icon_search"></i>
                <span>Consultar</span>
              </a>
            </li>
          @endif

          @if(in_array(\Session::get('categoria')[0], ['TRABAJADOR_SPR']))
            <li class="">
              <a class="" href="/listado/spr">
                <i class="icon_pushpin_alt"></i>
                <span>Por Firmar (SPR)</span>
              </a>
            </li>
          @endif

          <!-- ACCESOS DEPENDENCIA -->
          @if(strcmp(\Session::get('categoria')[0],'TITULAR')==0)

          <li class="">
            <a class="" href="/listado/dependencia">
              <i class=""></i>
              <span>Solicitudes Realizadas</span>
            </a>
          </li>
          @if(\Session::get('horario')[0])
          <li class="sub-menu">
            <a href="javascript:;" class="">
              <!--<i class="icon_document_alt"></i>-->
              <i class=""></i>
              <span>Crear Solicitud</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <!--<li><a class="" href="/listado/dependencia">Solicitudes Realizadas</a></li>-->
              
                <li><a class="" href="/solicitudes/contratacion">Contratación</a></li>
                <li><a class="" href="/solicitudes/sustitucion">Sustitución</a></li>
                <li><a class="" href="/solicitudes/promocion">Promoción</a></li>
                <li><a class="" href="/solicitudes/cambio_adscripcion">Cambio de Adscripción</a></li>
              
            </ul>
          </li>
          @endif
          @endif

          @if(strcmp(\Session::get('categoria')[0],'ADMINISTRADOR_CGA')==0)
          <!-- USUARIOS -->
          <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="icon_group"></i>
              <span>Usuarios</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="/usuarios">Crear Usuario</a></li>
            </ul>
          </li>
          @endif
          @if(in_array(\Session::get('categoria')[0], ['ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA','TRABAJADOR_SPR']))
            <li class="">
              <a class="" href="/reportes">
                <i class="icon_document_alt"></i>
                <span>Reportes</span>
              </a>
            </li>
          @endif

          @if(in_array(\Session::get('categoria')[0], ['TRABAJADOR_SPR']))
          <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="icon_pencil"></i>
              <span>Solicitudes</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
                <li><a class="" href="/solicitudes/contratacion">Contratación</a></li>
                <li><a class="" href="/solicitudes/sustitucion">Sustitución</a></li>
                <li><a class="" href="/solicitudes/promocion">Promoción</a></li>
                <li><a class="" href="/solicitudes/cambio_adscripcion">Cambio de Adscripción</a></li>
            </ul>
          </li>
          @endif

          <li class="">
            <a class="" href="/salir">
              <i class=""></i>
              <span>Salir</span>
            </a>
          </li>
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->