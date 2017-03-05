<?php

namespace Pipeline\Model;

class Pipeline
{
    protected $name;
    protected $basePath;

    use VariableTrait;

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

    public function setBasePath($path)
    {
        $this->basePath = $path;
    }

    public function getBasePath()
    {
        return $this->basePath;
    }
}
