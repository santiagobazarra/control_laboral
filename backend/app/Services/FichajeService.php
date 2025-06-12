<?php

namespace App\Services;

use App\Models\Fichaje;
use App\Repositories\FichajeRepository;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class FichajeService
{
    protected $fichajeRepository;

    public function __construct(FichajeRepository $fichajeRepository)
    {
        $this->fichajeRepository = $fichajeRepository;
    }

    public function getAllFichajes()
    {
        return $this->fichajeRepository->getAll();
    }

    public function getFichajeByUsuario($id_usuario)
    {
        return $this->fichajeRepository->findByUsuarioId($id_usuario);
    }

    public function createFichaje(array $data)
    {
        DB::beginTransaction();
        try {
            // Validación simple del tipo de fichaje (opcionalmente puede hacerse en Request)
            $tiposValidos = ['ENTRADA', 'SALIDA', 'PAUSA_INICIO', 'PAUSA_FIN'];
            if (!in_array($data['tipo'], $tiposValidos)) {
                throw new InvalidArgumentException("Tipo de fichaje inválido.");
            }

            $fichaje = $this->fichajeRepository->create($data);
            DB::commit();
            return $fichaje;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateFichaje(Fichaje $fichaje, array $data)
    {
        return $this->fichajeRepository->update($fichaje, $data);
    }

    public function deleteFichaje(Fichaje $fichaje)
    {
        return $this->fichajeRepository->delete($fichaje);
    }
}
