<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 24.06.16
 * Time: 17:50
 */

namespace Merkeleon\Form\Form\Element;


use Merkeleon\Form\Form\Element;

class Raw extends Element
{
    protected $content   = '';
    protected $isIgnored = true;

    public function __construct($name, $content)
    {
        parent::__construct($name);
        $this->name    = $name;
        $this->content = $content;
    }

    public function validate($keys)
    {
        return true;
    }

    public function view()
    {
        return view('form::' . $this->theme . '.element.raw', [
            'label'   => $this->label,
            'content' => $this->content,
            'class'   => $this->class,
        ]);
    }
}
