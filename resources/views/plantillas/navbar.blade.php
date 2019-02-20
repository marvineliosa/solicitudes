<!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          @if(strcmp(\Session::get('categoria')[0],'TITULAR')!=0)
            <li class="sub-menu">
              <a href="javascript:;" class="">
                <i class="icon_table"></i>
                <span>Listados</span>
                <span class="menu-arrow arrow_carrot-right"></span>
              </a>
              <ul class="sub">
                @if(strcmp(\Session::get('categoria')[0],'TRBAJADOR_CGA')==0)
                  <li><a class="" href="/listado/revision_informacion">Revision de Información</a></li>
                  <li><a class="" href="/listado/completo">Listado Completo</a></li>
                  <!--<li><a class="" href="/listado/contratacion">Contratación</a></li>
                  <li><a class="" href="/listado/contratacion_sustitucion">Sustitución</a></li>
                  <li><a class="" href="/listado/promocion">Promoción</a></li>
                  <li><a class="" href="/listado/cambio_adscripcion">Cambio de Adscripción</a></li>-->
                @endif
                @if(strcmp(\Session::get('categoria')[0],'TRABAJADOR_SPR')==0)
                  <li><a class="" href="/listado/nuevas">Nuevas (SPR)</a></li>
                  <li><a class="" href="/listado/en_proceso">En Proceso (CGA)</a></li>
                  <li><a class="" href="/listado/por_revisar">Por Revisar (SPR)</a></li>
                  <li><a class="" href="/listado/revisadas">Para Autorizar (SPR)</a></li>
                @endif
              </ul>
            </li>
          @endif
          @if(strcmp(\Session::get('categoria')[0],'TITULAR')==0)
          <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="icon_document_alt"></i>
              <span>Solicitudes</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="/listado/dependencia">Listado</a></li>
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