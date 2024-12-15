<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    
    protected $fillable = [
        'nombre',
        'telefono', 
        'email',
        'NIT'
    ];

    public function direccion()
    {
        return $this->hasMany(Direccion::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedidos::class);
    }
}
