<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipanteEvento extends Model
{
    public $timestamps = false;
    protected $table = 'participantes_evento';
    
    protected $primaryKey = null;
    public $incrementing = false;
    
    protected $fillable = ['id_evento', 'id_usuario', 'es_organizador'];

    public function evento()
    {
        return $this->belongsTo(EventoCalendario::class, 'id_evento');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
