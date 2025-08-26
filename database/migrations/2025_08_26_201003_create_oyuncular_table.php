<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oyuncular', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained('filmler')->onDelete('cascade');
            $table->foreignId('kisi_id')->constrained('kisiler')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oyuncular');
    }
};
