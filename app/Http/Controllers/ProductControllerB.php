<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category' => 'nullable|string'
        ]);

        $client = new Client();
        
        try {
            $imageName = Str::uuid() . '.jpg';
            $imagePath = public_path('storage/products/' . $imageName);
            
            // Log de depuración
            Log::info('Ruta de imagen: ' . $imagePath);

            // Verificar si el directorio existe
            if (!is_dir(dirname($imagePath))) {
                mkdir(dirname($imagePath), 0755, true);
            }

            // Descargar imagen
            $client->request('GET', 'https://source.unsplash.com/300x300/?product', [
                'sink' => $imagePath
            ]);

            // Verificar si el archivo se guardó
            if (!file_exists($imagePath)) {
                throw new \Exception('Imagen no se pudo guardar');
            }

            $producto = Product::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'description' => $validatedData['description'] ?? 'Sin descripción',
                'category' => $validatedData['category'] ?? 'Sin categoría',
                'imagen' => 'products/' . $imageName
            ]);

            return response()->json($producto, 201);

        } catch (\Exception $e) {
            Log::error('Error al obtener imagen: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al obtener imagen',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Otros métodos del controlador...
}
