<?php

namespace GlueApps\GluePHP\Tests\Unit\Builder;

use GlueApps\GluePHP\AbstractApp;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class App extends AbstractApp
{
    public function sidebars(): array
    {
        return ['sidebar1', 'sidebar2'];
    }

    public function html(): ?string
    {
    }
}
