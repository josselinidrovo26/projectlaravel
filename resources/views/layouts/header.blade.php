
<!-- Código HTML existente -->
<form class="form-inline mr-auto" action="#">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
</form>
<a id="campana" data-toggle="modal" data-target="#notificationModal" class="nav-link dropdown-toggle nav-link-lg nav-link-bell"><i class="fas fa-bell"></i></a>
<ul class="navbar-nav navbar-right">

    @if(\Illuminate\Support\Facades\Auth::user())
        <li class="dropdown">

            <a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/logo.png') }}"
                     class="rounded-circle mr-1 thumbnail-rounded user-thumbnail ">
                <div class="d-sm-none d-lg-inline-block">
                    Hola, {{ explode(' ', \Illuminate\Support\Facades\Auth::user()->persona->nombre)[0] }}
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-title">
                        Bienvenido, {{ \Illuminate\Support\Facades\Auth::user()->persona->nombre }}
                    </div>

                    <div class="dropdown-title blue-text">
                        >>{{ \Illuminate\Support\Facades\Auth::user()->persona->rol }}<<
                    </div>



                  {{--   <a class="dropdown-item has-icon edit-profile" href="#" data-id="{{ \Auth::id() }}"> --}}

                 {{--    <i class="fa fa-user"></i>Editar perfil</a> --}}
                <a class="dropdown-item has-icon" data-toggle="modal" data-target="#changePasswordModal" href="#" data-id="{{ \Auth::id() }}"><i
                            class="fa fa-lock"> </i>Cambiar contraseña</a>
                <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"
                   onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    @else
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                {{--                <img alt="image" src="#" class="rounded-circle mr-1">--}}
                <div class="d-sm-none d-lg-inline-block">{{ __('messages.common.hello') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ __('messages.common.login') }}
                    / {{ __('messages.common.register') }}</div>
                <a href="{{ route('login') }}" class="dropdown-item has-icon">
                    <i class="fas fa-sign-in-alt"></i> {{ __('messages.common.login') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('register') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-plus"></i> {{ __('messages.common.register') }}
                </a>
            </div>
        </li>
    @endif
</ul>


<!-- Notification Modal -->
<div class="modal" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">

                <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            <div class="modal-body ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                <p class="text-white"><strong></strong> <span id="notificationTitle"></span></p>
                <p class="text-white"><strong>Cuota:</strong> <span id="notificationCuota"></span></p>
                <p class="text-white"><strong>Pagar hasta:</strong> <span id="notificationPago"></span></p>
                    </div>
                </div>
            </div>
            </div>

        </div>
    </div>
</div>





<script>
    function showNotification() {
        // Realizar una petición al servidor para obtener los datos del último blog
        fetch('/api/latest-blog')
            .then(response => response.json())
            .then(data => {
                // Obtener los datos del blog
                const blog = data;

                // Actualizar los valores en la ventana flotante de notificación
                document.getElementById("notificationTitle").innerText = blog.titulo;
                document.getElementById("notificationCuota").innerText = blog.cuota;
                document.getElementById("notificationPago").innerText = blog.pago;

                // Agregar la clase CSS para el nuevo color a la ventana modal
                $('#notificationModal .modal-content').addClass('modal-color2');

                // Mostrar la ventana flotante de notificación
                $('#notificationModal').modal('show');
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                // Eliminar la clase CSS para restaurar el color original de la ventana modal
                $('#notificationModal .modal-content').removeClass('modal-color2');
            });
    }

    // Agregar un evento de clic al icono de campana para mostrar el modal de notificación
    document.querySelector('.nav-link-bell').addEventListener('click', showNotification);
</script>





