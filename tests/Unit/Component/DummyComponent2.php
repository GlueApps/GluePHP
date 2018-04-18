<?php

namespace GlueApps\GluePHP\Tests\Unit\Component;

use GlueApps\GluePHP\Component\AbstractComponent;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class DummyComponent2 extends AbstractComponent
{
    /**
     * @Glue()
     */
    protected $attr4;

    public function html(): string
    {
        return '';
    }

    public function getAttr4()
    {
    }
}
