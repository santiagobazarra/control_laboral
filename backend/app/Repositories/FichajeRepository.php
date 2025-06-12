<?php

namespace App\Repositories;

use App\Models\Fichaje;

class FichajeRepository
{
    public function getAll()
    {
        return Fichaje::all();
    }

    public function findByUsuarioId($id_usuario)
    {
        return Fichaje::where('id_usuario', $id_usuario)
        ->orderBy('hora_fichaje', 'desc')
        ->get();
    }

    public function create(array $data)
    {
        return Fichaje::create($data);
    }

    public function update(Fichaje $fichaje, array $data)
    {
        $fichaje->update($data);
        return $fichaje;
    }

    public function delete(Fichaje $fichaje)
    {
        return $fichaje->delete();
    }
}
