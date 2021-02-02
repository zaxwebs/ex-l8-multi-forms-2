<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $id;
    public $type;
    public $label;
    public $form;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name= null, $id = null, $type=null, $label='text', $form = null)
    {
        //
        $this->name= $name;
        $this->id= $id ? $id : ($form && $name ? $form . '-' . $name : null);
        $this->type= $type;
        $this->label= $label;
        $this->form= $form;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.input');
    }
}
