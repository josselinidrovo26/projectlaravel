<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\Pago;
use App\Models\Pasarela;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;

class PasarelaController extends Controller
{
    private $blog; 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($blog_id)
    {
        // Obtén los datos del blog utilizando el modelo Blog
        $blog = Blog::find($blog_id);

        // Verifica si se encontró el blog
        if (!$blog) {
            abort(404); // Puedes personalizar la respuesta en caso de que el blog no exista
        }
        // Pasa los datos del blog a la vista "pasarelas.index"
        return view('pasarelas.index', ['blog' => $blog]);
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
        $request->validate([
            'monto' => '',

        ]);


        // Redirige a la página de pasarela.index junto con el ID del blog
        return redirect()->route('pasarela.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($blog_id)
    {
        // Obtén los datos del blog utilizando el modelo Blog
        $blog = Blog::find($blog_id);
        $this->blog = $blog;
        return view('pasarela.index', compact('blog'));
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

    public function getDataStudent(Request $request)
    {
        $user = auth()->user();
        // Obtén los datos del estudiante y los datos de pago guardados en el blog
        $studentData = $user->persona;
        $paymentData = Blog::find($request->blog_id);;
        $status = 'Pagado';
        $cuotaPaymentData = (float) $paymentData->cuota;
        $cuotaRequest = (float) $request->monto;
        $diferencia = $cuotaPaymentData - $cuotaRequest;
        if ($cuotaPaymentData != $cuotaRequest) {
            $status = 'Abonado';
        }
        $pago = new Pago();
        $pago->abono = $cuotaRequest;
        $pago->diferencia = $diferencia;
        $pago->estado = $status;
        $pago->estudiante_id = $studentData->estudiante->id;
        $pago->eventoPago = $request->blog_id; // Asigna el valor al campo eventoPago
        $pago->usuarioid = auth()->user()->id;
        $pago->save();

       
        // Combina los datos del estudiante y los datos de pago en un solo array
        $data = [
            'student' => $studentData,
            'payment' => $paymentData,
            'status' => $status
        ];

        // Devuelve los datos como respuesta JSON
        return response()->json($data);
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
    public function destroy($id)
    {
        //
    }
}
