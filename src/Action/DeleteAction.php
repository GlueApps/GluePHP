<?php

namespace GlueApps\GluePHP\Action;

use GlueApps\GluePHP\AbstractApp;
use GlueApps\GluePHP\Action\AbstractAction;
use GlueApps\GluePHP\Component\AbstractComponent;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class DeleteAction extends AbstractAction
{
    public function __construct(AbstractApp $app, AbstractComponent $parent, AbstractComponent $child, bool $render = true)
    {
        parent::__construct([
            'parentId' => $parent->getId(),
            'childId'  => $child->getId(),
        ]);
    }

    public static function handlerScript(): string
    {
        return <<<JAVASCRIPT

    if (app.existsComponent(data.childId)) {
        app.dropComponent(data.childId);
    }

    var parent = app.getComponent(data.parentId);
    if (parent instanceof GluePHP.Component) {
        parent.dropComponent(data.childId);
    }

JAVASCRIPT;
    }
}
