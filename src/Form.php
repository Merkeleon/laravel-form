<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 27.04.16
 * Time: 15:38
 */

namespace Merkeleon\Form;

use Illuminate\Support\HtmlString;
use Merkeleon\Form\Form\Element;
use Merkeleon\Form\Form\Element\Checkbox;
use Merkeleon\Form\Form\Element\Hidden;
use Merkeleon\Form\Form\Element\Password;
use Merkeleon\Form\Form\Element\Select;
use Merkeleon\Form\Form\Element\Text;
use Merkeleon\Form\Form\Element\Submit;
use Merkeleon\Form\Form\Element\Textarea;

class Form
{
    protected $method;
    protected $action;
    protected $theme;
    protected $class;
    protected $elements = [];
    protected $errors = [];
    protected $validated = false;
    protected $name = false;
    protected $isAjax = false;
    protected $enctype;

    public function __construct()
    {
        $this->theme = config('merkeleon.form.theme');
    }

    public static function form()
    {
        return new static();
    }

    public function method($method = null)
    {
        $this->method = $method;
        return $this;
    }

    public function isAjax($isAjax)
    {
        $this->isAjax = $isAjax;
        return $this;
    }

    public function route($routeName, $parameters = [])
    {
        $this->action = route($routeName, $parameters);
        return $this;
    }

    public function action($action) {
        $this->action = $action;
        return $this;
    }

    public function view()
    {
        return view('form::' . $this->theme . '.form', [
            'elements' => $this->elements,
            'method' => $this->method,
            'action' => $this->action,
            'name' => $this->name,
            'class' => $this->class,
            'isAjax' => $this->isAjax,
            'enctype' => $this->enctype,
        ]);
    }

    public function render()
    {
        $this->setupFormName();
        $this->addElementHidden($this->name)->setValue($this->name);
        return new HtmlString($this->view()->render());
    }

    public function isSubmitted() {
        $this->setupFormName();

        return request()->has($this->name) || old($this->name);
    }

    public function setTranslationMask($translationMask = '')
    {
        $this->translationMask = $translationMask;
        return $this;
    }

    public function setPlaceholderTranslationMask($placeholderTranslationMask = '')
    {
        $this->placeholderTranslationMask = $placeholderTranslationMask;
        return $this;
    }

    public function setName($name = '')
    {
        $this->name = $name;
        return $this;
    }

    public function setClass($class = '')
    {
        $this->class = $class;
        return $this;
    }

    public function addClass($class)
    {
        $this->class .= ' ' . $class;
        return $this;
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\Text
     */
    public function addElementText($name, $validators = '')
    {
        $element = new Text($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\DateTime
     */
    public function addElementDateTime($name, $validators = '')
    {
        $element = new Element\DateTime($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\Date
     */
    public function addElementDate($name, $validators = '')
    {
        $element = new Element\Date($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\Range
     */
    public function addElementRange($name, $validators = '')
    {
        $element = new Element\Range($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\File
     */
    public function addElementFile($name, $validators = '')
    {
        $element = new Element\File($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        $this->enctype = 'multipart/form-data';
        
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $view
     * @param array $data
     * @return \Merkeleon\Form\Form\Element\Delimiter
     */
    public function addElementDelimiter($name, $view = '', $data = [])
    {
        $element = new Element\Delimiter($name, '');
        $element->setTheme($this->theme)
            ->setContent($view, $data);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    public function addElement(Element $element)
    {
        $this->elements[$element->getName()] = $element;
        return $this->elements[$element->getName()];
    }


    /**
     * @param $name
     * @param string $content
     * @return \Merkeleon\Form\Form\Element\Html
     */
    public function addElementHtml($name, $content = '')
    {
        $element = new Element\Html($name, $content, $this);

        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }
    
    
    /**
     * @param $name
     * @param string $content
     * @return \Merkeleon\Form\Form\Element\Raw
     */
    public function addElementRaw($name, $content = '')
    {
        $element = new Element\Raw($name, $content, $this);

        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    
    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\Textarea
     */
    public function addElementTextarea($name, $validators = '')
    {
        $element = new Textarea($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\Hidden
     */
    public function addElementHidden($name, $validators = '')
    {
        $element = new Hidden($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\Checkbox
     */
    public function addElementCheckbox($name, $validators = '')
    {
        $element = new Checkbox($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\CheckboxGroup
     */
    public function addElementCheckboxGroup($name, $validators = '')
    {
        $element = new Element\CheckboxGroup($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\Password
     */
    public function addElementPassword($name, $validators = '')
    {
        $element = new Password($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\Select
     */
    public function addElementSelect($name, $validators = '')
    {
        $element = new Select($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;

        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \Merkeleon\Form\Form\Element\Radio
     */
    public function addElementRadio($name, $validators = '')
    {
        $element = new Element\Radio($name, $validators, $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;

        return $this->elements[$name];
    }

    /**
     * @param string $name
     * @return \Merkeleon\Form\Form\Element\Submit
     */
    public function addElementSubmit($name = 'submit')
    {
        $element = new Submit($name, '', $this);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    public function getElement($name)
    {
        return isset($this->elements[$name]) ? $this->elements[$name] : null;
    }


    public function getElements($names = null)
    {
        if ($names === null) {
            return $this->elements;
        }
        if (!is_array($names)) {
            $names = func_get_args();
        }
        return array_only($this->elements, $names);
    }

    public function validate($force = false)
    {
        if(!$this->isSubmitted() && !$force) {
            return false;
        }

        if (!$this->validated) {
            $keys = array_keys($this->elements);
            foreach ($this->elements as $name => $element) {
                if(!$element->isIgnored()) {
                    if (!$element->validate($keys)) {
                        array_set($this->errors, $name, $element->error());
                    }
                }
            }
            $this->validated = true;
        }

        return count($this->errors) < 1;
    }

    public function errors()
    {
        if (!$this->validated) {
            $this->validate();
        }
        return $this->errors;
    }

    public function values($skipEmptyString = false)
    {
        $data = [];
        foreach ($this->elements as $name => $element) {
            if(!$element->isIgnored()) {
                $value = $element->value();
                if (!$skipEmptyString || $skipEmptyString && $value !== '') {
                    array_set($data, $name, $value);
                }
            }
        }

        return $data;
    }

    public function value($name, $default = null)
    {
        return array_get($this->values(), $name, $default);
    }

    public function setValues($values = [])
    {
        foreach ($this->elements as $name => $element) {
            $value = array_get($values, $name);

            if ($value !== null) {
                $element->setValue($value);
            }
        }

        return $this;
    }

    public function setTheme($theme = '')
    {
        $this->theme = $theme;
        return $this;
    }

    public function redirectToRoute($route, $attributes = [])
    {
        return redirect()->route($route, $attributes)->withErrors($this->errors)->withInput();
    }

    public function redirectBack($additionalErrors = []) {
        $errors = array_merge($additionalErrors, $this->errors());

        return redirect()->back()->withErrors($errors)->withInput();
    }

    private function setupFormName() {
        if (!$this->name) {
            $this->name = md5(get_class($this));
        }
    }

}
