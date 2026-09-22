<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Compra #{{ $venta->id }} - NerdVault</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="{{ route('catalogo') }}" class="btn btn-secondary">&larr; Volver al Catálogo</a>
            <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimir Factura</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success no-print">{{ session('success') }}</div>
        @endif

        <div class="card p-4 shadow-sm bg-white">
            <div class="row mb-4">
                <div class="col-6">
                    <h2 class="fw-bold">NerdVault</h2>
                    <p class="text-muted">Comprobante de Pago</p>
                </div>
                <div class="col-6 text-end">
                    <h4>Factura #{{ $venta->id }}</h4>
                    <p class="text-muted">Fecha: {{ $venta->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <hr>

            <!-- Datos del Cliente -->
            <div class="row mb-4">
                <div class="col-6">
                    <h5 class="fw-bold">Datos del Cliente</h5>
                    <p class="mb-1"><strong>Nombre:</strong> {{ $venta->cliente_nombre }}</p>
                    <p class="mb-1"><strong>Correo:</strong> {{ $venta->cliente_email }}</p>
                </div>
                <div class="col-6 text-end">
                    <h5 class="fw-bold">Método de Pago</h5>
                    <p class="mb-1">Tarjeta terminada en: <strong>**** {{ $venta->tarjeta_credito }}</strong></p>
                </div>
            </div>

            <!-- Tabla de Ítems Comprados -->
            <h5 class="fw-bold mb-3">Detalle de la Compra</h5>
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Franquicia</th>
                        <th>Categoría</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio Unitario</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                            <td>{{ $detalle->producto->franquicia ?? 'N/A' }}</td>
                            <td>{{ $detalle->producto->categoria->nombre ?? 'N/A' }}</td>
                            <td class="text-center">{{ $detalle->cantidad }}</td>
                            <td class="text-end">${{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td class="text-end">${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end fs-5">Total Pagado:</th>
                        <th class="text-end fs-5 text-success">${{ number_format($venta->total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>

            <div class="text-center mt-4">
                <p class="text-muted">¡Gracias por tu compra en NerdVault!</p>
            </div>
        </div>
    </div>
</body>
</html>