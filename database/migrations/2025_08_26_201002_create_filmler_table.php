<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filmler', function (Blueprint $table) {
            $table->id();
            $table->string('adi');
            $table->text('konusu');
            $table->decimal('imdb_puani', 3, 1)->nullable();
            $table->foreignId('tur_id')->constrained('turler')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filmler');
    }
};
