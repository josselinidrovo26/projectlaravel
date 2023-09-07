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
                                @foreach ($estudiantes as $estudiante)
                                @if ($estudiante->persona && $estudiante->persona->rol === 'ESTUDIANTE')
                                <tr class="usuario-row">
                                  <td>{{ $estudiante->id }}</td>
                                  <td>{{ $estudiante->persona->cedula }}</td>
                                  <td>{{ $estudiante->persona->nombre }}</td>
                                  <td>{{ $estudiante->persona->user->email }}</td>
                                  @if ($estudiante->periodo)
                                  <td>{{ $estudiante->periodo }}</td>
                                  <td>{{ $estudiante->curso }}</td>
                                  @endif
                                  <td>
                                    <div class="btn-group" role="group" aria-label="Acciones">
                                    @can('editar-estudiante')
                                    @if ($estudiante->periodo)
                                    <a class="btn btn-primary btn-sm"   href="{{ route('estudiante.edit', $estudiante->id)}}" title = "editar estudiante"><i class="fas fa-edit"></i></a>

                                    @endif
                                    @endcan

                                    @can('borrar-estudiante')
                                         @if ($estudiante->periodo)
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['estudiante.destroy', $estudiante->id], 'style' => 'display:inline']) !!}
                                            {!! Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'title' => 'eliminar estudiante']) !!}
                                        {!! Form::close() !!}
                                    @endif

                                    @endcan
                                    </div>
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
