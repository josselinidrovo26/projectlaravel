<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\Pago;
use App\Models\Detalles;
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
        $blog = Blog::find($blog_id);
        if (!$blog) {
            abort(404);
        }
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
        $user = auth()->user();
        $studentData = $user->persona;
        $blog = Blog::find($blog_id);
        $pagos = Pago::where('eventoPago', $blog_id)->where('estudiante_id',  $studentData->estudiante->id)->latest()
        ->first();
        $canpay = true;
        if($pagos){
            $canpay =  $pagos->diferencia !== 0;
        }


        $this->blog = $blog;
        return view('pasarela.index', compact('blog','canpay','pagos'));
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
        $studentData = $user->persona;
        $pagos = Pago::where('eventoPago', $request->blog_id)->where('estudiante_id',  $studentData->estudiante->id)->latest()
        ->first();
        $studentData = $user->persona;
        $paymentData = Blog::find($request->blog_id);
        $status = 'Pagado';
        $cuotaPaymentData = (float) $paymentData->cuota;
        $cuotaRequest = (float) $request->monto + $pagos->abono;
        $diferencia = $cuotaPaymentData - $cuotaRequest ;
        if ($cuotaPaymentData != $cuotaRequest) {
            $status = 'Abonado';
        }
        $pago = new Pago();
        $pago->abono = $cuotaRequest;
        $pago->diferencia = $diferencia;
        $pago->estado = $status;
        $pago->estudiante_id = $studentData->estudiante->id;
        $pago->eventoPago = $request->blog_id;
        $pago->usuarioid = auth()->user()->id;
        $pago->save();

        $pagos2 = Pago::where('eventoPago', $request->blog_id)->where('estudiante_id',  $studentData->estudiante->id)->latest()
        ->first();
        $data = [
            'student' => $studentData,
            'payment' =>  $pagos2,
            'status' => $pagos2->estado
        ];
        return response()->json($data);
    }



    public function getInvoice(Request $request)
    {
        $user = auth()->user();
        $studentData = $user->persona;
        $blog = Blog::find($request->blog_id);
        $detalles = $blog->detalles;
        $status = 'Pagado';
        $cuotaPaymentData = (float) $blog->cuota;
        $cuotaRequest = (float) $request->monto;
        if ($cuotaPaymentData != $cuotaRequest) {
            $status = 'Abonado';
        }
        $data = [
            'student' => $studentData,
            'blog' => $blog,
            'detalles' => $detalles,
            'status' => $status
        ];
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
