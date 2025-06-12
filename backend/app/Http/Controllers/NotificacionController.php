<?php

namespace App\Http\Controllers;

use App\Services\NotificacionService;
use Illuminate\Http\Request;

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
        $notificacion = $this->notificacionService->marcarComoLeida($id);

        if (!$notificacion) {
            return response()->json(['error' => 'Notificación no encontrada'], 404);
        }

        return response()->json($notificacion);
    }


    public function destroy($id)
    {
        $this->notificacionService->eliminarNotificacion($id);
        return response()->json(null, 204);
    }
}
