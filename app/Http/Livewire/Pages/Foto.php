<?php

namespace App\Http\Livewire\Pages;

use App\Models\Photo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Foto extends Component
{
    use WithFileUploads;
    
    public $photo, $urlPhoto, $photoUser, $state, $images, $isActive, $isPaused;
    protected function defaultProfilePhotoUrl()
    {
        return asset('img/photoLoad.svg');
    }

    public function render()
    {
        $this->isActive = Photo::where('user_id',auth()->user()->id)->orderBy('created_at','DESC')->where('state','active')->count();
        $this->isPaused = Photo::where('user_id',auth()->user()->id)->orderBy('created_at','DESC')->where('state','paused')->count();
        $this->images = Photo::where('user_id',auth()->user()->id)->orderBy('created_at','DESC')->get();
        return view('livewire.pages.foto');
    }

    protected $rules = [
        'photo' => 'required',
        'state' => 'required'
    ];
    // carga la imagen
    public function loadImage(){
        $this->validate();
        $this->photo->store('photo');
        if (isset($this->photo)) { /* agregando fotos */
            $photoUser= $this->photo->store('/public/gallery');
            // agregando foto
            $url = Storage::url($photoUser);
            $urlClear = str_replace(['/storag','e/'],"", $url);
            $this->urlPhoto = $urlClear;
        }

        Photo::create([
            'user_id' => auth()->user()->id,
            'url' => $this->urlPhoto,
            'state' => $this->state
        ]);

        $this->resetInput();
        $this->dispatchBrowserEvent('created_user',[
            'descripcion' => 'Imagen subida correctamente'
        ]);

    }
    public function onState( $id, $status ){
        switch ($status) {
            case 'active':
                Photo::where('id',$id)->update(['state' => 'paused']);
                break;
            case 'paused':
                Photo::where('id',$id)->update(['state' => 'active']);
                break;
        }
    }
    
    public function deleteImage($id){
        Photo::where('id',$id)->delete();
    }

    // validación en tiempo real de los datos
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    // resetea los inputs
    public function resetInput(){
        $this->reset(
            'photo','state'
        );
    }
}
