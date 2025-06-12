<?php

namespace App\Services;
use App\Repositories\DepartamentoRepository;
use App\Models\Departamento;

class DepartamentoService
{
    protected $departamentoRepository;

    public function __construct(DepartamentoRepository $departamentoRepository)
    {
        $this->departamentoRepository = $departamentoRepository;
    }

    public function getAllDepartamentos()
    {
        return $this->departamentoRepository->getAll();
    }

    public function getDepartamentoById($id)
    {
        return $this->departamentoRepository->findById($id);
    }

    public function createDepartamento(array $data)
    {
        return $this->departamentoRepository->create($data);
    }

    public function updateDepartamento(Departamento $departamento, array $data)
    {
        return $this->departamentoRepository->update($departamento, $data);
    }

    public function deleteDepartamento(Departamento $departamento)
    {
        return $this->departamentoRepository->delete($departamento);
    }
}
