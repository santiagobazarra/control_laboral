<?php

namespace App\Services;
use App\Repositories\RolRepository;
use App\Models\Rol;

class RolService
{
    protected $rolRepository;

    public function __construct(RolRepository $rolRepository)
    {
        $this->rolRepository = $rolRepository;
    }

    public function getAllRoles()
    {
        return $this->rolRepository->getAll();
    }

    public function getRolById($id)
    {
        return $this->rolRepository->findById($id);
    }

    public function createRol(array $data)
    {
        return $this->rolRepository->create($data);
    }

    public function updateRol(Rol $rol, array $data)
    {
        return $this->rolRepository->update($rol, $data);
    }

    public function deleteRol(Rol $rol)
    {
        return $this->rolRepository->delete($rol);
    }
}
