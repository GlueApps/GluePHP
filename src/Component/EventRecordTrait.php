<?php

namespace GlueApps\GluePHP\Component;

trait EventRecordTrait
{
    protected $eventRecord = [];

    public function getEventRecord(): array
    {
        return $this->eventRecord;
    }
}