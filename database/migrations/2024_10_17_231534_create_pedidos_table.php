<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleados_id'); 
            $table->foreign('empleados_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->unsignedBigInteger('cliente_id'); 
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->decimal('monto_total',6,2);
            $table->date('fecha_pedido');
            $table->date('fecha_entrega');
            $table->string('estado');
            $table->string('pago');
            $table->string('direccion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
