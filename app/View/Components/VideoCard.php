<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VideoCard extends Component
{
    public $video;
    public $settings;
    public $size;
    
    /**
     * Create a new component instance.
     */
    public function __construct($video, $size)
    {
        $this->video = $video;
        $this->size = $size;
        $this->settings = $video->user->settings;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.video-card');
    }
}
