<?php

namespace GlueApps\GluePHP\Action;

use GlueApps\GluePHP\Action\AbstractAction;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class UpdateAction extends AbstractAction
{
    public function __construct(string $componentId, string $attribute, $value)
    {
        parent::__construct([
            'componentId' => $componentId,
            'attribute'   => $attribute,
            'value'       => $value,
        ]);
    }

    public static function handlerScript(): string
    {
        return <<<JAVASCRIPT
    var component = app.getComponent(data.componentId);
    var setter = GluePHP.Helpers.getSetter(data.attribute);
    if (component) {
        component[setter](data.value, false);
    }
JAVASCRIPT;
    }

    public function getComponentId(): string
    {
        return $this->data['componentId'];
    }

    public function getAttribute(): string
    {
        return $this->data['attribute'];
    }

    public function getValue()
    {
        return $this->data['value'];
    }
}
