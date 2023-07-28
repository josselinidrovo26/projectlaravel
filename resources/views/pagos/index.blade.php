@extends('layouts.app')

@section('content')

<section class="section">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <div class="section-header">
        <h3 class="page__heading">Registro de pagos</h3>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <strong>Revise los campos!</strong>
                            @foreach ($errors->all() as $error)
                            <span class="badge badge-danger">{{ $error }}</span>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <form action="{{ route('pagos.store')}}" method="POST">
                            @csrf

                            <div class="table-responsive">
                                <table>
                                    <tr>
                                        <p>Datos del evento:</p>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="periodo">Periodo</label>
                                                    <select class="form-control" id="periodo" name="periodo">
                                                        <option value="">Seleccionar periodo</option>
                                                        @foreach ($periodos as $periodo)
                                                        <option value="{{ $periodo }}">{{ $periodo }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="curso">Curso</label>
                                                    <select class="form-control" id="curso" name="curso">
                                                        <option value="">Seleccionar curso</option>
                                                        @foreach ($cursos as $curso)
                                                        <option value="{{ $curso }}">{{ $curso }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="titulo">Evento</label>
                                                    <select class="form-control" name="titulo" id="evento" required>
                                                        <option value="">Seleccione un evento</option>
                                                        @foreach ($blogs as $id => $titulo)
                                                        <option value="{{ $id }}">{{ $titulo }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <!-- Input de Total a pagar -->
                                                <div class="form-group">
                                                    <label for="cuota">Total a pagar:</label>
                                                    <input type="text" class="form-control" name="cuota" id="cuota"
                                                        readonly>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <!-- Script para obtener la cuota del evento seleccionado -->
                                <script>
                                    $(document).ready(function() {
                                        $('#evento').change(function() {
                                            var selectedEvento = $(this).val();
                                            obtenerCuota(selectedEvento);
                                        });

                                        function obtenerCuota(evento) {
                                            $.ajax({
                                                url: '{{ route("pagos.obtenerCuota") }}',
                                                type: 'POST',
                                                dataType: 'json',
                                                data: {
                                                    evento: evento
                                                },
                                                success: function(response) {
                                                    $('#cuota').val(response.cuota);
                                                }
                                            });
                                        }
                                    });
                                </script>

                                    <table>
                                        <tr>
                                            <p>Datos del estudiante:</p>
                                            <td>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="cedula">Cédula estudiante</label>
                                                        <input type="text" id="cedula" class="form-control" name="cedula" placeholder="Ingrese la cédula">
                                                        @error('cedula')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div id="estudiante-info" class="text-danger"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <button wire:click="consultarEstudiante" type="button" id="btnConsultar">Consultar estudiante</button>
                                            </td>
                                            <td>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="nombre">Nombre estudiante</label>
                                                        <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Nombre del estudiante">
                                                        <div id="estudiante-info-msg"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>


                                <table>
                                    <tr>
                                        <p>Datos del pago:</p>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="abono">Abono</label>
                                                    <input type="number" name="abono"
                                                        class="class-cuota">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="estado">Estado</label>
                                                    <select class="class-cuota" name="estado">
                                                        <option value="">Selecciona un estado</option>
                                                        <option value="Pendiente">Pendiente</option>
                                                        <option value="Pagado">Pagado</option>
                                                        <option value="No pagado">No pagado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>

                                            @if ($user->persona->estudiante && $user->persona->estudiante->id)
                                            <input type="hidden" name="estudiante_id"
                                                value="{{ $user->persona->estudiante->id }}">
                                            @endif
                                            <button type="submit" class="btn btn-primary">Registrar pago</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#curso').change(function() {
                    var periodo = $('#periodo').val();
                    var curso = $(this).val();

                    if (periodo && curso) {
                        $.ajax({
                            url: "{{ route('pagos.getEvents') }}",
                            type: "POST",
                            data: {
                                periodo: periodo,
                                curso: curso
                            },
                            success: function(response) {
                                var events = response;
                                var eventoSelect = $('#evento');
                                eventoSelect.empty();
                                eventoSelect.append('<option value="">Seleccionar evento</option>');
                                $.each(events, function(id, titulo) {
                                    eventoSelect.append('<option value="' + id + '">' + titulo +
                                        '</option>');
                                });
                            }
                        });
                    } else {
                        var eventoSelect = $('#evento');
                        eventoSelect.empty();
                        eventoSelect.append('<option value="">Seleccionar evento</option>');
                    }
                });

                $('#periodo').change(function() {
                    var curso = $('#curso').val();
                    var periodo = $(this).val();

                    if (curso && periodo) {
                        $.ajax({
                            url: "{{ route('pagos.getEvents') }}",
                            type: "POST",
                            data: {
                                periodo: periodo,
                                curso: curso
                            },
                            success: function(response) {
                                var events = response;
                                var eventoSelect = $('#evento');
                                eventoSelect.empty();
                                eventoSelect.append('<option value="">Seleccionar evento</option>');
                                $.each(events, function(id, titulo) {
                                    eventoSelect.append('<option value="' + id + '">' + titulo +
                                        '</option>');
                                });
                            }
                        });
                    } else {
                        var eventoSelect = $('#evento');
                        eventoSelect.empty();
                        eventoSelect.append('<option value="">Seleccionar evento</option>');
                    }
                });

                /* $('#cedula').on('input', function() {
                    const periodo = $('#periodo').val();
                    const curso = $('#curso').val();
                    const cedula = $(this).val();

                    if (periodo && curso && cedula) {
                        $.ajax({
                            url: "{{ route('pagos.buscarEstudiante') }}",
                            type: "POST",
                            data: {
                                periodo: periodo,
                                curso: curso,
                                cedula: cedula
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#nombre').val(response.nombre);
                                    $('#estudiante-info').text('');
                                } else {
                                    $('#nombre').val('');
                                    $('#estudiante-info').text('Estudiante no pertenece al curso o no existe');
                                }
                            }
                        });
                    } else {
                        $('#nombre').val('');
                        $('#estudiante-info').text('');
                    }
                }); */
            });

        </script>
        {{-- <script>
             $('#btnConsultar').click(function() {
                    // Obtener el valor de la cédula ingresada
                    var cedula = $('#cedula').val();

                    // Realizar la solicitud AJAX al servidor para obtener el nombre del estudiante
                    $.ajax({
                        url: '/consultar_estudiante',
                        type: 'POST',
                        data: { cedula: cedula, _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            // Si la solicitud AJAX es exitosa, actualizar el campo de nombre con la respuesta del servidor
                            $('#nombre').val(response.nombre);
                        },
                        error: function() {
                            alert('Error al consultar el estudiante. Por favor, inténtalo nuevamente.');
                        }
                    });
                });
            </script> --}}


    </div>
</section>
@endsection
