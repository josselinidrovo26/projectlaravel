
@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

    <section class="section">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <div class="section-header">
            <h3 class="page__heading">Publicaciones de eventos</h3>
        </div>

            <div class="section-body">
            <div class="row">

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


                        <div class="col-md-12 gedf-main">
                            <div class="container-fluid gedf-wrapper">
                                <div class="row-biografia">

                                        <center>

                                            <form action="{{ route('biografias.store')}}" class="card gedf-card" method="POST" enctype="multipart/form-data" id="formulario">
                                                @csrf
                                                <div id="wrapper">
                                                    <div class="card-header">
                                                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Crea una publicación</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="images-tab" data-toggle="tab" role="tab" aria-controls="images" aria-selected="false" href="#images">Imagen</a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="tab-content" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                                                <div class="form-group">
                                                                    <textarea class="form-control" id="tituloBiografia" name="tituloBiografia" for="tituloBiografia" placeholder="Título..." required onkeyup="convertirAMayusculas(this)"></textarea>
                                                                </div>
                                                                {{-- PARA HACER MAYUSCULAS --}}
                                                                <script>
                                                                    function convertirAMayusculas(elemento) {
                                                                        elemento.value = elemento.value.toUpperCase();
                                                                    }
                                                                </script>

                                                                <div class="form-group">
                                                                    <textarea class="form-control" id="contenidoBiografia" name="contenidoBiografia" for="contenidoBiografia" placeholder="¿Qué estás pensando?" required></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                                                <div class="form-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" name="image[]" id="image" multiple>
                                                                        <label class="custom-file-label" value="imagenprueba" for="image" data-browse="Seleccionar">Cargar imagen</label><br><br>
                                                                    </div>
                                                                </div>

                                                                <div class="py-4">
                                                                    <div id="preview-images"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="btn-toolbar justify-content-between">
                                                            <div class="btn-group">
                                                                @can('crear-biografia')
                                                                <button type="submit" id="publish" name="submit" class="btn btn-primary">Compartir</button>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <script type="text/javascript">
                                                (function () {
                                                    'use strict';

                                                    var fileInput = document.getElementById('image');
                                                    var previewImagesContainer = document.getElementById('preview-images');

                                                    fileInput.addEventListener('change', function (event) {
                                                        var files = event.target.files;


                                                        previewImagesContainer.innerHTML = '';
                                                        Array.from(files).forEach(function (file) {
                                                            var reader = new FileReader();

                                                            reader.onload = function (e) {
                                                                var image = document.createElement('img');
                                                                image.classList.add('preview-image');
                                                                image.src = e.target.result;

                                                                var closeButton = document.createElement('button');
                                                                closeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'preview-image-close');
                                                                closeButton.innerHTML = 'X';
                                                                closeButton.addEventListener('click', function () {

                                                                    image.parentNode.removeChild(image);
                                                                    closeButton.parentNode.removeChild(closeButton);
                                                                });

                                                                var previewContainer = document.createElement('div');
                                                                previewContainer.classList.add('preview-image-container');
                                                                previewContainer.appendChild(image);
                                                                previewContainer.appendChild(closeButton);

                                                                previewImagesContainer.appendChild(previewContainer);
                                                            };

                                                            reader.readAsDataURL(file);
                                                        });
                                                    });
                                                })();
                                            </script>


                                     {{--     CUERPO DEL TEXTO --}}

                                     @foreach ($biografias as $biografia)
                                     <div class="card gedf-card" >
                                         <div class="card-header">

                                            <div class="d-flex justify-content-between align-items-center">
                                                @if(\Illuminate\Support\Facades\Auth::user())
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="mr-2">
                                                        <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                                                    </div>
                                                    <div class="ml-2">
                                                        <div class="h5 m-0">{{ \Illuminate\Support\Facades\Auth::user()->persona->nombre }}</div>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="justify-content-end">
                                                    <div class="dropdownoptions">
                                                        <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-h"></i>
                                                        </button>

                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                                                <div class="h6 dropdown-header">Configuración</div>
                                                            <form action="{{ route('biografias.destroy', $biografia->id) }}" method="POST">

                                                                @csrf
                                                                @method('DELETE')
                                                                @can('borrar-biografia')
                                                            <button class="dropdown-item delete-biography" type="submit" class="btn btn-danger">Eliminar</button>
                                                                @endcan
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                  {{--   TIEMPO DE PUBLICACION --}}

                                         <div class="card-body">
                                            <div class="text-muted h7 mb-2">
                                                <i class="fa fa-clock-o"></i>
                                                @if ($biografia->created_at)
                                                   {{ $biografia->created_at->diffForHumans(['options' => Carbon\Carbon::JUST_NOW]) }}
                                                @else
                                                    Fecha de creación desconocida
                                                @endif
                                            </div>



                                             <a class="card-link" >
                                                <h5 class="card-title">  <?php echo($biografia->tituloBiografia); ?> </h5>
                                            </a>


                                            <p class="card-text">
                                                <p class="card-title">  <?php echo($biografia->contenidoBiografia); ?> </p>
                                                <div class="panel-body">

                                                    <?php
                                                        $images = explode('|', $biografia->image); // Obtener las URLs de las imágenes
                                                        foreach ($images as $url) {
                                                            if (!empty($url)) {
                                                        ?>
                                                                <a href="<?php echo $url; ?>" target="_blank">
                                                                    <img src="<?php echo URL::to($url); ?>" style="height:150px;width:150px;margin-right:5px;" alt="">
                                                                </a>
                                                        <?php
                                                            }
                                                        }
                                                        ?>


                                                </div>
                                            </p>
                                         </div>

                                       <!-- Add this within the <div class="card-footer text-left"> block -->
                                        <div class="card-footer text-left">
                                            <a href="#" class="card-link like-button" data-biografia-id="{{ $biografia->id }}"><i class="fa fa-heart"></i> Me gusta</a>
                                            <span class="likes-count">{{ $biografia->likes }}</span>
                                        </div>
                                            <!-- Place this at the end of your blade template, before the closing </body> tag -->
                                                       <!-- Place this at the end of your blade template, before the closing </body> tag -->
                                                       <script>
                                                        $(document).ready(function() {
                                                            $('.like-button').on('click', function(event) {
                                                                event.preventDefault();
                                                                var biografiaId = $(this).data('biografia-id');

                                                                $.ajax({
                                                                    url: "{{ route('biografias.like', ':biografiaId') }}".replace(':biografiaId', biografiaId),
                                                                    type: 'POST',
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                    },
                                                                    success: function(response) {
                                                                        if (response.success) {
                                                                            var likesCount = response.likes;
                                                                            $(`.like-button[data-biografia-id="${biografiaId}"]`).next('.likes-count').text(likesCount + ' like');
                                                                        } else {
                                                                            alert('User not authenticated. Please log in to like.');
                                                                        }
                                                                    },
                                                                    error: function(xhr) {
                                                                        alert('An error occurred. Please try again later.');
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    </script>



                                     </div>
                                 @endforeach


                                  </center>

                                </div>
                            </div>
                        </div>
                     </div>
                </div>
    @endsection





