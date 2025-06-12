<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    public $timestamps = false;
    protected $table = 'jornadas';

    protected $fillable = ['id_usuario', 'fecha', 'horas_trabajadas', 'tiempo_pausas'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
