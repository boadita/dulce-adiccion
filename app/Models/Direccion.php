<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direccion';
    
    protected $fillable = [
        'lugar',
        'cliente_id'
    ];

    public function clientes()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
