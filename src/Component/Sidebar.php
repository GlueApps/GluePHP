<?php

namespace GlueApps\GluePHP\Component;

use GlueApps\ComposedViews\Component\SidebarInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class Sidebar extends AbstractComponent implements SidebarInterface
{
    public function processors(): array
    {
        return [];
    }

    public function html(): ?string
    {
        return AbstractComponent::containerView(
            $this->id,
            $this->renderizeChildren()
        );
    }
}
