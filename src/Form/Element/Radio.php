<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace Merkeleon\Forms\Form\Element;

use Illuminate\Database\Eloquent\Collection;
use Merkeleon\Forms\Form\Element;

class Radio extends Element
{
    protected $options = [];

    public function setOptions($options) {
        if ($options instanceof Collection) {
            $options = $options->getDictionary();
        }
        $this->options = $options;

        return $this;
    }

    public function view()
    {
        return view('form::'.$this->theme.'.element.radio', [
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'name' => $this->name,
            'elementName' => $this->elementName,
            'options' => $this->options,
            'error' => $this->error,
            'value' => $this->value,
            'class' => $this->class,
            'attributes' => $this->attributes
        ]);
    }

}