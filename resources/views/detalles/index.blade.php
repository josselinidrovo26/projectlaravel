@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Detalles del evento</h3>
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

                            <form action="{{ route('detalles.store')}}" method="POST">

                                @csrf
                                <div class="row">
                                    <div class="table-responsive">
                                    <table>


                                        <tr>
                                            <td>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="blog_id">Código</label>
                                                        <input type="text" name="blog_id" class="class-cuota">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="actividad">Actividad</label>
                                                        <input type="text" name="actividad" class="class-cuota">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="precio">Precio</label>
                                                        <input type="number" name="precio" class="class-cuota" value="1">
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                @can('crear-detalles')
                                                <button type="submit" class="btn btn-success rounded-circle">
                                                    <i class="fas fa-plus"></i>
                                                  </button>
                                                @endcan

                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h5 class="card-title">Detalles asociados a los eventos según su código</h5>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                <div class="filter-buttons">
                                    <button class="btn btn-filter btn-all active" data-filter="all">Todos</button><br><br>
                                    <div class="custom-filter input-group">
                                      <input type="text" class="class-cuota" id="customFilterInput" placeholder="Ingrese el ID">
                                      <div class="input-group-append">
                                        <button class="btn btn-primary btn-filter" id="customFilterButton">Filtrar</button>
                                      </div>
                                    </div>
                                  </div>


                                <script>
                                   $(document).ready(function() {
                                    $('.btn-filter').on('click', function() {
                                        var filterValue = $(this).data('filter');

                                        if (filterValue === 'all') {
                                        $('tbody tr').show();
                                        } else {
                                        $('tbody tr').hide();
                                        $('tbody tr td:first-child:contains(' + filterValue + ')').parent('tr').show();
                                        }

                                        $('.btn-filter').removeClass('active');
                                        $(this).addClass('active');
                                    });

                                    $('#customFilterButton').on('click', function() {
                                        var customFilterValue = $('#customFilterInput').val().trim().toLowerCase();

                                        if (customFilterValue !== '') {
                                        $('tbody tr').each(function() {
                                            var columnValue = $(this).find('td:first-child').text().trim().toLowerCase();
                                            if (columnValue === customFilterValue) {
                                            $(this).show();
                                            } else {
                                            $(this).hide();
                                            }
                                        });
                                        } else {
                                        $('tbody tr').show();
                                        }
                                    });

                                    // Mostrar todas las filas al cargar la página
                                    $('tbody tr').show();
                                    });

                                  </script>


                            <div id="sumContainer">
                                <p>Subtotales:</p>
                                <ul id="sumList"></ul>
                            </div>

                            <table class="table table-striped" id="detallesTable">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Actividad</th>
                                        <th>Precio</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detalles as $detalle)
                                        <tr>
                                            <td>{{ $detalle->blog_id }}</td>
                                            <td>{{ $detalle->actividad }}</td>
                                            <td>${{ $detalle->precio }}</td>
                                            <td>
                                                <form action="{{ route('detalles.destroy', $detalle->id) }}" method="POST">
                                               {{--  @can('editar-detalle')
                                                <a class="btn btn-info" href="{{ route('detalles.edit', $detalle->id)}}"><i class=" fas fa-edit"></i></a>
                                                @endcan --}}

                                                @csrf

                                                @method('DELETE')
                                                @can('borrar-detalle')
                                               <button type="submit" class="btn btn-danger"><i class=" fas fa-trash"></i></button>
                                                @endcan
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <script>
                                // Obtener la tabla y los elementos de la misma
                                const table = document.getElementById("detallesTable");
                                const rows = table.getElementsByTagName("tr");

                                // Objeto para almacenar la suma del precio por blog_id
                                const sumByBlogId = {};

                                // Calcular la suma del precio por blog_id
                                for (let i = 1; i < rows.length; i++) {
                                const row = rows[i];
                                const blogId = row.cells[0].textContent;
                                const precio = parseInt(row.cells[2].textContent.replace("$", ""));

                                if (sumByBlogId[blogId]) {
                                    sumByBlogId[blogId] += precio;
                                } else {
                                    sumByBlogId[blogId] = precio;
                                }
                                }

                                // Mostrar la suma en la página
                                const sumList = document.getElementById("sumList");
                                for (const blogId in sumByBlogId) {
                                const listItem = document.createElement("li");
                                listItem.textContent = `Evento ID ${blogId}: $${sumByBlogId[blogId]}`;
                                sumList.appendChild(listItem);
                                }
                            </script>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



        <style>
            .rounded-circle {
                border-radius: 50%;
                width: 40px;
                height: 40px;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                }

                .rounded-circle i {
                font-size: 20px;
                color: white;
                }

                .filter-buttons {
                margin-bottom: 20px;
                }

                .btn-filter {
                margin-right: 10px;
                border-radius: 20px;
                padding: 6px 16px;
                }

                .btn-primary.btn-filter {
                background-color: #28a745;
                border-color: #28a745;
                }

                .btn-primary.btn-filter:hover,
                .btn-primary.btn-filter:focus {
                background-color: #218838;
                border-color: #218838;
                }


                /* Botones de filtrado */


                .btn-all.active {
                background-color: #007bff;
                color: white;
                }

                .btn-all:hover,
                .btn-all:focus {
                background-color: #0069d9;
                }

                /* Input de filtrado personalizado */
                .custom-filter {
                display: inline-flex;
                align-items: center;
                }

                .custom-filter .btn-filter {
                margin-left: 5px;
                }





        </style>



