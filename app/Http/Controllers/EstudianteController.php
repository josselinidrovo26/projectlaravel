<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Persona;
use App\Models\Estudiante;
use App\Models\Curso;
use App\Models\Periodo;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;


class EstudianteController extends Controller
{

    function __construct()
    {
        $this-> middleware('permission:ver-estudiante|crear-estudiante|editar-estudiante|borrar-estudiante')->only('index');
        $this-> middleware('permission:crear-estudiante', ['only'=>['create', 'store']]);
        $this-> middleware('permission:editar-estudiante', ['only'=>['edit', 'update']]);
        $this-> middleware('permission:borrar-estudiante', ['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       /*  $usuarios = User::with('persona.estudiante')->get();
        $estudiantes = User::paginate(20);

        return view('estudiante.index', compact('usuarios', 'estudiantes')); */
        $estudiantes = Estudiante::with('persona.user')->paginate(10);

        return view('estudiante.index', compact('estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cursos = Curso::pluck('name', 'name')->all();
        $periodos = Periodo::pluck('nombrePeriodo', 'nombrePeriodo')->all();
        $roles = Role::pluck('name','name')->all();
        return view('estudiante.crear', compact('periodos', 'cursos', 'roles'));
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
        'curso' => 'required',
        'periodo' => 'required',
        'email' => 'required|unique:users,email',
        'password' => 'required|same:confirm-password',
        'nombre' => 'required',
        'rol' => 'required',
        'cedula' => 'required|unique:persona,cedula',
    ]);

    $input = $request->all();


    $user = User::create([
        'email' => $input['email'],
        'password' => Hash::make($input['password']),

    ]);
    $rolEstudiante = Role::where('name', 'Estudiante')->first();
    $user->assignRole($rolEstudiante);

    $persona = Persona::create([
        'nombre' => $input['nombre'],
        'cedula' => $input['cedula'],
       /*  'rol' => $rolEstudiante->name, */
        'rol' => $input['rol'],
        'usuario_id' => $user->id,
    ]);

    $estudiante = Estudiante::create([
        'persona_id' => $persona->id,
        'periodo' => $input['periodo'],
        'curso' => $input['curso'],
        'usuarioid' =>  auth()->user()->id,
    ]);

    $persona->user()->associate($user);
    $rol = $input['rol'];
    $user->assignRole($rol);

    $persona->save();

    return redirect()->route('estudiante.index');

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
        $estudiante = Estudiante::findOrFail($id);

        if ($estudiante) {
            $persona = $estudiante->persona;
            $user = $persona->user;
            $cursos = Curso::pluck('name', 'name')->all();
            $periodos = Periodo::pluck('nombrePeriodo', 'nombrePeriodo')->all();
            $roles = Role::pluck('name', 'name')->all();
            $personRole = $persona->roles->pluck('name', 'name')->all();

            return view('estudiante.editar', compact('estudiante', 'user', 'cursos', 'periodos', 'roles'));
        }

        return redirect()->route('estudiante.index')->with('error', 'El estudiante no existe');
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
            'persona.cedula' => 'required',
            'persona.nombre' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|same:confirm-password',
            'confirm-password' => 'nullable',
            'estudiante.periodo' => 'required',
            'rol' => 'required',
            'estudiante.curso' => 'required',

        ]);

        $input = $request->all();

        $estudiante = Estudiante::findOrFail($id);
        $persona = $estudiante->persona;
        $user = $persona->user;

        $user->email = $input['email'];
        if (!empty($input['password'])) {
            $user->password = Hash::make($input['password']);
        }
        $user->save();

        $persona->cedula = $input['persona']['cedula'];
        $persona->nombre = $input['persona']['nombre'];
        $persona->save();

        $estudiante->periodo = $input['estudiante']['periodo'];
        $estudiante->curso = $input['estudiante']['curso'];
        $estudiante->usuarioid = auth()->user()->id;
        $estudiante->updated_at = Carbon::now();
        $estudiante->save();

        DB::table('model_has_roles')->where('model_id', $id)->delete();
         $rol = $input['rol'];
         $user->syncRoles([$rol]);

        return redirect()->route('estudiante.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $estudiante = Estudiante::find($id);

    if ($estudiante) {
        $estudiante->persona->user->delete(); // Eliminar el usuario
        $estudiante->persona->delete(); // Eliminar la persona
        $estudiante->delete(); // Eliminar el estudiante

        return redirect()->route('estudiante.index');
    }

    return redirect()->route('estudiante.index')->with('error', 'El estudiante no existe');
}



}
