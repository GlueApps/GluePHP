<?php

namespace GlueApps\GluePHP\Extended\VueJS;

use GlueApps\GluePHP\Processor\ShortEventsProcessor;
use GlueApps\GluePHP\Component\AbstractComponent;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class VueComponent extends AbstractComponent
{
    public function processors(): array
    {
        return [
            VueProcessor::class,
            ShortEventsProcessor::class,
        ];
    }

    public function html(): ?string
    {
    }
}
