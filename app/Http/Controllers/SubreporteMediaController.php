<?php

namespace App\Http\Controllers;

use App\Models\Subreporte;
use App\Models\SubreporteMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubreporteMediaController extends Controller
{
    public function store(Request $request, Subreporte $subreporte)
    {
        $reporte = $subreporte->reportePrincipal;

        // Bloquear si el principal está finalizado
        if ($reporte->estado === 'finalizado') {
            abort(403, 'El reporte está finalizado; no se pueden subir imágenes.');
        }

        // (Opcional) Solo técnico asignado
        if (auth()->id() !== (int) $reporte->tecnico_id) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'archivos'   => 'required',
            'archivos.*' => 'file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        foreach ($request->file('archivos', []) as $file) {
            $path = $file->store("public/reportes/{$reporte->id}/subreportes/{$subreporte->id}");
            SubreporteMedia::create([
                'subreporte_id' => $subreporte->id,
                'user_id'       => auth()->id(),
                'disk'          => 'public',
                'path'          => $path, // guardar tal cual lo retorna store()
                'mime'          => $file->getClientMimeType(),
                'size'          => $file->getSize(),
            ]);
        }

        return back()->with('success', 'Imágenes cargadas correctamente.');
    }
}

