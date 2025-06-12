<?php

namespace App\Repositories;

use App\Models\Notificacion;

class NotificacionRepository
{
    public function getAll()
    {
        return Notificacion::all();
    }

    public function findById($id)
    {
        return Notificacion::find($id);
    }

    public function findByUsuarioId($usuarioId)
    {
        return Notificacion::where('usuario_id', $usuarioId)->get();
    }

    public function create(array $data)
    {
        return Notificacion::create($data);
    }

    public function update(Notificacion $notificacion, array $data)
    {
        $notificacion->update($data);
        return $notificacion;
    }

    public function delete(Notificacion $notificacion)
    {
        return $notificacion->delete();
    }
}
