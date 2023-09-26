 @extends('layouts.app')

    @section('content')

    <section class="section">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
  {{--      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.10.2/jspdf.umd.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.10.2/jspdf.umd.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.19/jspdf.plugin.autotable.min.js"></script> --}}



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
                                                $('#filtrarButton').click(function() {
                                                    var selectedEvento = $('#evento').val();

                                                    $.ajax({
                                                        url: '{{ route("reportes.filtrar") }}',
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        data: { evento: selectedEvento },
                                                        success: function(response) {
                                                            actualizarTabla(response);
                                                            $('#detallesTable').show();
                                                            var selectedEventoTitle = $('#evento option:selected').text();
                                                         obtenerCuotaEvento(selectedEventoTitle);
                                                            calcularTotalRecolectar();
                                                            calcularTotalPagado();
                                                        }
                                                    });
                                                });

                                                // Evento para el botón de búsqueda
                                                    $(document).ready(function() {

                                                        $('#buscarButton').click(function() {
                                                            var searchTerm = $('#elemento').val().toLowerCase();

                                                            $('#detallesTable tbody tr').each(function() {
                                                                var rowText = $(this).text().toLowerCase();
                                                                if (rowText.includes(searchTerm)) {
                                                                    $(this).show();
                                                                } else {
                                                                    $(this).hide();
                                                                }
                                                            });
                                                        });
                                                    });


                                                function actualizarTabla(pagos) {
                                                    var tableBody = $('#detallesTable tbody');
                                                    tableBody.empty();


                                                    pagos.forEach(function(pago) {
                                                        var fechaHoraISO = pago.created_at;
                                                        var fechaHora = new Date(fechaHoraISO);
                                                        var fechaLegible = fechaHora.toLocaleString();

                                                        var row = '<tr>' +
                                                            '<td>' + pago.estudiante_id + '</td>' +
                                                            '<td>' + pago.estudiante.persona.cedula + '</td>' +
                                                            '<td>' + pago.estudiante.persona.nombre + '</td>' +
                                                            '<td>$' + pago.abono + '</td>' +
                                                            '<td>$' + pago.diferencia + '</td>' +
                                                            '<td>' + pago.estado + '</td>' +
                                                            '<td>' + pago.blog.cuota + '</td>' +
                                                            '<td>'  + fechaLegible + '</td>' +
                                                            '</form></td>' +
                                                            '</tr>';

                                                        tableBody.append(row);
                                                    });
                                                }

                                                function obtenerCuotaEvento(titulo) {
                                                    $.ajax({
                                                        url: '{{ route("reportes.obtenerCuotaEvento") }}',
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        data: { titulo: titulo },
                                                        success: function(response) {
                                                            var cuotaEvento = parseFloat(response.cuota);
                                                            calcularTotalRecolectar(cuotaEvento);

                                                        }
                                                    });
                                                }

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

                                                    $('#totalRecolectar').text('$' + totalRecolectar.toFixed(2));
                                                }

                                                function calcularTotalPagado() {
                                                    var totalAbono = 0;

                                                    $('#detallesTable tbody tr').each(function() {
                                                        var abonoText = $(this).find('td:nth-child(4)').text();
                                                        console.log('Valor de abonoText:', abonoText);
                                                        var abono = parseFloat(abonoText.replace('$', '').trim());
                                                        console.log('Valor de abono:', abono);
                                                        totalAbono += abono;
                                                    });

                                                    console.log('Total de abonos:', totalAbono);
                                                    $('#totalPagado').text('$' + totalAbono.toFixed(2));
                                                }

                                            });


                                        </script>


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
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>




                                               {{--  <td>
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="estado">Buscar por estado:</label>
                                                            <select class="class-cuota form-control" name="estado" id="estado">
                                                                <option value="">Selecciona un estado</option>
                                                                <option value="PENDIENTE">PENDIENTE</option>
                                                                <option value="PAGADO">PAGADO</option>
                                                                <option value="NO PAGADO">NO PAGADO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td> --}}



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
                                    <p>Total pagado: <span id="totalPagado">$0.00</span></p>
                                    <ul id="sumList"></ul>
                                </div>


                                <table class="table table-striped" id="detallesTable">
                                    @if ($pagos->isEmpty())
                                    <div class="text-center">
                                      <i class="fas fa-exclamation-triangle fa-2x mb-3 text-muted"></i>
                                      <p class="text-muted">No existen registros de pagos en este momento.</p>
                                  </div>
                                      @else

                                    <thead style="background-color: #6777ef">
                                        <tr>
                                         <th style="color: #fff; font-weight: bold;">ID</th>
                                          <th style="color: #fff; font-weight: bold;">Cédula</th>
                                            <th style="color: #fff; font-weight: bold;">Estudiante</th>
                                            <th style="color:#fff; font-weight: bold;">Abono</th>
                                            <th style="color: #fff; font-weight: bold;">Diferencia</th>
                                            <th style="color: #fff; font-weight: bold;">Estado</th>
                                            <th style="color: #fff; font-weight: bold;">Total</th>
                                            <th style="color: #fff; font-weight: bold;">Fecha pago</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>

                                </table>
                                @endif
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

        var userName = "{{ \Illuminate\Support\Facades\Auth::user()->persona->nombre }}";

            var contenidoHTML = `
                <html>
                <head>
                    <title>Unidad Educativa Blanca García-Reporte de pagos</title>
                    <style>
                        table {
                            border-collapse: collapse;
                            width: 100%;
                            border: 1px solid black;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 8px;
                            text-align: left;
                        }
                        .header {
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-start;
                            margin-bottom: 20px;
                        }
                        .logo {
                            width: 100px;
                            height: auto;
                        }

                    </style>
                </head>
                <body>
                    <div class="header">
                        <p>Usuario: ${userName}</p>
                        <h1>Unidad Educativa Blanca García</h1>
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo">
                    </div>

                    ${tablaContenido.outerHTML}


                </body>
                </html>`;


            printJS({ printable: contenidoHTML, type: 'raw-html'});

            }


    function descargarExcel() {
        var tablaClonada = $('#contenidotabla').clone();
            var tablaNueva = $('<table></table>');
            tablaNueva.append('<tr><td>Total a recolectar:</td><td>' + $('#totalRecolectar').text() + '</td></tr>');
            tablaNueva.append('<tr><td>Total pagado:</td><td>' + $('#totalPagado').text() + '</td></tr>');
            tablaNueva.append(tablaClonada);
            tablaNueva.find('th').css('font-weight', 'bold');
            var wb = XLSX.utils.table_to_book(tablaNueva[0]);
            XLSX.writeFile(wb, 'Unidad Educativa Blanca García-reporte de pagos.xlsx');
    }

    document.getElementById('descargarExcelButton').addEventListener('click', function() {
        descargarExcel();
    });
    </script>






    @endsection

    <style>
        #detallesTable {
            display: none;
        }

    .estado-pendiente {
        background-color: blue;
        color: white;
    }


    .estado-pagado {
        background-color: green;
        color: white;
    }


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
                background-color: #dc3545;
            }

            .btn-container button:nth-child(1):hover {
                background-color: #c82333;
            }

            .btn-container button:nth-child(2) {
                background-color: #28a745;
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


            .bold-title {
                font-weight: bold;
            }

    </style>
