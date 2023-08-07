<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
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

public function like(Request $request, Biografias $biografia)
{
    if (Auth::check()) {
        // Increment the 'likes' count in the database
        $biografia->increment('likes');

        // Return the updated 'likes' count in the response
        return response()->json(['success' => true, 'likes' => $biografia->likes]);
    }

    return response()->json(['success' => false, 'message' => 'User not authenticated']);
}


public function update(Request $request, Biografias $biografia)
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
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'www/projectlaravel/';
            $image_url = $upload_path . $image_full_name;
            $file->move($upload_path, $image_full_name);
            $image[] = $image_url;
        }
    }

    $biografia->image = implode('|', $image);
    $biografia->tituloBiografia = $request->tituloBiografia;
    $biografia->contenidoBiografia = $request->contenidoBiografia;
    $biografia->usuarioid = auth()->user()->id;
    // Omit the 'likes' field to prevent overwriting the existing value
    // $biografia->likes = $currentLikes;
    $biografia->save();

    return redirect()->route('biografias.index');
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






