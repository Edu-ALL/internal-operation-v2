<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Scholarship extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $class,
        public string $id, 
    ) 
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.scholarship');
    }
}
