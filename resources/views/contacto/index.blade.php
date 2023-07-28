<link rel="stylesheet" href="{{ asset('web/css/style.css') }}">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Contacto</title>
    <link rel="stylesheet" href="estilos.css">
    <!--Icon-Font-->
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-form">
        <div class="info-form">
            <h2>Contáctanos</h2>
            <p>Necesitas realizar seguimiento a tus eventos, pagos y reuniones. Puedes contactarte cen nuestros canales oficiales, para un asesoriamiento y capacitación personalizada, según corresponda</p>
            <a href="#"><i class="fa fa-phone"></i> 098 588 3053</a>
            <a href="#"><i class="fa fa-envelope"></i> josselin.idrovog@ug.edu.ec</a>
            <a href="#"><i class="fa fa-map-marked"></i> Guayaquil, Ecuador</a>
        </div>
        <form action="#" autocomplete="off">
            <input type="text" name="nombre" placeholder="Tu Nombre" class="campo">
            <input type="emal" name="email" placeholder="Tu Email" class="campo">
            <textarea name="mensaje" placeholder="Tu Mensaje..."></textarea>
            <input type="submit" name="enviar" value="Enviar Mensaje" class="btn-enviar">
        </form>
    </div>
</body>
</html>
