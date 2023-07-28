<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\Pasarela;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;

class PasarelaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($blog_id)
    {
        // Obtén los datos del blog utilizando el modelo Blog
        $blog = Blog::find($blog_id);

        // Verifica si se encontró el blog
        if (!$blog) {
            abort(404); // Puedes personalizar la respuesta en caso de que el blog no exista
        }

        // Pasa los datos del blog a la vista "pasarelas.index"
        return view('pasarelas.index', ['blog' => $blog]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'monto' => '',

        ]);


        // Redirige a la página de pasarela.index junto con el ID del blog
        return redirect()->route('pasarela.index');

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
