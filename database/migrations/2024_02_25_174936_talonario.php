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
        Schema::create('talonario', function (Blueprint $table) {
            $table->id();
            $table->string('cliente');
            $table->string('datosCompra');
            $table->string('totalDeLaCompra');
            $table->string('fechaCompra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talonario');

    }
};
