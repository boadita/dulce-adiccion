<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    
    protected $fillable = [
        'descripcion',
        'categoria_id',
        'precio', 
        'imagen',
        'disponible'
    ];

    public function items()
    {
        return $this->hasMany(Items::class);
    }

    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
