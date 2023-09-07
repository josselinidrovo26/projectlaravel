<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Curso;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;





class CursoController extends Controller
{
    function __construct()
    {
        $this-> middleware('permission:ver-curso|crear-curso|editar-curso|borrar-curso', ['only'=>['index']]);
        $this-> middleware('permission:crear-curso', ['only'=>['create', 'store']]);
        $this-> middleware('permission:editar-curso', ['only'=>['edit', 'update']]);
        $this-> middleware('permission:borrar-curso', ['only'=>['destroy']]);
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curso::paginate(20);
        return view('cursos.index', compact('cursos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('cursos.crear',compact('permission'));
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
            'name' => 'required',
        ]);
        Curso::create($request->all());
        return redirect()->route('cursos.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* $curso = Curso::find($id);
        $usuarios = $curso->users;
        return view('cursos.show', compact('curso', 'usuarios')); */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        $permission = Permission::get();
        return view('cursos.editar', compact('permission', 'curso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Curso $curso)
    {request()->validate([
        'name' => 'required',

    ]);
    $curso->update($request->all());
    return redirect()->route('cursos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index');
    }
}
