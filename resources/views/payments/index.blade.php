@extends('layouts.app')

@section('content')
<body>
    <h1>Página de Pago</h1>

    <form action="{{ route('payment.paypal') }}" method="post">
        @csrf
        <label for="amount">Monto a pagar:</label>
        <input type="text" name="amount" id="amount" required>
        <button type="submit">Pagar con PayPal</button>
    </form>

    <!-- Agrega aquí el código HTML adicional que desees mostrar en la página -->

</body>

