<?php

namespace App\Repositories;

use App\Models\Rol;

class RolRepository
{
    public function getAll()
    {
        return Rol::all();
    }

    public function findById($id)
    {
        return Rol::find($id);
    }

    public function create(array $data)
    {
        return Rol::create($data);
    }

    public function update(Rol $rol, array $data)
    {
        $rol->update($data);
        return $rol;
    }

    public function delete(Rol $rol)
    {
        return $rol->delete();
    }
}
