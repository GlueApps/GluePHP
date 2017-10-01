<?php

namespace PlatformPHP\GlueApps\Processor;

class BindEventsProcessor extends AbstractProcessor
{
    public static function script(): string
    {
        return <<<JAVASCRIPT
    var bindEvents = function(attribute) {

        var items = component.html.querySelectorAll('*[' + attribute + ']');
        items.forEach(function(item) {
            var events = item.getAttribute(attribute).split(' ');
            events.forEach(function (eventName) {
                item.addEventListener(eventName, function(event) {
                    component.dispatch(eventName, event);
                });
            });
        });
    };

    bindEvents('g-event');
    bindEvents('data-g-event');
JAVASCRIPT;
    }
}
