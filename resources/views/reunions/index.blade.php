@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Reuniones</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">


                            @can('crear-reunion')
                                <a class="btn btn-warning" href="{{ route('reunions.create') }}">Nuevo</a>
                            @endcan

                           {{--  Tabla  --}}
                           <div class="table-responsive">
                            @if ($reunions->isEmpty())
                            <div class="text-center">
                              <i class="fas fa-exclamation-triangle fa-2x mb-3 text-muted"></i>
                              <p class="text-muted">No existen registros de reuniones en este momento.</p>
                          </div>
                              @else

                           <table class="table table-striped mt-2">
                            <thead style="background-color: #6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color: #fff">Título</th>
                                <th style="color: #fff">Descripción</th>
                                <th style="color: #fff">Fecha</th>
                                <th style="color: #fff">Inicio</th>
                                <th style="color: #fff">Fin</th>
                                <th style="color: #fff">Enlace</th>
                                <th style="color: #fff">Participantes</th>
                                <th style="color: #fff">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($reunions as $reunion)
                                <tr>
                                    <td style="display: none;">{{ $reunion->id}}</td>
                                    <td>{{ $reunion->tituloreuniones }}</td>
                                    <td>{{ $reunion->descripcion }}</td>
                                    <td>{{ $reunion->fechareuniones }}</td>
                                    <td>{{ $reunion->inicio }}</td>
                                    <td>{{ $reunion->fin }}</td>
                                    <td> <a href="{{ $reunion->enlace }}">{{ $reunion->enlace }}</a> </td>
                                    <td>{{ $reunion->participantes }}</td>
                                   {{--  <td>{{ $reunion->modonotificar }}</td>
                                    <td>{{ $reunion->tiempo }}</td>
                                    <td>{{ $reunion->horario }}</td> --}}

                                    <td>
                                        <form action="{{ route('reunions.destroy', $reunion->id) }}" method="POST">
                                        @can('editar-blog')
                                        <a class="btn btn-info" href="{{ route('reunions.edit', $reunion->id)}}"><i class=" fas fa-edit"></i></a>
                                        @endcan

                                        @csrf

                                        @method('DELETE')
                                        @can('borrar-reunion')
                                       <button type="submit" class="btn btn-danger"><i class=" fas fa-trash"></i></button>
                                        @endcan
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                           </table>

                        </div><br>

                           <div class="pagination justify-content-end">
                            {!! $reunions->links() !!}
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
