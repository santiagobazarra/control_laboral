<?php

namespace App\Repositories;

use App\Models\Departamento;

class DepartamentoRepository
{
    public function getAll()
    {
        return Departamento::all();
    }

    public function findById($id)
    {
        return Departamento::find($id);
    }

    public function create(array $data)
    {
        return Departamento::create($data);
    }

    public function update(Departamento $departamento, array $data)
    {
        $departamento->update($data);
        return $departamento;
    }

    public function delete(Departamento $departamento)
    {
        return $departamento->delete();
    }
}
