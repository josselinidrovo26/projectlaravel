<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Persona;
use App\Models\Estudiante;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    use HasFactory;
    protected $fillable = ['abono', 'diferencia', 'estado', 'estudiante_id', 'eventoPago','usuarioid', 'suma'];


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($pago) {
            foreach ($pago->getAttributes() as $key => $value) {
                $pago->$key = Str::upper($value);
            }
        });
    }


    public function blog()
    {
        return $this->belongsTo(Blog::class, 'eventoPago' );
    }


    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'usuarioid');
    }


}
