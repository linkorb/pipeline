<?php

namespace Pipeline\Model;

class Pipeline
{
    protected $name;
    protected $description;
    protected $basePath;

    use VariableTrait;

    public function __construct($name, $description = null)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
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
