<?php

namespace Pipeline\Model;

class Job
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

    protected $input;

    public function getInput()
    {
        return $this->input;
    }

    public function setInput($input)
    {
        $this->input = $input;
        return $this;
    }

    protected $workingDirectory;

    public function getWorkingDirectory()
    {
        return $this->workingDirectory;
    }

    public function setWorkingDirectory($workingDirectory)
    {
        $this->workingDirectory = $workingDirectory;
        return $this;
    }

}
