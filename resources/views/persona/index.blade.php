@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Eventos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">

                            @can('crear-blog')
                                <a class="btn btn-warning" href="{{ route('blogs.create') }}">Nuevo</a>
                            @endcan

                           {{--  Tabla  --}}
                           <div class="table-responsive">

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
                                    <td style="display: none;">{{ $blog->id}}</td>
                                    <td>{{ $blog->titulo }}</td>
                                    <td>{{ $blog->contenido }}</td>
                                    <td>{{ $blog->cuota }}</td>
                                    <td>{{ $blog->pago }}</td>

                                    <td>
                                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST">
                                        @can('editar-blog')
                                        <a class="btn btn-info" href="{{ route('blogs.edit', $blog->id)}}"><i class=" fas fa-edit"></i></a>
                                        @endcan

                                        @csrf

                                        @method('DELETE')
                                        @can('borrar-blog')
                                       <button type="submit" class="btn btn-danger"><i class=" fas fa-trash"></i></button>
                                        @endcan
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                           </table>
                        </div>

                           <div class="pagination justify-content-end">
                            {!! $blogs->links() !!}

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
