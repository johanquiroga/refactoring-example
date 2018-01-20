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
        $result = $this->open();

        if ($this->isVoid()) {
            return $result;
        }

        $result .= $this->content();

        $result .= $this->close();

        return $result;
    }

    public function open()
    {
        if (! empty($this->attributes)) {
            $result = "<{$this->name}{$this->attributes()}>";
        } else {
            $result = "<{$this->name}>";
        }

        return $result;
    }

    public function attributes()
    {
        $htmlAttributes = '';

        foreach ($this->attributes as $attribute => $value) {
            $htmlAttributes .= $this->renderAttribute($attribute, $value);
        }

        return $htmlAttributes;
    }

    protected function renderAttribute($attribute, $value)
    {
        $htmlAttribute = '';

        if (is_numeric($attribute)) {
            $htmlAttribute .= ' '.$value;
        } else {
            $htmlAttribute .= ' '.$attribute.'="'.htmlentities($value, ENT_QUOTES, 'UTF-8').'"'; // name="value"
        }

        return $htmlAttribute;
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