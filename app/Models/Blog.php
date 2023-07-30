<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Detalles;
use App\Models\Pasarela;
/* use App\Models\Estudiante; */
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'contenido', 'cuota', 'pago', 'cursoblog', 'periodoblog'];


    public function detalles()
    {
        return $this->hasMany(Detalles::class, 'blog_id');
    }



        public function pasarelas()
        {
            return $this->hasMany(Pasarela::class, 'pasarelablogs');
        }



}
