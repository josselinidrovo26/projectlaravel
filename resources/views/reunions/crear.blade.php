@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear reunión</h3>
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

                           <form action="{{ route('reunions.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Título</label>
                                       <input type="text" name="tituloreuniones" class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                       <input type="text" name="descripcion" class="form-control">
                                    </div>
                                </div>



                                <table>

                                    <tr>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="fechareuniones">Fecha reunión</label>
                                                <input type="date" class="form-control" name="fechareuniones" >
                                                </div><br>
                                            </div>
                                        </td>

                                        <td>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="inicio">Inicia reunión</label>
                                               <input type="text" name="inicio" class="class-cuota" placeholder="hh:mm" >
                                            </div>
                                        </div>
                                        </td>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="fin">Finaliza reunión</label>
                                                   <input type="text" name="fin" class="class-cuota" placeholder="hh:mm" >
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="enlace">Enlace de reunión</label>
                                    <textarea class="form-control" name="enlace" placeholder="https:/..." ></textarea>
                                    </div><br>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="participantes">Participantes</label>
                                        <select class="form-control" id="participantes" name="participantes">
                                            <option value="">Seleccionar participantes</option>
                                            @foreach($cursos as $id => $nombre)
                                                <option value="{{ $id }}">{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <table>

                                    <tr>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="modonotificar">Modo alerta</label>
                                                    <input class="form-control" name="modonotificar" type="text" value="Notificación" readonly>
                                                </div>
                                            </div>

                                        </td>

                                        <td>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="tiempo">Hora</label>
                                                <input type="number" name="tiempo" class="class-cuota" value="30">
                                            </div>
                                        </div>
                                        </td>

                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="horario">Tiempo</label>
                                                    <select class="form-control" name="horario">
                                                        <option value="Horas">Horas</option>
                                                        <option value="Minutos" selected>Minutos</option>
                                                        <option value="Días">Días</option>
                                                        <option value="Semanas">Semanas</option>
                                                    </select>
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
