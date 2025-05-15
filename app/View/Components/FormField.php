<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormField extends Component
{
    public $type;
    public $name;
    public $label;
    public $placeholder;
    public $value;
    public $options;
    public $id;
    public $selected;  // Add the selected property

    public function __construct($type, $name, $label, $value = null, $options = [], $id = null, $selected = null, $placeholder = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->options = $options;
        $this->id = $id; // Default to using the name as the ID if none is provided
        $this->selected = $selected;  // Assign the selected value
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.form-field');
    }
}
