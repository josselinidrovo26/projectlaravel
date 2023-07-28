@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Evento</h3>
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

                           <form action="{{ route('blogs.update', $blog->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="titulo">Título</label>
                                       <input type="text" name="titulo" class="form-control" value="{{ $blog->titulo }}">
                                    </div>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-floating">
                                    <label for="contenido">Descripción</label>
                                    <textarea class="form-control" name="contenido" style="height: 100px">{{  $blog->contenido}}</textarea>
                                    </div><br>
                                </div>

                                <table>
                                    <tr>
                                        {{-- <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="cuota">Cuota $</label>
                                                <input class="class-cuota" name="cuota" type="text" value="{{ $blog->cuota }}" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">

                                                </div>
                                            </div>
                                        </td> --}}


                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="pago">Pagar hasta</label>
                                                <input class="class-cuota" name="pago" type="date" value="{{ $blog->pago }}" min="today">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                </table>



                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <center>
                                    <button type="submit" class="btn btn-primary">Guardar</button>

                                    <button type="reset" class="btn btn-danger" onclick="/blogs" >Cancelar</button>
                                    </center>

                                </div><br><br><br>

                               {{--  <div class="col-xs-12 col-sm-12 col-md-12">
                                <center><a href="#">No deseo participar en este evento</a></center>
                                </div> --}}
                            </div>

                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
