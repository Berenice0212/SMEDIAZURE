<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\User;
use App\Models\UbicacionAntena;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        $reportes = Reporte::with(['ubicacionAntena.localidad', 'ubicacionAntena.municipio'])->get();

        return view('reportes.index', compact('reportes'));
    }

    public function create()
    {
        $usuarios = User::all();
        $antenas = UbicacionAntena::with(['localidad', 'municipio'])->get(); // Asegúrate de cargar las relaciones
        return view('reportes.create', compact('usuarios', 'antenas'));
    }

    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'ip_antena' => 'required|exists:ubicacion_antenas,ip',
            'creado_por' => 'required|exists:users,id',
            'tecnico_id' => 'required|exists:users,id',
            'fecha_fallo' => 'required|date',
            'descripcion_admin' => 'required|string',
            'id_antena' => 'required|exists:ubicacion_antenas,id_antena',  // Validar que id_antena exista
        ]);

        // Crear el reporte
        $reporte = Reporte::create([
            'ip_antena' => $request->ip_antena,
            'id_antena' => $request->id_antena,  // Asignar id_antena enviado desde el formulario
            'id_localidad' => $request->id_localidad,
            'id_municipio' => $request->id_municipio,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'fecha_fallo' => $request->fecha_fallo,
            'estado' => 'pendiente', // El estado es pendiente por defecto
            'descripcion_admin' => $request->descripcion_admin,
            'creado_por' => $request->creado_por,
            'tecnico_id' => $request->tecnico_id, // Asignar el técnico
        ]);

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('reportes.index')->with('success', 'Reporte creado exitosamente.');
    }

    public function edit($id)
    {
        $reporte = Reporte::with(['ubicacionAntena.localidad', 'ubicacionAntena.municipio'])->findOrFail($id);

        // Verificar que solo el técnico asignado pueda editar, y que el reporte no esté finalizado
        if (auth()->id() !== $reporte->tecnico_id || $reporte->fecha_finalizacion) {
            abort(403, 'No autorizado.');
        }

        return view('reportes.edit', compact('reporte'));
    }

    public function update(Request $request, $id)
    {
        $reporte = Reporte::findOrFail($id);

        // Verificar que solo el técnico asignado pueda editar
        if (auth()->id() !== $reporte->tecnico_id || $reporte->fecha_finalizacion) {
            abort(403, 'No autorizado.');
        }

        // Validación de los datos
        $request->validate([
            'descripcion_tecnico' => 'required|string',
            'solucion' => 'required|string',
            'fecha_finalizacion' => 'required|date',
        ]);

        // Actualizar los valores del reporte
        $reporte->update([
            'descripcion_tecnico' => $request->descripcion_tecnico,
            'solucion' => $request->solucion,
            'fecha_finalizacion' => $request->fecha_finalizacion,
            'estado' => 'finalizado', // El reporte se marca como finalizado
        ]);

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('reportes.index')->with('success', 'Reporte actualizado y finalizado exitosamente.');
    }

    public function show($id)
    {
        $reporte = Reporte::with(['ubicacionAntena.localidad', 'ubicacionAntena.municipio'])->findOrFail($id);

        return view('reportes.show', compact('reporte'));
    }
}
