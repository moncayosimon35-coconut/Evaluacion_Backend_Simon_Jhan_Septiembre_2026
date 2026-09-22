<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function carrito()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito', compact('carrito'));
    }

    public function agregarAlCarrito(Request $request, Producto $producto)
    {
        $cantidad = (int) $request->input('cantidad', 1);

        if ($producto->stock < $cantidad) {
            return redirect()->back()->with('error', 'Stock insuficiente.');
        }

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$producto->id])) {
            $carrito[$producto->id]['cantidad'] += $cantidad;
        } else {
            $carrito[$producto->id] = [
                'id'       => $producto->id,
                'nombre'   => $producto->nombre,
                'precio'   => $producto->precio_final,
                'cantidad' => $cantidad,
                'stock'    => $producto->stock
            ];
        }

        session()->put('carrito', $carrito);
        return redirect()->route('carrito')->with('success', 'Producto añadido al carrito.');
    }

    public function removerDelCarrito($id)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }
        return redirect()->back();
    }

    public function checkout()
    {
        $carrito = session()->get('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('catalogo');
        }
        return view('checkout', compact('carrito'));
    }

    public function procesarCompra(Request $request)
    {
        $request->validate([
            'cliente_nombre'  => 'required|string',
            'cliente_email'   => 'required|email',
            'tarjeta_credito' => 'required|string',
        ]);

        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('factura.mostrar', $venta->id)->with('success', '¡Compra realizada con éxito!');
        }

        DB::beginTransaction();


        try {
            $total = 0;

            // 1. Verificación de stock mediante Eloquent
            foreach ($carrito as $item) {
                $producto = Producto::find($item['id']);
                if (!$producto || $producto->stock < $item['cantidad']) {
                    DB::rollBack();
                    return redirect()->route('carrito')->with('error', "Stock insuficiente para: {$item['nombre']}");
                }
                $total += $item['precio'] * $item['cantidad'];
            }

            // 2. Creación de la venta principal con Eloquent
            $venta = Venta::create([
                'cliente_nombre'  => $request->cliente_nombre,
                'cliente_email'   => $request->cliente_email,
                'tarjeta_credito' => substr($request->tarjeta_credito, -4),
                'total'           => $total
            ]);

            // 3. Creación de detalles a través de la relación Eloquent $venta->detalles()
            foreach ($carrito as $item) {
                $venta->detalles()->create([
                    'producto_id'     => $item['id'],
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio']
                ]);

                // Actualización de stock con Eloquent
                $producto = Producto::find($item['id']);
                $producto->decrement('stock', $item['cantidad']);
            }

            DB::commit();
session()->forget('carrito');

return redirect()->route('factura.mostrar', $venta->id)->with('success', '¡Compra realizada con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }
public function factura(Venta $venta)
{
    $venta->load('detalles.producto.categoria');
    return view('factura', compact('venta'));
}

}