<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    public $timestamps = false;
    protected $table = 'solicitudes';

    protected $fillable = [
        'id_usuario', 'tipo', 'motivo',
        'fecha_inicio', 'fecha_fin', 'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
