<?php

namespace App\Repositories;

use App\Models\EventoCalendario;

class EventoCalendarioRepository
{
    public function getAll()
    {
        return EventoCalendario::all();
    }

    public function findById($id)
    {
        return EventoCalendario::find($id);
    }

    public function create(array $data)
    {
        return EventoCalendario::create($data);
    }

    public function update(EventoCalendario $evento, array $data)
    {
        $evento->update($data);
        return $evento;
    }

    public function delete(EventoCalendario $evento)
    {
        return $evento->delete();
    }
}
