<?php

namespace App\Http\Controllers;

use App\Models\UbicacionAntena;
use Illuminate\Http\Request;

class UbicacionAntenaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $antenas = UbicacionAntena::with(['localidad', 'municipio', 'estadoEnergia', 'dispositivo'])->get();
        return view('ubicacion_antenas.index', compact('antenas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function apiIndex()
    {
        $antenas = UbicacionAntena::with(['localidad', 'municipio', 'estadoEnergia', 'dispositivo'])->get();

        $data = $antenas->map(function ($antena) {
            return [
                'id' => $antena->id_antena,
                'ip' => $antena->ip,
                'latitud' => $antena->latitud,
                'longitud' => $antena->longitud,
                'localidad' => $antena->localidad->localidad ?? null,
                'municipio' => $antena->municipio->municipio ?? null,
                'estado_energia' => $antena->estadoEnergia->estado_energia ?? null,
                'dispositivo' => [
                    'modelo' => $antena->dispositivo->modelo ?? null,
                ]
            ];
        });

        return response()->json($data);
    }

}
