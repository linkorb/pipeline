<?php

namespace Pipeline\Model;

class JobResult
{

    protected $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function getJob()
    {
        return $this->job;
    }

    protected $stageResults = [];

    public function getStageResults()
    {
        return $this->stageResults;
    }

    public function getStageResult($stageName)
    {
        if (!isset($this->stageResults[$stageName])) {
            throw new RuntimeException("No result for stage: " . $stageName);
        }
        return $this->stageResults[$stageName];
    }

    public function addStageResult(StageResult $stageResult)
    {
        $this->stageResults[$stageResult->getStage()->getName()] = $stageResult;
        return $this;
    }

    public function getOutput()
    {
        $output = null;
        foreach ($this->stageResults as $stageResult) {
            $output = $stageResult->getOutput();
        }
        return $output;
    }


    public function isSuccessful()
    {
        foreach ($this->stageResults as $stageResult) {
            if ($stageResult->getExitCode()!=0) {
                return false;
            }
        }
        return true;
    }
}
