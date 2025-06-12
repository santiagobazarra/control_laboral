<?php

namespace App\Services;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Repositories\UsuarioRepository;

class UsuarioService
{
    protected $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function getAllUsuarios()
    {
        return $this->usuarioRepository->getAll();
    }

    public function getUsuarioById($id)
    {
        return $this->usuarioRepository->findById($id);
    }

    public function createUsuario(array $data)
    {
        DB::beginTransaction();
        try {
            // Hasheamos la contraseña
            $data['password_hash'] = Hash::make($data['password']);
            unset($data['password']);

            $usuario = $this->usuarioRepository->create($data);
            DB::commit();
            return $usuario;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateUsuario(Usuario $usuario, array $data)
    {
        if (isset($data['password'])) {
            $data['password_hash'] = Hash::make($data['password']);
            unset($data['password']);
        }
        return $this->usuarioRepository->update($usuario, $data);
    }

    public function deleteUsuario(Usuario $usuario)
    {
        return $this->usuarioRepository->delete($usuario);
    }
}
