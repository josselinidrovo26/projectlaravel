@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear Evento</h3>
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

                           <form action="{{ route('blogs.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Título</label>
                                       <input type="text" name="titulo" class="form-control">
                                    </div>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-floating">
                                        <label for="contenido">Descripción</label>
                                    <textarea class="form-control" name="contenido" style="height: 100px"></textarea>
                                    </div><br>
                                </div>

                                <table>

                                    <tr>

                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="pago">Pagar hasta</label>
                                                   <input type="date" name="pago" class="class-cuota">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </table>

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
