<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">

        <div class="py-4"></div>

        <ul class="pcoded-item pcoded-left-item">
            <li id="inicio">
                <a href="{{ route('admin_inicio') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Inicio</span>
                </a>
            </li>
            <li>
                <a href="{{ route('usuarios') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Usuarios</span>
                </a>
            </li>
            <li>
                <a href="{{ route('vidrio') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Vidrios</span>
                </a>
            </li>
            <li class="mb-2"></li>
            <li>
                <a href="{{ route('aluminio') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Aluminios</span>
                </a>
            </li>
            <li class="mb-2"></li>
            <li>
                <a href="{{ route('herrajes') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Herrajes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ventas') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Ventas</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script src="{{ asset('js/navbar.js') }}"></script>
