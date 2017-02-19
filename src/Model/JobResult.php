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

    public function addStageResult(StageResult $stageResult)
    {
        $this->stageResults[] = $stageResult;
        return $this;
    }

}
