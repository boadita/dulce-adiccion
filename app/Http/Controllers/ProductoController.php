<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        $productos = Producto::all();
        return view('productos.index', compact('productos', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'categoria_id' => 'required',
            'precio' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Subir la imagen si existe
        if ($request->hasFile('imagen')) {
            $imageName = $request->descripcion . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('imagenes/productos'), $imageName);
        }

        // Crear el nuevo empleado
        Producto::create([
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria_id,
            'precio' => $request->precio,
            'imagen' => $imageName,
            'disponible' => 1,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productos = Producto::findOrFail($id);
        return view('productos.show', compact('productos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productos = Producto::findOrFail($id);

        // Verifica si el empleado fue encontrado
        if ($productos) {
            return response()->json($productos); // Devuelve los datos del producto como JSON
        } else {
            return response()->json(['message' => 'Producto no encontrado'], 404); // Manejo de error si no se encuentra el producto
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'categoria_id' => 'required',
            'precio' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'disponible' => 'required|boolean',
        ]);

        $productos = Producto::findOrFail($id);

        // Actualizar los datos del empleado
        $productos->descripcion = $request->descripcion;
        $productos->categoria_id = $request->categoria_id;
        $productos->precio = $request->precio;
        $productos->disponible = $request->disponible;

        // Manejar la carga de la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($productos->imagen) {
                if (Storage::exists('imagenes/productos/' . $productos->imagen)) {
                    Storage::delete('imagenes/productos/' . $productos->imagen);
                }
            }

            // Subir la nueva imagen
            $imageName = $request->descripcion.'.' . $request->imagen->extension();
            $request->imagen->move(public_path('imagenes/productos'), $imageName);

            // Actualizar el campo de la imagen en el producto
            $productos->imagen = $imageName;
            
        }

        // Guardar los cambios
        $productos->save();

        // Redirigir con un mensaje de éxito
        return response()->json(['success' => 'Producto actualizado correctamente']);
    } catch (\Exception $e) {
        // Enviar respuesta de error
        return response()->json([
            'error' => 'Error al actualizar el producto: ' . $e->getMessage(),
        ], 500);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productos = Producto::findOrFail($id);
        $productos->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function filtrarProductos(Request $request)
    {
        if ($request->categoria_id) {
            $productos = Producto::with('categorias')->where('categoria_id', $request->categoria_id)->get();
        } else {
            $productos = Producto::with('categorias')->get();
        }

        // Agregar rutas a los productos
        foreach ($productos as $producto) {
            $producto->show_route = route('productos.show', $producto->id);
            $producto->destroy_route = route('productos.destroy', $producto->id);
        }

        return response()->json($productos);
    }
}
