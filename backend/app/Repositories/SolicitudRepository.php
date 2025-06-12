<?php

namespace App\Repositories;

use App\Models\Solicitud;

class SolicitudRepository
{
    public function getAll()
    {
        return Solicitud::all();
    }

    public function findById($id)
    {
        return Solicitud::find($id);
    }

    public function create(array $data)
    {
        return Solicitud::create($data);
    }

    public function update(Solicitud $solicitud, array $data)
    {
        $solicitud->update($data);
        return $solicitud;
    }

    public function delete(Solicitud $solicitud)
    {
        return $solicitud->delete();
    }
}
