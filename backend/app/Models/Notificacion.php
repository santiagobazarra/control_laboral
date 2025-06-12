<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    public $timestamps = false;
    protected $table = 'notificaciones';

    protected $fillable = ['id_usuario', 'mensaje', 'leida'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
