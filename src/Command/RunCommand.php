<?php

namespace Pipeline\Command;

use LinkORB\Component\Etcd\Client as EtcdClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pipeline\Model\Pipeline;
use Pipeline\Model\Job;
use Pipeline\Processor;
use Pipeline\Exporter\JsonExporter;
use Pipeline\Loader\YamlLoader;
use RuntimeException;


class RunCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription(
                'Run a pipeline'
            )
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'Pipeline file to run'
            )
            ->addOption(
                'define',
                'd',
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Define variable (key=value)'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        if (!file_exists($filename)) {
            throw new RuntimeException("File not found: $filename");
        }
        $defines = $input->getOption('define');

        $loader = new YamlLoader();
        $pipeline = $loader->loadFile($filename);
        //print_r($pipeline);

        $job = new Job($pipeline);
        foreach ($defines as $define) {
            $part = explode('=', $define);
            if (count($part)!=2) {
                throw new RuntimeException("--define (-d) usage: -d color=green");
            }
            $job->setVariable(trim($part[0]), trim($part[1]));
        }

        $processor = new Processor();
        $result = $processor->process($job);
        if ($result->isSuccessful()) {
            echo $result->getOutput();
            exit(0);
        }
        $stageResults = $result->getStageResults();
        foreach ($stageResults as $stageResult) {
            $output->writeLn("<info>Stage: " . $stageResult->getStage()->getName() . "</info>");
            $output->writeLn("<comment> * Command:</comment>" . $stageResult->getCommand());
            $output->writeLn("<comment> * Exitcode:</comment> " . $stageResult->getExitCode());
            //$output->writeLn("<comment>" . rtrim($stageResult->getOutput(), "\n") . "</comment>");
            $output->writeLn("");

        }


        $lastResult = array_pop($stageResults);
        $output->writeLn("<error>Error in stage: " . $lastResult->getStage()->getName() . "</error>");
        $output->writeLn("<comment>" . rtrim($lastResult->getErrorOutput(), "\n") . "</comment>");
        exit($lastResult->getExitCode());
    }
}