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
                                        <label for="fecha">Fecha de nacimiento:</label>
                                        <input type="date" id="fecha" name="fecha" value="{{ $user->persona->fecha }}" class="form-control" max="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edad">Edad:</label>
                                        <input type="number" id="edad" name="edad" value="{{ $user->persona->edad}}" class="form-control" readonly>
                                    </div>
                                    @if (Auth::check())
                                    <button id="editarFecha" class="btn btn-primary">Editar</button>
                                    <form id="formGuardarFecha" method="POST" action="{{ route('guardarFecha') }}" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="usuario_id" value="{{ $user->id }}">
                                        <input type="hidden" name="fecha" id="fechaHidden">
                                        <input type="hidden" name="edad" id="edadHidden"> <!-- Nuevo campo de edad oculto -->
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                    </form>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // Función para calcular la edad a partir de la fecha de nacimiento
        function calcularEdad() {
            const fechaNacimiento = new Date($('#fecha').val());
            const hoy = new Date();
            let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            const mesActual = hoy.getMonth();
            const diaActual = hoy.getDate();
            const mesNacimiento = fechaNacimiento.getMonth();
            const diaNacimiento = fechaNacimiento.getDate();

            if (mesActual < mesNacimiento || (mesActual == mesNacimiento && diaActual < diaNacimiento)) {
                edad--;
            }

            $('#edad').val(edad);
        }

        // Calcular edad al cargar la página
        calcularEdad();

        // Calcular edad cada vez que se cambie la fecha
        $('#fecha').on('change', function () {
            calcularEdad();
        });

        // Habilitar edición de la edad si se hace clic en el botón "Editar"
        $('#editarEdad').on('click', function () {
            $('#edad').prop('readonly', false);
        });

          // Habilitar edición de la fecha y ocultar el botón "Editar"
        $('#editarFecha').on('click', function () {
            $('#fecha').prop('readonly', false);
            $('#editarFecha').hide();
            $('#formGuardarFecha').show();
        });

         // Al enviar el formulario para guardar los cambios, ocultar el formulario y mostrar el botón "Editar"
         $('#formGuardarFecha').on('submit', function (event) {
            event.preventDefault();
            const nuevaFecha = $('#fecha').val();
            const nuevaEdad = $('#edad').val(); // Obtener la edad actualizada
            $('#fechaHidden').val(nuevaFecha);
            $('#edadHidden').val(nuevaEdad); // Establecer el valor de la edad oculta
            $(this).hide();
            $('#editarFecha').show();
            this.submit(); // Envía el formulario al controlador
        });
    });
</script>
</section>

@endsection

<!-- Estilos CSS (Bootstrap) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
