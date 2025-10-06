<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UbicacionAntenaController;
use App\Http\Controllers\Api\UbicacionAntenaApiController;
use App\Http\Controllers\Api\MunicipioApiController;
use App\Http\Controllers\Api\LocalidadApiController;

use App\Http\Controllers\Api\ReportePrincipalApiController;
use App\Http\Controllers\Api\SubreporteApiController;

Route::get('/ubicacion-antena', [UbicacionAntenaController::class, 'apiIndex']);

// Requiere tokens /auth: Sanctum o Passport. Cambia el middleware según uses.
// Desactivado la autenticación por el momento para que no cause conflictos.
//Route::middleware('auth:sanctum')->group(function () {

    // Reporte Principal (admin)
    Route::get   ('/reportes',               [ReportePrincipalApiController::class, 'index']);   // list + filtros
    Route::post  ('/reportes',               [ReportePrincipalApiController::class, 'store']);   // crea + email
    Route::get   ('/reportes/{reporte}',     [ReportePrincipalApiController::class, 'show']);    // detalle
    Route::patch ('/reportes/{reporte}',     [ReportePrincipalApiController::class, 'update']);  // actualizar estado/desc

    // Subreportes (técnico)
    Route::get   ('/reportes/{reporte}/subreportes', [SubreporteApiController::class, 'index']); // lista por reporte
    Route::post  ('/reportes/{reporte}/subreportes', [SubreporteApiController::class, 'store']); // crea + medias
    Route::get   ('/subreportes/{subreporte}',       [SubreporteApiController::class, 'show']);  // detalle subreporte
//});

    // Ubicaciones de antenas
    Route::get   ('/antenas',            [UbicacionAntenaApiController::class, 'index']);   // list + filtros
    Route::post  ('/antenas',            [UbicacionAntenaApiController::class, 'store']);   // crear
    Route::get   ('/antenas/{id}',       [UbicacionAntenaApiController::class, 'show']);    // detalle
    Route::patch ('/antenas/{id}',       [UbicacionAntenaApiController::class, 'update']);  // actualizar
    Route::delete('/antenas/{id}',       [UbicacionAntenaApiController::class, 'destroy']); // eliminar

    // Catálogos para selects (localidades/municipios/estado energía/dispositivos)
    Route::get('/antenas/catalogos/all', [UbicacionAntenaApiController::class, 'catalogos']);

    // Municipios
    Route::get   ('/municipios',           [MunicipioApiController::class, 'index']);
    Route::post  ('/municipios',           [MunicipioApiController::class, 'store']);
    Route::get   ('/municipios/{id}',      [MunicipioApiController::class, 'show']);
    Route::patch ('/municipios/{id}',      [MunicipioApiController::class, 'update']);
    Route::delete('/municipios/{id}',      [MunicipioApiController::class, 'destroy']);

    // Localidades
    Route::get   ('/localidades',          [LocalidadApiController::class, 'index']);
    Route::post  ('/localidades',          [LocalidadApiController::class, 'store']);
    Route::get   ('/localidades/{id}',     [LocalidadApiController::class, 'show']);
    Route::patch ('/localidades/{id}',     [LocalidadApiController::class, 'update']);
    Route::delete('/localidades/{id}',     [LocalidadApiController::class, 'destroy']);

    // Helper: localidades por municipio (para selects dependientes)
    Route::get('/municipios/{id}/localidades', [LocalidadApiController::class, 'byMunicipio']);