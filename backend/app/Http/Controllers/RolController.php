<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Services\RolService;
use Illuminate\Http\Request;

class RolController extends Controller
{
    protected $rolService;

    public function __construct(RolService $rolService)
    {
        $this->rolService = $rolService;
    }

    public function index()
    {
        return response()->json($this->rolService->getAllRoles());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|unique:roles,nombre',
        ]);

        $rol = $this->rolService->createRol($data);

        return response()->json($rol, 201);
    }

    public function show($id)
    {
        $rol = $this->rolService->getRolById($id);
        if (!$rol) {
            return response()->json(['error' => 'Rol no encontrado'], 404);
        }
        return response()->json($rol);
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);

        $this->rolService->updateRol($rol, $request->all());

        return response()->json($rol);
    }

    public function destroy(Rol $rol)
    {
        return $this->rolService->deleteRol($rol);
    }
}
