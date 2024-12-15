<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Direccion;
use App\Models\Items;
use App\Models\Pedidos;
use App\Models\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PedidosExport;



class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pedidos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'ci_nit' => 'required',
        ]);

        $ci_nit = $request->ci_nit;
        $count = Cliente::where('NIT', $ci_nit)->count();

        if ($count == 0) {
            return view('clientes.create', compact('ci_nit'));
        } else {
            $cliente = Cliente::where('NIT', $ci_nit)->first();
            $direccion = Direccion::where('cliente_id', $cliente->id)->get();
            $categorias = Categoria::all();
            return view('clientes.show', compact('cliente', 'direccion', 'categorias'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'pedidos' => 'required|array',
            'items' => 'required|array',
        ]);

        $pedidos = $request->pedidos;
        $items = $request->items;

        try {

            $pedido = Pedidos::create([
                'empleados_id' => $pedidos['empleado_id'],
                'cliente_id' => $pedidos['cliente_id'],
                'monto_total' => $pedidos['monto_total'],
                'fecha_pedido' => $pedidos['fecha_pedido'],
                'fecha_entrega' => $pedidos['fecha_entrega'],
                'estado' => 'Pendiente',
                'pago' => 'Pendiente',
                'direccion' => $pedidos['direccion'],
            ]);

            // Crear un nuevo producto
            foreach ($items as $item) {
                Items::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_cant' => $item['precio_cant'],
                ]);
            }

            return response()->json([
                'redirect_url' => route('pedidos.show', ['pedido' => $pedido->id])
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pedido = Pedidos::findOrFail($id);  // Obtener el pedido por ID
        $items = Items::where('pedido_id', $id)->get();  // Obtener los items relacionados con el pedido
        $productos = Producto::all();  // Obtener todos los productos
        $clientes = Cliente::all();  // Obtener todos los clientes

        return view('pedidos.show', compact('pedido', 'items', 'productos', 'clientes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pedidos = Pedidos::findOrFail($id);
        $items = Items::where('pedido_id', $id)->get();
        return view('pedidos.edit', compact('pedidos', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'estado' => 'required',
            'pago' => 'required',
        ]);

        $pedidos = Pedidos::findOrFail($id);

        // Actualizar los datos del empleado
        $pedidos->estado = $request->estado;
        $pedidos->pago = $request->pago;

        // Guardar los cambios
        $pedidos->save();

        $pedidos_hoy = Pedidos::where('fecha_pedido', now()->toDateString())->get();
        $count_hoy = Pedidos::where('fecha_pedido', now()->toDateString())->count();
        $pedidos_para_hoy = Pedidos::where('fecha_entrega', now()->toDateString())->get();
        $count_para_hoy = Pedidos::where('fecha_entrega', now()->toDateString())->count();
        return view('pedidos.hoy', compact('pedidos_hoy', 'pedidos_para_hoy', 'count_hoy', 'count_para_hoy'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function hoy()
    {
        $pedidos_hoy = Pedidos::where('fecha_pedido', now()->toDateString())->get();
        $count_hoy = Pedidos::where('fecha_pedido', now()->toDateString())->count();
        $pedidos_para_hoy = Pedidos::where('fecha_entrega', now()->toDateString())->get();
        $count_para_hoy = Pedidos::where('fecha_entrega', now()->toDateString())->count();
        return view('pedidos.hoy', compact('pedidos_hoy', 'pedidos_para_hoy', 'count_hoy', 'count_para_hoy'));
    }

    public function historial()
    {
        $fechaInicio = now();
        $fechaFin = now();
        $pedidos = Pedidos::where('pago', 'Pagado')->get();
        $totalMonto = $pedidos->sum('monto_total');
        return view('pedidos.historial', compact('pedidos', 'totalMonto', 'fechaInicio', 'fechaFin'));
    }
    public function filtrar(Request $request)
    {
        // Validar las fechas ingresadas
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Obtener las fechas del request
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Realizar la consulta con Eloquent filtrando por el rango de fechas
        $pedidos = Pedidos::whereBetween('fecha_entrega', [$fechaInicio, $fechaFin])->where('pago', 'Pagado')->get();
        $totalMonto = $pedidos->sum('monto_total');

        // Retornar la vista con los resultados de la consulta
        return view('pedidos.historial', compact('pedidos', 'totalMonto', 'fechaInicio', 'fechaFin'));
    }

    public function pdf(string $id)
    {
        set_time_limit(300);
        $pedido = Pedidos::findOrFail($id);  // Obtener el pedido por ID
        $items = Items::where('pedido_id', $id)->get();
        $pdf = Pdf::loadView('pedidos.pdf', compact('pedido', 'items'));
        return $pdf->download('pedidos.pdf');
    }

    public function historial_pdf(Request $request)
    {
        // Validar las fechas ingresadas
        $request->validate([
            'f_inicio',
            'f_fin',
        ]);


        // Obtener las fechas del request
        $fechaInicio = $request->input('f_inicio');
        $fechaFin = $request->input('f_fin');

        // Realizar la consulta con Eloquent filtrando por el rango de fechas
        if($fechaInicio=='' && $fechaFin =='')
        {
            $pedidos = Pedidos::where('pago', 'Pagado')->get();
        }
        else
        {
            $pedidos = Pedidos::whereBetween('fecha_entrega', [$fechaInicio, $fechaFin])->where('pago', 'Pagado')->get();
        }
        $totalMonto = $pedidos->sum('monto_total');

        // Retornar la vista con los resultados de la consulta
        $pdf = Pdf::loadView('pedidos.historial_pdf', compact('pedidos', 'totalMonto', 'fechaInicio', 'fechaFin'));
        return $pdf->download('pedidos.historial_pdf');
    }

    public function historial_excel(Request $request)
{
    // Validar las fechas ingresadas
    $request->validate([
        'ff_inicio',
        'ff_fin',
    ]);

    // Obtener las fechas del request
    $fechaInicio = $request->input('ff_inicio');
    $fechaFin = $request->input('ff_fin');

    // Realizar la consulta con Eloquent filtrando por el rango de fechas
    if ($fechaInicio == '' && $fechaFin == '') {
        $pedidos = Pedidos::where('pago', 'Pagado')->get();
    } else {
        $pedidos = Pedidos::whereBetween('fecha_entrega', [$fechaInicio, $fechaFin])->where('pago', 'Pagado')->get();
    }

    // Exportar los pedidos a Excel usando la clase exportadora
    return Excel::download(new PedidosExport($pedidos, $fechaInicio, $fechaFin), 'historial_pedidos.xlsx');
}

}
