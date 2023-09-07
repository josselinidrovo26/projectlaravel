

<form class="form-inline mr-auto" action="#">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>


    <div class="modal fade" id="notificationCustomModal" role="dialog" aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="custom-modal-content">
                <button type="button" class="custom-modal-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <p class="custom-modal-title">
                                    <i class="fas fa-bell custom-notification-icon"></i> <span id="customNotificationTitle"></span>
                                </p>
                                <p class="custom-modal-text"><strong>Cuota:</strong> <span id="customNotificationCuota"></span></p>
                                <p class="custom-modal-text"><strong>Pagar hasta:</strong> <span id="customNotificationPago"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>


<a id="modal" data-toggle="modal" data-target="#notificationCustomModal" class="nav-link dropdown-toggle nav-link-lg nav-link-bell">
    <i class="fas fa-bell"></i>
    <span class="notification-indicator"></span>
</a>

{{-- EN CASO DE QUE ALGO FALLE AGG LINEAS DE CSS --}}
{{--  position:fixed;top:0;left:0;z-index:1040; --}}


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


    <script>
        function showCustomNotification() {
            fetch('/api/latest-blog')
                .then(response => response.json())
                .then(data => {
                    const blog = data;

                    document.getElementById("customNotificationTitle").innerText = blog.titulo;
                    document.getElementById("customNotificationCuota").innerText = blog.cuota;
                    document.getElementById("customNotificationPago").innerText = blog.pago;

                    const hasPendingNotification = true;
                    const indicator = document.querySelector('.notification-indicator');
                    indicator.style.display = hasPendingNotification ? 'inline-block' : 'none';

                    $('#notificationCustomModal .custom-modal-content').addClass('modal-color2');

                    $('#notificationCustomModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {

                    $('#notificationCustomModal .custom-modal-content').removeClass('modal-color2');
                });
        }

        document.querySelector('.nav-link-bell').addEventListener('click', function() {
    const indicator = document.querySelector('.notification-indicator');
    indicator.style.display = 'none';

    showCustomNotification();
});

    </script>






<style>

    .custom-modal-content {
        background-color: #a2e2fb;
        border: none;
        border-radius: 10px;
    }

    .custom-modal-close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        color: #6c757d;
        background: transparent;
        border: none;
    }

    .custom-modal-title {
        font-size: 18px;
        font-weight: bold;
    }


    .custom-modal-text {
        font-size: 14px;
        margin-top: 10px;
    }


    .custom-notification-icon {
        font-size: 24px;
        color: #ff9f43;
        margin-right: 10px;
    }


    .custom-user-thumbnail {
        width: 40px;
        height: 40px;
    }


    .custom-dropdown-menu {
        border: none;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }


    .custom-dropdown-item {
        font-size: 14px;
    }

    .notification-indicator {
    display: inline-block;
    width: 6px;
    height: 6px;
    background-color: red;
    border-radius: 50%;
    position: flex;
    top: 10px;
    right: 2px;
}


</style>
