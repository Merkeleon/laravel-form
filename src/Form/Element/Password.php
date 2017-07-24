<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace Merkeleon\Forms\Form\Element;

use Merkeleon\Forms\Form\Element;

class Password extends Element
{
    public function view()
    {
        return view('form::'.$this->theme.'.element.password', [
            'name' => $this->name,
            'elementName' => $this->elementName,
            'error' => $this->error,
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'postfix' => $this->postfix,
            'class' => $this->class,
            'attributes' => $this->attributes
        ]);
    }

}