<?php

namespace Pipeline;

use Symfony\Component\Process\Process;
use Pipeline\Model\Pipeline;
use Pipeline\Model\Stage;
use Pipeline\Model\Job;
use Pipeline\Model\StageResult;
use Pipeline\Model\JobResult;
use RuntimeException;

class Processor
{
    public function process(Job $job)
    {
        $variables = $job->getPipeline()->getVariables();
        $variables = array_merge($variables, $_ENV);
        $variables = array_merge($variables, $job->getVariables());
        foreach ($variables as $key => $value) {
            if (trim($value)=='?') {
                throw new RuntimeException("Require input variable undefined: " . $key);
            }
        }

        $jobResult = new JobResult($job);

        $input = $job->getInput();
        foreach ($job->getPipeline()->getStages() as $stage) {
            $command = $stage->getCommand();
            foreach ($variables as $key => $value) {
                $command = str_replace('{' . $key . '}', $value, $command);
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
