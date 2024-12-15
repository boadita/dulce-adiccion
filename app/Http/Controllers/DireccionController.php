<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Direccion;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'lugar' => 'required',
            'cliente_id' => 'required',
        ]);

         Direccion::create([
            'lugar' => $request->lugar,
            'cliente_id' => $request->cliente_id,
        ]);

        $cliente= Cliente::where('id', $request->cliente_id)->first();

        $direccion=Direccion::where('cliente_id', $cliente->id)->get();
        $categorias = Categoria::all();
        return view('clientes.show', compact('cliente', 'direccion', 'categorias'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
