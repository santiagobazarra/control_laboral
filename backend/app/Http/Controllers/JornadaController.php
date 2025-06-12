<?php

namespace App\Http\Controllers;

use App\Services\JornadaService;
use Illuminate\Http\Request;

class JornadaController extends Controller
{
    protected $jornadaService;

    public function __construct(JornadaService $jornadaService)
    {
        $this->jornadaService = $jornadaService;
    }

    public function index()
    {
        return response()->json($this->jornadaService->getAllJornadas());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => 'required|integer|exists:usuarios,id',
            'fecha' => 'required|date',
            'horas_trabajadas' => 'required',
            'tiempo_pausas' => 'required',
        ]);

        $jornada = $this->jornadaService->createJornada($data);

        return response()->json($jornada, 201);
    }

    public function show($id)
    {
        $jornada = $this->jornadaService->getJornadaById($id);
        if (!$jornada) {
            return response()->json(['error' => 'Jornada no encontrada'], 404);
        }
        return response()->json($jornada);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_usuario' => 'sometimes|required|integer|exists:usuarios,id',
            'fecha' => 'sometimes|required|date',
            'horas_trabajadas' => 'sometimes|required',
            'tiempo_pausas' => 'sometimes|required',
        ]);

        $jornada = $this->jornadaService->updateJornada($id, $data);

        return response()->json($jornada);
    }

    public function destroy($id)
    {
        $this->jornadaService->deleteJornada($id);
        return response()->json(null, 204);
    }
}
