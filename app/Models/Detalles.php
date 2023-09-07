<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Detalles extends Model
{
    protected $table = 'detalles';
    use HasFactory;
    protected $fillable = ['actividad', 'precio', 'blog_id'];


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detalle) {
            foreach ($detalle->getAttributes() as $key => $value) {
                $detalle->$key = Str::upper($value);
            }
        });
    }



    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id' );
    }


}
