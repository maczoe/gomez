<?php

use App\Models\Producto;
use App\Models\Venta;
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
        Schema::create('lineasv', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Venta::class)->constrained();
            $table->decimal('cantidad', 12, 2);
            $table->foreignIdFor(Producto::class)->constrained();
            $table->decimal('unitario', 12, 2);
            $table->decimal('precio', 12, 2);
            $table->decimal('costo', 12, 2);
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
        Schema::dropIfExists('lineasv');
    }
};
