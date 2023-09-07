@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar cuenta</h3>
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

                           <form action="{{ route('bancos.update', $banco->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="nombre_banco">Banco</label>
                                       <input type="text" name="nombre_banco" class="form-control" value="{{ $banco->nombre_banco }}">
                                    </div>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-floating">
                                        <label for="Tipocuenta">Tipo de cuenta</label>
                                        <select class="form-control" name="Tipocuenta">
                                            <option value="Ahorros" {{ $banco->Tipocuenta === 'Ahorros' ? 'selected' : '' }}>AHORROS</option>
                                            <option value="Corriente" {{ $banco->Tipocuenta === 'Corriente' ? 'selected' : '' }}>CORRIENTE</option>
                                        </select>
                                    </div>
                                    <br>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-floating">
                                    <label for="numcuenta">Tipo de cuenta</label>
                                    <input class="form-control" type="text" name="numcuenta" value="{{  $banco->numcuenta}}">
                                    </div><br>
                                </div>


                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="nameUser">Nombre del beneficiario $</label>
                                                <input class="form-control" name="nameUser" type="text" value="{{ $banco->nameUser }}" >

                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="cedula">Cédula del beneficiario</label>
                                                    <input class="form-control" name="cedula" type="text" value="{{ $banco->cedula }}" maxlength="10">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="cedula">Teléfono/Celular</label>
                                                    <input class="form-control" name="Telefono" type="text" value="{{ $banco->telefono }}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                        <center>
                                    <button type="submit" class="btn btn-primary">Guardar</button>

                                    <button type="reset" class="btn btn-danger" onclick="/bancos" >Cancelar</button>
                                    </center>

                                </div><br><br><br>

                            </div>

                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
