<?php

namespace App\Http\Livewire\Pages;

use App\Models\Photo;
use Livewire\Component;

class Galery extends Component
{
    public $photos;

    public function render()
    {
        $this->photos = Photo::inRandomOrder()->get();
        return view('livewire.pages.galery');
    }
}
