<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditoria';
    protected $fillable = ['fecha_hora', 'sentencia', 'usuario', 'modulo', 'interfaz', 'codigo','sentencia'];
    public function getFechaHoraAttribute()
    {
        return $this->attributes['fecha-hora'];
    }


    public function setFechaHoraAttribute($value)
    {
        $this->attributes['fecha-hora'] = $value;
    }

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(Persona::class, 'usuario', 'usuario_id');
    }
}
