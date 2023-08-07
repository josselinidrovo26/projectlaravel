@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear cuenta</h3>
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

                           <form action="{{ route('bancos.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Banco</label>
                                       <input type="text" name="nombre_banco" class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="Tipocuenta">Tipo de cuenta</label>
                                        <select class="form-control" name="Tipocuenta">
                                            <option value="Ahorros">Ahorros</option>
                                            <option value="Corriente">Corriente</option>
                                        </select>
                                    </div>
                                    <br>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="numcuenta">Número de cuenta</label>
                                    <input class="form-control" type="text" name="numcuenta">
                                    </div><br>
                                </div>


                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                <label for="nameUser">Nombre del beneficiario</label>
                                                <input class="form-control" type="text" name="nameUser">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="cedula">Cédula del beneficiario</label>
                                                <input class="form-control" type="text" name="cedula" maxlength="10">
                                            </div>
                                        </div>





                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </center>
                        </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
