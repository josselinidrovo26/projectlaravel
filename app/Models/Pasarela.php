<?php

namespace App\Models;
use App\Models\Blog;
use App\Models\Detalles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasarela extends Model
{
    protected $table = 'pasarela';
    use HasFactory;
    protected $fillable = [ 'monto', 'pasarelablogs', 'pasareladetalles', 'pasarelapagos'];



    public function blog()
    {
        return $this->belongsTo(Blog::class, 'pasarelablogs');
    }

}
