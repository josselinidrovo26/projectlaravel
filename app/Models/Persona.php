<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;
use Illuminate\Support\Str;

class Persona extends Model
{
    protected $table = 'persona';
    use HasFactory;
    protected $fillable = ['nombre', 'cedula', 'edad', 'rol', 'fecha', 'usuario_id'];



    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }


    public function estudiante()
    {
        return $this->hasOne(Estudiante::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($persona) {
            foreach ($persona->getAttributes() as $key => $value) {
                $persona->$key = Str::upper($value);
            }
        });
    }


}
