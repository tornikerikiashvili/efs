<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
     /**
     * The input type.
     *
     * @var string
     */
    public $type;
 
     /**
     * The input type.
     *
     * @var string
     */
    public $disabled;

    /**
     * The input value.
     *
     * @var string
     */
    public $headline;

     /**
     * The input name.
     *
     * @var string
     */
    public $name;

    /**
     * The input value.
     *
     * @var string
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $headline,$name,$value,$disabled = null)
    {
        $this->type = $type;
        $this->headline = $headline;
        $this->name = $name;
        $this->value = $value;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.input');
    }
}
