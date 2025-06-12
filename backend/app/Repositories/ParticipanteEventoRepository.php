<?php

namespace App\Repositories;

use App\Models\ParticipanteEvento;

class ParticipanteEventoRepository
{
    public function getAll()
    {
        return ParticipanteEvento::all();
    }

    public function findById($id)
    {
        return ParticipanteEvento::find($id);
    }
    
    public function findByEventoId($eventoId)
    {
        return ParticipanteEvento::where('id_evento', $eventoId)->get();
    }

    public function create(array $data)
    {
        $participanteExistente = ParticipanteEvento::where('id_evento', $data['id_evento'])
            ->where('id_usuario', $data['id_usuario'])
            ->exists();

        if ($participanteExistente) {
            throw new \Exception('El participante ya está registrado en este evento.');
        }    
        
        return ParticipanteEvento::create($data);
    }

    public function update(ParticipanteEvento $participante, array $data)
    {
        $participante->update($data);
        return $participante;
    }

    public function delete(ParticipanteEvento $participante)
    {
        return ParticipanteEvento::where('id_evento', $participante->id_evento)
            ->where('id_usuario', $participante->id_usuario)
            ->delete();
    }
}

