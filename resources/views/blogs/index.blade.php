@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Eventos</h3>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-***" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-***" crossorigin="anonymous" />

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('alert'))
                                <div class="alert alert-danger">
                                    {{ session('alert') }}
                                </div>
                            @endif

                            @can('crear-blog')
                                <a class="btn btn-warning" href="{{ route('blogs.create') }}">Nuevo</a>
                            @endcan

                            <div class="table-responsive">
                              @if ($blogs->isEmpty())
                              <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-2x mb-3 text-muted"></i>
                                <p class="text-muted">No existen registros de pagos realizados.</p>
                            </div>
                                @else
                                    <table class="table table-striped mt-2">
                                        <thead style="background-color: #6777ef">
                                            <th style="display: none;">ID</th>
                                            <th style="color: #fff">Título</th>
                                            <th style="color: #fff">Descripción</th>
                                            <th style="color: #fff">Cuota</th>
                                            <th style="color: #fff">Pagar hasta</th>
                                            <th style="color: #fff">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($blogs as $blog)
                                                <tr>
                                                    <td style="display: none;">{{ $blog->id }}</td>
                                                    <td>{{ $blog->titulo }}</td>
                                                    <td>{{ $blog->contenido }}</td>
                                                    <td>${{ $blog->cuota }}</td>
                                                    <td>{{ $blog->pago }}</td>
                                                    <td>
                                                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
                                                            @can('editar-blog')
                                                                <a class="btn btn-info btn-sm" href="{{ route('blogs.edit', $blog->id) }}" title="editar evento"><i class="fas fa-edit"></i></a>
                                                            @endcan
                                                            @csrf
                                                            @method('DELETE')
                                                            @can('borrar-blog')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="eliminar evento"><i class="fas fa-trash"></i></button>
                                                            @endcan
                                                        </form>

                                                        <!-- Botón del modal de agregar -->
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal{{ $blog->id }}" title="agregar detalle"><i class="fas fa-plus"></i></button>


                                                        <!-- Modal -->
                                                        <div class="modal fade" id="myModal{{ $blog->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="myModalLabel">Detalles del evento</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="modal-body">
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
                                                                        <!-- Contenido del formulario del modal -->
                                                                        <form action="{{ route('detalles.store') }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                                                            <!-- Resto de los campos del formulario -->
                                                                            <div class="form-group">
                                                                                <label for="actividad">Actividad</label>
                                                                                <input type="text" name="actividad" class="form-control">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="precio">Precio</label>
                                                                                <input type="text" name="precio" id="precio" class="form-control" placeholder="___ . _ _" required>
                                                                            </div>


                                                                            <button type="submit" class="btn btn-success">Agregar</button>
                                                                        </form>
                                                                        <script>
                                                                            const precioInput = document.getElementById('precio');

                                                                            precioInput.addEventListener('input', function () {
                                                                                const input = this.value.trim();
                                                                                const regex = /^[0-9]+(\.[0-9]{0,2})?$/;
                                                                                if (!regex.test(input)) {
                                                                                    this.setCustomValidity('Ingrese un número válido');
                                                                                } else {
                                                                                    this.setCustomValidity('');
                                                                                }
                                                                            });
                                                                        </script>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- BOTON DEL MODAL PARA VER --}}
                                                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Modal2{{ $blog->id }}" title="ver detalle"><i class="fas fa-eye"></i></a>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="Modal2{{ $blog->id }}" tabindex="-1" role="dialog" aria-labelledby="Modal2Label">
                                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="Modal2Label">Resumen de detalles del evento</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body" style="max-height: 400px; overflow-y: scroll;">
                                                                        <div class="suma-precio{{ $blog->id }}">Total: ${{ number_format($blog->detalles->sum('precio'), 2) }}</div><br>


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
                                                                                @foreach ($blog->detalles as $detalle)
                                                                                <tr id="detalle-{{ $detalle->id }}">
                                                                                    <td>{{ $detalle->blog_id }}</td>
                                                                                    <td>{{ $detalle->actividad }}</td>
                                                                                    <td class="precio">${{ $detalle->precio }}</td>
                                                                                    <td>
                                                                                        <form class="form-delete-{{ $detalle->id }}" action="{{ route('detalles.destroy', $detalle->id) }}" method="POST">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            @can('borrar-detalle')
                                                                                                <button type="submit" class="btn btn-danger" onclick="eliminarDetalle('{{ $detalle->id }}', '{{ $blog->id }}')">
                                                                                                    <i class="fas fa-trash"></i>
                                                                                                </button>
                                                                                            @endcan
                                                                                        </form>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach

                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    {{--     SUMA DE PRECIOS --}}
                                                    <script>
                                                        function eliminarDetalle(event, detalleId, blogId) {
                                                            event.preventDefault();

                                                            // Send an AJAX request to delete the detail from the database
                                                            $.ajax({
                                                                url: `/detalles/${detalleId}`,
                                                                type: 'DELETE',
                                                                headers: {
                                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                },
                                                                success: function (data) {
                                                                    // On success, remove the detail row from the table
                                                                    const detalleRow = document.querySelector(`#detalle-${detalleId}`);
                                                                    detalleRow.parentNode.removeChild(detalleRow);

                                                                    // Update the total sum of prices in the modal
                                                                    const precioElement = detalleRow.querySelector('.precio');
                                                                    const precio = parseFloat(precioElement.textContent.replace('$', ''));
                                                                    const sumaPrecioElement = document.querySelector(`.suma-precio${blogId}`);
                                                                    const sumaPrecio = parseFloat(sumaPrecioElement.textContent.replace("Suma del campo 'precio': $", ''));
                                                                    sumaPrecioElement.textContent = `Suma del campo 'precio': $${sumaPrecio - precio}`;

                                                                    // Reload the current page after successful deletion
                                                                    location.reload();
                                                                },
                                                                error: function (error) {
                                                                    console.log('Error deleting detail:', error);
                                                                    alert('Error deleting detail. Please try again.');
                                                                }
                                                            });
                                                        }
                                                    </script>




                                                    @if ($user->persona->estudiante && $user->persona->estudiante->curso)

                                                       <!-- Botón de pagar -->
                                                        <a class="btn btn-warning btn-sm" href="{{ route('pasarelas.show', $blog->id) }}" title="pagar"><i class="fas fa-money-bill"></i></a>
                                                    @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pagination justify-content-end">
                                        {!! $blogs->links() !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

