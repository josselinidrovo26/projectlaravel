<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Banco;


class BancoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bancos = Banco::paginate(10);
        return view('bancos.index', compact('bancos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bancos.crear');
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
            'nombre_banco' => 'required',
            'Tipocuenta'=> 'required',
            'numcuenta'=> 'required',
            'nameUser'=> 'required',
            'cedula'=> 'required'
        ]);
        Banco::create($request->all());
        return redirect()->route('bancos.index');
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
    public function edit(Banco $banco)
    {
        return view('bancos.editar', compact('banco'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banco $banco)
    {
        request()->validate([
            'nombre_banco' => 'required',
            'Tipocuenta'=> 'required',
            'numcuenta'=> 'required',
            'nameUser'=> 'required',
            'cedula'=> 'required'
        ]);
        $banco->update($request->all());
        return redirect()->route('bancos.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banco $banco)
    {
        $banco->delete();
        return redirect()->route('bancos.index');
    }
}
