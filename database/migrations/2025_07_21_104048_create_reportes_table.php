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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();

            // Relación con tabla users (quien crea y quien resuelve)
            $table->foreignId('creado_por')->constrained('users', 'id');
            $table->foreignId('tecnico_id')->nullable()->constrained('users', 'id');


            // Relación con tabla ubicacion_antenas (por IP única)
            $table->unsignedBigInteger('id_antena');
            $table->foreign('id_antena')->references('id_antena')->on('ubicacion_antenas')->onDelete('cascade');
            $table->string('ip_antena');


            // Datos que se autocompletan al seleccionar la antena
            $table->unsignedBigInteger('id_localidad');
            $table->unsignedBigInteger('id_municipio');
            $table->string('latitud');
            $table->string('longitud');

            // Fechas
            $table->dateTime('fecha_fallo'); // Elegida por el usuario
            $table->dateTime('fecha_finalizacion')->nullable(); // Automática cuando el técnico guarda

            // Estados del reporte
            $table->enum('estado', ['pendiente', 'en_proceso', 'finalizado'])->default('pendiente');

            // Descripciones largas
            $table->longText('descripcion_admin');  // Quien crea
            $table->longText('descripcion_tecnico')->nullable(); // Técnico
            $table->longText('solucion')->nullable(); // Técnico

            $table->timestamps(); // created_at = fecha de creación
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
