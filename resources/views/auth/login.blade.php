<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@extends('layouts.auth_app')
@section('title')
    Iniciar sesión
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>Inicio de sesión</h4></div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input aria-describedby="emailHelpBlock" id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           placeholder="Ingrese su correo electrónico" tabindex="1"
                           value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}" autofocus
                           required>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>

                 <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Contraseña</label>
                        <div class="float-right">
                            <a href="{{ route('password.request') }}" class="text-small">
                                ¿Has olvidado tu contraseña?
                            </a>
                        </div>
                    </div>

                <div class="input-group">
                    <input aria-describedby="passwordHelpBlock" id="password" type="password"
                           value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"
                           placeholder="Ingrese su contraseña"
                           class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password"
                           tabindex="2" required>
                    {{--   AQUI VA EL OJO  --}}
                        <div class="input-group-append">
                              <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                        </div>



                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                 </div>


                <script type="text/javascript">
                    function mostrarPassword(){
                            var cambio = document.getElementById("password");
                            if(cambio.type == "password"){
                                cambio.type = "text";
                                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                            }else{
                                cambio.type = "password";
                                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                            }
                        }

                        $(document).ready(function () {
                        $('#ShowPassword').click(function () {
                            $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
                        });
                    });
                    </script>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                               id="remember"{{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">Recuérdame</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Ingresar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
