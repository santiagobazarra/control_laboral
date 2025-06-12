<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use App\Services\DepartamentoService;

class DepartamentoController extends Controller
{
    protected $departamentoService;

    public function __construct(DepartamentoService $departamentoService)
    {
        $this->departamentoService = $departamentoService;
    }

    public function index()
    {
        return response()->json($this->departamentoService->getAllDepartamentos());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|unique:departamentos,nombre',
        ]);

        $departamento = $this->departamentoService->createDepartamento($data);

        return response()->json($departamento, 201);
    }

    public function show($id)
    {
        $departamento = $this->departamentoService->getDepartamentoById($id);
        if (!$departamento) {
            return response()->json(['error' => 'Departamento no encontrado'], 404);
        }
        return response()->json($departamento);
    }

    public function update(Request $request, $departamento)
    {
        $departamentoObj = Departamento::findOrFail($departamento);
        return $this->departamentoService->updateDepartamento($departamentoObj, $request->all());
    }


    public function destroy(Departamento $departamento)
    {
        return $this->departamentoService->deleteDepartamento($departamento);
    }
}
