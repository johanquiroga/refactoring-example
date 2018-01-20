<?php

namespace App;

class HtmlElement
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var null
     */
    private $content;

    /**
     * @var array
     */
    private $attributes;

    public function __construct(string $name, array $attributes = [], $content = null)
    {
        $this->name = $name;
        $this->content = $content;
        $this->attributes = $attributes;
    }

    public function render()
    {
        if ($this->isVoid()) {
            return $this->open();
        }

        return $this->open().$this->content().$this->close();
    }

    public function open()
    {
        return "<{$this->name}{$this->attributes()}>";
    }

    public function attributes()
    {
        return array_reduce(array_keys($this->attributes), function ($result, $attribute) {
            return $result . $this->renderAttribute($attribute);
        }, '');
    }

    public function hasAttributes()
    {
        return ! empty($this->attributes);
    }

    protected function renderAttribute($attribute)
    {
        if (is_numeric($attribute)) {
            return ' '.$this->attributes[$attribute];
        }

        return ' '.$attribute.'="'.htmlentities($this->attributes[$attribute], ENT_QUOTES, 'UTF-8').'"'; // name="value"
    }

    public function isVoid()
    {
        return in_array($this->name, ['br', 'hr', 'img', 'input', 'meta']);
    }

    public function content()
    {
        return htmlentities($this->content, ENT_QUOTES, 'UTF-8');
    }

    public function close()
    {
        return "</{$this->name}>";
    }
}
