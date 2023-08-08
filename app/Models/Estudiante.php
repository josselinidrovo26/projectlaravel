<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pago;
use Illuminate\Support\Str;

use App\Models\Persona;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiante';
    protected $fillable = ['curso', 'persona_id', 'periodo',];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'estudiante_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($estudiante) {
            foreach ($estudiante->getAttributes() as $key => $value) {
                $estudiante->$key = Str::upper($value);
            }
        });
    }



}
