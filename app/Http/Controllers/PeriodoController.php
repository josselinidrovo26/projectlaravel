<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodo;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;


class PeriodoController extends Controller
{
    function __construct()
    {
        $this-> middleware('permission:ver-periodo|crear-periodo|editar-periodo|borrar-periodo')->only('index');
        $this-> middleware('permission:crear-periodo', ['only'=>['create', 'store']]);
        $this-> middleware('permission:editar-periodo', ['only'=>['edit', 'update']]);
        $this-> middleware('permission:borrar-periodo', ['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodos = Periodo::paginate(5);
        return view('periodos.index', compact('periodos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('periodos.crear', compact('permission'));
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
            'nombrePeriodo' => 'required',
            'inicioVigencia' => 'required|date|after_or_equal:today',
            'finVigencia' => 'required|date|after:inicioVigencia',

        ]);
        Periodo::create($request->all());
        return redirect()->route('periodos.index');
    }

    /* BOTON DE ACTIVO E INACTIVO */
    public function toggle($id)
    {
        $periodo = Periodo::find($id);

        if (!$periodo) {
            return redirect()->back()->with('error', 'El período no existe.');
        }

        // Cambiar el estado
        if ($periodo->estado == 'activo') {
            $periodo->estado = 'inactivo';
        } else {
            $periodo->estado = 'activo';
        }

        $periodo->save();

        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
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
    public function edit(Periodo $periodo)
    {
        $permission = Permission::get();
        return view('periodos.editar', compact('periodo', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Periodo $periodo)
    {
        request()->validate([
            'nombrePeriodo' => 'required',
            'inicioVigencia' => 'required|date|after_or_equal:today',
            'finVigencia' => 'required|date|after:inicioVigencia',
        ]);
        $periodo->update($request->all());
        return redirect()->route('periodos.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Periodo $periodo)
    {
        $periodo->delete();
        return redirect()->route('periodos.index');
    }
}
