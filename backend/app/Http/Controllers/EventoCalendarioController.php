<?php

namespace App\Http\Controllers;

use App\Models\EventoCalendario;
use App\Services\EventoCalendarioService;
use Illuminate\Http\Request;

class EventoCalendarioController extends Controller
{
    protected $eventoService;

    public function __construct(EventoCalendarioService $eventoService)
    {
        $this->eventoService = $eventoService;
    }

    public function index()
    {
        return response()->json($this->eventoService->getAllEventos());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string',
            'descripcion' => 'nullable|string',
            'fecha_hora_inicio' => 'required|date',
            'fecha_hora_fin' => 'required|date|after_or_equal:fecha_hora_inicio',
            'creado_por' => 'required|integer|exists:usuarios,id',
            'organizador_id' => 'nullable|integer|exists:usuarios,id',
            'es_publico' => 'sometimes|boolean',
        ]);

        $evento = $this->eventoService->createEvento($data);

        return response()->json($evento, 201);
    }

    public function show($id)
    {
        $evento = $this->eventoService->getEventoById($id);
        if (!$evento) {
            return response()->json(['error' => 'Evento no encontrado'], 404);
        }
        return response()->json($evento);
    }

    public function update(Request $request, $evento)
    {
        $eventoCalendario = EventoCalendario::findOrFail($evento);

        $this->eventoService->updateEvento($eventoCalendario, $request->all());

        return response()->json($eventoCalendario);
    }

    public function destroy(EventoCalendario $evento)
    {
        return $this->eventoService->deleteEvento($evento);
    }
}
