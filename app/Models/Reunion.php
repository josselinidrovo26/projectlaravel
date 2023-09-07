<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reunion extends Model
{
    use HasFactory;
    protected $fillable = ['tituloreuniones', 'descripcion', 'fechareuniones', 'inicio', 'fin', 'enlace', 'participantes', 'modonotificar', 'tiempo', 'horario'];


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($reunion) {
            foreach ($reunion->getAttributes() as $key => $value) {
                $reunion->$key = Str::upper($value);
            }
        });
    }


}
