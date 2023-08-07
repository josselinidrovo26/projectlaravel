<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Persona;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;


class PersonaController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personas = Persona::all();
        return view('usuarios.index', compact('personas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    $roles = Role::pluck('id','name')->all();
    return view('usuarios.crear', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'cedula' => 'required',
            'edad' => '',
            'fecha' => 'date|before:today',
            'rol' => 'required',
        ]);

        $input = $request->all();

        $user = User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $persona = Persona::create([
            'nombre' => $input['nombre'],
            'cedula' => $input['cedula'],
            'edad' => $input['edad'],
            'fecha' => $input['fecha'],
            'rol' => $input['rol'],
            'usuario_id' => $user->id,
        ]);

        $rol = $input['rol'];
        $user->assignRole($rol);

     /*  $persona->user()->associate($user);
        $persona->save(); */

        return redirect()->route('usuarios.index');
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

        $persona = Persona::findOrFail($id);

    if ($persona) {
        $roles = Role::pluck('name', 'name')->all();
        $personRole = $persona->roles->pluck('name', 'name')->all();
        return view('usuarios.editar', compact('persona', 'roles', 'personRole'));
    }
    return redirect()->route('persona.index')->with('error', 'El usuario no existe');
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
        $this->validate($request, [
            'nombre' => 'required',
            'cedula' => 'required',
            'edad' => '',
            'fecha' => 'date|before:today',
            'rol' => 'required'
        ]);

        $input = $request->all();

        $persona = Persona::findOrFail($id);
        $persona->cedula = $request->input('cedula');
        $persona->nombre = $request->input('nombre');
        $persona->edad = $request->input('edad');
        $persona->fecha = $request->input('fecha');
        $persona->update($input);
         DB::table('model_has_roles')->where('model_id', $id)->delete();

       /*   $persona->assignRole($request->input('roles'));
        $persona->save(); */
      $user = $persona->user;
        $rol = $input['rol'];
        $user->syncRoles([$rol]);

        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Persona::find($id)->delete();
        return redirect()->route('usuarios.index');
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

        // Actualizar el campo de fecha en la tabla "persona"
        $persona = Persona::where('usuario_id', $usuario_id)->first();
        $persona->fecha = $fecha;
        $persona->save();

        // Actualizar el campo de edad en la tabla "persona"
        $persona->edad = $edad;
        $persona->save();

        return redirect()->back()->with('success', 'Fecha y edad actualizadas exitosamente.');
    }



}
