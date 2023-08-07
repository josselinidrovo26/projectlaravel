@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Auditoría</h3>
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
                                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif


                            <h2 class="section-title">Filtrar por fechas</h2>
                            <div class="filter-form">

                                <div class="form-group">
                                    <label for="fecha_desde">Fecha Desde:</label>
                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_hasta">Fecha Hasta:</label>
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" required>
                                </div>
                                    <button type="button" class="btn btn-primary btn-filter">Filtrar</button>
                                    <button type="button" class="btn btn-info btn-show-all">Todos</button>

                            </div>





                            {{-- BOTONES DE DESCARGAS --}}
                            <div class="btn-container">
                                <button id="printButton">Descargar/Imprimir</button>
                                <button id="excelButton">Descargar Excel</button>
                            </div>




                            <div class="container">
                                <h2 class="section-title">Registro de Auditoría</h2>

                                <table class="audit-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha y Hora de Acción</th>
                                            <th>Usuario</th>
                                            <th>Acción</th>
                                            <th>Módulo</th>
                                            <th>Interfaz</th>
                                            <th>Sentencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($audits as $audit)
                                        <tr>
                                            <td>{{ $audit->id }}</td>
                                            <td class="fecha-audit">{{ $audit->created_at }}</td>
                                            <td>{{ optional($audit->user)->nombre }}</td>
                                            <td>{{ $audit->codigo }}</td>
                                            <td>{{ $audit->modulo }}</td>
                                            <td>{{ $audit->interfaz }}</td>
                                            <td>{{ $audit->sentencia }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                          {{--   <div class="pagination justify-content-end">
                                {!! $audits->links() !!}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterButton = document.querySelector(".btn-filter");
        const auditTable = document.querySelector(".audit-table");
        const showAllButton = document.querySelector(".btn-show-all");
        const fechaDesdeInput = document.getElementById("fecha_desde");
        const fechaHastaInput = document.getElementById("fecha_hasta");

        filterButton.addEventListener("click", function() {
            const fechaDesdeValue = fechaDesdeInput.value;
            const fechaHastaValue = fechaHastaInput.value;

            const rows = auditTable.querySelectorAll("tbody tr");
            rows.forEach(row => {
                const fechaHoraCell = row.querySelector(".fecha-audit");
                const fechaHoraValue = fechaHoraCell.textContent;

                if (isWithinRange(fechaHoraValue, fechaDesdeValue, fechaHastaValue)) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
            });
        });

        showAllButton.addEventListener("click", function() {
            const rows = auditTable.querySelectorAll("tbody tr");
            rows.forEach(row => {
                row.style.display = "table-row";
            });
        });

        function isWithinRange(dateValue, fromDate, toDate) {
            const formattedDate = formatDate(dateValue);
            const formattedFromDate = formatDate(fromDate);
            const formattedToDate = formatDate(toDate);

            return formattedDate >= formattedFromDate && formattedDate <= formattedToDate;
        }

        function formatDate(dateValue) {
            const parts = dateValue.split("/");
            const formattedDate = `20${parts[2]}-${parts[1]}-${parts[0]}`;
            return formattedDate;
        }
    });
</script>




    </section>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.19/jspdf.plugin.autotable.min.js"></script>
<script>
      // Función para imprimir la vista previa
      function printPreview() {
            const container = document.querySelector('.container');
            const clonedContainer = container.cloneNode(true);

            // Elimina los botones de descarga antes de imprimir
            const buttons = clonedContainer.querySelectorAll('.btn-container');
            buttons.forEach(button => button.remove());

            // Abre una nueva ventana de impresión
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(clonedContainer.outerHTML);
            printWindow.document.close();

            // Espera un momento antes de imprimir para que se renderice correctamente
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 100);
        }

        // Asigna el evento al botón de imprimir
        document.getElementById('printButton').addEventListener('click', printPreview);


        function downloadExcel() {
    const table = document.querySelector('.audit-table');
    const visibleRows = Array.from(table.querySelectorAll('tbody tr')).filter(row => row.style.display !== 'none'); // Filas visibles
    const allTableData = [];

    visibleRows.forEach(row => {
        const rowData = [];
        row.querySelectorAll('td').forEach(cell => {
            rowData.push(cell.textContent);
        });
        allTableData.push(rowData);
    });

    if (allTableData.length > 0) {
        const ws = XLSX.utils.aoa_to_sheet([['ID', 'Fecha y Hora de Acción', 'Usuario', 'Acción', 'Módulo', 'Interfaz']].concat(allTableData));
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Auditoria');

        XLSX.writeFile(wb, 'reporte.xlsx');
    } else {
        alert('No hay registros visibles para descargar.');
    }
}

// Asigna el evento al botón de descarga Excel
document.getElementById('excelButton').addEventListener('click', downloadExcel);


          </script>
@endsection
<style>


    .audit-table {
        width: 100%;
        border-collapse: collapse;
    }

    .audit-table caption {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .audit-table th,
    .audit-table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .audit-table th {
        background-color: #f5f5f5;
    }

    .btn-container {
        text-align: right;
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
    }

    .btn-container button:first-child {
        margin-right: 10px;
    }

    .filter-form {
        display: flex;
        gap: 10px; /* Espacio entre los elementos */
        align-items: center; /* Alineación vertical del contenido */
    }

    .btn-filter {
        /* Estilos adicionales para el botón Filtrar */
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }

    @media print {
        /* Agrega estilos específicos para la impresión */
        .btn-container {
            display: none;
        }
    }
    .filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px; /* Añade margen inferior para separar del contenido siguiente */
    }

</style>
