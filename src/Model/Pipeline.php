<?php

namespace Pipeline\Model;

class Pipeline
{
    protected $name;
    protected $variables = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    protected $stages = [];

    public function getStages()
    {
        return $this->stages;
    }

    public function addStage(Stage $stage)
    {
        $this->stages[$stage->getName()] = $stage;
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

    public function getVariables()
    {
        return $this->variables;
    }

    public function setVariable($key, $value)
    {
        $this->variables[$key] = $value;

        return $this;
    }
}
