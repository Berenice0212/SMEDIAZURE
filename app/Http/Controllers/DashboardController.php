<?php

namespace App\Http\Controllers;

use App\Models\UbicacionAntena;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $antenas = UbicacionAntena::with([
            'localidad.municipio',
            'municipio',
            'estadoEnergia',
            'dispositivo'
        ])->get();

        // Contar el total de antenas
        $totalAntenas = $antenas->count();

        // Contar antenas según su estado de energía
        $funcionando = $antenas->filter(function ($antena) {
            return optional($antena->estadoEnergia)->estado_energia === 'funcionando';
        })->count();

        $falla = $antenas->filter(function ($antena) {
            return optional($antena->estadoEnergia)->estado_energia === 'falla';
        })->count();

        $panelSolar = $antenas->filter(function ($antena) {
            return optional($antena->estadoEnergia)->estado_energia === 'panel_solar';
        })->count();

        // Retornar la vista con todas las variables necesarias
        return view('dashboard', compact(
            'antenas', 
            'totalAntenas', 
            'funcionando', 
            'falla', 
            'panelSolar'
        ));
    }
}
