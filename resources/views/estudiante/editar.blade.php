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
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="confirm-password">Confirmar contraseña *</label>
                                    {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
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
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
