<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Curso extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    protected $table = 'cursos';


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($curso) {
            foreach ($curso->getAttributes() as $key => $value) {
                $curso->$key = Str::upper($value);
            }
        });
    }

}
