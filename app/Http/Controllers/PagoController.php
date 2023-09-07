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
            $query->whereHas('estudiante.persona', function ($subquery) use ($search) {
                $subquery->where('cedula', 'LIKE', $search . '%');
            });
        }

        $pagos = $query->paginate(10);
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
            'suma' => '',
            'titulo' => 'required',
        ]);

        $eventoId = $request->input('titulo');
        $evento = Blog::find($eventoId);
        $cuotaEvento = $evento->cuota;

        if (!$evento) {
            return back()->withErrors(['mensaje' => 'El evento seleccionado no existe']);
        }

        $suma = $request->input('suma');
     /*    $pagoHistorico = $request->input('pagoHistorico'); */
        $cedulaEstudiante = $request->input('cedula');
        $curso = $request->input('curso');
        $periodo = $request->input('periodo');
        $estudiante = Persona::where('rol', 'Estudiante')
        ->whereHas('estudiante', function ($query) use ($curso, $periodo) {
            $query->where('curso', $curso)->where('periodo', $periodo);
        })
        ->where('cedula', $cedulaEstudiante)
        ->first();
        if (!$evento) {
            return back()->withErrors(['mensaje' => 'El evento seleccionado no existe']);
        }
            $ultimoPago = Pago::where('estudiante_id', $estudiante->estudiante->id)
            ->where('eventoPago', $eventoId)
            ->orderBy('created_at', 'desc')
            ->first();

            $ultimoValorSuma = $ultimoPago ? $ultimoPago->suma : 0;
            $abono = $request->input('abono');
            $suma = $ultimoValorSuma + $abono;
            $diferencia = $cuotaEvento - $suma;
            if ($suma == $cuotaEvento) {
                $estado = 'PAGADO';
            } elseif ($suma < $cuotaEvento && $suma > 0) {
                $estado = 'PENDIENTE';
            } else {
                $estado = 'OTRO';
            }

            $pago = new Pago();
            $pago->abono = $abono;
            $pago->diferencia = $diferencia;
            $pago->suma = $suma;
         /*    $pago->pagoHistorico = $pagoHistorico; */
            $pago->estado = $estado;
            $pago->estudiante_id = $estudiante->estudiante->id;
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
    $reciboHTML = view('pagos.recibo', compact('pago', 'logoImagePath'))->render();
    $pdf = PDF::loadHTML($reciboHTML);

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
    $estudiante = Estudiante::whereHas('persona', function ($query) use ($cedula) {
        $query->where('cedula', $cedula);
    })->first();

    if (!$estudiante) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró un estudiante con la cédula ingresada.'
        ]);
    }
    $evento = Blog::find($eventoId);

    if (!$evento) {
        return response()->json([
            'success' => false,
            'message' => 'El evento seleccionado no fue encontrado.'
        ]);
    }

    $pago = $estudiante->pagos()
        ->where('eventoPago', $eventoId)
        ->orderBy('created_at', 'desc')
        ->first();

    if ($pago) {
        return response()->json([
            'success' => true,
            'diferencia' => $pago->diferencia,
            'estado' => $pago->estado
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'No existe un valor pendiente para el estudiante ingresado y el evento seleccionado.'
        ]);
    }
}


}
