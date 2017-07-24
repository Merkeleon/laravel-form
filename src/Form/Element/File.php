<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace Merkeleon\Forms\Form\Element;

use Merkeleon\Forms\Form\Element;

class File extends Element
{
    protected $isMultiple = false;

    public function setMultiple($multiple = true) {
        $this->isMultiple = $multiple;

        return $this;
    }

    public function view()
    {
        return view('form::'.$this->theme.'.element.file', [
            'name' => $this->name,
            'elementName' => $this->elementName,
            'error' => $this->error,
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'class' => $this->class,
            'multiple' => $this->isMultiple,
            'attributes' => $this->attributes
        ]);
    }

}