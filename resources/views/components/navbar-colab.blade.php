<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">

        <div class="py-4"></div>

        <ul class="pcoded-item pcoded-left-item">
            <li>
                <a href="{{ route('colab_inicio') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Inicio</span>
                </a>
            </li>
            <li>
                <a href="{{ route('consulta_vidrio') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Vidrios</span>
                </a>
            </li>
            <li>
                <a href="{{ route('consulta_aluminio') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Aluminios</span>
                </a>
            </li>
            <li>
                <a href="{{ route('consulta_herrajes') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Herrajes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('consulta_ventas') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-control-record"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Ventas</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script src="{{ asset('js/navbar.js') }}"></script>
