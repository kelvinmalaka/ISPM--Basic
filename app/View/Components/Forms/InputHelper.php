<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputHelper extends Component {
    /**
     * Valid file types.
     *
     * @var  array|string|null
     */
    public $types;

    /**
     * Valid max size.
     *
     * @var  int|string|null
     */
    public $size;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($types = null, $size = null) {
        if ($types) {
            if (is_array($types)) $this->types = $types;
            elseif (is_string($types)) $this->types = [$types];
        }

        if ($size) {
            if (is_numeric($size)) $this->size = strval($size) . "MB";
            elseif (is_string($size)) $this->size = $size;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.forms.input-helper');
    }
}
