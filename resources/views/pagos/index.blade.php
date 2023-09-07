@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Pagos registrados</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-2">
                                <div class="col-lg-6 d-flex justify-content-start">
                                    @can('crear-pagos')
                                    <a class="btn btn-warning mr-2" href="{{ route('pagos.create') }}">Nuevo</a>
                                    @endcan
                                    <a class="btn btn-secondary mr-2" href="{{ route('pagos.index') }}"><i class="fas fa-broom"></i> </a>
                                    <form action="{{ route('pagos.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" placeholder="Buscar por cédula" value="{{ request('search') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>



                            {{-- Tabla --}}
                            @if ($pagos->where('abono', '<>', 0)->count() > 0)
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef">
                                    <th style="color: #fff">Fecha</th>
                                    <th style="color: #fff">Cédula</th>
                                    <th style="color: #fff">Estudiante</th>
                                    <th style="color: #fff">Evento</th>
                                    <th style="color: #fff">Pagado</th>
                                    <th style="color: #fff">Por pagar</th>
                                    <th style="color: #fff">Total</th>
                                    <th style="color: #fff">Recibo</th>
                                    <th style="color: #fff">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($pagos->where('abono', '<>', 0) as $pago)
                                    <tr>
                                            @if ($pago->abono !== 0)
                                            <td>{{$pago->created_at}}</td>
                                            <td>{{ $pago->estudiante->persona->cedula }}</td>
                                            <td>{{ $pago->estudiante->persona->nombre }}</td>
                                            <td>{{$pago->blog->titulo}}</td>
                                            <td>${{$pago->abono}}</td>
                                            <td>${{ number_format($pago->diferencia, 2) }}</td>
                                            <td>${{$pago->blog->cuota}}</td>
                                            <td>
                                                {{-- BOTON DE RECIBO --}}
                                                <a class="btn btn-success btn-sm"  title="descargar recibo" href="{{ route('generar-recibo', ['pago' => $pago->id]) }}">
                                                    <i class="fas fa-file"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Acciones">
                                                    
                                                    @can('borrar-pagos')
                                                    {!! Form::open(['method'=>'DELETE', 'route'=>['pagos.destroy', $pago->id], 'style'=>'display:inline']) !!}
                                                    {!! Form::button('<i class="fas fa-trash"></i> ', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'title' => 'Eliminar Pago']) !!}
                                                    {!! Form::close() !!}
                                                    @endcan
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <div class="text-center">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-3 text-muted"></i>
                                    <p class="text-muted">No existen registros de pagos.</p>
                                </div>
                                @endif
                            <div class="pagination justify-content-end">
                                {!! $pagos->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@php
function hasPaymentsWithZeroAbono() {
    return \App\Models\Pago::where('abono', 0)->exists();
}
@endphp
