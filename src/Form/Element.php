<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 12:55
 */

namespace Merkeleon\Forms\Form;

use Illuminate\Support\HtmlString;

abstract class Element
{
    protected $name;
    protected $validators;
    protected $theme;
    protected $error;
    protected $value;
    protected $label;
    protected $placeholder;
    protected $postfix;
    protected $class;
    protected $attributes = [];

    protected $isIgnored = false;
    protected $hasOldValue = false;

    public function __construct($name, $validators = '')
    {
        $this->name = $name;
        $this->elementName = self::prepareElementName($name);
        $this->validators = $validators;
        $oldValue = request()->input($this->name, null);
        if ($oldValue === null) {
            $oldValue = request()->old($this->name, null);
        }
        $this->hasOldValue = $oldValue !== null;
        $this->value = $oldValue;
        $this->error = null;
        if ($errors = session()->get('errors')) {
            $this->error = array_get($errors->toArray(), $this->name, '');
            if (is_array($this->error)) {
                $this->error = array_first($this->error);
            }
        }
    }

    public static function prepareElementName($name) {
        $parts = explode('.', $name);
        $result = array_shift($parts);
        foreach ($parts as $part) {
            $result .= '['.$part.']';
        }
        return $result;
    }

    public function setIgnored($isIgnored)
    {
        $this->isIgnored = $isIgnored;

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

    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function render()
    {
        return new HtmlString($this->view()->render());
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

    public function validate($keys)
    {
        $values = request($keys);
        $validator = validator($values, [
            $this->name => $this->validators
        ]);
        if ($validator->fails()) {
            $this->error = array_get($validator->errors()->toArray(), $this->name . '.0');
            return false;
        }

        return true;
    }

    public function setValue($value, $force = false)
    {
        if ($force || !$this->hasOldValue) {
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