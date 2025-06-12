<?php

namespace App\Services;

use App\Models\EventoCalendario;
use App\Repositories\EventoCalendarioRepository;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class EventoCalendarioService
{
    protected $eventoCalendarioRepository;

    public function __construct(EventoCalendarioRepository $eventoCalendarioRepository)
    {
        $this->eventoCalendarioRepository = $eventoCalendarioRepository;
    }

    public function getAllEventos()
    {
        return $this->eventoCalendarioRepository->getAll();
    }

    public function getEventoById($id)
    {
        return $this->eventoCalendarioRepository->findById($id);
    }

    public function createEvento(array $data)
    {
        DB::beginTransaction();
        try {
            if (strtotime($data['fecha_hora_fin']) <= strtotime($data['fecha_hora_inicio'])) {
                throw new InvalidArgumentException("La fecha de fin debe ser posterior a la de inicio.");
            }

            $evento = $this->eventoCalendarioRepository->create($data);
            
            $organizadorId = $data['organizador_id'] ?? $data['creado_por'];
            
            \App\Models\ParticipanteEvento::create([
                'id_evento' => $evento->id,
                'id_usuario' => $organizadorId,
                'es_organizador' => true,
            ]);

            DB::commit();
            return $evento;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateEvento(EventoCalendario $evento, array $data)
    {
        return $this->eventoCalendarioRepository->update($evento, $data);
    }

    public function deleteEvento(EventoCalendario $evento)
    {
        return $this->eventoCalendarioRepository->delete($evento);
    }
}
