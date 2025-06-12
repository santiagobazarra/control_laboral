<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoCalendario extends Model
{
    public $timestamps = false;
    protected $table = 'eventos_calendario';

    protected $fillable = [
        'titulo', 'descripcion', 'fecha_hora_inicio',
        'fecha_hora_fin', 'creado_por', 'es_publico'
    ];

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($evento) {
            $evento->participantes()->delete();
        });
    }
    
    public function participantes()
    {
        return $this->hasMany(ParticipanteEvento::class, 'id_evento');
    }

}
