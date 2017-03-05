<?php

namespace Pipeline\Model;

class Job
{
    protected $pipeline;
    use VariableTrait;

    public function __construct(Pipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    public function getPipeline()
    {
        return $this->pipeline;
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
        if ($this->workingDirectory) {
            return $this->workingDirectory;
        }
        return $this->pipeline->getWorkingDirectory();
    }

    public function setWorkingDirectory($workingDirectory)
    {
        $this->workingDirectory = $workingDirectory;
        return $this;
    }
}
