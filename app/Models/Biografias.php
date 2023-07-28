<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Biografias extends Model
{
    protected $table = 'biografias';

    use HasFactory;
    protected $fillable = ['tituloBiografia', 'contenidoBiografia', 'image', 'likes','usuarioid'];



    public function eliminar()
    {
        $this->delete();
    }

}

