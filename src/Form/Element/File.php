<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace Merkeleon\Form\Form\Element;

use Merkeleon\Form\Form\Element;

class File extends Element
{
    protected $isMultiple = false;

    public function setMultiple($multiple = true)
    {
        $this->isMultiple = $multiple;

        return $this;
    }

    public function view()
    {
        return view('form::' . $this->theme . '.element.file', [
            'name'        => $this->name,
            'help'        => $this->help,
            'elementName' => $this->elementName,
            'error'       => $this->error,
            'label'       => $this->label,
            'placeholder' => $this->placeholder,
            'class'       => $this->class,
            'multiple'    => $this->isMultiple,
            'attributes'  => $this->attributes
        ]);
    }

    public function validate($keys)
    {
        if (!$this->isMultiple)
        {
            return parent::validate($keys);
        }

        $values    = request($keys);
        $validator = validator($values, [
            $this->name . '.*' => $this->validators
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

}