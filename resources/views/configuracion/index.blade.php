<!-- Vista perfil.blade.php -->

@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"></h3>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Información de perfil</h5>
                                <div class="profile-details">
                                    <h2>{{ $user->persona->nombre }}</h2>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="cedula">Cédula:</label>
                                        <input type="text" id="cedula" name="cedula" value="{{ $user->persona->cedula }}" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="edad">Edad:</label>
                                        <input type="number" id="edad" name="edad" value="{{ $user->persona->edad }}" class="form-control">
                                    </div>
                                    @if (Auth::check())
                                    <button id="editarEdad" class="btn btn-primary">Editar</button>
                                    @endif
                                   {{--  <p>Fecha de Nacimiento: {{ $user->persona->fecha_nacimiento }}</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Actualizar Foto de Perfil</h5>
                                <form action="{{-- {{ route('profile.updatePicture') }} --}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="profile_picture">Seleccionar nueva foto:</label>
                                        <div class="custom-file">
                                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="custom-file-input" required>
                                            <label class="custom-file-label" for="profile_picture">Elegir archivo</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </form>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <img src="{{-- ruta de la fotografía seleccionada --}}" class="card-img-top" alt="Foto de perfil">
                            <div class="card-body">
                                <h5 class="card-title">Foto de Perfil</h5>
                                <p class="card-text">Aquí se mostrará la foto de perfil seleccionada.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Scripts -->
@if (Auth::check())
<script>
    document.getElementById("editarEdad").addEventListener("click", function() {
        document.getElementById("edad").readOnly = false;
    });
</script>
@endif

<!-- Estilos CSS (Bootstrap) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
