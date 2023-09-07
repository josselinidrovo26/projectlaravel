<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comentario extends Model
{

    protected $table = 'comentarios';

    protected $fillable = [
        'nombre',
        'contenido',
        'biografias_id',
    ];

   
    public function biografias()
    {
        return $this->belongsTo(Biografias::class, 'biografias_id');
    }

}
