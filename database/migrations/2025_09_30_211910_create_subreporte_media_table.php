<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subreporte_medias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subreporte_id')->constrained('subreportes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('restrict');

            // Dónde está guardado el archivo
            $table->string('disk')->default('public'); // storage disk
            $table->string('path');                    // ruta relativa en el disk
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size')->nullable();

            $table->timestamps();

            $table->index(['subreporte_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('subreporte_medias');
    }
};

