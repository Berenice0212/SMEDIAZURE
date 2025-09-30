<?php

namespace App\Http\Controllers;

use App\Models\ReportePrincipal;
use App\Models\UbicacionAntena;
use Illuminate\Http\Request;

class ReportePrincipalController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'creado_por'     => 'required|exists:users,id',
            'tecnico_id'     => 'nullable|exists:users,id',
            'id_antena'      => 'required|exists:ubicacion_antenas,id_antena',
            'ip_antena'      => 'required|ip',
            'id_localidad'   => 'required|integer',
            'id_municipio'   => 'required|integer',
            'latitud'        => 'required|numeric',
            'longitud'       => 'required|numeric',
            'fecha_fallo'    => 'required|date',
            'descripcion_admin' => 'required|string',
        ]);

        // Validar consistencia id_antena ↔ ip_antena
        $antena = UbicacionAntena::findOrFail($data['id_antena']);
        if ($antena->ip !== $data['ip_antena']) {
            return back()->withErrors(['ip_antena' => 'La IP no coincide con la antena seleccionada.'])->withInput();
        }

        $reporte = ReportePrincipal::create($data);

        return redirect()->route('reporte-principal.show', $reporte)->with('success', 'Reporte creado.');
    }

    public function update(Request $request, ReportePrincipal $reporte_principal)
    {
        // Si ya está finalizado, no se edita
        if ($reporte_principal->estado === 'finalizado') {
            abort(403, 'Este reporte ya está finalizado.');
        }

        $data = $request->validate([
            'tecnico_id'        => 'nullable|exists:users,id',
            'descripcion_admin' => 'required|string',
            'estado'            => 'required|in:pendiente,en_proceso,finalizado',
        ]);

        $reporte_principal->update($data);

        // Si lo finalizan aquí, sello fecha_finalizacion
        if ($data['estado'] === 'finalizado' && is_null($reporte_principal->fecha_finalizacion)) {
            $reporte_principal->update(['fecha_finalizacion' => now()]);
        }

        return back()->with('success', 'Reporte actualizado.');
    }
}
