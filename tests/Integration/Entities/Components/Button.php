<?php

namespace GlueApps\GluePHP\Tests\Integration\Entities\Components;

use GlueApps\GluePHP\Component\AbstractComponent;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class Button extends AbstractComponent
{
    public function html(): ?string
    {
        return "<button gphp-bind-events=\"click\">{$this->getId()}</button>";
    }
}
