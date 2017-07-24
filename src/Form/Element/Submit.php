<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace Merkeleon\Forms\Form\Element;

use Merkeleon\Forms\Form\Element;

class Submit extends Element
{
    protected $isIgnored = true;

    public function isClicked() {
        return (bool)$this->value();
    }

    public function view()
    {
        return view('form::'.$this->theme.'.element.submit', [
            'label' => $this->label,
            'name' => $this->name,
            'elementName' => $this->elementName,
            'class' => $this->class,
            'attributes' => $this->attributes,
        ]);
    }

}