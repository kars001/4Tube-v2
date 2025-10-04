<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavLink extends Component
{
    public $active;
    public $icon;
    public $target;

    public function __construct($active = false, $target = null, $icon = null)
    {
        $this->active = $active;
        $this->icon = $icon;
        $this->target = $target;
    }

    public function render()
    {
        return view('components.nav-link');
    }
}
