<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PedidosExport implements FromView, ShouldAutoSize
{
    protected $pedidos;
    protected $fechaInicio;
    protected $fechaFin;

    public function __construct($pedidos, $fechaInicio, $fechaFin)
    {
        $this->pedidos = $pedidos;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        
    }

    public function view(): View
    {
        // Retorna la vista que contendrá los datos a exportar
        return view('pedidos.historial_excel', [
            'pedidos' => $this->pedidos,
            'totalMonto' => $this->pedidos->sum('monto_total'),
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ]);
    }
}
