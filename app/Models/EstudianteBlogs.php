<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;
use App\Models\Blog;

class EstudianteBlogs extends Model
{
    use HasFactory;
    protected $table = 'estudiante_blogs';
    protected $fillable = ['estudianteblogId', 'blogIdblog'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudianteblogId');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blogIdblog');
    }

}
