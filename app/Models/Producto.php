<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $fillable = ['nombre', 'descripcion', 'precio', 'stock', 'franquicia', 'categoria_id'];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function detallesVenta(): HasMany
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id');
    }

    // Accessor Eloquent para precio con descuento (Lógica de Negocio en Modelo)
    public function getPrecioFinalAttribute(): float
    {
        if ($this->stock > 20) {
            return round($this->precio * 0.90, 2);
        }
        return (float) $this->precio;
    }

    public function tieneDescuento(): bool
    {
        return $this->stock > 20;
    }
}