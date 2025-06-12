<?php

namespace App\Http\Controllers;

use App\Models\Fichaje;
use Illuminate\Http\Request;
use App\Services\FichajeService;

class FichajeController extends Controller
{
    protected $fichajeService;

    public function __construct(FichajeService $fichajeService)
    {
        $this->fichajeService = $fichajeService;
    }

    public function index()
    {
        return response()->json($this->fichajeService->getAllFichajes());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => 'required|integer|exists:usuarios,id',
            'tipo' => 'required|string|in:ENTRADA,SALIDA,PAUSA_INICIO,PAUSA_FIN',
            'hora_fichaje' => 'required|date',
        ]);

        $fichaje = $this->fichajeService->createFichaje($data);

        return response()->json($fichaje, 201);
    }

    public function show($id_usuario)
    {
        $fichajes = $this->fichajeService->getFichajeByUsuario($id_usuario);
        if ($fichajes->isEmpty()) {
            return response()->json(['error' => 'No se encontraron fichajes'], 404);
        }
        return response()->json($fichajes);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tipo' => 'required|string|in:ENTRADA,SALIDA,PAUSA_INICIO,PAUSA_FIN',
            'hora_fichaje' => 'sometimes|date',
        ]);

        $fichaje = Fichaje::find($id);
        
        if (!$fichaje) {
            return response()->json(['error' => 'Fichaje no encontrado'], 404);
        }

        $fichajeActualizado = $this->fichajeService->updateFichaje($fichaje, $data);

        return response()->json($fichajeActualizado);
    }

    public function destroy($id)
    {
        $fichaje = Fichaje::find($id);

        if (!$fichaje) {
            return response()->json(['error' => 'Fichaje no encontrado'], 404);
        }

        $this->fichajeService->deleteFichaje($fichaje);

        return response()->json(null, 204);
    }
}
