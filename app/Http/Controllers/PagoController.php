<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Persona;
use App\Models\Periodo;
use App\Models\Curso;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
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
        $query = Pago::with('estudiante.persona', 'blog')->where('abono', '<>', 0);

        if ($request->has('search')) {
            $search = $request->input('search');

            // Buscar registros con cédula que comiencen con la búsqueda
            $query->whereHas('estudiante.persona', function ($subquery) use ($search) {
                $subquery->where('cedula', 'LIKE', $search . '%');
            });
        }

        $pagos = $query->paginate(10);

        // Calcular la diferencia y actualizarla en la base de datos
        // foreach ($pagos as $pago) {
        //     $diferencia = $pago->blog->cuota - $pago->abono;
        //     $pago->diferencia = $diferencia;
        //     $pago->save();
        // }

        $cedulaNoEncontrada = null;

        if ($request->has('search') && $pagos->isEmpty()) {
            $cedulaNoEncontrada = "No se encontraron registros para la cédula ingresada.";
        }

        return view('pagos.index', compact('pagos', 'cedulaNoEncontrada'));
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
    public function create(Request $request)
    {
        $user = auth()->user();
        $cursos = Curso::pluck('name', 'id');
        $activeEventTitle = Periodo::where('estado', 'activo')->value('nombrePeriodo');
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

            return view('pagos.crear', compact('activeEventTitle', 'pagos', 'cursos', 'blogs', 'nombresEstudiantes', 'user'));
        } else {
            $pagos = Pago::all();
            return view('pagos.crear', compact('activeEventTitle', 'pagos', 'cursos', 'blogs', 'user', 'nombresEstudiantes'));
        }
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
            'abono' => 'required|numeric',
            'titulo' => 'required',
            'estudiante_id' => '',
            'nombre' => 'required',
            'titulo' => 'required',
        ]);

        $eventoId = $request->input('titulo');
        $evento = Blog::find($eventoId);
        $cuotaEvento = $evento->cuota;

        if (!$evento) {
            return back()->withErrors(['mensaje' => 'El evento seleccionado no existe']);
        }


        $abono = $request->input('abono');
        $diferencia = $cuotaEvento - $abono;
        $cedulaEstudiante = $request->input('cedula');
        $curso = $request->input('curso');
        $periodo = $request->input('periodo');
        $estudiante = Persona::where('rol', 'Estudiante')
        ->whereHas('estudiante', function ($query) use ($curso, $periodo) {
            $query->where('curso', $curso)->where('periodo', $periodo);
        })
        ->where('cedula', $cedulaEstudiante)
        ->first();

        // Verifica si el evento es null antes de acceder a sus propiedades
        if (!$evento) {
            return back()->withErrors(['mensaje' => 'El evento seleccionado no existe']);
        }

        // Obtener el último pago del estudiante en el mismo evento
        $ultimoPago = Pago::where('estudiante_id', $estudiante->estudiante->id)
        ->where('eventoPago', $eventoId)
        ->orderBy('created_at', 'desc') // Ordenar por fecha de creación descendente
        ->first();

    $ultimoValorDiferencia = $ultimoPago ? $ultimoPago->diferencia : 0;



        $pago = new Pago();
        $pago->abono = $abono;
        $pago->diferencia = $diferencia;
        $pago->estado = $request->input('estado');
        $pago->estudiante_id = $estudiante->estudiante->id; // Asegúrate de que la relación estudiante en Persona sea correcta
        $pago->eventoPago = $request->input('titulo');
        $pago->usuarioid = auth()->user()->id;
        $pago->save();

        return redirect()->route('pagos.index')->with('success', 'Pago registrado con éxito.');
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
         return redirect()->route('pagos.index');

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
/* DESCARGAR RECIBO */

public function generarRecibo(Pago $pago)
{
    $logoImagePath = public_path('img/logo.png');

    // Renderizar la vista del recibo en una variable
    $reciboHTML = view('pagos.recibo', compact('pago', 'logoImagePath'))->render();

    // Crear el PDF utilizando la biblioteca Dompdf
    $pdf = PDF::loadHTML($reciboHTML);

    // Devolver el PDF al navegador
    return $pdf->stream('Unidad educativa Blanca García-recibo.pdf');
}


/* CONSULTAR ESTUDIANTE POR CEDULA */
public function consultarEstudiante(Request $request) {
    $cedula = $request->input('cedula');
    $persona = Persona::where('cedula', $cedula)->first();

    if ($persona && $persona->estudiante) {
        $curso = $persona->estudiante->curso;
        $periodo = $persona->estudiante->periodo;

        return response()->json([
            'success' => true,
            'nombre' => $persona->nombre,
            'curso' => $curso,
            'periodo' => $periodo
        ]);
    } else {
        return response()->json([
            'success' => false
        ]);
    }
}


/* VERIFICAR VALOR PENDIENTE A PAGAR  */
public function verificarEstado(Request $request)
{
    $cedula = $request->input('cedula');
    $eventoId = $request->input('evento');

    // Buscar el estudiante correspondiente a la cédula ingresada
    $estudiante = Estudiante::whereHas('persona', function ($query) use ($cedula) {
        $query->where('cedula', $cedula);
    })->first();

    if (!$estudiante) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró un estudiante con la cédula ingresada.'
        ]);
    }

    // Buscar el evento correspondiente
    $evento = Blog::find($eventoId);

    if (!$evento) {
        return response()->json([
            'success' => false,
            'message' => 'El evento seleccionado no fue encontrado.'
        ]);
    }

    // Buscar el pago correspondiente a través de la relación con estudiante
    $pago = $estudiante->pagos()
        ->where('eventoPago', $eventoId)
        ->orderBy('created_at', 'desc')
        ->first();

    if ($pago) {
        return response()->json([
            'success' => true,
            'diferencia' => $pago->diferencia,
            'estado' => $pago->estado // Agregar el estado al JSON de respuesta
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'No existe un valor pendiente para el estudiante ingresado y el evento seleccionado.'
        ]);
    }
}







}
