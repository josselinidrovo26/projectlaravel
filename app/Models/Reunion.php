<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    use HasFactory;
    protected $fillable = ['tituloreuniones', 'descripcion', 'fechareuniones', 'inicio', 'fin', 'enlace', 'participantes', 'modonotificar', 'tiempo', 'horario'];
}
