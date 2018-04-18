<?php

namespace GlueApps\GluePHP\Tests\Integration\Entities\Components;

use GlueApps\GluePHP\Extended\VueJS\VueComponent;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class VueGroup extends VueComponent
{
    /**
     * @Glue
     */
    protected $text = '';

    public function html(): ?string
    {
        return "
            <label>{{ text }}</label>
            {$this->renderizeChildren()}
        ";
    }
}
