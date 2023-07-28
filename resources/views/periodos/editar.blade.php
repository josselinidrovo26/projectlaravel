@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar periodo lectivo</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

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

                            <form action="{{ route('periodos.update', $periodo->id)}}" method="POST">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Nombre del periodo lectivo</label>
                                            <input class="form-control" name="nombrePeriodo" type="text" value="{{ $periodo->nombrePeriodo }}">

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Fecha de inicio de vigencia</label>
                                            <input class="form-control" name="inicioVigencia" type="date" value="{{ $periodo->inicioVigencia }}">

                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                             <label for="">Fecha fin de vigencia</label>
                                            <input class="form-control" name="finVigencia" type="date" value="{{ $periodo->finVigencia }}">

                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
