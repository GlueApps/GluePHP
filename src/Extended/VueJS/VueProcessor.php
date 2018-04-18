<?php

namespace GlueApps\GluePHP\Extended\VueJS;

use GlueApps\ComposedViews\Asset\ScriptAsset;
use GlueApps\GluePHP\Processor\AbstractProcessor;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class VueProcessor extends AbstractProcessor
{
    public static function assets(): array
    {
        return [
            'vuejs' => new ScriptAsset('vuejs', '')
        ];
    }

    public static function script(): string
    {
        return <<<JAVASCRIPT

    component.vueInstances = [];

    // Se tiene que clonar el modelo para que funcione el binding.
    var newModel = {};
    for (var prop in component.model) {
        newModel[prop] = component.model[prop];
    }

    traverseElements(function(element) {
        var vueInstance = new Vue({el: element, data: newModel});
        component.vueInstances.push(vueInstance);
    });

    component.model = newModel;

JAVASCRIPT;
    }
}
