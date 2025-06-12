<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fichaje extends Model
{
    public $timestamps = false;
    protected $table = 'fichajes';

    protected $fillable = ['id_usuario', 'tipo', 'hora_fichaje'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
