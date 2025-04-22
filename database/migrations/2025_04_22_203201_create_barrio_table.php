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
        Schema::create('barrio', function (Blueprint $table) {
            $table->id();
            $table->string("nombre_barrio", length:355);
            $table->unsignedBigInteger('municipio_id');
            $table->timestamps();
            
            $table->foreign('municipio_id')->references('id')->on('municipio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barrios');
    }
};
