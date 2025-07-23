<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\User;
use App\Models\UbicacionAntena;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

        // Obtener el técnico asignado
        $tecnico = User::find($request->tecnico_id);

        // Enviar correo al técnico asignado
        $this->enviarCorreoAlTecnico($tecnico, $reporte);

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
            $localidad = $reporte->ubicacionAntena->localidad->localidad ?? 'N/D';
            $municipio = $reporte->ubicacionAntena->municipio->municipio ?? 'N/D';

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
