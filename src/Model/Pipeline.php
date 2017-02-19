<?php

namespace Pipeline\Model;

class Pipeline
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    protected $stages = [];

    public function getStages()
    {
        return $this->stages;
    }

    public function addStage(Stage $stage)
    {
        $this->stages[$stage->getName()] = $stage;
        return $this;
    }

}
