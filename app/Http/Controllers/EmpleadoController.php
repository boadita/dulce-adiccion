<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::all();
        //$empleados = Empleado::where('id', '<>', '3')->get();
        return view('empleados.index', compact('empleados'));
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
            'nombre' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:empleados,email',
            'password' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Subir la imagen si existe
        if ($request->hasFile('imagen')) {
            $imageName = $request->nombre.'.'.$request->imagen->extension();
            $request->imagen->move(public_path('imagenes/empleados'), $imageName);
        }
    
        // Crear el nuevo empleado
        Empleado::create([
            'nombre' => $request->nombre,
            'nickname' => $request->nickname,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'imagen' => $imageName,
        ]);
    
        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $empleados = Empleado::findOrFail($id);
        return view('empleados.show', compact('empleados'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $empleados = Empleado::findOrFail($id);

        // Verifica si el empleado fue encontrado
    if ($empleados) {
        return response()->json($empleados); // Devuelve los datos del empleado como JSON
    } else {
        return response()->json(['message' => 'Empleado no encontrado'], 404); // Manejo de error si no se encuentra el empleado
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        $empleados = Empleado::findOrFail($id);

         // Actualizar los datos del empleado
        $empleados->nombre = $request->nombre;
        $empleados->nickname = $request->nickname;
        $empleados->telefono = $request->telefono;
        $empleados->email = $request->email;

    // Guardar los cambios
    $empleados->save();

    // Redirigir con un mensaje de éxito
    return response()->json(['success' => 'Empleado actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleados = Empleado::findOrFail($id);
        $empleados->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}
