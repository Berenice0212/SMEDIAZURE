<?php

namespace App\Http\Controllers;

use App\Models\UbicacionAntena;
use Illuminate\Http\Request;
use App\Models\Localidad;
use App\Models\Municipio;
use App\Models\EstadoEnergia;
use App\Models\Dispositivo;

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
        $localidades = Localidad::orderBy('localidad')->get();
        $municipios = Municipio::orderBy('municipio')->get();
        $estadosEnergia = EstadoEnergia::orderBy('estado_energia')->get();
        $dispositivos = Dispositivo::orderBy('modelo')->get();

        return view('ubicacion_antenas.create', compact(
            'localidades',
            'municipios',
            'estadosEnergia',
            'dispositivos'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los campos del formulario
        $validatedData = $request->validate([
            'ip' => 'required|string|max:25|unique:ubicacion_antenas,ip',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'id_localidad' => 'required|exists:localidades,id_localidad',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'id_estado_energia' => 'required|exists:estado_energia,id_estado_energia',
            // 'dispositivo_id' => 'nullable|exists:dispositivos,id', // Si decides usarlo después
        ]);

        // Validar combinación única de latitud y longitud
        $existeUbicacion = \App\Models\UbicacionAntena::where('latitud', $request->latitud)
                                ->where('longitud', $request->longitud)
                                ->exists();

        if ($existeUbicacion) {
            return back()
                ->withErrors(['latitud' => 'Ya existe una antena en esta ubicación (latitud y longitud).'])
                ->withInput();
        }

        // Asignar el dispositivo por defecto (id = 1)
        $validatedData['id_dispositivo'] = 1;

        // Crear nueva antena
        UbicacionAntena::create($validatedData);

        // Redirigir con mensaje de éxito
        return redirect()->route('ubicacion_antenas.index')->with('success', 'Antena creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $antena = UbicacionAntena::with(['localidad', 'municipio', 'estadoEnergia'])->findOrFail($id);
        return view('ubicacion_antenas.show', compact('antena'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $antena = UbicacionAntena::findOrFail($id);
        $localidades = Localidad::orderBy('localidad')->get();
        $municipios = Municipio::orderBy('municipio')->get();
        $estadosEnergia = EstadoEnergia::orderBy('estado_energia')->get();

        return view('ubicacion_antenas.edit', compact(
            'antena',
            'localidades',
            'municipios',
            'estadosEnergia'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $antena = UbicacionAntena::findOrFail($id);

        // Validaciones
        $validatedData = $request->validate([
            'ip' => 'required|string|max:25|unique:ubicacion_antenas,ip,' . $antena->id_antena . ',id_antena',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'id_localidad' => 'required|exists:localidades,id_localidad',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'id_estado_energia' => 'required|exists:estado_energia,id_estado_energia',
        ]);

        // Validar combinación única de latitud y longitud (excluyendo la actual)
        $ubicacionRepetida = UbicacionAntena::where('id_antena', '!=', $antena->id_antena)
            ->where('latitud', $request->latitud)
            ->where('longitud', $request->longitud)
            ->exists();

        if ($ubicacionRepetida) {
            return back()
                ->withErrors(['latitud' => 'Ya existe otra antena en esta ubicación (latitud y longitud).'])
                ->withInput();
        }

        // Actualizar datos
        $antena->update($validatedData);

        return redirect()->route('ubicacion_antenas.index')->with('success', 'Antena actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $antena = UbicacionAntena::findOrFail($id);
        $antena->delete();

        return redirect()->route('ubicacion_antenas.index')
                         ->with([
                            'success' => 'Antena eliminada correctamente.',
                            'alert_type' => 'danger'
                        ]);
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
