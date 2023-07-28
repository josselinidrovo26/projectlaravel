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
                                <strong>Revise los campos!</strong>
                                @foreach ( $errors->all() as $error )
                                <span class="badge badge-danger">{{$error}}</span>
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            {{-- FILTRADOS --}}
                            <div class="filter-container">
                                <h2 class="section-title">Filtrar por fechas</h2>

                                <form {{-- action="{{ route('audits.filter') }}" --}} method="GET">
                                    <div>
                                        <label for="fecha_desde">Fecha Desde:</label>
                                        <input type="date" id="fecha_desde" name="fecha_desde"  required>
                                    </div>

                                    <div>
                                        <label for="fecha_hasta">Fecha Hasta:</label>
                                        <input type="date" id="fecha_hasta" name="fecha_hasta" required>
                                    </div>

                                    <button type="submit">Filtrar</button>
                                </form>
                            </div>

                        {{--     BOTONES DE DESCARGAS --}}
                            <div class="btn-container">
                                <button {{-- onclick="window.location.href='{{ route('audits.pdf') }}' --}}">Descargar PDF</button>
                                <button {{-- onclick="window.location.href='{{ route('audits.excel') }}' --}}">Descargar Excel</button>
                            </div>

                                <div class="container">
                                    <h2 class="section-title">Registro de Auditoría</h2>

                                    <table class="audit-table">
                                        <caption>Registro de acciones realizadas por los usuarios</caption>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Fecha y Hora de Acción</th>
                                                <th>Usuario</th>
                                                <th>Acción</th>
                                                <th>Modulo</th>
                                                <th>Interfaz</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($audits as $audit)
                                            <tr>
                                                <td>{{ $audit->id }}</td>
                                                <td>{{ $audit->fecha_hora }}</td>
                                                <td>{{ optional($audit->user)->nombre }}</td>
                                                <td>{{ $audit->codigo }}</td>
                                                <td>{{ $audit->modulo }}</td>
                                                <td>{{ $audit->interfaz }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<style>
    /* Estilos personalizados */
    .page-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .project-title {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .school-name {
        font-size: 14px;
        color: #888;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .audit-table {
        width: 100%;
        border-collapse: collapse;
    }

    .audit-table caption {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .audit-table th, .audit-table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .audit-table th {
        background-color: #f5f5f5;
    }

    .developer, .generation-date {
        font-size: 12px;
        color: #888;
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


