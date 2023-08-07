<?php
namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UsuarioController extends Controller
{
     function __construct()
    {
        $this-> middleware('permission:ver-usuario|crear-usuario|editar-usuario|borrar-usuario')->only('index');
        $this-> middleware('permission:crear-usuario', ['only'=>['create', 'store']]);
        $this-> middleware('permission:editar-usuario', ['only'=>['edit', 'update']]);
        $this-> middleware('permission:borrar-usuario', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $usuarios = User::with('persona')->paginate(5);
        $personas = Persona::pluck('nombre', 'id')->all();
        return view('usuarios.index', compact('usuarios', 'personas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm_password',
            'rol' => ''
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        // Asignar el rol a través de la relación con la persona y el estudiante
        if ($user->persona && $user->persona->estudiante) {
        $rol = $user->persona->estudiante->rol;
        $user->assignRole($rol);
        return redirect()->route('usuarios.index');
        }
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
        $roles = Role::pluck('name', 'id'); // Obtener los roles de la base de datos
        $user = User::find($id);
        $personas = Persona::pluck('nombre', 'id')->all();
        return view('usuarios.editar', compact('user', 'personas', 'roles'));
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
    $request->validate([
        'email' => 'required|email',
        'persona' => [
            'required',
            'array',
            Rule::exists('persona', 'id')->where(function ($query) use ($id) {
                $query->where('usuario_id', $id);
            }),
        ],
        'persona.cedula' => 'required',
        'persona.nombre' => 'required',
        'persona.rol' => 'required',
    ]);

    $user = User::findOrFail($id);
    $user->email = $request->input('email');
    $user->save();

    $persona = $user->persona;
    $persona->cedula = $request->input('persona.cedula');
    $persona->nombre = $request->input('persona.nombre');
    $persona->rol = $request->input('persona.rol');
    $persona->save();

    return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.index');
    }
}
