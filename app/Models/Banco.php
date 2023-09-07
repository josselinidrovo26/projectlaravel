<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banco extends Model
{
    use HasFactory;
    protected $fillable = ['nombre_banco', 'Tipocuenta', 'numcuenta', 'nameUser', 'cedula', 'Telefono'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($banco) {
            foreach ($banco->getAttributes() as $key => $value) {
                $banco->$key = Str::upper($value);
            }
        });
    }
}
