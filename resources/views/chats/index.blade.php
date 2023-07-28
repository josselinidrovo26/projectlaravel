@extends('layouts.app')
@section('content')
<section class="section">
    <link rel="stylesheet" href="{{ asset('web/css/estilochat.css') }}">


{{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> --}}
{{-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> --}}
{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
<!------ Include the above in your HEAD tag ---------->

{{--
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> --}}
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>

	<!--Coded With Love By Mutiullah Samim-->
    <div class="section-header">
        <h3 class="page__heading">Chat habilitado</h3>
    </div>
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

</section>
@endsection
