<?php

namespace App\Http\Controllers;

use App\Models\Jornada;
use Illuminate\Http\Request;
use App\Services\JornadaService;

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

        $jornada = Jornada::find($id);

        if (!$jornada) {
            return response()->json(['error' => 'Jornada no encontrada'], 404);
        }

        $jornadaActualizada = $this->jornadaService->updateJornada($jornada, $data);

        return response()->json($jornadaActualizada);
    }

    public function destroy($id)
    {
        $jornada = Jornada::find($id);
        
        if (!$jornada) {
            return response()->json(['error' => 'Jornada no encontrada'], 404);
        }

        $this->jornadaService->deleteJornada($jornada);
        return response()->json(null, 204);
    }
}
