<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReportePrincipal;
use App\Models\UbicacionAntena;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ReportePrincipalApiController extends Controller
{
    // GET /api/v1/reportes?estado=&tecnico_id=&municipio_id=&search=&page=&per_page=&sort=&dir=
    public function index(Request $req)
    {
        $q = ReportePrincipal::query()
            ->with(['antena.localidad','antena.municipio','creador','tecnico'])
            ->when($req->filled('estado'), fn($qq) => $qq->where('estado', $req->estado))
            ->when($req->filled('tecnico_id'), fn($qq) => $qq->where('tecnico_id', $req->tecnico_id))
            ->when($req->filled('municipio_id'), fn($qq) => $qq->where('id_municipio', $req->municipio_id))
            ->when($req->filled('search'), function ($qq) use ($req) {
                $s = $req->search;
                $qq->where(function ($w) use ($s) {
                    $w->where('ip_antena', 'like', "%$s%")
                      ->orWhere('descripcion_admin', 'like', "%$s%");
                });
            });

        $sort = $req->get('sort', 'id');
        $dir  = $req->get('dir',  'desc') === 'asc' ? 'asc' : 'desc';
        $q->orderBy($sort, $dir);

        $perPage = min((int) $req->get('per_page', 15), 100);
        $data = $q->paginate($perPage);

        return response()->json([
            'data' => $data->items(),
            'meta' => [
                'current_page' => $data->currentPage(),
                'per_page'     => $data->perPage(),
                'total'        => $data->total(),
                'last_page'    => $data->lastPage(),
                'sort'         => $sort,
                'dir'          => $dir,
            ]
        ]);
    }

    // POST /api/v1/reportes
    public function store(Request $request)
    {
        $data = $request->validate([
            'creado_por'        => ['required','exists:users,id'],
            'tecnico_id'        => ['required','exists:users,id'],
            'id_antena'         => ['required','exists:ubicacion_antenas,id_antena'],
            'ip_antena'         => ['required','ip'],
            'id_localidad'      => ['required','integer'],
            'id_municipio'      => ['required','integer'],
            'latitud'           => ['required','numeric'],
            'longitud'          => ['required','numeric'],
            'fecha_fallo'       => ['required','date'],
            'descripcion_admin' => ['required','string'],
        ]);

        // (opcional) fuerza que creado_por sea el usuario autenticado:
        // if ((int)$data['creado_por'] !== (int)$request->user()->id) {
        //     return response()->json(['message' => 'No autorizado para crear a nombre de otro usuario'], 403);
        // }

        // Validar antena ↔ IP
        $antena = UbicacionAntena::findOrFail($data['id_antena']);
        if ($antena->ip !== $data['ip_antena']) {
            return response()->json(['message' => 'La IP no coincide con la antena seleccionada.'], 422);
        }

        $reporte = ReportePrincipal::create($data)->load('antena.localidad','antena.municipio');

        // Enviar correo al técnico
        try {
            $tecnico = User::find($data['tecnico_id']);
            if ($tecnico) {
                $this->enviarCorreoAlTecnico($tecnico, $reporte);
            }
        } catch (\Throwable $th) {
            Log::error('API correo reporte principal: '.$th->getMessage());
        }

        return response()->json(['data' => $reporte], 201);
    }

    // GET /api/v1/reportes/{reporte}
    public function show(ReportePrincipal $reporte)
    {
        $reporte->load([
            'antena.localidad', 'antena.municipio',
            'creador', 'tecnico',
            'subreportes.tecnico', 'subreportes.medias'
        ]);
        return response()->json(['data' => $reporte]);
    }

    // PATCH /api/v1/reportes/{reporte}
    public function update(Request $request, ReportePrincipal $reporte)
    {
        if ($reporte->estado === 'finalizado') {
            return response()->json(['message' => 'Este reporte ya está finalizado.'], 403);
        }

        $data = $request->validate([
            'tecnico_id'        => ['nullable','exists:users,id'],
            'descripcion_admin' => ['required','string'],
            'estado'            => ['required', Rule::in(['pendiente','en_proceso','finalizado'])],
        ]);

        $reporte->update($data);

        if ($data['estado'] === 'finalizado' && is_null($reporte->fecha_finalizacion)) {
            $reporte->update(['fecha_finalizacion' => now()]);
        }

        return response()->json(['data' => $reporte->fresh()]);
    }

    // --- email helper (tu estilo, usando .env) ---
    protected function enviarCorreoAlTecnico(User $tecnico, ReportePrincipal $reporte)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = env('MAIL_HOST', 'mail.curvatosoft.com');
        $mail->SMTPAuth   = true;
        $mail->Username   = env('MAIL_USERNAME', 'alumnos@curvatosoft.com');
        $mail->Password   = env('MAIL_PASSWORD', 'gSe_mHQBq_mc');
        $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'ssl'); // 'ssl' o 'tls'
        $mail->Port       = (int) env('MAIL_PORT', 465);

        $mail->setFrom(env('MAIL_FROM_ADDRESS', 'sender@curvatosoft.com'),
                       env('MAIL_FROM_NAME', 'CurvatoSoft'));
        $mail->addAddress($tecnico->email, $tecnico->name ?? '');

        $localidad = $reporte->antena?->localidad?->localidad ?? 'N/D';
        $municipio = $reporte->antena?->municipio?->municipio ?? 'N/D';

        $mail->isHTML(true);
        $mail->Subject = 'Nuevo Reporte Asignado';
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; background:#f5efe9; padding:20px; border:2px solid #3b82f6; border-radius:10px;'>
                <h2 style='color:#0b48b8;'>Nuevo Reporte Asignado</h2>
                <p>Hola <strong>{$tecnico->name}</strong>,</p>
                <ul>
                    <li><strong>IP Antena:</strong> {$reporte->ip_antena}</li>
                    <li><strong>Localidad:</strong> {$localidad}</li>
                    <li><strong>Municipio:</strong> {$municipio}</li>
                    <li><strong>Fecha fallo:</strong> {$reporte->fecha_fallo}</li>
                    <li><strong>Descripción:</strong> {$reporte->descripcion_admin}</li>
                </ul>
                <p>Inicia sesión para ver más detalles.</p>
            </div>
        ";
        $mail->send();
    }
}
