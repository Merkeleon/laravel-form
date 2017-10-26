<?php

namespace Merkeleon\Form\Form\Element;

use Merkeleon\Form\Form\Element;

class Delimiter extends Element
{
    protected $view;
    protected $data = [];

    public function setContent($view, $data = []) {
        $this->view = $view;
        $this->data = $data;

        return $this;
    }

    public function view()
    {
        $data = array_merge($this->data, [
            'name' => $this->name,
            'elementName' => $this->elementName,
            'class' => $this->class,
        ]);

        return view($this->view ?: 'form::'.$this->theme.'.element.delimiter', $data);
    }

}