<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subreportes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reporte_principal_id')->constrained('reporte_principal')->onDelete('cascade');
            $table->foreignId('tecnico_id')->constrained('users', 'id')->onDelete('restrict');

            $table->longText('descripcion_tecnico');
            $table->longText('solucion')->nullable();
            $table->dateTime('fecha_visita');

            // Estado resultante después de esta intervención
            $table->enum('estado_after', ['pendiente','en_proceso','finalizado'])->default('en_proceso');

            $table->timestamps();

            $table->index(['reporte_principal_id','created_at']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('subreportes');
    }
};
