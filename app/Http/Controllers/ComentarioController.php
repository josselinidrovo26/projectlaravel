<?php

namespace App\Http\Controllers;
use App\Models\Biografias;
use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
        public function index()
    {
        $biografias = Biografias::all();
        foreach ($biografias as $biografia) {
            $comentarios = Comentario::where('biografias_id', $biografia->id)->get();
            $biografia->comentarios = $comentarios;
        }

        return view('biografias.index', compact('biografias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required',
            'contenido' => 'required',
            'biografias_id' => 'required',
        ]);

        $comentario = new Comentario();
        $comentario->nombre = $validatedData['nombre'];
        $comentario->contenido = $validatedData['contenido'];
        $comentario->biografias_id = $validatedData['biografias_id'];
        $comentario->save();

        return redirect()->route('biografias.index')->back()->with('success', 'Comentario agregado exitosamente');
    }

}
