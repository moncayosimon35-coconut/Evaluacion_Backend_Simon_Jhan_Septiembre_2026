<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = ['Cómics', 'Ropa', 'Coleccionables', 'Accesorios'];
        foreach ($categorias as $cat) {
            Categoria::firstOrCreate(['nombre' => $cat]);
        }
    }
}