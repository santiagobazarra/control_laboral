<?php

namespace App\Services;

use App\Models\Jornada;
use App\Repositories\JornadaRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use InvalidArgumentException;

class JornadaService
{
    protected $jornadaRepository;

    public function __construct(JornadaRepository $jornadaRepository)
    {
        $this->jornadaRepository = $jornadaRepository;
    }

    public function getAllJornadas()
    {
        return $this->jornadaRepository->getAll();
    }

    public function getJornadaById($id)
    {
        return $this->jornadaRepository->findById($id);
    }

    public function createJornada(array $data)
    {
        DB::beginTransaction();
        try {
            // Validaciones adicionales de lógica empresarial pueden ir aquí
            if (empty($data['horas_trabajadas']) || empty($data['tiempo_pausas'])) {
                throw new InvalidArgumentException("Faltan datos obligatorios.");
            }

            $jornada = $this->jornadaRepository->create($data);
            DB::commit();
            return $jornada;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateJornada(Jornada $jornada, array $data)
    {
        return $this->jornadaRepository->update($jornada, $data);
    }

    public function deleteJornada(Jornada $jornada)
    {
        return $this->jornadaRepository->delete($jornada);
    }

    // Ejemplo de posible cálculo de total horas trabajadas (para futuras ampliaciones)
    public function calcularTotalHorasTrabajadas(array $jornadas)
    {
        $total = CarbonInterval::seconds(0);

        foreach ($jornadas as $jornada) {
            $horas = CarbonInterval::parse($jornada->horas_trabajadas);
            $total = $total->add($horas);
        }

        return $total;
    }
}
