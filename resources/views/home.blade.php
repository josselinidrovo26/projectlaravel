@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Actividades extracurriculares escolares</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cardt">
                        <div class="card-body">
                                <div class="row">
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

                                    <div class="col-md-4 col-xl-4">
                                        <div class="bg-c-blue order-card">
                                                <div class="card-block">
                                                <h5>Usuarios</h5>
                                                    @php
                                                     use App\Models\User;
                                                    $cant_usuarios = User::count();
                                                    @endphp
                                                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span>{{$cant_usuarios}}</span></h2>
                                                    <p class="m-b-0 text-right"><a href="/usuarios" class="text-white">Ver más</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="col-md-4 col-xl-4">
                                        <div class="bg-c-green order-card">
                                            <div class="card-block">
                                            <h5>Roles</h5>
                                                @php
                                                use Spatie\Permission\Models\Role;
                                                 $cant_roles = Role::count();
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-user-lock f-left"></i><span>{{$cant_roles}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/roles" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xl-4">
                                        <div class="bg-c-pink order-card">
                                            <div class="card-block">
                                                <h5>Eventos</h5>
                                                @php
                                                 use App\Models\Blog;
                                                $cant_blogs = Blog::count();
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-blog f-left"></i><span>{{$cant_blogs}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/blogs" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xl-4">
                                        <div class="bg-c-pink order-card">
                                            <div class="card-block">
                                                <h5>Cursos</h5>
                                                @php
                                                 use App\Models\Curso;
                                                $cant_cursos = Curso::count();
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-blog f-left"></i><span>{{$cant_cursos}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/curso" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xl-4">
                                        <div class="bg-c-blue order-card">
                                            <div class="card-block">
                                                <h5>Reuniones</h5>
                                                @php
                                                 use App\Models\Reunion;
                                                $cant_reunions = Reunion::count();
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-blog f-left"></i><span>{{$cant_reunions}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/reunions" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xl-4">
                                        <div class="bg-c-green order-card">
                                            <div class="card-block">
                                                <h5>Publicaciones</h5>
                                                @php
                                                 use App\Models\Biografias;
                                                $cant_biografias = Biografias::count();
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-blog f-left"></i><span>{{$cant_biografias}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/biografias" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                        </div>
                    </div>
                </div>
            </div>

             {{--    BOTON FLOTANTE --}}
             <div class="container-boton">
                <a href="#">
                    <img class="boton" src="{{ asset('assets/images/icons8-charla-64.png') }}" alt="Icono de charla" id="myButton">
                </a>
            </div>

            {{-- VENTANA MODAL --}}

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
           <link rel="stylesheet" href="{{ asset('web/css/estilochat.css') }}">


	{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>


    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">


					<div class="card">
						<div class="card-header msg_head">
							<div class="d-flex bd-highlight">
								<div class="img_cont">
									<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
									<span class="online_icon"></span>
								</div>
								<div class="user_info">
									<span>Chat with Khalid</span>
									<p>1767 Messages</p>
								</div>

							</div>
							<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
							<div class="action_menu">
								<ul>

									<li><i class="fas fa-plus"></i> Agregar al grupo</li>
									<li><i class="fas fa-ban"></i> Borrar chat</li>
								</ul>
							</div>
						</div>
						<div class="card-body msg_card_body">
							<div class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg">
									<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg">
								</div>
								<div class="msg_cotainer">
									Hi, how are you samim?
									<span class="msg_time">8:40 AM, Today</span>
								</div>
							</div>
							<div class="d-flex justify-content-end mb-4">
								<div class="msg_cotainer_send">
									Hi Khalid i am good tnx how about you?
									<span class="msg_time_send">8:55 AM, Today</span>
								</div>
								<div class="img_cont_msg">
							<img src="https://us.123rf.com/450wm/pytyczech/pytyczech1904/pytyczech190400437/121432188-globo-terr%C3%A1queo-natural-mapa-del-mundo-3d-con-tierras-verdes-que-dejan-caer-sombras-sobre-mares-y.jpg" class="rounded-circle user_img_msg">
								</div>
							</div>
							<div class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg">
									<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg">
								</div>
								<div class="msg_cotainer">
									I am good too, thank you for your chat template
									<span class="msg_time">9:00 AM, Today</span>
								</div>
							</div>
							<div class="d-flex justify-content-end mb-4">
								<div class="msg_cotainer_send">
									You are welcome
									<span class="msg_time_send">9:05 AM, Today</span>
								</div>
								<div class="img_cont_msg">
							<img src="https://us.123rf.com/450wm/pytyczech/pytyczech1904/pytyczech190400437/121432188-globo-terr%C3%A1queo-natural-mapa-del-mundo-3d-con-tierras-verdes-que-dejan-caer-sombras-sobre-mares-y.jpg" class="rounded-circle user_img_msg">
								</div>
							</div>
							<div class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg">
									<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg">
								</div>
								<div class="msg_cotainer">
									I am looking for your next templates
									<span class="msg_time">9:07 AM, Today</span>
								</div>
							</div>
							<div class="d-flex justify-content-end mb-4">
								<div class="msg_cotainer_send">
									Ok, thank you have a good day
									<span class="msg_time_send">9:10 AM, Today</span>
								</div>
								<div class="img_cont_msg">
						<img src="https://us.123rf.com/450wm/pytyczech/pytyczech1904/pytyczech190400437/121432188-globo-terr%C3%A1queo-natural-mapa-del-mundo-3d-con-tierras-verdes-que-dejan-caer-sombras-sobre-mares-y.jpg" class="rounded-circle user_img_msg">
								</div>
							</div>
							<div class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg">
									<img src="https://us.123rf.com/450wm/pytyczech/pytyczech1904/pytyczech190400437/121432188-globo-terr%C3%A1queo-natural-mapa-del-mundo-3d-con-tierras-verdes-que-dejan-caer-sombras-sobre-mares-y.jpg" class="rounded-circle user_img_msg">
								</div>
								<div class="msg_cotainer">
									Bye, see you
									<span class="msg_time">9:12 AM, Today</span>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="input-group">
								<div class="input-group-append">
									<span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
								</div>
								<textarea name="" class="form-control type_msg" placeholder="Type your message..."></textarea>
								<div class="input-group-append">
									<span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>

<script>
    	$(document).ready(function(){
        $('#action_menu_btn').click(function(){
            $('.action_menu').toggle();
        });
            });
</script>
                </div>
              </div>

        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
   $(document).ready(function() {
  // Mostrar la ventana modal y ocultar el icono de la charla y su contenedor al hacer clic en el icono
  $("#myButton").click(function() {
    $("#myModal").css("display", "block");
    $(".container-boton").hide();
  });

  // Ocultar la ventana modal cuando se hace clic en el botón de cerrar
  $(".close").click(function() {
    $("#myModal").css("display", "none");
    $(".container-boton").show();
  });

  // Evitar que se cierre la ventana modal al hacer clic fuera de ella
  $(window).click(function(event) {
    if (event.target == $("#myModal")[0]) {
      return false; // Evita que se cierre la ventana modal
    }
  });
});


</script>
<style>
    .modal {
        /* Estilos generales de la ventana modal */
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
    /* Estilos del contenido de la ventana modal */
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    border-radius: 4px;
    max-width: 400px;
    position: fixed;
    bottom: 20px;
    right: 20px;
  }

  @media (max-width: 480px) {
    .modal-content {
      /* Estilos para pantallas pequeñas */
      max-width: 100%;
      bottom: 0;
      right: 0;
    }
  }
</style>

 --}}




@endsection
