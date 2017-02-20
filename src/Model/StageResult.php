<?php

namespace Pipeline\Model;


class StageResult
{
    protected $stage;

    public function __construct($stage)
    {
        $this->stage = $stage;
    }

    public function getStage()
    {
        return $this->stage;
    }

    protected $command;

    public function getCommand()
    {
        return $this->command;
    }

    public function setCommand($command)
    {
        $this->command = $command;
        return $this;
    }

    protected $exitCode;

    public function getExitCode()
    {
        return $this->exitCode;
    }

    public function setExitCode($exitCode)
    {
        $this->exitCode = $exitCode;
        return $this;
    }

    protected $output;

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput($output)
    {
        $this->output = $output;
        return $this;
    }

    protected $errorOutput;

    public function getErrorOutput()
    {
        return $this->errorOutput;
    }

    public function setErrorOutput($errorOutput)
    {
        $this->errorOutput = $errorOutput;
        return $this;
    }



}
