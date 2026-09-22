<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Administración de Productos</h2>
    <a href="{{ route('catalogo') }}" class="btn btn-secondary mb-3">Volver a la Tienda</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-3 mb-4">
        <h4>Crear Nuevo Producto</h4>
        <form action="{{ route('admin.productos.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-4">
                <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="franquicia" placeholder="Franquicia (ej. Star Wars)" class="form-control" required>
            </div>
            <div class="col-md-4">
                <select name="categoria_id" class="form-select" required>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" step="0.01" name="precio" placeholder="Precio Base" class="form-control" required>
            </div>
            <div class="col-md-4">
                <input type="number" name="stock" placeholder="Stock" class="form-control" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100">Guardar Producto</button>
            </div>
        </form>
    </div>

    <h4>Productos Existentes</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Franquicia</th>
                <th>Precio Base</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $prod)
                <tr>
                    <td>{{ $prod->id }}</td>
                    <td>{{ $prod->nombre }}</td>
                    <td>{{ $prod->franquicia }}</td>
                    <td>${{ $prod->precio }}</td>
                    <td>{{ $prod->stock }}</td>
                    <td>
                        <form action="{{ route('admin.productos.destroy', $prod->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>