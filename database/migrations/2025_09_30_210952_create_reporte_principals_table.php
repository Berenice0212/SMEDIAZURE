<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reporte_principal', function (Blueprint $table) {
            $table->id();

            // Quién crea y a quién se asigna
            $table->foreignId('creado_por')->constrained('users', 'id')->onDelete('restrict');
            $table->foreignId('tecnico_id')->nullable()->constrained('users', 'id')->onDelete('restrict');

            // Antena (usa PK personalizada id_antena)
            $table->unsignedBigInteger('id_antena');
            $table->foreign('id_antena')->references('id_antena')->on('ubicacion_antenas')->onDelete('cascade');

            // También guardamos IP (snapshot) y validaremos consistencia en el controlador
            $table->string('ip_antena');

            // Snapshot de ubicación (recomendado: decimales para geodatos)
            $table->unsignedBigInteger('id_localidad');
            $table->unsignedBigInteger('id_municipio');
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);

            // Tiempos
            $table->dateTime('fecha_fallo');
            $table->dateTime('fecha_finalizacion')->nullable();

            // Estados
            $table->enum('estado', ['pendiente','en_proceso','finalizado'])->default('pendiente');

            // Descripción del admin
            $table->longText('descripcion_admin');

            $table->timestamps();

            $table->index(['estado','fecha_fallo']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('reporte_principal');
    }
};
