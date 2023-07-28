<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Detalles;
use App\Models\Blog;


class DetallesController extends Controller
{
   /*  function __construct()
    {
        $this-> middleware('permission:ver-detalles|crear-detalles|editar-detalles|borrar-detalles')->only('index');
        $this-> middleware('permission:crear-detalles', ['only'=>['create', 'store']]);
        $this-> middleware('permission:editar-detalles', ['only'=>['edit', 'update']]);
        $this-> middleware('permission:borrar-detalles', ['only'=>['destroy']]);
    } */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::with('detalles')->paginate(2);

        foreach ($blogs as $blog) {
            $sumaPrecio = $blog->detalles->sum('precio');
            $blog->sumaPrecio = $sumaPrecio;
        }

        return view('blogs.index', compact('blogs'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($blogId)
    {
        $blog = Blog::findOrFail($blogId);
        return view('blogs.index', compact('blog'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'actividad' => 'required|unique:actividad',
            'precio' => 'required',
            'blog_id' => '',
        ]);

        $blogId = $request->input('blog_id');
        $blog = Blog::findOrFail($blogId);

        $detalle = new Detalles();
        $detalle->actividad = $request->input('actividad');
        $detalle->precio = $request->input('precio');

        $blog->detalles()->save($detalle);

        // Recalcula la suma de los precios de los detalles relacionados
        $cuota = $blog->detalles()->sum('precio');

        // Actualiza el campo 'cuota' en el modelo 'Blog'
        $blog->cuota = $cuota;
        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Detalles agregados correctamente.');
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Detalles $detalle)
    {
        $blog = $detalle->blog;
        return view('blogs.index', compact('blog', 'detalle'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detalles $detalle)
    {
        $request->validate([
            'actividad' => 'required',
            'precio' => 'required',
            'blog_id' => 'required',
        ]);

        $detalle->actividad = $request->input('actividad');
        $detalle->precio = $request->input('precio');
        $detalle->save();

        $blog = $detalle->blog;

        // Recalcula la suma de los precios de los detalles relacionados
        $cuota = $blog->detalles()->sum('precio');

        // Actualiza el campo 'cuota' en el modelo 'Blog'
        $blog->cuota = $cuota;
        $blog->save();

        return redirect()->route('blogs.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detalles $detalle)
    {
        $blog = $detalle->blog; // Obtener el blog asociado al detalle

        $detalle->delete(); // Eliminar el detalle

        // Recalcula la suma de los precios de los detalles relacionados
        $cuota = $blog->detalles()->sum('precio');

        // Actualiza el campo 'cuota' en el modelo 'Blog'
        $blog->cuota = $cuota;
        $blog->save();

        return redirect()->route('blogs.index');
    }
}