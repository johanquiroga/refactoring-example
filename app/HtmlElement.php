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
        $this->attributes = new HtmlAttributes($attributes);
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
        return $this->attributes->render();
    }

    public function hasAttributes()
    {
        return $this->attributes->empty();
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

/**
 * 1. Agregar prueba en HtmlElementTest para hasAttributes
 * 2. Agregar otra vez dicho método a la clase HtmlElement
 * 3. Mover a clase HtmlAttributes
 */
