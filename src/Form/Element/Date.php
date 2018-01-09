<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace Merkeleon\Form\Form\Element;

use Carbon\Carbon;
use Merkeleon\Form\Form\Element;

class Date extends Element
{

    public function value()
    {
        if ($this->value === '')
        {
            $value = null;
        }
        else
        {
            $value = Carbon::parse($this->value);
        }

        return $value;
    }

    public function setValue($value, $force = false)
    {
        if ($force || !$this->hasOldValue)
        {
            $this->value = Carbon::parse($value);
        }

        return $this;
    }

    public function view()
    {
        $this->addAttributes(['data-toggle' => 'datepicker']);

        return view('form::' . $this->theme . '.element.text', [
            'name'        => $this->name,
            'help'        => $this->help,
            'elementName' => $this->elementName,
            'error'       => $this->error,
            'label'       => $this->label,
            'value'       => $this->value,
            'placeholder' => $this->placeholder,
            'postfix'     => $this->postfix,
            'class'       => $this->class,
            'attributes'  => $this->attributes
        ]);
    }

}