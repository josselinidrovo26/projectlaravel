@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Registro de cuentas</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">

                            @can('crear-bancos')
                                <a class="btn btn-warning" href="{{ route('bancos.create') }}">Nuevo</a>
                            @endcan

                           <div class="table-responsive">
                            @if ($bancos->isEmpty())
                            <div class="text-center">
                              <i class="fas fa-exclamation-triangle fa-2x mb-3 text-muted"></i>
                              <p class="text-muted">No existen registros de cuentas bancarias en este momento.</p>
                          </div>
                              @else

                           <table class="table table-striped mt-2">
                            <thead style="background-color: #6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color: #fff">Banco</th>
                                <th style="color: #fff">Tipo cuenta</th>
                                <th style="color: #fff">Número cuenta</th>
                                <th style="color: #fff">Nombre Beneficiario</th>
                                <th style="color: #fff">Cédula</th>
                                <th style="color: #fff">Teléfono</th>
                                <th style="color: #fff">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($bancos as $banco)
                                <tr>
                                    <td style="display: none;">{{ $banco->id}}</td>
                                    <td>{{ $banco->nombre_banco }}</td>
                                    <td>{{ $banco->Tipocuenta }}</td>
                                    <td>{{ $banco->numcuenta }}</td>
                                    <td>{{ $banco->nameUser }}</td>
                                    <td>{{ $banco->cedula }}</td>
                                    <td>{{ $banco->Telefono }}</td>
                                    <td>
                                        <form action="{{ route('bancos.destroy', $banco->id) }}" method="POST">
                                        @can('editar-bancos')
                                        <a class="btn btn-info" href="{{ route('bancos.edit', $banco->id)}}"><i class=" fas fa-edit"></i></a>
                                        @endcan

                                        @csrf

                                        @method('DELETE')
                                        @can('borrar-bancos')
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
                            {!! $bancos->links() !!}

                            </div>

                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
