<?php

use App\Models\Contacto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignIdFor(Contacto::class)->constrained();
            $table->decimal('total', 12, 2);
            $table->decimal('costo', 12, 2);
            $table->enum('estado', ['finalizado', 'anulado'])->default('finalizado');
            $table->string('obeservaciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
