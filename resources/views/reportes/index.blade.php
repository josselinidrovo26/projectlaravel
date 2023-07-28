 @extends('layouts.app')

    @section('content')

    <section class="section">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
       {{--  Descargar reportes --}}
       <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.10.2/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.10.2/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.19/jspdf.plugin.autotable.min.js"></script>



        <div class="section-header">
            <h3 class="page__heading">Reporte de pagos</h3>
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



                                    <div class="table-responsive">
                                        <table>
                                            <tr>
                                                <p>Selecciona un evento para filtrar:</p>
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
                                                <button type="button" id="filtrarButton" class="btn btn-primary">Filtrar</button>
                                                </td>


                                            </tr>
                                        </table>


                                        <script>
                                              $(document).ready(function() {
                                                // Evento para el botón "Filtrar"
                                                $('#filtrarButton').click(function() {
                                                    var selectedEvento = $('#evento').val();

                                                    // Realiza la llamada AJAX para obtener los pagos filtrados
                                                    $.ajax({
                                                        url: '{{ route("reportes.filtrar") }}',
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        data: { evento: selectedEvento },
                                                        success: function(response) {
                                                            // Actualiza la tabla con los pagos filtrados
                                                            actualizarTabla(response);

                                                            // Muestra la tabla después de filtrar
                                                            $('#detallesTable').show();

                                                            // Obtiene y actualiza la cuota del evento seleccionado
                                                            var selectedEventoTitle = $('#evento option:selected').text();
                                                            obtenerCuotaEvento(selectedEventoTitle);
                                                            // Calcular el "Total a recolectar" basado en los estudiantes únicos y el valor de la cuota del evento seleccionado
                                                            calcularTotalRecolectar();
                                                        }
                                                    });
                                                });

                                                // Evento para el botón de búsqueda
            $('#buscarButton').click(function() {
                var searchQuery = $('#elemento').val();

                // Realiza la llamada AJAX para buscar los registros
                $.ajax({
                    url: '{{ route("reportes.buscar") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { query: searchQuery },
                    success: function(response) {
                        // Actualiza la tabla con los registros encontrados
                        actualizarTabla(response);

                        // Muestra la tabla después de la búsqueda
                        $('#detallesTable').show();
                    }
                });
            });

                                                function actualizarTabla(pagos) {
                                                    var tableBody = $('#detallesTable tbody');
                                                    tableBody.empty();


                                                    pagos.forEach(function(pago) {
                                                        var row = '<tr>' +
                                                            '<td>' + pago.estudiante_id + '</td>' +
                                                            '<td>' + pago.estudiante.persona.cedula + '</td>' +
                                                            '<td>' + pago.estudiante.persona.nombre + '</td>' +
                                                            '<td>$' + pago.abono + '</td>' +
                                                            '<td>$' + pago.diferencia + '</td>' +
                                                            '<td>' + pago.estado + '</td>' +
                                                            '<td>' + pago.blog.cuota + '</td>' +
                                                            '<td><form action="{{ route('reportes.destroy', ':id') }}" method="POST">' +
                                                            '@csrf' +
                                                            '@method('DELETE')' +
                                                            '@can('borrar-pago')' +
                                                            '<button type="submit" class="btn btn-danger btn-delete" data-pago-id="' + pago.id + '"><i class="fas fa-trash"></i></button>' +
                                                            '@endcan' +
                                                            '</form></td>' +
                                                            '</tr>';

                                                        tableBody.append(row);
                                                    });
                                                }

                                                function obtenerCuotaEvento(titulo) {
                                                    // Hacer una llamada AJAX para obtener la cuota del evento seleccionado
                                                    $.ajax({
                                                        url: '{{ route("reportes.obtenerCuotaEvento") }}',
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        data: { titulo: titulo },
                                                        success: function(response) {
                                                            // Una vez que se obtenga la respuesta, calcular el "Total a recolectar" con la cuota obtenida
                                                            var cuotaEvento = parseFloat(response.cuota);
                                                            calcularTotalRecolectar(cuotaEvento);
                                                        }
                                                    });
                                                }

                                                // Función para calcular el "Total a recolectar" basado en los estudiantes únicos y el valor de la cuota del evento seleccionado
                                                function calcularTotalRecolectar() {
                                                    var estudiantesUnicos = {};
                                                    var totalRecolectar = 0;

                                                    $('#detallesTable tbody tr').each(function() {
                                                        var estudianteId = $(this).find('td:nth-child(1)').text();
                                                        if (!estudiantesUnicos[estudianteId]) {
                                                            estudiantesUnicos[estudianteId] = true;
                                                            totalRecolectar += parseFloat($(this).find('td:nth-child(7)').text());
                                                        }
                                                    });

                                                    // Actualizar el elemento en la página con el resultado
                                                    $('#totalRecolectar').text('$' + totalRecolectar.toFixed(2));
                                                }
                                            });


                                        </script>


                                        <!-- Script para obtener la cuota del evento seleccionado -->
                                        <script>
                                             $(document).ready(function() {
                                            $('#evento').change(function() {
                                                var selectedEventoTitle = $(this).find(':selected').text();
                                                $('#eventoSeleccionado').text(selectedEventoTitle);
                                                var selectedEvento = $(this).val();
                                                obtenerCuota(selectedEvento);
                                            });


                                                function obtenerCuota(evento) {
                                                    $.ajax({
                                                        url: '{{ route("pagos.obtenerCuota") }}',
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        data: { evento: evento },
                                                        success: function(response) {
                                                            $('#cuota').val(response.cuota);
                                                        }
                                                    });
                                                }
                                            });
                                        </script>




                                    </div>


                                <table>
                                    <tr>

                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="elemento">Buscar por elemento:</label>
                                                    <div class="input-group">
                                                        <input type="text" name="elemento" id="elemento" class="form-control">
                                                        @error('elemento')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-primary" id="buscarButton">
                                                                <i class="fas fa-search"></i> <!-- Icono de lupa de Font Awesome -->
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>




                                                <td>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="estado">Buscar por estado:</label>
                                                            <select class="class-cuota form-control" name="estado" id="estado">
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
                                            <input type="hidden" name="estudiante_id" value="{{ $user->persona->estudiante->id }}">
                                        @endif

                                        </td>



                                    </tr>
                                </table>

                        </div>
                    </div>
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="btn-container">
                                <button id="descargarPDFButton">Descargar PDF</button>
                                <button id="descargarExcelButton">Descargar Excel</button>
                            </div><br><br>
                            <div class="table-responsive" id="contenidotabla">
                                <h5 class="card-title">Evento:  <span id="eventoSeleccionado"></span></h5>



                                <script>
                                    $(document).ready(function() {
                                        $('#curso').change(function() {
                                            var periodo = $('#periodo').val();
                                            var curso = $(this).val();

                                            if (periodo && curso) {
                                                $.ajax({
                                                    url: "{{ route('reportes.getEvents') }}",
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
                                                            eventoSelect.append('<option value="' + id + '">' + titulo + '</option>');
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
                                                    url: "{{ route('reportes.getEvents') }}",
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
                                                            eventoSelect.append('<option value="' + id + '">' + titulo + '</option>');
                                                        });
                                                    }
                                                });
                                            } else {
                                                var eventoSelect = $('#evento');
                                                eventoSelect.empty();
                                                eventoSelect.append('<option value="">Seleccionar evento</option>');
                                            }
                                        });
                                    });
                                </script>

                                <div id="sumContainer">
                                    <p>Total a recolectar: <span id="totalRecolectar">$0.00</span></p>
                                    <p>Total pagado:</p>
                                    <ul id="sumList"></ul>
                                </div>





                                <table class="table table-striped" id="detallesTable">
                                    <thead>
                                        <tr>
                                         <th>ID</th>
                                          <th>Cédula</th>
                                            <th>Estudiante</th>
                                            <th>Abono</th>
                                            <th>Diferencia</th>
                                            <th>Estado</th>
                                            <th>Total</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     {{--  Descargar reportes --}}
     <script>
        document.getElementById('descargarPDFButton').addEventListener('click', function() {
        imprimirTabla();
    });

    function imprimirTabla() {
        var tablaContenido = document.getElementById('contenidotabla');
        var eventoSeleccionado = document.getElementById('eventoSeleccionado').innerText;
        var win = window.open('', '', 'width=800, height=600');
        filename: 'reporte_' + eventoSeleccionado + '.pdf',
        win.document.write('<html><head><title>Reporte</title></head><body>');
        win.document.write('<h3>Evento: ' + document.getElementById('eventoSeleccionado').innerText + '</h3>');
        win.document.write(tablaContenido.outerHTML);
        win.document.write('</body></html>');
        win.document.close();
        win.print();
        win.close();

        // Crea el PDF con el contenido de la tabla
        html2pdf().from(tablaContenido).set(options).save();
    }


    function descargarExcel() {
        var tablaContenido = document.getElementById('contenidotabla');
        var wb = XLSX.utils.table_to_book(tablaContenido);
        XLSX.writeFile(wb, 'reporte.xlsx');
    }

    // Evento para el botón de descarga de Excel (si se desea mantener)
    document.getElementById('descargarExcelButton').addEventListener('click', function() {
        descargarExcel();
    });
    </script>






    @endsection

    <style>
        #detallesTable {
            display: none;
        }

       /* Estilo para el estado "Pendiente" */
    .estado-pendiente {
        background-color: blue;
        color: white;
    }

    /* Estilo para el estado "Pagado" */
    .estado-pagado {
        background-color: green;
        color: white;
    }

    /* Estilo para el estado "No Pagado" */
    .estado-no-pagado {
        background-color: red;
        color: white;
    }



     .btn-container {
                margin-top: 20px;
            }

            .btn-container button {
                padding: 10px 20px;
                border-radius: 4px;
                font-size: 16px;
                font-weight: bold;
                color: #fff;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .btn-container button:nth-child(1) {
                background-color: #dc3545; /* Rojo */
            }

            .btn-container button:nth-child(1):hover {
                background-color: #c82333;
            }

            .btn-container button:nth-child(2) {
                background-color: #28a745; /* Verde */
            }

            .btn-container button:nth-child(2):hover {
                background-color: #218838;
            .btn-container {
                margin-top: 20px;
            }



            .btn-container button:first-child {
                margin-right: 10px;
            }


            .filter-container {
                margin-top: 20px;
            }

            .filter-container label {
                font-weight: bold;
            }

            .filter-container input {
                margin-top: 5px;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            .filter-container button {
                padding: 10px 20px;
                border-radius: 4px;
                font-size: 16px;
                font-weight: bold;
                color: #fff;
                background-color: #007bff;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .filter-container button:hover {
                background-color: #0056b3;
            }

    </style>
