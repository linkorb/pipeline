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

            //print_r($job->getVariables());exit();
            //print_r($_ENV);exit();
            // echo $command . PHP_EOL;

            $process = new Process($command, null, null);
            $process->setTimeout(3600);
            $process->setIdleTimeout(3600);
            if ($stage->getInput()) {
                $inputStageResult = $jobResult->getStageResult($stage->getInput());
                $input = $inputStageResult->getOutput();
            }
            $process->setInput($input);
            $process->setWorkingDirectory($job->getWorkingDirectory());
            $process->run();

            $output = $process->getOutput();
            $errorOutput = $process->getErrorOutput();
            $exitCode = $process->getExitCode();

            // echo "ExitCode: $exitCode\n";
            // echo "Output length: " . strlen($output) . "\n";
            // echo "Error length: " . strlen($errorOutput) . "\n";


            $stageResult->setExitCode($exitCode);
            $stageResult->setOutput($output);
            $stageResult->setErrorOutput($errorOutput);

            if (!$output) {
                throw new RuntimeException("No output...");
            }


            if (!$process->isSuccessful()) {
                return $jobResult;
            }

            $input = $output; // provide input for next run
        }

        return $jobResult;
    }
}
