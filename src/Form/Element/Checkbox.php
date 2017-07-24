<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace Merkeleon\Forms\Form\Element;

use Merkeleon\Forms\Form\Element;

class Checkbox extends Element
{
    protected $options = [];

    public function view()
    {
        return view('form::'.$this->theme.'.element.checkbox', [
            'name' => $this->name,
            'elementName' => $this->elementName,
            'error' => $this->error,
            'label' => $this->label,
            'checked' => $this->value,
            'options' => $this->options,
            'class' => $this->class,
            'attributes' => $this->attributes
        ]);
    }

    public function value() {
        return $this->value ? 1 : 0;
    }
}