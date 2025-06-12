<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Repositories\NotificacionRepository;
use Illuminate\Support\Facades\DB;

class NotificacionService
{
    protected $notificacionRepository;

    public function __construct(NotificacionRepository $notificacionRepository)
    {
        $this->notificacionRepository = $notificacionRepository;
    }

    public function getAllNotificaciones()
    {
        return $this->notificacionRepository->getAll();
    }

    public function getNotificacionesPorUsuario($usuarioId)
    {
        return $this->notificacionRepository->findByUsuarioId($usuarioId);
    }

    public function crearNotificacion(array $data)
    {
        DB::beginTransaction();
        try {
            $notificacion = $this->notificacionRepository->create($data);
            DB::commit();
            return $notificacion;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function actualizarNotificacion($id, array $data)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->fill($data);
        $notificacion->save();

        return $notificacion;
    }

    public function marcarComoLeida(Notificacion $notificacion)
    {
        return $this->notificacionRepository->update($notificacion, ['leida' => true]);
    }

    public function eliminarNotificacion(Notificacion $notificacion)
    {
        return $this->notificacionRepository->delete($notificacion);
    }
}
