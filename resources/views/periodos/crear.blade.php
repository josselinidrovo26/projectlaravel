@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear periodo lectivo</h3>
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

                            {!! Form::open(array('route'=> 'periodos.store', 'method' => 'POST')) !!}
                            <div class="row">
                            <table>
                                <tr>
                                    <td>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="">Nombre del periodo lectivo</label>
                                                {!!Form::text('nombrePeriodo', null, array('class'=>'form-control'))!!}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="">Fecha de inicio de vigencia</label>
                                                {!!Form::date('inicioVigencia', null, array('class'=>'form-control'))!!}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="">Fecha fin de vigencia</label>
                                                {!!Form::date('finVigencia', null, array('class'=>'form-control'))!!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
