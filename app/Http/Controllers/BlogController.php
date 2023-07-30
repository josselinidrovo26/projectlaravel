<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use App\Models\Blog;
use App\Models\Estudiante;
use App\Models\Detalles;



class BlogController extends Controller
{
    public function getLatestBlog()
{
    $latestBlog = Blog::latest()->first();

    return response()->json($latestBlog);
}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = auth()->user();

        if ($user->persona->estudiante && $user->persona->estudiante->curso) {
            $userCurso = $user->persona->estudiante->curso;
            $blogs = Blog::where('cursoblog', $userCurso)->paginate(10);
        } else {
            $blogs = Blog::paginate(10);
        }


        return view('blogs.index', compact('blogs', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blogs.crear');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'cuota' => '',
            'pago' => 'required',
        ]);

        $estudiante = $user->persona->estudiante;

        $blog = new Blog();
        $blog->titulo = $request->input('titulo');
        $blog->contenido = $request->input('contenido');
        $blog->cuota = $request->input('cuota');
        $blog->pago = $request->input('pago');
        $blog->cursoblog = $estudiante->curso;
        $blog->periodoblog = $estudiante->periodo;
        $blog->save();

        return redirect()->route('blogs.index');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return view('pasarela.index', compact('blog'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('blogs.editar', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        request()->validate([
            'titulo' => 'required',
            'contenido'=> 'required',
            'cuota'=> '',
            'pago'=> 'required',
        ]);
        $blog->update($request->all());
        return redirect()->route('blogs.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        // Verificar si existen detalles relacionados con el blog
        $detalles = Detalles::where('blog_id', $blog->id)->exists();

        if ($detalles) {
            return redirect()->route('blogs.index')->with('alert', 'Primero debe eliminar los detalles del evento');
        }

        $blog->delete();

        return redirect()->route('blogs.index');
    }
}
