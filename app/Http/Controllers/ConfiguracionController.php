<?php

namespace App\Http\Controllers;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());

        return view('configuracion.index', compact('user'));
    }
        public function __construct()
        {
            $this->middleware('auth');
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
        //
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

    public function update(Request $request)
    {
      $user = User::find(Auth::id());

        $request->validate([
            'fecha' => 'nullable|date',
            'edad' => 'nullable|integer|min:0',
        ]);

        $fecha = $request->input('fecha');
        $edad = $request->input('edad');
        $user->persona->fecha = $fecha;
        $user->persona->edad = $edad;
        $user->persona->save();

        return redirect()->route('configuracion.index')->with('success', 'Perfil actualizado correctamente.');
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

    public function guardarFecha(Request $request)
    {
        $this->validate($request, [
            'usuario_id' => 'required|integer',
            'fecha' => 'required|date',
            'edad' => 'required|integer',
        ]);

        $usuario_id = $request->input('usuario_id');
        $fecha = $request->input('fecha');
        $edad = $request->input('edad');

        $persona = Persona::where('usuario_id', $usuario_id)->first();
        $persona->fecha = $fecha;
        $persona->save();
        $persona->edad = $edad;
        $persona->save();

        return redirect()->back()->with('success', 'Fecha y edad actualizadas exitosamente.');
    }

}
