<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReportePrincipal;
use App\Models\Subreporte;
use App\Models\SubreporteMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SubreporteApiController extends Controller
{
    // GET /api/v1/reportes/{reporte}/subreportes
    public function index(ReportePrincipal $reporte)
    {
        $reporte->load(['subreportes.tecnico','subreportes.medias']);
        // añadir URLs públicas
        $items = $reporte->subreportes->sortByDesc('fecha_visita')->values();
        $items->each(function ($sub) {
            $sub->medias->transform(function ($m) {
                $m->url = Storage::disk($m->disk ?? 'public')->url($m->path);
                return $m;
            });
        });

        return response()->json(['data' => $items]);
    }

    // GET /api/v1/subreportes/{subreporte}
    public function show(Subreporte $subreporte)
    {
        $subreporte->load(['tecnico','medias']);
        $subreporte->medias->transform(function ($m) {
            $m->url = Storage::disk($m->disk ?? 'public')->url($m->path);
            return $m;
        });
        return response()->json(['data' => $subreporte]);
    }

    // POST /api/v1/reportes/{reporte}/subreportes  (multipart/form-data)
    public function store(Request $request, ReportePrincipal $reporte)
    {
        if ($reporte->estado === 'finalizado') {
            return response()->json(['message' => 'El reporte está finalizado.'], 403);
        }
        // Solo el técnico asignado puede crear subreportes
        if ($request->user()->id !== (int) $reporte->tecnico_id) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'descripcion_tecnico' => ['required','string'],
            'solucion'            => ['nullable','string'],
            'fecha_visita'        => ['required','date'],
            'estado_after'        => ['required', Rule::in(['pendiente','en_proceso','finalizado'])],
            'archivos.*'          => ['nullable','file','mimes:jpg,jpeg,png,webp,pdf','max:5120'],
        ]);

        $sub = Subreporte::create([
            'reporte_principal_id' => $reporte->id,
            'tecnico_id'           => $request->user()->id,
            'descripcion_tecnico'  => $data['descripcion_tecnico'],
            'solucion'             => $data['solucion'] ?? null,
            'fecha_visita'         => $data['fecha_visita'],
            'estado_after'         => $data['estado_after'],
        ]);

        // Guardar archivos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $file) {
                $relativeDir = "reportes/{$reporte->id}/subreportes/{$sub->id}";
                $path = $file->store($relativeDir, 'public'); // storage/app/public/...
                SubreporteMedia::create([
                    'subreporte_id' => $sub->id,
                    'user_id'       => $request->user()->id,
                    'disk'          => 'public',
                    'path'          => $path, // sin "public/"
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

        // Respuesta con URLs
        $sub->load(['tecnico','medias']);
        $sub->medias->transform(function ($m) {
            $m->url = Storage::disk($m->disk ?? 'public')->url($m->path);
            return $m;
        });

        return response()->json(['data' => $sub], 201);
    }
}
