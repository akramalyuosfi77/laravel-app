<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavLink extends Component
{
    /**
     * The link URL.
     *
     * @var string
     */
    public $href;

    /**
     * Determine if the link is active.
     *
     * @var bool
     */
    public $active;

    /**
     * Create a new component instance.
     *
     * @param string $href
     * @param bool $active
     */
    public function __construct(string $href = '#', bool $active = false)
    {
        $this->href = $href;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav-link');
    }
}
