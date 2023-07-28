@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Reunión</h3>
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


                            <form action="{{ route('reunions.update', $reunion->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="tituloreuniones">Título</label>
                                       <input type="text" name="tituloreuniones" class="form-control" value="{{ $reunion->tituloreuniones }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                       <input type="text" name="descripcion" class="form-control" value="{{ $reunion->descripcion }}">
                                    </div>
                                </div>



                                <table>
                                    <tr>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-floating">
                                                <label for="fechareuniones">Fecha reunión</label>
                                                <input class="form-control" name="fechareuniones" type="date"  value="{{ $reunion->fechareuniones }}">
                                                </div><br>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="inicio">Inicia reunión</label>
                                                <input class="class-cuota" name="inicio"  value="{{ $reunion->inicio }}" >

                                                </div>
                                            </div>
                                        </td>


                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="fin">Finaliza reunión</label>
                                                <input class="class-cuota" name="fin"  value="{{ $reunion->fin }}" min="today">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                </table>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-floating">
                                    <label for="enlace">Enlace de reunión</label>
                                    <textarea class="form-control" name="enlace" style="height: 100px">{{ $reunion->enlace}}</textarea>
                                    </div><br>
                                </div>

                                @if (isset($user))
                                <!-- Resto del código -->
                                <input type="hidden" name="id_reunion" value="{{ $reunion->id }}">
                                <!-- Resto del código -->
                                 @endif



                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-floating">
                                        <div class="form-group">
                                            <label for="participantes">Participantes</label>
                                           {{--  {!! Form::select('participantes', $cursos, $id->curso, ['class' => 'form-control']) !!} --}}
                                           {!! Form::select('participantes', $cursos, isset($id) ? $id->curso : null, ['class' => 'form-control']) !!}
                                        </div>

                                    </div>
                                </div>


                                <table>
                                    <tr>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-floating">
                                                <label for="modonotificar">Enviar notificación</label>
                                                <select class="form-control" name="modonotificar"  value="{{ $reunion->modonotificar }}">
                                                    <option value="Notificación">Notificación</option>
                                                    <option value="Correo electrónico">Correo electrónico</option>
                                                  </select>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="tiempo"></label>
                                                <input class="class-cuota" name="tiempo"  value="{{ $reunion->tiempo }}" >

                                                </div>
                                            </div>
                                        </td>


                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="horario"></label>
                                                <select class="form-control" name="horario" value="{{ $reunion->horario }}">
                                                    <option value="Horas">Horas</option>
                                                    <option value="Minutos">Minutos</option>
                                                    <option value="Días">Días</option>
                                                    <option value="Semanas">Semanas</option>
                                                  </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>





                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <center>
                                    <button type="submit" class="btn btn-primary">Guardar</button>

                                    <button type="reset" class="btn btn-danger"  >Cancelar</button>
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
