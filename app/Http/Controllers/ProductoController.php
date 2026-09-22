<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        // Uso de Eloquent localScopes y Eager Loading (with)
        $query = Producto::with('categoria')->where('stock', '>', 0);

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('franquicia')) {
            $query->where('franquicia', 'like', '%' . $request->franquicia . '%');
        }

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $productos = $query->get();
        $categorias = Categoria::all();

        return view('catalogo', compact('productos', 'categorias'));
    }

    public function adminIndex()
    {
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::all();
        return view('admin.productos', compact('productos', 'categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:100',
            'descripcion'  => 'nullable|string',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'franquicia'   => 'required|string|max:50',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Producto::create($data);

        return redirect()->back()->with('success', 'Producto creado exitosamente');
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:100',
            'descripcion'  => 'nullable|string',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'franquicia'   => 'required|string|max:50',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $producto->update($data);

        return redirect()->back()->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->back()->with('success', 'Producto eliminado');
    }

    public function show(Producto $producto)
    {
        return view('producto_detalle', compact('producto'));
    }
}