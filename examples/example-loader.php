<?php

use Pipeline\Model\Pipeline;
use Pipeline\Model\Job;
use Pipeline\Processor;
use Pipeline\Exporter\JsonExporter;
use Pipeline\Loader\YamlLoader;

require_once __DIR__ . "/../vendor/autoload.php";

$loader = new YamlLoader();
$pipeline = $loader->loadFile(__DIR__ . '/bbc-news-demo.pipeline.yml');

$job = new Job($pipeline);
$job->setVariable('topic', 'world');

$processor = new Processor();
$result = $processor->process($job);

$exporter = new JsonExporter();
$json = $exporter->export($result);

echo $json;
