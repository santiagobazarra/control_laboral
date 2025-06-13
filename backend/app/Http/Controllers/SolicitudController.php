<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use App\Services\SolicitudService;

class SolicitudController extends Controller
{
    protected $solicitudService;

    public function __construct(SolicitudService $solicitudService)
    {
        $this->solicitudService = $solicitudService;
    }

    public function index()
    {
        return response()->json($this->solicitudService->getAllSolicitudes());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => 'required|integer|exists:usuarios,id',
            'tipo' => 'required|string|in:VACACIONES,BAJA_MEDICA,PERMISO',
            'motivo' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|string|in:PENDIENTE,APROBADA,RECHAZADA',
        ]);

        $solicitud = $this->solicitudService->createSolicitud($data);

        return response()->json($solicitud, 201);
    }

    public function show($id)
    {
        $solicitud = $this->solicitudService->getSolicitudById($id);
        if (!$solicitud) {
            return response()->json(['error' => 'Solicitud no encontrada'], 404);
        }
        return response()->json($solicitud);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_usuario' => 'sometimes|required|integer|exists:usuarios,id',
            'tipo' => 'sometimes|required|string|in:VACACIONES,BAJA_MEDICA,PERMISO',
            'motivo' => 'nullable|string',
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_fin' => 'sometimes|required|date|after_or_equal:fecha_inicio',
            'estado' => 'sometimes|required|string|in:PENDIENTE,APROBADA,RECHAZADA',
        ]);

        $solicitud = Solicitud::find($id); 

        if (!$solicitud) {
            return response()->json(['error' => 'Solicitud no encontrada'], 404);
        }

        $solicitudActualizada = $this->solicitudService->updateSolicitud($solicitud, $data);

        return response()->json($solicitudActualizada);
    }

    public function destroy($id)
    {
        $solicitud = Solicitud::find($id);

        if (!$solicitud) {
            return response()->json(['error' => 'Solicitud no encontrada'], 404);
        }

        $this->solicitudService->deleteSolicitud($solicitud);
        return response()->json(null, 204);
    }
}
