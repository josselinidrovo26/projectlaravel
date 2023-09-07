<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Periodo extends Model
{
    use HasFactory;
    protected $fillable = ['nombrePeriodo','estado', 'inicioVigencia', 'finVigencia'];
    protected $table = 'periodos';

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($periodo) {
            foreach ($periodo->getAttributes() as $key => $value) {
                $periodo->$key = Str::upper($value);
            }
        });
    }
}
