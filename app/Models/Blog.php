<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Detalles;
use App\Models\Pasarela;
/* use App\Models\Estudiante; */
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'contenido', 'cuota', 'pago', 'cursoblog', 'periodoblog'];


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($blog) {
            foreach ($blog->getAttributes() as $key => $value) {
                $blog->$key = Str::upper($value);
            }
        });
    }



    public function detalles()
    {
        return $this->hasMany(Detalles::class, 'blog_id');
    }



        public function pasarelas()
        {
            return $this->hasMany(Pasarela::class, 'pasarelablogs');
        }



}
