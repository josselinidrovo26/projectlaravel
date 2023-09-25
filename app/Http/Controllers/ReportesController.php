<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Blog;
use App\Models\Curso;
use App\Models\Periodo;
use App\Models\Persona;

class ReportesController extends Controller
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

        $periodoSeleccionado = $request->input('periodo');
        $cursoSeleccionado = $request->input('curso');
        $eventoSeleccionado = $request->input('evento');

        $blogs = Blog::when($periodoSeleccionado, function ($query, $periodoSeleccionado) {
            return $query->where('periodoblog', $periodoSeleccionado);
        })->when($cursoSeleccionado, function ($query, $cursoSeleccionado) {
            return $query->where('cursoblog', $cursoSeleccionado);
        })->pluck('titulo', 'id');

        $pagosQuery = Pago::when($periodoSeleccionado, function ($query, $periodoSeleccionado) {
            return $query->whereHas('estudiante', function ($query) use ($periodoSeleccionado) {
                $query->where('periodo', $periodoSeleccionado);
            });
        })->when($cursoSeleccionado, function ($query, $cursoSeleccionado) {
            return $query->whereHas('estudiante', function ($query) use ($cursoSeleccionado) {
                $query->where('curso', $cursoSeleccionado);
            });
        })->when($eventoSeleccionado, function ($query, $eventoSeleccionado) {
            return $query->whereHas('blog', function ($query) use ($eventoSeleccionado) {
                $query->where('titulo', $eventoSeleccionado);
            });
        });

        $pagos = $pagosQuery->get();

        return view('reportes.index', compact('pagos', 'cursos', 'blogs', 'periodos', 'user'));
    }

    public function getEvents(Request $request)
    {
        $periodo = $request->input('periodo');
        $curso = $request->input('curso');

        $events = Blog::where('cursoblog', $curso)
            ->where('periodoblog', $periodo)
            ->pluck('titulo', 'id');

        return response()->json($events);
    }




    public function filtrarPagos(Request $request)
    {
        $eventoId = $request->input('evento');

        // Filtrar los pagos según el evento seleccionado
        $pagos = Pago::with('blog', 'estudiante.persona')
            ->where('eventoPago', $eventoId)
            ->get();

        // Retornar los datos en formato JSON
        return response()->json($pagos);
    }




    public function getEventosPorCursoYPeriodo(Request $request)
    {
        $periodo = $request->input('periodo');
        $curso = $request->input('curso');

        if (!$periodo || !$curso) {
            return response()->json([]);
        }

        // Obtener los eventos correspondientes al curso y periodo seleccionados
        $eventos = Blog::where('cursoblog', $curso)
            ->where('periodoblog', $periodo)
            ->pluck('titulo', 'eventoPago');

        return response()->json($eventos);
    }


    public function obtenerCuotaEvento(Request $request)
    {
        // Validar que el título del evento fue enviado en la solicitud
        $request->validate([
            'titulo' => 'required|string',
        ]);

        // Obtener el título del evento desde la solicitud
        $tituloEvento = $request->input('titulo');

        // Realizar la lógica para obtener la cuota del evento según el título
        // Supongamos que la cuota se encuentra en la tabla "blogs" y se busca por el campo "titulo"
        $cuotaEvento = Blog::where('titulo', $tituloEvento)->value('cuota');

        // Retornar la cuota como respuesta en formato JSON
        return response()->json(['cuota' => $cuotaEvento]);
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


    public function buscar(Request $request)
{
    $query = $request->input('query');

    // Realiza la consulta para buscar los registros que coincidan con el query
    $registrosEncontrados = Pago::where('nombre', 'like', '%' . $query . '%')
        ->orWhere('otro_campo', 'like', '%' . $query . '%')
        ->get();

    return response()->json($registrosEncontrados);
}

}
