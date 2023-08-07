<!DOCTYPE html>
<html>
<head>
    <!-- Agrega los enlaces a los estilos de Bootstrap aquí -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos personalizados */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }
        body {
            background-image: url('/ruta/a/tu/imagen/fondo.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .invoice-container {
            width: 100vw;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }
        .logo-img {
            max-width: 150px;
            height: auto;
            float: right;
            margin-right: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .invoice-title {
            font-size: 20px;
            color: #185f9c;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .invoice-details {
            font-size: 16px;
            color: #333;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 12px;
            border: 1px solid #e0e0e0;
            text-align: left;
            font-size: 14px;
        }
        .invoice-table th {
            background-color: #185f9c;
            color: #fff;
            font-weight: bold;
        }
        .signature {
            font-size: 14px;
            font-style: italic;
            margin-top: 20px;
            color: #555;
        }
        .footer {
            text-align: center;
            color: #fff;
            background-color: #002855;
            width: 100%;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
         <img src="{{ public_path('img/logo.png') }}" alt="Logo" class="logo-img">
        </div>
        <div class="invoice-title text-left">Recibo de Pago</div>
        <div class="invoice-details">
            <p><strong>Recibo N°:</strong> 0001213</p>
            <p><strong>Fecha:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
            <p><strong>Cliente:</strong> {{ $pago->estudiante->persona->nombre }}</p>
            <p><strong>Actividad a pagar:</strong> {{ $pago->blog->titulo }}</p>
            <p><strong>Pendiente por pagar:</strong> <span class="text-danger">${{ $pago->diferencia }}</span></p>
        </div>

        <div class="table-responsive">
            <table class="table invoice-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $pago->blog->titulo }}</td>
                        <td>1</td>
                        <td>${{ $pago->abono }}</td>
                        <td>${{ $pago->abono }}</td>
                    </tr>
                    <!-- Agrega más filas aquí si es necesario -->
                    <tr>
                        <td colspan="4" class="text-right"><strong>Subtotal</strong></td>
                        <td>${{ $pago->abono }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total</strong></td>
                        <td>${{ $pago->abono }}</td>
                    </tr>
                </tbody>
            </table><BR><BR><BR>
        </div>
        <div class="signature">
            <img src="{{ public_path('img/firma.png') }}" alt="Logo" class="firma-img" border="0" width="25%">
            <p> ______________________________</p>
            <p class="font-italic">Sello del Comité</p>
        </div>
    </div>

    <div class="footer">
        <p class="footer-text">UNIDAD EDUCATIVA "BLANCA GARCÍA PLAZA DE ARIAS"</p>
    </div>
</body>
</html>
