<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Persona;
use App\Models\Periodo;
use App\Models\Curso;
use App\Models\Blog;
use App\Http\Controllers\PaymentController;
use App\Models\Estudiante;
use App\Models\EstudianteBlogs;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;



class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $cursos = Curso::pluck('name', 'id');
        $periodos = Periodo::where('estado', 'activo')->pluck('nombrePeriodo', 'id');
        $blogs = collect();
        $nombresEstudiantes = Persona::where('rol', 'Estudiante')->pluck('nombre');

        if ($user->persona->estudiante && $user->persona->estudiante->curso && $user->persona->estudiante->periodo) {
            $userCurso = $user->persona->estudiante->curso;
            $userPeriodo = $user->persona->estudiante->periodo;
            $estudianteId = $user->persona->estudiante->id;

            $pagosQuery = Pago::where('estudiante_id', $estudianteId)
                ->whereHas('persona.estudiante', function ($query) use ($userCurso, $userPeriodo) {
                    $query->where('curso', $userCurso)->where('periodo', $userPeriodo);
                });

            $periodo = $request->input('periodo');
            $curso = $request->input('curso');

            if ($periodo && $curso) {
                $blogs = Blog::where(function ($query) use ($curso, $periodo) {
                    $query->where('cursoblog', $curso)->where('periodoblog', $periodo);
                })->pluck('titulo', 'id');

                $pagosQuery->whereHas('blog', function ($query) use ($curso, $periodo) {
                    $query->where('cursoblog', $curso)->where('periodoblog', $periodo);
                });
            }

            $pagos = $pagosQuery->get();

            return view('pagos.index', compact('pagos', 'cursos', 'blogs', 'periodos', 'nombresEstudiantes', 'user'));
        } else {
            $pagos = Pago::all();
            return view('pagos.index', compact('pagos', 'cursos', 'blogs', 'user', 'periodos', 'nombresEstudiantes'));
        }
    }

    /*  PARA EL FILTRADO DE REGISTROS */

    public function getEvents(Request $request)
    {
        $periodo = $request->input('periodo');
        $curso = $request->input('curso');

        $events = Blog::where('cursoblog', $curso)
            ->where('periodoblog', $periodo)
            ->pluck('titulo', 'id');

        return response()->json($events);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periodos = Periodo::pluck('nombrePeriodo', 'id');
        $cursos = Curso::pluck('name', 'id');
        $blogs = Blog::pluck('titulo', 'id');
        return view('pagos.index', compact('periodos', 'cursos', 'blogs'));
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
            'abono' => 'required',
            'diferencia' => '',
            'estado' => 'required',
            'nombre' => 'required',
            'titulo' => 'required',
        ]);

        // Obtén el estudiante basado en la cédula ingresada y los filtros de período y curso
        $cedulaEstudiante = $request->input('cedula');
        $curso = $request->input('curso');
        $periodo = $request->input('periodo');

        $estudiante = Persona::where('rol', 'Estudiante')
            ->whereHas('estudiante', function ($query) use ($curso, $periodo) {
                $query->where('curso', $curso)->where('periodo', $periodo);
            })
            ->where('cedula', $cedulaEstudiante)
            ->first();

        if (!$estudiante) {
            return back()->withErrors(['mensaje' => 'Estudiante no pertenece al curso o no existe']);
        }
        
        // Crea el registro de pago
        $pago = new Pago();
        $pago->abono = $request->input('abono');
        $pago->diferencia = $request->input('diferencia');
        $pago->estado = $request->input('estado');
        $pago->estudiante_id = $estudiante->estudiante->id;
        $pago->eventoPago = $request->input('titulo'); // Asigna el valor al campo eventoPago
        $pago->usuarioid = auth()->user()->id;
        $pago->save();
        // Actualiza el campo eventoPago en el registro de pago
        $pago->eventoPago = $request->input('titulo');
        $pago->save();

        return redirect()->action([PaymentController::class, 'payWithPayPal'], ['amount' => $pago->abono]);


        return redirect()->route('pagos.index');
    }



    public function consultarEstudiante(Request $request)
    {
        $cedula = $request->input('cedula');

        // Buscar el estudiante en la tabla 'persona' por la cédula
        $estudiante = Persona::where('cedula', $cedula)->first();

        // Verificar si se encontró el estudiante
        if ($estudiante) {
            // Si se encuentra el estudiante, devolver el nombre en la respuesta JSON
            return response()->json(['nombre' => $estudiante->nombre]);
        } else {
            // Si no se encontró el estudiante, devolver un mensaje de error en la respuesta JSON
            return response()->json(['nombre' => 'Estudiante no encontrado']);
        }
    }


    public function render()
    {
        return view('index.blade');
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
    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('reportes.index');
    }



    public function obtenerCuota(Request $request)
    {
        $eventoId = $request->input('evento');
        $blog = Blog::find($eventoId);

        if ($blog) {
            $cuota = $blog->cuota;
        } else {
            $cuota = null;
        }

        return response()->json(['cuota' => $cuota]);
    }





}
