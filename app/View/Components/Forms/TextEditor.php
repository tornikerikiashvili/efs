<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class TextEditor extends Component
{
     /**
     * The input name.
     *
     * @var string
     */
    public $inputname;

     /**
     * The input content.
     *
     * @var string
     */
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($inputname,$content)
    {
        $this->inputname = $inputname;
        $this->content = $content;
        
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.text-editor');
    }
}
