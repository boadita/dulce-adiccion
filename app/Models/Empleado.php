<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Empleado extends Authenticatable
{
    use HasFactory;

    protected $table = 'empleados';
    
    protected $fillable = [
        'nombre',
        'nickname',
        'telefono', 
        'email',
        'password',
        'imagen'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function username()
    {
        return 'nickname';
    }

    public function pedidos()
    {
        return $this->hasMany(Pedidos::class);
    }
}
