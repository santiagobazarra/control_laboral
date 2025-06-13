<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use App\Services\NotificacionService;

class NotificacionController extends Controller
{
    protected $notificacionService;

    public function __construct(NotificacionService $notificacionService)
    {
        $this->notificacionService = $notificacionService;
    }

    public function index()
    {
        return response()->json($this->notificacionService->getAllNotificaciones());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => 'required|integer|exists:usuarios,id',
            'mensaje' => 'required|string',
            'leida' => 'sometimes|boolean',
        ]);

        $notificacion = $this->notificacionService->crearNotificacion($data);

        return response()->json($notificacion, 201);
    }

    public function show($id)
    {
        $notificacion = $this->notificacionService->getNotificacionesPorUsuario($id);
        if (!$notificacion) {
            return response()->json(['error' => 'Notificación no encontrada'], 404);
        }
        return response()->json($notificacion);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_usuario' => 'sometimes|required|integer|exists:usuarios,id',
            'mensaje' => 'sometimes|required|string',
            'leida' => 'sometimes|boolean',
        ]);

        $notificacion = $this->notificacionService->actualizarNotificacion($id, $data);

        return response()->json($notificacion);
    }

    public function marcarComoLeida($id)
    {
        $notificacion = Notificacion::find($id);

        if (!$notificacion) {
            return response()->json(['error' => 'Notificación no encontrada'], 404);
        }

        $notificacionActualizada = $this->notificacionService->marcarComoLeida($notificacion);

        return response()->json($notificacionActualizada);
    }


    public function destroy($id)
    {
        $notificacion = Notificacion::find($id);

        if (!$notificacion) {
            return response()->json(['error' => 'Notificación no encontrada'], 404);
        }

        $this->notificacionService->eliminarNotificacion($notificacion);
        return response()->json(null, 204);
    }
}
