@extends('layouts.app')

@section('content')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="https://www.paypal.com/sdk/js?client-id=AZ0IlC3Wm2UwLxYMrzxlCs2pWEjtLJSeN7z655zcI_acEeX1stSvNLIhytSzM8XdpnxyDiSuU1Rz1dzd&currency=USD"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.3/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">
</head>
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Método de pago</h3>
    </div>
</section>
{{-- CARD DE DETALLES DEL PAGO --}}
<div class="section-body">

    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="step-link" data-step="1"><i class="bi bi-credit-card"></i> 1. Seleccionar método de pago</a></li>
                <li class="breadcrumb-item"><a href="#" class="step-link" data-step="2"><i class="bi bi-file-alt"></i> 2. Resumen de pago</a></li>
                <li class="breadcrumb-item"><a href="#" class="step-link" data-step="3"><i class="bi bi-check-circle"></i>3. Resultado</a></li>
            </ol>
        </nav>
    </div>


<!-- Contenido de cada paso -->
    <!-- Paso 1: Seleccionar método de pago -->
    <div class="row step-content" data-step="1">
        <div class="col-lg-12">
             <!-- Primera columna con el primer card -->
             <h5>Paso 1: Seleccionar método de pago</h5>
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                                <div class="section-header custom-header">

                                    <h3 class="page__heading"><strong>Importe:</strong>{{ $blog->cuota }}</h3>
                                </div>

                                <p><b>Título del blog: </b>{{ $blog->titulo }}</p>
                                <p><b>Fecha: </b><?php echo date('Y-m-d'); ?></p> <!-- Imprime la fecha actual -->
                                <p><b>Factura N°:</b>&nbsp;00001</p>

                </div>
            </div>
        </div>

        <!-- Segunda columna con el segundo card -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <body>
                        {{--  BOTON PAGOS --}}
                        <div id="paypal-button-container"></div>
                        <script>
                            paypal.Buttons({
                                style: {
                                    color: 'blue',
                                    shape: 'pill',
                                    label: 'pay'
                                },
                                createOrder: function(data, actions) {
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                                value: 10
                                            }
                                        }]
                                    });
                                },

                                onApprove: function(data, actions) {
                                    actions.order.capture().then(function(detalles) {
                                        console.log(detalles);
                                        window.location.href = "completado.php"
                                    });
                                },


                                onCancel: function(data) {
                                    alert("Pago cancelado");
                                    console.log(data);
                                }
                            }).render('#paypal-button-container');
                        </script>

                    </body>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>

    <!-- Paso 2: Resumen de pago -->
    <div class="row mt-4 step-content" data-step="2" style="display: none;">
        <div class="col-lg-12">
            <h5>Paso 2: Resumen de pago</h5>
            <!-- Contenido del paso 2 aquí (puedes agregar un card si es necesario) -->
        </div>
    </div>

    <!-- Paso 3: Resultado -->
    <div class="row mt-4 step-content" data-step="3" style="display: none;">
        <div class="col-lg-12">
            <h5>Paso 3: Resultado</h5>
            <!-- Contenido del paso 3 aquí (puedes agregar un card si es necesario) -->
        </div>
    </div>


</div>

<script>
    // Manejador de eventos para los enlaces de los pasos
    document.addEventListener('DOMContentLoaded', function() {
        const stepLinks = document.querySelectorAll('.step-link');
        const stepContents = document.querySelectorAll('.step-content');

        // Función para mostrar el contenido del paso seleccionado y ocultar los demás
        function showStep(step) {
            stepContents.forEach(function(content) {
                if (content.dataset.step === step) {
                    content.style.display = 'block';
                } else {
                    content.style.display = 'none';
                }
            });
        }

        // Agregar el evento de clic a los enlaces de los pasos
        stepLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const step = this.dataset.step;
                showStep(step);

                // Cargar contenido desde una vista parcial
                if (step === '2') {
                    fetch('/resumen_de_pago') // Reemplaza con la URL que devuelve la vista parcial para Resumen de pago
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('step2-content').innerHTML = data;
                        });
                } else if (step === '3') {
                    fetch('/resultado') // Reemplaza con la URL que devuelve la vista parcial para Resultado
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('step3-content').innerHTML = data;
                        });
                }
            });
        });

        // Mostrar el contenido del paso 1 por defecto
        showStep('1');
    });
</script>
</html>
@endsection

<style>
    .custom-header {
        background-color: rgb(42, 42, 188);
        color: white;
        padding: 10px;
        border-radius: 5px; /* Agrega bordes redondeados */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Agrega sombra */
        margin-bottom: 20px; /* Agrega un margen inferior para separar del contenido siguiente */
    }

    .custom-header h3 {
        margin: 0; /* Elimina el margen predeterminado del h3 */
    }

    .step-title {
        font-weight: bold;
        background-color: #f5f5f5;
        padding: 5px;
        margin: 0;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }


    .breadcrumb-item a {
        color: #007bff; /* Color del enlace */
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline; /* Subraya al pasar el mouse */
    }
    .breadcrumb {
                padding: 0; /* Elimina el relleno predeterminado */
                background-color: transparent; /* Fondo transparente */
            }

            .breadcrumb-item+.breadcrumb-item::before {
                content: "/"; /* Separador */
                padding: 0 5px; /* Espaciado entre el separador y el elemento anterior */
            }

            .breadcrumb-item .bi {
                vertical-align: -.125em;
                fill: currentColor;
                margin-right: 5px;
            }

            .breadcrumb-item.active .bi {
                vertical-align: -.125em;
                fill: currentColor;
                margin-right: 5px;
            }
</style>

