<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="https://www.paypal.com/sdk/js?client-id=AZ0IlC3Wm2UwLxYMrzxlCs2pWEjtLJSeN7z655zcI_acEeX1stSvNLIhytSzM8XdpnxyDiSuU1Rz1dzd&currency=USD"></script>
</head>
<body>
   {{--  BOTON PAGOS --}}
    <div id="paypal-button-container"></div>
    <script>
        paypal.Buttons({
            style:{
                color:'blue',
                shape: 'pill',
                label:'pay'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                        purchase_units: [{
                             amount:{
                                value:10
                            }
                        }]
                });
            },

            onApprove: function(data, actions){
                actions.order.capture().then(function(detalles){
                    console.log(detalles);
                    window.location.href="completado.php"
                });
            },


            onCancel: function(data){
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>

</body>
</html>

