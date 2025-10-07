<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UbicacionAntenaController;

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