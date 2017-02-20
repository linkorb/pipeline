<?php

namespace Pipeline\Exporter;

use Pipeline\Model\JobResult;

class JsonExporter extends ArrayExporter
{
    public function export(JobResult $jobResult)
    {
        $data = parent::export($jobResult);
        return json_encode($data, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }
}
