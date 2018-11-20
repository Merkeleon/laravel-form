<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace Merkeleon\Form\Form\Element;

use Illuminate\Database\Eloquent\Collection;
use Merkeleon\Form\Form\Element;

class Select extends Element
{

    protected $options           = [];
    protected $multiple          = false;
    protected $emptyFirst        = false;
    protected $optionsAttributes = [];

    public function setOptions($options, $attributes = [])
    {
        if ($options instanceof Collection)
        {
            $options = $options->getDictionary();
        }
        $this->options = $options;

        $this->optionsAttributes = $attributes;

        return $this;
    }

    public function addEmptyFirst($trans = '')
    {
        $this->emptyFirst = $trans;
    }

    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function value()
    {
        if (!$this->value)
        {
            return null;
        }

        return parent::value();
    }

    public function setValue($value, $force = false)
    {

        if (is_array($value))
        {
            foreach ($value as &$v)
            {
                $v = (string)$v;
            }
            unset($v);
        }
        else
        {
            $value = (string)$value;
        }

        return parent::setValue($value, $force);
    }

    public function validate($keys)
    {
        if (!$this->multiple)
        {
            return parent::validate($keys);
        }

        $values    = request($keys);

        $validator = validator($values, [
            $this->name.'.*' => $this->validators
        ]);

        if ($validator->fails())
        {
            $errors = $validator->errors()
                                ->toArray();

            $this->error = array_first($errors);

            return false;
        }

        return true;
    }

    public function view()
    {
        if ($this->emptyFirst !== false)
        {
            $this->options = ['' => $this->emptyFirst] + $this->options;
        }

        if ($this->multiple && !is_array($this->value))
        {
            $this->value = empty($this->value) ? [] : [$this->value];
        }

        return view('form::' . $this->theme . '.element.select', [
            'label'             => $this->label,
            'help'              => $this->help,
            'placeholder'       => $this->placeholder,
            'name'              => $this->name,
            'elementName'       => $this->elementName,
            'options'           => $this->options,
            'optionsAttributes' => $this->optionsAttributes,
            'error'             => $this->error,
            'value'             => $this->value,
            'multiple'          => $this->multiple,
            'class'             => $this->class,
            'attributes'        => $this->attributes
        ]);
    }

}