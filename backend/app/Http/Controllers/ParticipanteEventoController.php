<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventoCalendario;
use App\Models\ParticipanteEvento;
use App\Services\ParticipanteEventoService;

class ParticipanteEventoController extends Controller
{
    protected $participanteService;

    public function __construct(ParticipanteEventoService $participanteService)
    {
        $this->participanteService = $participanteService;
    }

    public function index()
    {
        return response()->json($this->participanteService->getAllParticipantes());
    }

    public function store(Request $request, $id_evento)
    {
        $data = $request->validate([
            'id_usuario' => 'required|integer|exists:usuarios,id',
            'es_organizador' => 'sometimes|boolean',
        ]);

        $data['id_evento'] = $id_evento;

        try {
            $participante = $this->participanteService->addParticipante($data);
            return response()->json($participante, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar participante: ' . $e->getMessage()], 500);
        }
    }

    public function show($id_evento, $id_usuario)
    {
        $participante = $this->participanteService->getParticipanteById($id_evento, $id_usuario);
        if (!$participante) {
            return response()->json(['error' => 'Participante no encontrado'], 404);
        }
        return response()->json($participante);
    }

    public function update(Request $request, $id_evento, $id_usuario)
    {
        $data = $request->validate([
            'es_organizador' => 'sometimes|boolean',
        ]);

        $participante = $this->participanteService->updateParticipante($id_evento, $id_usuario, $data);

        return response()->json($participante);
    }

    public function destroy($id_evento, $id_usuario)
    {
        $participante = ParticipanteEvento::where('id_evento', $id_evento)
            ->where('id_usuario', $id_usuario)
            ->first();

        if (!$participante) {
            return response()->json(['error' => 'Participante no encontrado'], 404);
        }

        $this->participanteService->removeParticipante($participante);
        
        return response()->json(null, 204);
    }

    public function participantesPorEvento($evento)
    {
        $participantes = $this->participanteService->getParticipantesPorEvento($evento);

        if ($participantes->isEmpty()) {
            return response()->json(['message' => 'No hay participantes para este evento.'], 404);
        }

        return response()->json($participantes);
    }
}
