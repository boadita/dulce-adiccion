<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    
    protected $fillable = [
        'empleados_id',
        'cliente_id',
        'monto_total', 
        'fecha_pedido',
        'fecha_entrega',
        'estado',
        'pago',
        'direccion'
    ];

    public function items()
    {
        return $this->hasMany(Items::class);
    }

    public function clientes()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function empleados()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
