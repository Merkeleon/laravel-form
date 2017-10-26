<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace Merkeleon\Form\Form\Element;

use Merkeleon\Form\Form\Element;

class Submit extends Element
{
    protected $buttonClass = 'btn-primary';
    protected $isIgnored = true;

    public function setButtonClass($buttonClass) {
        $this->buttonClass = $buttonClass;

        return $this;
    }

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
            'buttonClass' => $this->buttonClass,
            'attributes' => $this->attributes,
        ]);
    }

}