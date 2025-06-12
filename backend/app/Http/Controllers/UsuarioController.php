<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Services\UsuarioService;

class UsuarioController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function index()
    {
        return response()->json($this->usuarioService->getAllUsuarios());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'email' => 'required|email|unique:usuarios,email',
            'password_hash' => 'required|string',
            'esta_activo' => 'boolean',
            'id_rol' => 'required|integer|exists:roles,id',
            'id_departamento' => 'required|integer|exists:departamentos,id',
        ]);

        $usuario = $this->usuarioService->createUsuario($data);

        return response()->json($usuario, 201);
    }

    public function show($id)
    {
        $usuario = $this->usuarioService->getUsuarioById($id);
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json($usuario);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $this->usuarioService->updateUsuario($usuario, $request->all());

        return response()->json($usuario);
    }


    public function destroy(Usuario $usuario)
    {
        return $this->usuarioService->deleteUsuario($usuario);
    }
}
