<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;

class Detalles extends Model
{
    protected $table = 'detalles';
    use HasFactory;
    protected $fillable = ['actividad', 'precio', 'blog_id'];

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id' );
    }
   

}
