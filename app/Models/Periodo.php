<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;
    protected $fillable = ['nombrePeriodo','estado', 'inicioVigencia', 'finVigencia'];
    protected $table = 'periodos';
}
