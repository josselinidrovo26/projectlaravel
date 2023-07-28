@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Administrar periodos lectivos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            @can('crear-periodos')
                                <a class="btn btn-warning" href="{{ route('periodos.create') }}">Nuevo</a>
                            @endcan

                           {{--  Tabla  --}}

                           <table class="table table-striped mt-2">
                            <thead style="background-color: #6777ef">
                                <th style="color: #fff">Año lectivo</th>
                                <th style="color: #fff">Estado</th>
                                <th style="color: #fff">Vigencia Inicio</th>
                                <th style="color: #fff">Vigencia Fin</th>
                                <th style="color: #fff">Acciones</th>
                            </thead>
                          <tbody>
                                @foreach ($periodos as $periodo)
                                <tr>
                                    <td>{{$periodo->nombrePeriodo}}</td>
                                    <td>
                                        @if ($periodo->estado == 'activo')
                                        <form action="{{ route('periodos.toggle', $periodo->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" style="background-color: green; border: none; color: white; cursor: pointer;">activo</button>
                                        </form>
                                    @else
                                        <form action="{{ route('periodos.toggle', $periodo->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" style="background-color: red; border: none; color: white; cursor: pointer;">inactivo</button>
                                        </form>
                                    @endif

                                </td>
                                    <td>{{$periodo->inicioVigencia}}</td>
                                    <td>{{$periodo->finVigencia}}</td>
                                    <td>
                                        @can('editar-periodos')
                                        <a class="btn btn-primary" href="{{ route('periodos.edit', $periodo->id)}}"><i class=" fas fa-edit"></i></a>
                                        @endcan

                                        @can('borrar-periodos')
                                        {!! Form::open(['method'=>'DELETE', 'route'=>['periodos.destroy', $periodo->id], 'style'=>'display:inline']) !!}
                                        {!! Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                           </table>
                           <div class="pagination justify-content-end">
                            {!! $periodos->links() !!}
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
