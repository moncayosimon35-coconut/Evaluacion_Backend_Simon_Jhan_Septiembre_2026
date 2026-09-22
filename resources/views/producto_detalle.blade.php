<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $producto->nombre }} - NerdVault</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <a href="{{ route('catalogo') }}" class="btn btn-secondary mb-3">&larr; Volver al catálogo</a>
    
    <div class="card p-4">
        <h2>{{ $producto->nombre }}</h2>
        <p class="text-muted">Franquicia: {{ $producto->franquicia }} | Categoría: {{ $producto->categoria->nombre }}</p>
        <p>{{ $producto->descripcion }}</p>

        @if($producto->tieneDescuento())
            <p class="text-danger"><strong>¡En Promoción! 10% de Descuento aplicado por stock alto.</strong></p>
            <h3>Precio: <del class="text-muted">${{ number_format($producto->precio, 2) }}</del> ${{ number_format($producto->precio_final, 2) }}</h3>
        @else
            <h3>Precio: ${{ number_format($producto->precio, 2) }}</h3>
        @endif

        <p>Stock disponible: <strong>{{ $producto->stock }}</strong></p>

        <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mt-3 col-md-4">
            @csrf
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad a comprar:</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" value="1" min="1" max="{{ $producto->stock }}" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Agregar al Carrito</button>
        </form>
    </div>
</body>
</html>