<?php

use Pipeline\Model\Pipeline;
use Pipeline\Model\Stage;
use Pipeline\Model\Job;
use Pipeline\Processor;

require_once __DIR__ . "/../vendor/autoload.php";

$pipeline = new Pipeline('cool');

$stage = new Stage('download');
$stage->setCommand('curl "http://feeds.bbci.co.uk/news/{topic}/rss.xml?edition=uk"');
$pipeline->addStage($stage);

$stage = new Stage('validate');
$stage->setCommand('xmllint --schema rss-2_0.xsd -');
$pipeline->addStage($stage);

$stage = new Stage('transform');
$stage->setCommand('xsltproc rss2html.xslt -');
$pipeline->addStage($stage);

$stage = new Stage('pretty');
$stage->setCommand('xsltproc pretty.xslt -');
$pipeline->addStage($stage);

$job = new Job($pipeline);
$job->setVariable('topic', 'technology');
$job->setWorkingDirectory(__DIR__ . '/');

$processor = new Processor();
$result = $processor->process($job);

print_r($result);
