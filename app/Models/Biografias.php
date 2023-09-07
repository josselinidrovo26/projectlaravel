<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Biografias extends Model
{
    protected $table = 'biografias';

    use HasFactory;
    protected $fillable = ['tituloBiografia', 'contenidoBiografia', 'image', 'likes','usuarioid'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($biografia) {
            foreach ($biografia->getAttributes() as $key => $value) {
                $biografia->$key = Str::upper($value);
            }
        });
    }


    public function eliminar()
    {
        $this->delete();
    }

}

