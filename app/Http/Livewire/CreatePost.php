<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\Posts;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{

    use WithFileUploads;
    public $open = true;

    public $tituloBiografia, $contenidoBiografia, $customFile;

    protected $rules = [
        'tituloBiografia' => 'required',
        'contenidoBiografia' => 'required',
        'file' => 'customFile|max:2048',
    ];




    public function save(){

        $this->validate();

      /*   Post::create([
            'tituloBiografia' => $this-> tituloBiografia,
            'contenidoBiografia' => $this-> contenidoBiografia,
            'file' => $this-> customFile,
        ]); */

       /*  $this->reset(['open', 'tituloBiografia', 'contenidoBiografia']);
        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se creó satisfactoriamente'); */

    }

    public function render()
    {
     /* return view('biografia.index'); */
    }
}
