@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Administrar cursos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            @can('crear-cursos')
                                <a class="btn btn-warning" href="{{ route('curso.create') }}">Nuevo</a>
                            @endcan

                           {{--  Tabla  --}}

                           <table class="table table-striped mt-2">
                            <thead style="background-color: #6777ef">
                                <th style="color: #fff">Cursos</th>
                                <th style="color: #fff">Acciones</th>
                            </thead>
                          <tbody>
                                @foreach ($cursos as $curso)
                                <tr>
                                    <td>{{$curso->name}}</td>
                                    <td>
                                        @can('editar-cursos')
                                        <a class="btn btn-primary" href="{{ route('curso.edit', $curso->id)}}"><i class=" fas fa-edit"></i></a>
                                        @endcan

                                        @can('borrar-cursos')
                                        {!! Form::open(['method'=>'DELETE', 'route'=>['curso.destroy', $curso->id], 'style'=>'display:inline']) !!}
                                        {!! Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                           </table>
                           <div class="pagination justify-content-end">
                            {!! $cursos->links() !!}
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
