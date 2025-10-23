@props(['user'])
<nav class="navbar header-navbar pcoded-header">

    <div class="navbar-wrapper">

        <div class="navbar-logo d-flex align-items-center">
            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse">
                <i class="ti-menu"></i>
            </a>
            <img class="img-fluid" src="{{ asset('images/logo.png') }}" height="40px" width="40px" />
            <a class="waves-effect waves-light ms-2">
                <span>ALUVID Ixmiquilpan</span>
            </a>
        </div>

        <div class="navbar-container container-fluid">

            <ul class="nav-left">
                <li>
                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                </li>
            </ul>

            <ul class="nav-right">
                <li class="header-notification">
                    <a href="#!" id="campanaNotificaciones" class="waves-effect waves-light"
                        style="text-decoration: none;">
                        <i id="iconoCampana"
                            class="bi bi-bell-fill {{ auth()->user()->unreadNotifications->count() ? 'text-danger' : '' }}"></i>
                    </a>

                    <ul class="show-notification">
                        @php
                            $notificaciones = auth()
                                ->user()
                                ->unreadNotifications->filter(
                                    fn($n) => $n->type === App\Notifications\Inventario::class,
                                );
                        @endphp

                        @forelse($notificaciones as $noti)
                            <li class="waves-effect waves-light noti-item" data-id="{{ $noti->id }}">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="notification-user">{{ $noti->data['mensaje'] }}</h5>
                                        <p class="notification-msg">
                                            Categoría: {{ $noti->data['categoria'] }}<br>
                                            @if ($noti->data['categoria'] === 'Vidrios')
                                                Producto: {{ $noti->data['tonalidad'] ?? 'N/A' }}
                                                {{ $noti->data['mm'] ?? 'N/A' }} mm<br>
                                            @else
                                                Producto: {{ $noti->data['producto'] ?? 'N/A' }}<br>
                                            @endif
                                            {{ \Carbon\Carbon::parse($noti->data['fecha'])->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="waves-effect waves-light">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="notification-msg">No hay notificaciones nuevas</p>
                                    </div>
                                </div>
                            </li>
                        @endforelse

                    </ul>
                </li>


                <li class="user-profile header-notification">

                    <a href="#!" class="waves-effect waves-light" style="text-decoration: none;">
                        <span>
                            {{ $user && $user->role === 2 ? 'Colaborador' : 'Usuario' }}
                        </span>
                        <i class="ti-angle-down"></i>
                    </a>

                    <ul class="show-notification profile-notification">
                        <li class="waves-effect waves-light" style="text-decoration: none;">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                style="text-decoration: none;">
                                <i class="ti-layout-sidebar-left"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>

                </li>

            </ul>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const badge = document.getElementById('contadorNotificaciones');
                    const notificationList = document.querySelector('.header-notification .show-notification');

                    notificationList.addEventListener('click', function(e) {
                        let li = e.target.closest('.noti-item');
                        if (!li) return;

                        const notiId = li.getAttribute('data-id');

                        fetch(`/notificaciones/inventario/${notiId}/leer`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    // Quitar la notificación del DOM
                                    li.remove();

                                    // Verifica si ya no queda ninguna
                                    const remainingItems = notificationList.querySelectorAll('.noti-item');

                                    if (remainingItems.length === 0) {
                                        // Reemplaza por mensaje vacío
                                        notificationList.innerHTML = `
                <li class="waves-effect waves-light">
                    <div class="media">
                        <div class="media-body">
                            <p class="notification-msg">No hay notificaciones nuevas.</p>
                        </div>
                    </div>
                </li>
            `;

                                        const bellIcon = document.querySelector('#campanaNotificaciones i');
                                        if (remainingItems.length === 0) {

                                            notificationList.innerHTML = `...`;

                                            if (bellIcon) bellIcon.classList.remove('text-danger');

                                        } else {
                                            if (bellIcon) bellIcon.classList.add('text-danger');
                                        }

                                        if (bellIcon) {
                                            bellIcon.classList.remove('animated', 'infinite',
                                                'bounce');
                                        }
                                    }
                                } else {
                                    alert('No se pudo marcar la notificación como leída.');
                                }
                            })
                            .catch(error => {
                                console.error('Error al marcar como leída:', error);
                            });
                    });
                });
            </script>
        </div>

    </div>

</nav>
