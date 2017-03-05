<?php

namespace Pipeline\Loader;

use Pipeline\Model\Pipeline;
use Pipeline\Model\Stage;
use Symfony\Component\Yaml\Yaml as YamlParser;
use RuntimeException;

class YamlLoader
{
    public function loadFile($filename)
    {
        $filename = realpath($filename);
        if (!file_exists($filename)) {
            throw new RuntimeException("File not found: " . $filename);
        }
        $basePath = dirname($filename);
        $data = $this->loadYaml($filename);

        return $this->load($data, $basePath);
    }

    public function loadYaml($filename)
    {
        if (!file_exists($filename)) {
            $this->errors[] = sprintf(
                'Failed to load yaml file "%s": File not found.',
                $filename
            );

            return array();
        }
        $basePath = dirname($filename);

        $parser = new YamlParser();
        $data = null;
        try {
            $data = $parser->parse(file_get_contents($filename));
            if (! is_array($data)) {
                $this->errors[] = sprintf(
                    'Failed to get any yaml content from file "%s".',
                    $filename
                );

                return array();
            }
        } catch (ParseException $e) {
            $this->errors[] = sprintf(
                'Failed to parse yaml content from file "%s": %s',
                $filename,
                $e->getMessage()
            );

            return array();
        }

        return $data;
    }

    public function load($data, $basePath)
    {
        $pipeline = new Pipeline($data['name']);
        $pipeline->setWorkingDirectory($basePath);

        if (!isset($data['stages'])) {
            throw new RuntimeException("This pipeline doesn't define any stages (required)");
        }
        foreach ($data['stages'] as $name => $stageData) {
            $stage = new Stage($name);
            $stage->setCommand($stageData['command']);

            $pipeline->addStage($stage);
        }

        if (isset($data['variables'])) {
            foreach ($data['variables'] as $key => $value) {
                $pipeline->setVariable($key, $value);
            }
        }

        return $pipeline;
    }
}
