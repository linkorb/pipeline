<?php

namespace Pipeline;

use Symfony\Component\Process\Process;
use Pipeline\Model\Pipeline;
use Pipeline\Model\Stage;
use Pipeline\Model\Job;
use Pipeline\Model\StageResult;
use Pipeline\Model\JobResult;

class Processor
{
    public function process(Job $job)
    {
        $pipeline = $job->getPipeline();
        $pipelineVars = $pipeline->getVariables();
        $arguments = $job->getVariables();
        $arguments = array_merge($pipelineVars, $arguments);
        $jobResult = new JobResult($job);

        $input = $job->getInput();
        foreach ($pipeline->getStages() as $stage) {
            $command = $stage->getCommand();
            foreach ($arguments as $key => $value) {
                $command = str_replace('{'.$key.'}', $value, $command);
            }
            $stageResult = new StageResult($stage);
            $stageResult->setCommand($command);
            $jobResult->addStageResult($stageResult);

            $process = new Process($command);
            $process->setTimeout(3600);
            $process->setIdleTimeout(3600);
            $process->setInput($input);
            $process->setWorkingDirectory($job->getWorkingDirectory());
            $process->run();
            $stageResult->setExitCode($process->getExitCode());
            $stageResult->setOutput($process->getOutput());
            $stageResult->setErrorOutput($process->getErrorOutput());
            $input = $process->getOutput();
            if (!$process->isSuccessful()) {
                return $jobResult;
            }
        }

        return $jobResult;
    }
}
