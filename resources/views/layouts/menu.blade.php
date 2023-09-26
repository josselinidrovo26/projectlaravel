<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/home">
        <i class=" fas fa-building"></i><span>Inicio</span>
    </a>

    @if(Auth::user()->persona->rol === 'ADMINISTRADOR')
    <!-- Menú que solo verá el ADMINISTRADOR -->
    <a class="nav-link" href="/" data-toggle="collapse" data-target="#registro-menu" aria-expanded="false">
        <i class="fas fa-book"></i><span>Registros</span><i class="fas arrow"></i>
    </a>

    <ul class="sub-menu collapse" id="registro-menu">
        <li><a href="/usuarios"><i class="fas fa-users"></i>Usuarios</a></li>
        <li><a href="/estudiante"><i class="fas fa-user"></i>Estudiantes</a></li>
        <li><a href="/roles"><i class=" fas fa-user-lock"></i>Roles</a></li>
        <li><a href="/curso"><i class=" fas fa-folder"></i>Cursos</a></li>
        <li><a href="/periodos"><i class=" fas fa-clock"></i>Periodos</a></li>
    </ul>
@endif



    <a class="nav-link" href="/" data-toggle="collapse" data-target="#servicio-menu" aria-expanded="false">
        <i class="fas fa-blog"></i><span>Servicios</span><i class="fas arrow"></i>
    </a>
    <ul class="sub-menu collapse" id="servicio-menu">
        <li><a href="/blogs"><i class="fas fa-list"></i>Eventos</a></li>
        <li><a href="/pagos"><i class="fas fa-money-bill"></i>Pagos</a></li>

    </ul>


    <a class="nav-link" href="/biografias">
        <i class=" fas fa-icons"></i><span>Biografía</span>
    </a>

    <a class="nav-link" href="/bancos">
        <i class="fas fa-landmark"></i><span>Bancos</span>
    </a>
    <a class="nav-link" href="/reunions">
        <i class=" fas fa-video"></i><span>Reuniones</span>
    </a>
    @if(Auth::user()->persona->rol !== 'ESTUDIANTE')
    <a class="nav-link" href="/reportes">
        <i class=" fas fa-paperclip"></i><span>Reportes</span>
    </a>
    @endif
    @if(Auth::user()->persona->rol === 'ADMINISTRADOR')
    <!-- Menú de Auditoría que no verán los ESTUDIANTES -->
    <a class="nav-link" href="/auditoria">
        <i class=" fas fa-download"></i><span>Auditoría</span>
    </a>
@endif

    <a class="nav-link" href="/evento">
        <i class="fas fa-calendar"></i><span>Calendario</span>

    </a>


    <a class="nav-link" href="/configuracion">
        <i class=" fas fa-list"></i><span>Configuración</span>
    </a>
</li>

<style>
.sub-menu {
    display: none;
    padding-left: 10px;
    background-color: rgb(255, 255, 255);
}

.nav-link[aria-expanded="true"] .arrow::after {
    content: "\f107";
    float: right;
}

.nav-link[aria-expanded="false"] .arrow::after {
    content: "\f105";
}

.nav-link[aria-expanded="true"] + .sub-menu {
    display: block;
}


</style>


