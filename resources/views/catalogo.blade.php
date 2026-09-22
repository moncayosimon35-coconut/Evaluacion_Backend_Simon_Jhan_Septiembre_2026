<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>NerdVault - Catálogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>NerdVault - Tienda</h1>
        <div>
            <a href="{{ route('admin.productos') }}" class="btn btn-outline-secondary">Gestor de Productos (Admin)</a>
            <a href="{{ route('carrito') }}" class="btn btn-primary">Carrito ({{ count(session('carrito', [])) }})</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filtros de búsqueda -->
    <form method="GET" action="{{ route('catalogo') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre..." value="{{ request('nombre') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="franquicia" class="form-control" placeholder="Buscar por franquicia..." value="{{ request('franquicia') }}">
        </div>
        <div class="col-md-3">
            <select name="categoria_id" class="form-select">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-dark w-100">Filtrar</button>
        </div>
    </form>

    <!-- Listado de Productos -->
    <div class="row">
        @forelse($productos as $prod)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2">{{ $prod->categoria->nombre }}</span>
                        <h5 class="card-title">{{ $prod->nombre }}</h5>
                        <p class="card-text text-muted">Franquicia: {{ $prod->franquicia }}</p>
                        
                        @if($prod->tieneDescuento())
                            <p class="card-text">
                                <span class="badge bg-danger">Promoción -10%</span><br>
                                <del class="text-muted">${{ number_format($prod->precio, 2) }}</del>
                                <strong class="text-success fs-5">${{ number_format($prod->precio_final, 2) }}</strong>
                            </p>
                        @else
                            <p class="card-text fs-5"><strong>${{ number_format($prod->precio, 2) }}</strong></p>
                        @endif

                        <p class="small text-muted">Stock disponible: {{ $prod->stock }}</p>
                        <a href="{{ route('producto.show', $prod->id) }}" class="btn btn-outline-primary w-100">Ver Detalles</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No se encontraron productos.</p>
        @endforelse
    </div>
</body>
</html>