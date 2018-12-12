<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 12:55
 */

namespace Merkeleon\Form\Form;

use Illuminate\Support\HtmlString;
use Merkeleon\Form\Form;

abstract class Element
{
    protected $name;
    protected $validators;
    protected $theme;
    protected $error;
    protected $value;
    protected $help;
    protected $label;
    protected $placeholder;
    protected $postfix;
    protected $class;
    protected $attributes = [];

    protected $isIgnored   = false;
    protected $isDisabled  = false;
    protected $hasOldValue = false;
    protected $form;

    public function __construct($name, $validators = '', Form $form = null)
    {
        $this->form        = $form;
        $isFormSubmitted   = is_null($form) || $form->isSubmitted();

        $this->name        = $name;
        $this->elementName = self::prepareElementName($name);
        $this->validators  = $validators;
        $oldValue          = request()->input($this->name, false);
        if ($oldValue === false)
        {
            $oldValue = request()->old($this->name, false);
        }
        $this->hasOldValue = $isFormSubmitted && $oldValue !== false;
        $this->error       = null;
        $errors            = session()->get('errors');

        if ($isFormSubmitted)
        {
            $this->value = $oldValue;

            if ($errors)
            {
                $this->error = $errors->first($this->name);
            }
        }
    }

    public static function prepareElementName($name)
    {
        $parts  = explode('.', $name);
        $result = array_shift($parts);
        foreach ($parts as $part)
        {
            $result .= '[' . $part . ']';
        }

        return $result;
    }

    public function disable($disable = true)
    {
        $this->setDisabled($disable)
             ->setIgnored($disable);

        return $this;
    }

    public function setIgnored($isIgnored)
    {
        $this->isIgnored = $isIgnored;

        return $this;
    }

    public function setDisabled($isDisabled = true)
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }

    public function setPostfix($postfix)
    {
        $this->postfix = $postfix;

        return $this;
    }

    public function isIgnored()
    {
        return $this->isIgnored;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function addAttributes($attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setHelp($help)
    {
        $this->help = $help;

        return $this;
    }

    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function render()
    {
        $this->disableIfNeeded();

        return new HtmlString($this->view()
                                   ->render());
    }

    public function disableIfNeeded()
    {
        $isElementDisabled = $this->isDisabled;
        $isFormDisabled    = $this->form ? $this->form->isDisabled() : false;

        if ($isElementDisabled || $isFormDisabled)
        {
            $this->addAttributes(['disabled' => 'disabled']);
        }

        return $this;
    }

    public function error()
    {
        return $this->error;
    }

    public function setValidators($validators)
    {
        $this->validators = $validators;

        return $this;
    }

    public function getValidators()
    {
        return $this->validators;
    }

    public function validate($keys)
    {
        $validator = $this->form ? $this->form->getValidator() : validator()->make([], []);
        $values    = request($keys);

        $validator = $validator->setData($values);
        $validator = $validator->setRules([
            $this->name => $this->validators
        ]);

        if ($validator->fails())
        {
            $this->error = $validator->errors()->first($this->name);

            return false;
        }

        return true;
    }

    public function setValue($value, $force = false)
    {
        if ($force || !$this->hasOldValue)
        {
            $this->value = $value;
        }

        return $this;
    }

    public function value()
    {
        return $this->value;
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public abstract function view();
}
