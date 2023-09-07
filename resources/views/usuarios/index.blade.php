
@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Usuarios</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">


                            @can('crear-usuario')
                         {{--  <a class="btn btn-warning" href="{{ route('usuarios.create') }}">Nuevo</a><br><br> --}}
                          @endcan
                           {{--BOTON BUSCAR --}}
                           <div class="input-group mb-3">
                            <input type="text" class="smaller-input" placeholder="Buscar" id="my-input">
                        </div>


                          <div class="table-responsive">
                            <table class="table table-striped mt-2">
                              <thead style="background-color:#6777ef">
                                  <th style="display: none;">ID</th>
                                  <th style="color:#fff;">Cédula</th>
                                  <th style="color:#fff;">Nombre</th>
                                  <th style="color:#fff;">Correo electrónico</th>
                                  <th style="color:#fff;">Rol</th>
                                  <th style="color:#fff;">Acciones</th>
                              </thead>
                              <tbody>
                                @foreach ($usuarios->where('persona.rol', '!=', 'ESTUDIANTE') as $usuario)
                                <tr class="usuario-row">
                                      <td style="display: none;">{{ $usuario->id }}</td>
                                      @if ($usuario->persona)
                                      <td>{{ $usuario->persona->cedula }}</td>
                                      <td>{{ $usuario->persona->nombre }}</td>
                                      @endif
                                      <td>{{ $usuario->email }}</td>
                                      <td>{{ optional($usuario->persona)->rol }}</td>
                                      <td>
                                          @can('editar-usuario')
                                          <a class="btn btn-primary" href="{{ route('usuarios.edit', $usuario->id)}}"><i class="fas fa-edit"></i></a>
                                          @endcan
                                          @csrf
                                          @method('DELETE')
                                          @can('borrar-usuario')
                                          {!! Form::open(['method' => 'DELETE','route' => ['usuarios.destroy', $usuario->id],'style'=>'display:inline']) !!}
                                          {!! Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                          {!! Form::close() !!}
                                          @endcan
                                      </td>
                                  </tr>
                                  @endforeach
                              </tbody>
                            </table>
                            <!-- Centramos la paginacion a la derecha -->
                          <div class="pagination justify-content-end">
                            {!! $usuarios->links() !!}
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



