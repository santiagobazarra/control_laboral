<?php

namespace App\Repositories;

use App\Models\Jornada;

class JornadaRepository
{
    public function getAll()
    {
        return Jornada::all();
    }

    public function findById($id)
    {
        return Jornada::find($id);
    }

    public function create(array $data)
    {
        return Jornada::create($data);
    }

    public function update(Jornada $jornada, array $data)
    {
        $jornada->update($data);
        return $jornada;
    }

    public function delete(Jornada $jornada)
    {
        return $jornada->delete();
    }
}
