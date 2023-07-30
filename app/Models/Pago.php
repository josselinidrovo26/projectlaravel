<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Persona;
use App\Models\Estudiante;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    use HasFactory;
    protected $fillable = ['abono', 'diferencia', 'estado', 'estudiante_id', 'eventoPago'];

    

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
