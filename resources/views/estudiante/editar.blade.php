@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar usuario</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                <strong>¡Revise los campos!</strong>
                                @foreach ($errors->all() as $error)
                                    <span class="badge badge-danger">{{ $error }}</span>
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        {!! Form::model($estudiante, ['method' => 'PATCH', 'route' => ['estudiante.update', $estudiante->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="cedula">Cédula de Identidad *</label>
                                    {!! Form::text('persona[cedula]', $estudiante->persona->cedula ?? null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre completo *</label>
                                    {!! Form::text('persona[nombre]', $estudiante->persona->nombre ?? null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="email">Correo electrónico *</label>
                                    {!! Form::text('email', $estudiante->persona->user->email ?? null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="password">Contraseña *</label>
                                        <div class="toggle-password">
                                            {!! Form::password('password', ['class' => 'form-control password-input']) !!}
                                            <span class="eye-icon">
                                                <i class="far fa-eye"></i>
                                            </span>
                                        </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="confirm_password">Confirmar contraseña *</label>
                                        <div class="toggle-password">
                                            {!! Form::password('confirm_password', ['class' => 'form-control password-input']) !!}
                                            <span class="eye-icon">
                                                <i class="far fa-eye"></i>
                                            </span>
                                        </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="periodo">Periodo *</label>
                                    {!! Form::select('estudiante[periodo]', $periodos, $estudiante->periodo ?? null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="curso">Curso *</label>
                                        {!! Form::select('estudiante[curso]', $cursos, $estudiante->curso ?? null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="rol">Rol *</label>
                                    {!! Form::select('persona[rol]', $roles, $user->persona->rol ?? null, ['class' => 'form-control']) !!}
                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
{{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>  --}}
{{--   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<script>
  $(document).ready(function () {
      $('.eye-icon').on('click', function () {
          const passwordInput = $(this).siblings('.password-input');
          const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
          passwordInput.attr('type', type);
          $(this).find('i').toggleClass('fa-eye fa-eye-slash');
      });
  });
</script>


</section>
@endsection
<style>
  .toggle-password {
      cursor: pointer;
      position: relative;
  }
  .toggle-password .eye-icon {
      position: absolute;
      right: 8px;
      top: 50%;
      transform: translateY(-50%);
  }

</style>
