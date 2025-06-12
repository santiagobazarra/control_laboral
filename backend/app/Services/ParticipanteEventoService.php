<?php

namespace App\Services;

use App\Models\EventoCalendario;
use App\Models\ParticipanteEvento;
use App\Repositories\ParticipanteEventoRepository;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ParticipanteEventoService
{
    protected $participanteEventoRepository;

    public function __construct(ParticipanteEventoRepository $participanteEventoRepository)
    {
        $this->participanteEventoRepository = $participanteEventoRepository;
    }

    public function getAllParticipantes()
    {
        return $this->participanteEventoRepository->getAll();
    }

    public function getParticipanteById($eventoId, $usuarioId)
    {
        return $this->participanteEventoRepository->findById($eventoId, $usuarioId);
    }

    public function addParticipante(array $data)
    {
        DB::beginTransaction();
        try {
            $participante = $this->participanteEventoRepository->create($data);
            DB::commit();
            return $participante;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateParticipante(ParticipanteEvento $participante, array $data)
    {
        return $this->participanteEventoRepository->update($participante, $data);
    }

    public function removeParticipante(ParticipanteEvento $participante)
    {
        return $this->participanteEventoRepository->delete($participante);
    }

    public function getParticipantesPorEvento($eventoId)
    {
        return $this->participanteEventoRepository->findByEventoId($eventoId);
    }
}
