<?php

namespace PlatformPHP\GlueApps\Asset;

trait SleepTrait
{
    public function __sleep()
    {
        return ['id', 'groups', 'dependencies', 'used', 'page', 'minimized'];
    }
}
