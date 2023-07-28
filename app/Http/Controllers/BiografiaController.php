<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Biografias;


/* use Session; */

class BiografiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biografias = Biografias::orderBy('id', 'DESC')->get();
        return view('biografias.index', compact('biografias'));
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
        'tituloBiografia' => 'required',
        'contenidoBiografia' => 'required',
        'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    $image = array();
    if ($files = $request->file('image')) {
        foreach ($files as $file) {
            $image_name = md5(rand(1000, 10000));
            $ext = strtolower($file->getClientOriginalExtension());
            $image_full_name = $image_name.'.'.$ext;
            $upload_path = 'www/projectlaravel/';
            $image_url = $upload_path.$image_full_name;
            $file->move($upload_path, $image_full_name);
            $image[] = $image_url;
        }
    }
  
    $biografia = new Biografias();
    $biografia->image = implode('|', $image);
    $biografia->tituloBiografia = $request->tituloBiografia;
    $biografia->contenidoBiografia = $request->contenidoBiografia;
    $biografia->usuarioid = auth()->user()->id;
    $biografia->save();

    return back();
}

/* CONTROLAR LOS LIKES */

public function like(Request $request, Biografias $biografia)
{
    try {
        // Verificar si el usuario ya ha dado clic en "Me gusta" antes
        $user = $request->user();
        $liked = $user->biografiasLiked()->where('biografia_id', $biografia->id)->exists();

        if ($liked) {
            // Restar 1 al contador de likes
            $biografia->decrement('likes');
            // Eliminar la relación entre el usuario y la biografía (No me gusta)
            $user->biografiasLiked()->detach($biografia->id);
            return response()->json(['success' => true, 'likes' => $biografia->likes]);
        } else {
            // Sumar 1 al contador de likes
            $biografia->increment('likes');
            // Crear la relación entre el usuario y la biografía (Me gusta)
            $user->biografiasLiked()->attach($biografia->id);
            return response()->json(['success' => true, 'likes' => $biografia->likes]);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}





        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Biografias $biografia)
    {
        $biografia->delete();
        return redirect()->route('biografias.index');
    }

}






