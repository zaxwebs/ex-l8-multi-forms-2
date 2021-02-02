<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\ViewErrorBag;

class Child extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function hasError($name, $errors, $form = null) {
        return old('_name') && $errors->has($name);
    }

    public function getError($name, $errors, $form = null) {
        return $errors->get($name)[0];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.child');
    }
}
