<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $table = 'items';
    
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad', 
        'precio_cant'
    ];

    public function pedidos()
    {
        return $this->belongsTo(Pedidos::class, 'pedido_id');
    }

    public function productos()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
