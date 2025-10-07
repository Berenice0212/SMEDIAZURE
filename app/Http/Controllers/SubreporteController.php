<?php

namespace App\Http\Controllers;

use App\Models\ReportePrincipal;
use App\Models\Subreporte;
use Illuminate\Http\Request;

class SubreporteController extends Controller
{
    public function store(Request $request, \App\Models\ReportePrincipal $reporte)
    {
        if ($reporte->estado === 'finalizado') abort(403, 'El reporte está finalizado.');
        if (auth()->id() !== (int) $reporte->tecnico_id) abort(403, 'No autorizado.');

        $data = $request->validate([
            'descripcion_tecnico' => 'required|string',
            'solucion'            => 'nullable|string',
            'fecha_visita'        => 'required|date',
            'estado_after'        => 'required|in:pendiente,en_proceso,finalizado',
            'archivos.*'          => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        $sub = \App\Models\Subreporte::create([
            'reporte_principal_id' => $reporte->id,
            'tecnico_id'           => auth()->id(),
            'descripcion_tecnico'  => $data['descripcion_tecnico'],
            'solucion'             => $data['solucion'] ?? null,
            'fecha_visita'         => $data['fecha_visita'],
            'estado_after'         => $data['estado_after'],
        ]);

        // Guardar archivos SOLO en creación
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $file) {
                $relativeDir = "reportes/{$reporte->id}/subreportes/{$sub->id}";
                // guarda en storage/app/public/reportes/...
                $path = $file->store($relativeDir, 'public');

                \App\Models\SubreporteMedia::create([
                    'subreporte_id' => $sub->id,
                    'user_id'       => auth()->id(),
                    'disk'          => 'public',
                    'path'          => $path,   // OJO: sin prefijo "public/"
                    'mime'          => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                ]);
            }
        }

        // Estado del principal
        if ($data['estado_after'] === 'finalizado') {
            $reporte->update(['estado' => 'finalizado', 'fecha_finalizacion' => now()]);
        } elseif ($reporte->estado === 'pendiente') {
            $reporte->update(['estado' => 'en_proceso']);
        }

        return back()->with('success', 'Subreporte registrado con éxito.');
    }
}

