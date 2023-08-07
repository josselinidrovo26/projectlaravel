@extends('layouts.app')

@section('content')

<section class="section">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


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
                                        <tr>
                                        <p>Datos del evento:</p>

                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                            <label  for="estado">Estado:</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="estado" id="estado"  readonly>
                                            </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="diferencia">Valor pendiente:</label>
                                                    <input type="text" class="form-control" name="diferencia" id="diferencia" readonly>
                                                    <div id="estado-info-msg"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="periodo">Período</label>
                                                    <input type="text" class="form-control" id="periodo" name="periodo" readonly value="{{ $activeEventTitle }}">
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
                                                <label  for="cuota">Total a pagar:</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="cuota" id="cuota" readonly>
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
                                                        <input type="text" id="cedula" class="form-control" data-bs-toggle="tooltip" data-bs-placement="top" title="ingresar cedula" name="cedula" placeholder="Ingrese la cédula">
                                                    </div>

                                            </td>
                                            <td>
                                               {{--  BOTON PARA HACER LA BUSQUEDA POR CEDULA DEL NOMBRE DE PERSONA --}}
                                               <button type="button" class="btn btn-primary" id="btnConsultar" onclick="validar()">
                                                <i class="fas fa-search"></i>
                                            </button>


                                            </td>
                                            <td>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="nombre">Nombre estudiante</label>
                                                        <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Nombre del estudiante" readonly size="40">
                                                        <div id="estudiante-info-msg"></div>     <div id="salida"></div>

                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                    </table>

                                    <center><button type="button" class="btn btn-primary" id="btnVerificarEstado">Verificar estado</button></center>
                                <table>
                                    <tr>
                                        <p>Datos del pago:</p>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="abono">Abono:</label>
                                                    <input type="number" name="abono" class="form-control" step="0.01" inputmode="decimal" id="abono" value="1.00">
                                                </div>
                                                <div id="mensaje-pago-completo" style="display: none;">
                                                    El pago se encuentra completo
                                                </div>

                                            </div>
                                        </td>
                                        <script>
                                            $(document).ready(function() {
                                                $('#abono').on('blur', function() {
                                                    var value = parseFloat($(this).val());
                                                    if (!isNaN(value)) {
                                                        $(this).val(value.toFixed(2));
                                                    }
                                                });
                                            });
                                        </script>


                                        <td>

                                            @if ($user->persona->estudiante && $user->persona->estudiante->id)
                                            <input type="hidden" name="estudiante_id"
                                                value="{{ $user->persona->estudiante->id }}">
                                            @endif
                                            <button type="submit" class="btn btn-primary" id="btnRegistrarPago" disabled>Registrar pago</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Tabla --}}
                        @if ($pagos->where('abono', '<>', 0)->count() > 0)
                        <table class="table table-striped mt-2">
                            <thead style="background-color: #6777ef">
                                <th style="color: #fff">Fecha</th>
                                <th style="color: #fff">Cédula</th>
                                <th style="color: #fff">Estudiante</th>
                                <th style="color: #fff">Evento</th>
                                <th style="color: #fff">Pagado</th>
                                <th style="color: #fff">Por pagar</th>
                                <th style="color: #fff">Total</th>
                                <th style="color: #fff">Recibo</th>
                                <th style="color: #fff">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($pagos->where('abono', '<>', 0) as $pago)
                                <tr>
                                        @if ($pago->abono !== 0)
                                        <td>{{$pago->created_at}}</td>
                                        <td>{{ $pago->estudiante->persona->cedula }}</td>
                                        <td>{{ $pago->estudiante->persona->nombre }}</td>
                                        <td>{{$pago->blog->titulo}}</td>
                                        <td>${{$pago->abono}}</td>
                                        <td>${{ number_format($pago->diferencia, 2) }}</td>
                                        <td>${{$pago->blog->cuota}}</td>
                                        <td>
                                            {{-- BOTON DE RECIBO --}}
                                            <a class="btn btn-success btn-sm"  title="descargar recibo" href="{{ route('generar-recibo', ['pago' => $pago->id]) }}">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Acciones">
                                                @can('editar-pagos')
                                                <a class="btn btn-info btn-sm" href="{{ route('pagos.edit', $pago->id)}}" title="Editar Pago">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan
                                                @can('borrar-pagos')
                                                {!! Form::open(['method'=>'DELETE', 'route'=>['pagos.destroy', $pago->id], 'style'=>'display:inline']) !!}
                                                {!! Form::button('<i class="fas fa-trash"></i> ', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'title' => 'Eliminar Pago']) !!}
                                                {!! Form::close() !!}
                                                @endcan
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-5x mb-3 text-muted"></i>
                                <p class="text-muted">No existen registros de pagos realizados por el estudiante seleccionado.</p>
                            </div>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>









   {{--      CONSULTAR ESTUDIANTE POR CEDULA --}}
   <script>
$(document).ready(function() {
    $('#btnConsultar').click(function() {
        var cedula = $('#cedula').val();
        var cursoSeleccionado = $('#curso').val();
        var periodoSeleccionado = $('#periodo').val();

        if (cedula && cursoSeleccionado && periodoSeleccionado) {
            consultarEstudiante(cedula, cursoSeleccionado, periodoSeleccionado);
        }
    });

    function consultarEstudiante(cedula, cursoSeleccionado, periodoSeleccionado) {
        console.log("Consultando estudiante con cédula:", cedula);
        $.ajax({
            url: '{{ route("consultarEstudiante") }}',
            type: 'POST',
            dataType: 'json',
            data: {
                cedula: cedula
            },
            success: function(response) {
                console.log("Respuesta:", response);
                if (response.success) {
                    if (
                        response.curso === cursoSeleccionado &&
                        response.periodo === periodoSeleccionado
                    ) {
                        $('#nombre').val(response.nombre);
                        $('#estudiante-info-msg').html('');
                    } else {
                        $('#nombre').val('');
                        $('#estudiante-info-msg').html('La cedula ingresada no pertenece a ese curso y periodo.');
                    }
                } else {
                    $('#nombre').val('');
                    $('#estudiante-info-msg').html('Estudiante no encontrado.');
                }
            },
            error: function(xhr, status, error) {
                console.log("Error:", error);
            }
        });
    }


        /*   MOSTRAR VALOR PENDIENTE */
        $('#btnVerificarEstado').click(function() {
    var cedula = $('#cedula').val();
    var eventoSeleccionado = $('#evento').val();
    var periodoSeleccionado = $('#periodo').val();

    if (cedula && eventoSeleccionado && periodoSeleccionado) {
        verificarEstado(cedula, eventoSeleccionado);
    }
});

function verificarEstado(cedula, eventoSeleccionado) {
    $.ajax({
        url: '{{ route("verificarEstado") }}',
        type: 'POST',
        dataType: 'json',
        data: {
            cedula: cedula,
            evento: eventoSeleccionado
        },
        success: function(response) {
            if (response.success) {
                $('#diferencia').val(response.diferencia);
                $('#estado').val(response.estado); // Mostrar el valor del estado
                $('#estado-info-msg').html('');
            } else {
                $('#diferencia').val('');
                $('#estado').val(''); // Limpiar el campo estado en caso de error
                $('#estado-info-msg').html(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error:", error);
        }
    });
}

        });

        </script>


                <script>
                $(document).ready(function() {
            var selectedPeriod = '{{ $activeEventTitle }}';
            var cursoSelect = $('#curso');
            var eventoSelect = $('#evento');

            cursoSelect.change(function() {
                var periodo = selectedPeriod;
                var curso = cursoSelect.val();

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
                            eventoSelect.empty();
                            eventoSelect.append('<option value="">Seleccionar evento</option>');
                            $.each(events, function(id, titulo) {
                                eventoSelect.append('<option value="' + id + '">' + titulo +
                                    '</option>');
                            });
                            eventoSelect.prop('disabled', false);
                        }
                    });
                } else {
                    eventoSelect.empty();
                    eventoSelect.append('<option value="">Seleccionar evento</option>');
                    eventoSelect.prop('disabled', true);
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
                            eventoSelect.empty();
                            eventoSelect.append('<option value="">Seleccionar evento</option>');
                            $.each(events, function(id, titulo) {
                                eventoSelect.append('<option value="' + id + '">' + titulo +
                                    '</option>');
                            });
                            eventoSelect.prop('disabled', false);
                        }
                    });
                } else {
                    eventoSelect.empty();
                    eventoSelect.append('<option value="">Seleccionar evento</option>');
                    eventoSelect.prop('disabled', true);
                }
            });

            // Manejo inicial al cargar la página
            cursoSelect.trigger('change');
        });
            </script>


            {{-- DIGITO VERIFICADOR --}}
            <script type="text/javascript">
                function validar() {
                  var cad = document.getElementById("cedula").value.trim();
                  var total = 0;
                  var longitud = cad.length;
                  var longcheck = longitud - 1;

                  if (cad !== "" && longitud === 10){
                    for(i = 0; i < longcheck; i++){
                      if (i%2 === 0) {
                        var aux = cad.charAt(i) * 2;
                        if (aux > 9) aux -= 9;
                        total += aux;
                      } else {
                        total += parseInt(cad.charAt(i));
                      }
                    }

                    total = total % 10 ? 10 - total % 10 : 0;

                    if (cad.charAt(longitud-1) == total) {
                      document.getElementById("salida").innerHTML = ("");
                    }else{
                      document.getElementById("salida").innerHTML = ("Cedula Inválida");
                    }
                  }
                }
              </script>


             {{--  CAMPO ABONO PERMITIR REGISTRO DE PAGO --}}
              <script>
                $('#btnVerificarEstado').click(function() {
    var cedula = $('#cedula').val();
    var eventoSeleccionado = $('#evento').val();

    if (cedula && eventoSeleccionado) {
        verificarEstado(cedula, eventoSeleccionado);
    }
});

function verificarEstado(cedula, eventoSeleccionado) {
    $.ajax({
        url: '{{ route("verificarEstado") }}',
        type: 'POST',
        dataType: 'json',
        data: {
            cedula: cedula,
            evento: eventoSeleccionado
        },
        success: function(response) {
            if (response.success) {
                $('#diferencia').val(response.diferencia);
                $('#estado').val(response.estado);

                if (response.diferencia <= 0) {
                    $('#mensaje-pago-completo').show();
                    $('#btnRegistrarPago').prop('disabled', true);
                } else {
                    $('#mensaje-pago-completo').hide();
                    $('#btnRegistrarPago').prop('disabled', false);
                }

                $('#estado-info-msg').html('');
            } else {
                $('#diferencia').val('');
                $('#estado').val('');
                $('#estado-info-msg').html(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error:", error);
        }
    });
}


              </script>



            <style>
                #estudiante-info-msg, #salida {
                    color: red;
                }
            </style>




    </div>
</section>
@endsection
