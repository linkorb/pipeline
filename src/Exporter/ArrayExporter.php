<?php

namespace Pipeline\Exporter;

use Pipeline\Model\JobResult;
use Pipeline\Model\StageResult;
use Pipeline\Model\Stage;

class ArrayExporter
{
    public function export(JobResult $jobResult)
    {
        $job = $jobResult->getJob();
        $data = [];
        $data['pipeline'] = [
            'name' => $job->getPipeline()->getName()
        ];
        $data['variables'] = $job->getVariables();
        $data['stage_results'] = [];
        foreach ($jobResult->getStageResults() as $stageResult) {
            $data['stage_results'][$stageResult->getStage()->getName()] = $this->exportStageResult($stageResult);
        }
        $data['output'] = $jobResult->getOutput();
        $data['successful'] = $jobResult->isSuccessful();

        return $data;
    }

    public function exportStageResult(StageResult $stageResult)
    {
        $data = [];
        $data['stage'] = $this->exportStage($stageResult->getStage());
        $data['command'] = $stageResult->getCommand();
        $data['output'] = $stageResult->getOutput();
        $data['error_output'] = $stageResult->getErrorOutput();
        $data['exit_code'] = $stageResult->getExitCode();
        $data['output'] = $stageResult->getOutput();
        return $data;
    }

    public function exportStage(Stage $stage)
    {
        $data = [];
        $data['name'] = $stage->getName();
        $data['command'] = $stage->getCommand();

        return $data;
    }
}
