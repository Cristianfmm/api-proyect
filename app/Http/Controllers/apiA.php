namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductoController extends Controller {
    // Obtener todos los productos con paginación
    public function index() {
        return Producto::paginate(10);
    }

    // Obtener un producto por ID
    public function show($id) {
        return Producto::findOrFail($id);
    }

    // Crear un nuevo producto con integración de imagen externa
    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|string|max:255',
        ]);

        // Obtener una imagen de un servicio externo (ejemplo: Lorem Picsum)
        $response = Http::get('https://picsum.photos/200');
        $imagenUrl = $response->effectiveUri(); // URL de la imagen generada

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'imagen' => $imagenUrl,
        ]);

        return response()->json($producto, 201);
    }

    // Actualizar un producto
    public function update(Request $request, $id) {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'precio' => 'sometimes|required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'categoria' => 'sometimes|required|string|max:255',
        ]);

        $producto->update($request->all());

        return response()->json($producto);
    }

    // Eliminar un producto
    public function destroy($id) {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return response()->json(['message' => 'Producto eliminado']);
    }
}
