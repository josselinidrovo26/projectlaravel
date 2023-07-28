@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Registro de estudiantes</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          <a class="btn btn-warning" href="{{ route('estudiante.create') }}">Nuevo</a><br><br>

                           {{--BOTON BUSCAR --}}
                           <div class="input-group mb-3">
                            <input type="text" class="smaller-input" placeholder="Buscar" id="my-input">
                            {{-- <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="buscar-btn">Buscar</button>
                            </div> --}}
                        </div>


                          <div class="table-responsive">
                            <table class="table table-striped mt-2">
                              <thead style="background-color:#6777ef">
                                  <th style="color:#fff;">ID</th>
                                  <th style="color:#fff;">Cédula</th>
                                  <th style="color:#fff;">Nombre</th>
                                  <th style="color:#fff;">Correo electrónico</th>
                                  <th style="color:#fff;">Periodo</th>
                                  <th style="color:#fff;">Curso</th>
                                  <th style="color:#fff;">Acciones</th>
                              </thead>
                              <tbody>
                                @foreach ($usuarios as $usuario)
                                @if ($usuario->persona && $usuario->persona->rol === 'Estudiante')
                                <tr class="usuario-row">
                                  <td>{{ $usuario->id }}</td>
                                  <td>{{ $usuario->persona->cedula }}</td>
                                  <td>{{ $usuario->persona->nombre }}</td>
                                  <td>{{ $usuario->email }}</td>
                                  @if ($usuario->persona->estudiante)
                                  <td>{{ $usuario->persona->estudiante->periodo }}</td>
                                  <td>{{ $usuario->persona->estudiante->curso }}</td>
                                  @endif
                                  <td>

                                    @can('editar-estudiante')
                                    @if ($usuario->persona->estudiante)
                                    <a class="btn btn-primary" href="{{ route('estudiante.edit', $usuario->persona->estudiante->id) }}"><i class="fas fa-edit"></i></a>
                                    @endif
                                    @endcan

                                    @can('borrar-estudiante')
                                         @if ($usuario->persona->estudiante)
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['estudiante.destroy', $usuario->persona->estudiante->id], 'style' => 'display:inline']) !!}
                                            {!! Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @endif

                                    @endcan
                                  </td>
                                </tr>
                                @endif
                                @endforeach
                              </tbody>
                            </table>
                            <!-- Centramos la paginacion a la derecha -->
                          <div class="pagination justify-content-end">
                            {!! $estudiantes->links() !!}
                          </div>
                        </div>

                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#my-input').on('input', function() {
                var searchText = $(this).val().toLowerCase();
                $('.usuario-row').each(function() {
                    var rowData = $(this).text().toLowerCase();
                    if (rowData.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
@endsection
@endsection
