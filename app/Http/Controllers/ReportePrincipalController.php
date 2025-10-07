<?php

namespace App\Http\Controllers;

use App\Models\ReportePrincipal;
use App\Models\UbicacionAntena;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\User;
use Illuminate\Support\Facades\Log; 

class ReportePrincipalController extends Controller
{
    public function index()
    {
        // Cargamos relaciones de la antena (localidad y municipio) para la tabla
        $reportes = \App\Models\ReportePrincipal::with([
            'antena.localidad',
            'antena.municipio',
            'tecnico',
        ])
        ->orderByDesc('id')
        ->get();

        return view('reporte_principal.index', compact('reportes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'creado_por'        => 'required|exists:users,id',
            'tecnico_id'        => 'required|exists:users,id',
            'id_antena'         => 'required|exists:ubicacion_antenas,id_antena',
            'ip_antena'         => 'required|ip',
            'id_localidad'      => 'required|integer',
            'id_municipio'      => 'required|integer',
            'latitud'           => 'required|numeric',
            'longitud'          => 'required|numeric',
            'fecha_fallo'       => 'required|date',
            'descripcion_admin' => 'required|string',
        ]);

        // Validar consistencia antena ↔ IP
        $antena = UbicacionAntena::findOrFail($data['id_antena']);
        if ($antena->ip !== $data['ip_antena']) {
            return back()->withErrors(['ip_antena' => 'La IP no coincide con la antena seleccionada.'])->withInput();
        }

        // Crear
        $reporte = ReportePrincipal::create($data);

        // Notificar al técnico (solo al crear el reporte principal)
        $tecnico = User::find($data['tecnico_id']);
        if ($tecnico) {
            try {
                $this->enviarCorreoAlTecnico($tecnico, $reporte->load('antena.localidad','antena.municipio'));
            } catch (\Throwable $th) {
                Log::error('Error enviando correo de reporte principal: '.$th->getMessage());
                // No romper la UX si falla el correo
            }
        }

        return redirect()->route('reporte-principal.show', $reporte)
            ->with('success', 'Reporte creado y técnico notificado.');
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

    public function create()
    {
        $usuarios = \App\Models\User::all(); // o filtra por rol técnico
        $antenas = \App\Models\UbicacionAntena::with(['localidad','municipio'])->get();

        return view('reporte_principal.create', compact('usuarios','antenas'));
    }

    public function show(\App\Models\ReportePrincipal $reporte_principal)
    {
        $reporte_principal->load([
            'antena.localidad',
            'antena.municipio',
            'creador',
            'tecnico',
            'subreportes.tecnico',
            'subreportes.medias'
        ]);

        return view('reporte_principal.show', compact('reporte_principal'));
    }

    public function enviarCorreoAlTecnico($tecnico, $reporte)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'mail.curvatosoft.com'; // o mailtrap.io, etc.
            $mail->SMTPAuth   = true;
            $mail->Username   = 'alumnos@curvatosoft.com'; // Cambia esto
            $mail->Password   = 'gSe_mHQBq_mc';
            $mail->SMTPSecure = 'ssl'; // o 'ssl'
            $mail->Port       = 465; // o 587

            // Establecer remitente y destinatario
            $mail->setFrom('sender@curvatosoft.com', 'CurvatoSoft');
            $mail->addAddress($tecnico->email); // Correo del técnico asignado

            // Evaluar las variables antes de enviarlas al correo
            $localidad = $reporte->antena->localidad->localidad ?? 'N/D';
            $municipio = $reporte->antena->municipio->municipio ?? 'N/D';

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Nuevo Reporte Asignado';
            $mail->Body    = "
                <div style='font-family: Arial, sans-serif; background-color: #f5efe9ff; padding: 20px; border: 2px solid #3b82f6; border-radius: 10px;'>
                    <h2 style='color: #0b48b8ff;'>Nuevo Reporte Asignado</h2>
                    <p>Hola <strong>{$tecnico->name}</strong>,</p>
                    <p>Se te ha asignado un nuevo reporte que requiere tu atención.</p>
                    <p><strong>Detalles del Reporte:</strong></p>
                    <ul>
                        <li><strong>IP de la Antena:</strong> {$reporte->ip_antena}</li>
                        <li><strong>Localidad:</strong> {$localidad}</li>
                        <li><strong>Municipio:</strong> {$municipio}</li>
                        <li><strong>Fecha del fallo:</strong> {$reporte->fecha_fallo}</li>
                        <li><strong>Descripción:</strong> {$reporte->descripcion_admin}</li>
                    </ul>
                    <p>Por favor, inicia sesión en el sistema para ver los detalles completos y comenzar a trabajar en este reporte.</p>
                    <p>Gracias por tu colaboración.</p>
                    <b>SMEDI</b>
                </div>
            ";

            $mail->send();
            echo 'Correo enviado correctamente.';
        } catch (Exception $e) {
            echo "Error al enviar: {$mail->ErrorInfo}";
        }
    }
}
