<?php
namespace Pipeline\Model;

trait VariableTrait
{
    protected $variables = [];
    public function getVariables()
    {
        return $this->variables;
    }

    public function setVariable($key, $value)
    {
        $this->variables[$key] = $value;
        return $this;
    }

    public function hasVariable($key)
    {
        return isset($this->variables[$key]);
    }

    public function getVariable($key)
    {
        if (!$this->hasVariable($key)) {
            throw new RuntimeException("Undefined variable: " . $key);
        }
        return $this->variables[$key];
    }
}
