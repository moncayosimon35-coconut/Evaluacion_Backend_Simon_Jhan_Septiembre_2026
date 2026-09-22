<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Productos - NerdVault</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Administración de Productos</h2>
    <a href="{{ route('catalogo') }}" class="btn btn-secondary mb-3">Volver a la Tienda</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Formulario Crear -->
    <div class="card p-3 mb-4">
        <h4>Crear Nuevo Producto</h4>
        <form action="{{ route('admin.productos.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-3">
                <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="franquicia" placeholder="Franquicia (ej. Star Wars)" class="form-control" required>
            </div>
            <div class="col-md-3">
                <select name="categoria_id" class="form-select" required>
                    <option value="">Seleccionar Categoría</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" name="precio" placeholder="Precio Base" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="stock" placeholder="Stock" class="form-control" required>
            </div>
            <div class="col-md-6">
                <input type="text" name="descripcion" placeholder="Descripción (opcional)" class="form-control">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100">Guardar Producto</button>
            </div>
        </form>
    </div>

    <!-- Lista con Opción de Edición Directa -->
    <h4>Productos Existentes</h4>
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Franquicia</th>
                <th>Categoría</th>
                <th>Precio Base</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $prod)
                <tr>
                    <form action="{{ route('admin.productos.update', $prod->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td>{{ $prod->id }}</td>
                        <td><input type="text" name="nombre" value="{{ $prod->nombre }}" class="form-control form-control-sm" required></td>
                        <td><input type="text" name="franquicia" value="{{ $prod->franquicia }}" class="form-control form-control-sm" required></td>
                        <td>
                            <select name="categoria_id" class="form-select form-select-sm" required>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ $prod->categoria_id == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" step="0.01" name="precio" value="{{ $prod->precio }}" class="form-control form-control-sm" style="width: 90px;" required></td>
                        <td><input type="number" name="stock" value="{{ $prod->stock }}" class="form-control form-control-sm" style="width: 80px;" required></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button type="submit" class="btn btn-warning btn-sm">Actualizar</button>
                    </form>
                                <form action="{{ route('admin.productos.destroy', $prod->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Borrar</button>
                                </form>
                            </div>
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>