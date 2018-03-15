<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace Merkeleon\Form\Form\Element;

use Merkeleon\Form\Form\Element;

class Checkbox extends Element
{
    protected $options  = [];
    protected $nullable = false;

    public function view()
    {
        return view('form::' . $this->theme . '.element.checkbox', [
            'name'        => $this->name,
            'help'        => $this->help,
            'elementName' => $this->elementName,
            'error'       => $this->error,
            'label'       => $this->label,
            'checked'     => $this->value,
            'options'     => $this->options,
            'class'       => $this->class,
            'attributes'  => $this->attributes,
            'nullable'    => $this->nullable,
        ]);
    }

    public function value()
    {
        $value = null;

        if ($this->value) {
            $value = 1;
        } elseif (!$this->nullable) {
            $value = 0;
        }

        return $value;
    }

    public function nullable($nullable = true)
    {
        $this->nullable = $nullable;
        
        return $this;
    }
}