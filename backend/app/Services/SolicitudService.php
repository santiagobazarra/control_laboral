<?php

namespace App\Services;

use App\Models\Solicitud;
use App\Repositories\SolicitudRepository;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class SolicitudService
{
    protected $solicitudRepository;

    public function __construct(SolicitudRepository $solicitudRepository)
    {
        $this->solicitudRepository = $solicitudRepository;
    }

    public function getAllSolicitudes()
    {
        return $this->solicitudRepository->getAll();
    }

    public function getSolicitudById($id)
    {
        return $this->solicitudRepository->findById($id);
    }

    public function createSolicitud(array $data)
    {
        DB::beginTransaction();
        try {
            // Validaciones básicas de negocio
            $tiposValidos = ['VACACIONES', 'BAJA_MEDICA', 'PERMISO'];
            if (!in_array($data['tipo'], $tiposValidos)) {
                throw new InvalidArgumentException("Tipo de solicitud inválido.");
            }

            $estadosValidos = ['PENDIENTE', 'APROBADA', 'RECHAZADA'];
            if (!in_array($data['estado'], $estadosValidos)) {
                throw new InvalidArgumentException("Estado inválido.");
            }

            $solicitud = $this->solicitudRepository->create($data);
            DB::commit();
            return $solicitud;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateSolicitud(Solicitud $solicitud, array $data)
    {
        return $this->solicitudRepository->update($solicitud, $data);
    }

    public function deleteSolicitud(Solicitud $solicitud)
    {
        return $this->solicitudRepository->delete($solicitud);
    }

    // Gestión específica para aprobar o rechazar solicitudes
    public function gestionarEstado(Solicitud $solicitud, string $nuevoEstado, ?string $comentario = null)
    {
        $estadosValidos = ['PENDIENTE', 'APROBADA', 'RECHAZADA'];

        if (!in_array($nuevoEstado, $estadosValidos)) {
            throw new InvalidArgumentException("Estado inválido.");
        }

        $data = [
            'estado' => $nuevoEstado,
            'fecha_actualizacion' => now(),
        ];

        if ($comentario !== null) {
            $data['comentario_admin'] = $comentario;
        }

        return $this->solicitudRepository->update($solicitud, $data);
    }
}
