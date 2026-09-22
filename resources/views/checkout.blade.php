<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Finalizar Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Finalizar Compra</h2>

    <form action="{{ route('checkout.procesar') }}" method="POST" class="col-md-6 mt-4">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" name="cliente_nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="cliente_email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Número de Tarjeta de Crédito</label>
            <input type="text" name="tarjeta_credito" class="form-control" placeholder="**** **** **** 1234" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Confirmar y Pagar</button>
    </form>
</body>
</html>