<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Videos;

class HomePage extends Component
{
    public $videos;

    public function mount()
    {
        $this->videos = Videos::with('views')->inRandomOrder()->get();
    }

    public function render()
    {
        return view('livewire.home-page', [
            'videos' => $this->videos,
        ]);
    }
}
