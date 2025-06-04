<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->id('id_localidad');
            $table->string('localidad');
            $table->unsignedBigInteger('id_municipio');
            $table->timestamps();

            $table->foreign('id_municipio')->references('id_municipio')->on('municipios')->onDelete('cascade');
        });
    }
};
