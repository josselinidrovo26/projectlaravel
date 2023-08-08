@extends('layouts.app')

@section('content')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
    <div class="row step-content" data-step="1" id="paso1">
        <div class="col-lg-12">
             <!-- Primera columna con el primer card -->
             <h5>Paso 1: Seleccionar método de pago</h5>
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                                <div class="section-header custom-header">
                                    <h3 class="page__heading">
                                        <strong>Importe:</strong>
                                        <input type="text" name="" id="cuotaInput" max="{{ $pagos->diferencia }}" value="{{$pagos->diferencia}}" style="background-color: transparent; color: white; border: none;"
                                        pattern="[0-9]+(\.[0-9]+)?" oninput="validateCuota(this)">
                                        <input type="hidden" name="" id="abonoInput" max="{{ $pagos->abono }}" value="{{$pagos->abono}}" style="background-color: transparent; color: white; border: none;"
                                        pattern="[0-9]+(\.[0-9]+)?" oninput="validateCuota(this)">
                                    </h3> </div>

                                <p><b>Título del blog: </b>{{ $blog->titulo }}</p>
                                <p><b>Fecha: </b><?php echo date('Y-m-d'); ?></p> <!-- Imprime la fecha actual -->
                                <p><b>Factura N°:</b>&nbsp;00001</p>

                </div>
            </div>
        </div>
        
        @if ($canpay)
        <!-- Segunda columna con el segundo card -->
        <div class="col-lg-6" >
            <div class="card">
                <div class="card-body">
                    <body>
                        {{--  BOTON PAGOS --}}
                        <div id="paypal-button-container"></div>
                      <script>
                          
                             var cuotaInput = document.getElementById('cuotaInput');
                            // Convertir el valor del input a un número flotante (si es necesario)
                            var cuota = parseFloat(cuotaInput.value);
                            console.log(cuota);
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
                                                value: document.getElementById('cuotaInput').value
                                            }
                                        }]
                                    });
                                },
                                
                                onApprove: function(data, actions) {
                                    actions.order.capture().then(function(detalles) {

                                        document.getElementById('paso1').style.display = 'none';
                                        // Mostrar el div del paso 2
                                        document.getElementById('paso2').style.display = 'block';
                                        //window.location.href = "completado.php"
                                        
                                        axios.post('/pasarelas/getDataStudent', {
                                            status: 'Pagado',
                                            monto: parseFloat(document.getElementById('cuotaInput').value),
                                            blog_id: {{ $blog->id }}
                                        })
                                        .then(function (response) {
                                            console.log(response);
                                            var fechaActual = new Date();
                                            var dia = fechaActual.getDate().toString().padStart(2, '0');
                                            var mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0');
                                            var anio = fechaActual.getFullYear();
                                            var fechaFormateada = dia + '/' + mes + '/' + anio;
                                            document.getElementById('fechaPago').innerText = fechaFormateada;
                                            document.getElementById('nombreEstudiante').innerText = response.data.student.nombre;
                                            document.getElementById('cuota').innerText =  parseFloat(document.getElementById('cuotaInput').value);
                                            document.getElementById('diferencia').innerText =  response.data.payment.diferencia;
                                            document.getElementById('status').innerText =  response.data.payment.estado;
                                        })
                                        .catch(function (error) {
                                            console.log(error);
                                        });
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
        @else
        <div class="col-lg-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Pago Completado</h5>
                    <p class="card-text">El pago del evento ya ha sido completado exitosamente.</p>
                </div>
            </div>
        </div>

        @endif                                             
    </div>
        </div>
    </div>

    <!-- Paso 2: Resumen de pago -->
    <div class="row mt-4 step-content" data-step="2" style="display: none;"  id="paso2">
        <div class="col-lg-12">
            <h5>Paso 2: Resumen de pago</h5>
            
            
            <div class="card" style="background-color: #cce5ff;">
                <div class="card-body">
                    <h5 class="card-title">Detalles del Pago</h5>
                    <p class="card-text"><strong>Nombre del Estudiante:</strong> <span id="nombreEstudiante"></span></p>
                    <p class="card-text"><strong>Fecha del Pago:</strong> <span id="fechaPago"></span></p>
                    <p class="card-text"><strong>Estado:</strong> <span id="status"></span></p>
                    <p class="card-text"><strong>Cuota:</strong> <span id="cuota"></span></p>
                    <p class="card-text"><strong>Diferencia:</strong> <span id="diferencia"></span></p>
                </div>
            </div>

            <div class="container mt-4">
                <button type="button" class="btn btn-primary" id="btnSiguiente">Siguiente</button>
              </div>
              <script>
                var btnSiguiente = document.getElementById('btnSiguiente');
                btnSiguiente.addEventListener('click', function() {
                  setInvoiceData();
                });
              
                // Definir la función que se ejecutará al hacer clic en el botón "Siguiente"
                function setInvoiceData() {
                    axios.post('/pasarelas/getInvoice', {
                        status: 'Pagado',
                        monto: cuota,
                        blog_id: {{ $blog->id }}
                    })
                    .then(function (response) {
                        // 3. Asignar la fecha formateada al elemento "fecha"
                        console.log(response);
                        document.getElementById('nombrePersona').innerText =  response.data.student.nombre;
                        document.getElementById('totalPago').innerText =  document.getElementById('cuotaInput').value;
                        document.getElementById('tituloEvento').innerText =   response.data.blog.titulo;
                        document.getElementById('datePago').innerText =  response.data.blog.pago;
                        document.getElementById('cursoEvento').innerText =  response.data.blog.cursoblog;
                        var contenidoTabla = '';
                        response.data.blog.detalles.forEach(function(item) {
                                contenidoTabla += '<tr>';
                                contenidoTabla += '<td>' + item.actividad + '</td>';
                                contenidoTabla += '<td>' + item.precio + '</td>';
                                contenidoTabla += '</tr>';
                                });
                                var tablaDetalle = document.getElementById('tablaDetalle');
                        // Inserta el contenido generado en el tbody de la tabla
                        tablaDetalle.innerHTML = contenidoTabla;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                }
              
               
              </script>
                              
        </div>
    </div>

    <!-- Paso 3: Resultado -->
    <div class="row mt-4 step-content" data-step="3" style="display: none;">
        <div class="col-lg-12">
          <h5>Paso 3: Resultado</h5>
      
          <!-- Cabecera -->
          <div class="row mb-2">
            <div class="col-md-2"><strong>Nombre:</strong> <span id="nombrePersona"></span></div>
            <div class="col-md-2"><strong>Total:</strong> <span id="totalPago"></span></div>
            <div class="col-md-2"><strong>Título:</strong> <span id="tituloEvento"></span></div>
            <div class="col-md-2"><strong>Fecha:</strong> <span id="datePago"></span></div>
            <div class="col-md-2"><strong>Curso:</strong> <span id="cursoEvento"></span></div>

            <div class="btn-container">
                <button id="descargarPDFButton" style="background-color: #dc3545;padding: 10px 20px;
                border-radius: 4px;
                font-size: 16px;
                font-weight: bold;
                color: #fff;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s ease;" >Descargar PDF</button>
            </div>

           </div>
      
          <!-- Detalle -->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Actividad</th>
                <th>Precio</th>
              </tr>
            </thead>
            <tbody id="tablaDetalle">
             
              <!-- Puedes agregar más filas según sea necesario -->
            </tbody>
          </table>
      
        </div>
      </div>
      
  {{--  Descargar reportes --}}
  <script>
        document.getElementById('descargarPDFButton').addEventListener('click', function() {
        imprimirTablas();
    });

    function imprimirTablas() {
        var tablaContenido = document.getElementById('contenidotabla');
        var win = window.open('', '', 'width=800, height=600');
        filename: 'reporte_Factura.pdf',
        win.document.write('<html><head><title>Factura</title></head><body>');
        win.document.write('<div style="max-width: 800px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);"><div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;"><div style="max-width: 150px;"><img src="{{ asset('img/logo.png') }}" alt="Logo de la empresa" style="max-width: 100%; height: auto;"></div><div style="text-align: right;">');
        win.document.write(' <h2 style="margin: 0; font-size: 24px; color: #333;">Factura N° 12345</h2>');
        win.document.write(' <p style="margin: 5px 0; color: #555;">Fecha: ' + document.getElementById('datePago').innerText + '</p>');
        win.document.write(' <p style="margin: 5px 0; color: #555;">Cliente: ' + document.getElementById('nombrePersona').innerText + '</p>');
        win.document.write(' <p style="margin: 5px 0; color: #555;">Actividad a pagar: ' + document.getElementById('tituloEvento').innerText + '</p>');
        win.document.write(' <p style="margin: 5px 0; color: #555;">Total a pagar: ' + document.getElementById('totalPago').innerText + '</p>');
        win.document.write(' </div> </div>');
        win.document.write(' <div style="width: 100%; overflow-x: auto;"> ');
        win.document.write('<table style="width: 100%; border-collapse: collapse;">  <thead><tr>'
            +'<th style="padding: 8px; border: 1px solid #ccc; background-color: #f2f2f2;">#</th>'
            +'<th style="padding: 8px; border: 1px solid #ccc; background-color: #f2f2f2;">Descripcion</th>'
            +'<th style="padding: 8px; border: 1px solid #ccc; background-color: #f2f2f2;">Actividad</th>'
            +'<th style="padding: 8px; border: 1px solid #ccc; background-color: #f2f2f2;">Cantidad</th>'
            +'<th style="padding: 8px; border: 1px solid #ccc; background-color: #f2f2f2;">Precio</th>'
            +'</tr></thead> <tbody id="tablaDetalle">');

        var detallesTabla = document.getElementById('tablaDetalle');
        var filas = detallesTabla.getElementsByTagName('tr');
        for (var i = 0; i < filas.length; i++) {
            var fila = filas[i];
            var celdas = fila.getElementsByTagName('td');
            var col1 = celdas[0].innerText;
            var col2 = celdas[1].innerText;

            win.document.write('<tr>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;">' + (i + 1) + '</td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;">' + document.getElementById('tituloEvento').innerText  + '</td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;">' + col1 + '</td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"> 1 </td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;">' + col2 + '</td>');
            win.document.write('</tr>');
        }
        win.document.write('<tr>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"></td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"></td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"></td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc; text-align: right ;background-color: #f2f2f2;">Subtotal</td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;">' +document.getElementById('totalPago').innerText + '</td>');
        win.document.write('</tr>');
        win.document.write('<tr>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"></td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"></td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"></td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc; text-align: right ;background-color: #f2f2f2;">Iva</td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"> 0.00 </td>');
        win.document.write('</tr>');
        win.document.write('<tr>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"></td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"></td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;"></td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc; text-align: right ;background-color: #f2f2f2;">Total</td>');
            win.document.write('<td style="padding: 8px; border: 1px solid #ccc;">' +document.getElementById('totalPago').innerText + '</td>');
        win.document.write('</tr>');
        win.document.write('</tbody></table>');
        win.document.write(' </div> ');
        win.document.write('</body></html>');
        win.document.close();
        win.print();
        win.close();
        
        // Crea el PDF con el contenido de la tabla
        html2pdf().from(tablaContenido).set(options).save();
    }
    </script>


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

<script>
    function validateCuota(input) {
        // Obtener el valor ingresado por el usuario
        var cuota = parseFloat(input.value);
    
        // Obtener el valor máximo permitido (valor de cuota)
        var maxCuota = parseFloat(input.getAttribute('max'));
    
        // Verificar si el valor ingresado es numérico y no es mayor que el valor de cuota
        if (isNaN(cuota) || cuota > maxCuota) {
            // Si el valor no es válido, establecer el valor del input en el valor de cuota
            input.value = '';
        }
    }
</script>
