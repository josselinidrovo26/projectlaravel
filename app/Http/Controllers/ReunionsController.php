<?php

namespace App\Http\Controllers;
use App\Models\Curso;
use Illuminate\Http\Request;
use App\Models\Reunion;


class ReunionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reunions = Reunion::paginate(10);
        return view('reunions.index', compact('reunions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cursos = Curso::pluck('name', 'name')->all();

        return view('reunions.crear', compact('cursos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        request()->validate([
            'tituloreuniones' => 'required',
            'descripcion' => 'required',
            'fechareuniones' => 'required|date|after:today',
            'inicio'=> 'required',
            'fin'=> 'required',
            'enlace'=> 'required',
            'participantes'=> 'required',
            'modonotificar' => 'required',
            'tiempo' => 'required',
            'horario' => 'required'
        ]);

        $input = $request->all();
        $reunion = Reunion::create($input);
        $curso = Curso::find($request->input('curso'));
        if ($curso) {
            $reunion->participantes = $curso->name;
            $reunion->save();
        } else {

        }

        return redirect()->route('reunions.index');
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
    public function edit(Reunion $reunion)
    {
        $cursos = Curso::pluck('name', 'name')->all();
        return view('reunions.editar', compact('reunion', 'cursos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reunion $reunion)
    {
        request()->validate([
            'descripcion' => 'required',
            'fechareuniones' => 'required|date|after:today',
            'inicio'=> 'required',
            'fin'=> 'required',
            'enlace'=> 'required',
            'participantes'=> 'required',
            'modonotificar' => 'required',
            'tiempo' => 'required',
            'horario' => 'required'
        ]);

        $reunion->update($request->all());
        $curso = Curso::find($request->input('curso'));
        if ($curso) {
            $reunion->participantes = $curso->name;
        } else {

        }
        $reunion->save();
        return redirect()->route('reunions.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reunion $reunion)
    {
        $reunion->delete();
        return redirect()->route('reunions.index');
    }
}
