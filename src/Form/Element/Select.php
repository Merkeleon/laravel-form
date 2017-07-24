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

class Select extends Element
{
    protected $options = [];
    protected $multiple = false;

    public function setOptions($options) {
        if ($options instanceof Collection) {
            $options = $options->getDictionary();
        }
        $this->options = $options;

        return $this;
    }

    public function setMultiple($multiple) {
        $this->multiple = $multiple;

        return $this;
    }

    public function value() {
        if (!$this->value) {
            return null;
        }

        return parent::value();
    }

    public function setValue($value, $force = false) {

        if (is_array($value)) {
            foreach ($value as &$v) {
                $v = (string)$v;
            }
            unset($v);
        } else {
            $value = (string)$value;
        }
        return parent::setValue($value, $force);
    }

    public function view()
    {
        if ($this->multiple && !is_array($this->value)) {
            $this->value = empty($this->value) ? [] : [$this->value];
        }

        return view('form::'.$this->theme.'.element.select', [
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'name' => $this->name,
            'elementName' => $this->elementName,
            'options' => $this->options,
            'error' => $this->error,
            'value' => $this->value,
            'multiple' => $this->multiple,
            'class' => $this->class,
            'attributes' => $this->attributes
        ]);
    }

}