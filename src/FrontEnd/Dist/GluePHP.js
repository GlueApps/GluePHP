/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

/////////////
// GluePHP //
/////////////

(function(GluePHP) {
'use strict';

Event.prototype.propagationStopped = false;
Event.prototype.stopEventPropagation = function() {
    this.propagationStopped = true;
};
Event.prototype.isPropagationStopped = function() {
    return this.propagationStopped;
};

GluePHP.Factory = {

    App: {

        createRequestEvent: function(request) {
            var event = new CustomEvent('app.request', {detail: request});
            event.request = request;
            return event;
        },

        createAppActionEvent: function(action) {
            var event = new CustomEvent('app.action', {detail: action});
            event.action = action;
            return event;
        },

        createResponseEvent: function(response) {
            var event = new CustomEvent('app.request', {detail: response});
            event.response = response;
            return event;
        },

        createFailedResponseEvent: function(request) {
            var event = new CustomEvent('app.failed_response', {detail: request});
            event.request = request;
            return event;
        },

        createResponseErrorEvent: function(response) {
            var event = new CustomEvent('app.response_error', {detail: response});
            event.response = response;
            return event;
        },

        createFilterEventDataEvent: function(eventName, event, data) {
            var result = new CustomEvent('app.filter_event_data');
            result.eventName = eventName;
            result.event = event;
            result.data = data;
            return result;
        },
    },

    Component: {

        createRemoteUpdateEvent: function(updates) {
            var event = new CustomEvent('remote_update', {detail: updates});
            event.updates = updates;
            return event;
        },

        createEndRemoteUpdateEvent: function(data) {
            var event = new CustomEvent('end_remote_update', {detail: data});
            event.data = data;
            return event;
        },
    },
};

GluePHP.Helpers = {

    capitalizeFirstLetter: function(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    },

    getSetter: function(attribute) {
        return 'set' + GluePHP.Helpers.capitalizeFirstLetter(attribute);
    },
};

})(window.GluePHP = window.GluePHP || {});

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

/////////////////////////////
// GluePHP.EventDispatcher //
/////////////////////////////

(function(GluePHP) {
'use strict';

function EventDispatcher() {
    this.events = {};
};

EventDispatcher.prototype.addListener = function(name, listener) {

    if (! this.events.hasOwnProperty(name)) {
        this.events[name] = [];
    }

    this.events[name].push(listener);
};

EventDispatcher.prototype.dispatch = function(name, event) {

    if (this.events.hasOwnProperty(name) && Array.isArray(this.events[name])) {
        for (var listener of this.events[name]) {
            if (! event.isPropagationStopped()) {
                listener(event);
            } else {
                break;
            }
        }
    }
};

GluePHP.EventDispatcher = EventDispatcher;

})(window.GluePHP = window.GluePHP || {});

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

////////////////////////////////
// GluePHP.ComponentContainer //
////////////////////////////////

(function(GluePHP) {
'use strict';

function ComponentContainer() {
    this.components = {};
};

ComponentContainer.prototype.getAllComponents = function() {
    return this.components;
};

ComponentContainer.prototype._findOne = function(components, id) {

    for (var componentId in components) {
        var component = components[componentId];
        if (id == component.id) {
            return component;
        } else {
            component = this._findOne(component.components, id);
            if (component) {
                return component;
            }
        }
    }

    return null;
};

ComponentContainer.prototype.getComponent = function(id) {

    var idList = id.split(' ');

    if (idList.length == 1) {
        return this._findOne(this.components, id);
    } else {

        var hash = {};
        for (var componentId of idList) {
            hash[componentId] = null;
        }

        var container = this;
        for (var componentId of idList) {
            var component = container.getComponent(componentId);
            if (component) {
                hash[componentId] = component;
                container = component;
            } else {
                break;
            }
        }

        return hash[idList.pop()];
    }
};

ComponentContainer.prototype.addComponent = function(component) {
    this.components[component.id] = component;
};

ComponentContainer.prototype.existsComponent = function(id) {
    return this.components.hasOwnProperty(id);
};

ComponentContainer.prototype.dropComponent = function(id) {

    var component = this.components[id];
    delete this.components[id];

    if (component instanceof GluePHP.Component &&
        component.element instanceof Element)
    {
        component.element.remove();
    }
};

GluePHP.ComponentContainer = ComponentContainer;

})(window.GluePHP = window.GluePHP || {});

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

////////////////////////
// GluePHP.BaseEntity //
////////////////////////

(function(GluePHP) {
'use strict';

function BaseEntity() {

    GluePHP.ComponentContainer.call(this);

    this.dispatcher = new GluePHP.EventDispatcher();
};

BaseEntity.prototype = Object.create(GluePHP.ComponentContainer.prototype);
BaseEntity.prototype.constructor = BaseEntity;

BaseEntity.prototype.addListener = function(name, listener) {
    this.dispatcher.addListener(name, listener);
};

BaseEntity.prototype.dispatchInLocal = function(name, event) {
    this.dispatcher.dispatch(name, event);
};

GluePHP.BaseEntity = BaseEntity;

})(window.GluePHP = window.GluePHP || {});

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

/////////////////
// GluePHP.App //
/////////////////

(function(GluePHP) {
'use strict';

function App(url, token) {

    GluePHP.BaseEntity.call(this);

    this.url = url;
    this.token = token;
    this.buffer = {};
    this.actionHandlers = {};
    this.processors = {};
    this.httpRequests = [];
    this.componentClasses = {};
    this.requestMethod = 'POST';
    this.requestKey = 'glue_request';
    this.debug = false;
    this.eventRecord = {};
};

App.prototype = Object.create(GluePHP.BaseEntity.prototype);
App.prototype.constructor = App;

App.prototype.getStatus = function() {
    return null;
};

App.prototype.dispatchInRemote = function(name, event) {

    var app = this;
    if (! app.url) return;

    var request = this.buildRequest(name, event);
    var requestEvent = GluePHP.Factory.App.createRequestEvent(request);

    this.dispatchInLocal('app.request', requestEvent);

    var xhr = new XMLHttpRequest();
    xhr.request = request;
    xhr.streaming = false;
    xhr.lastResponseLen = 0;

    xhr.onprogress = function(event) {

        if (! event.currentTarget) return;
        xhr.streaming = true;

        var currentResponse = null;
        var responseBuffer = event.currentTarget.response;

        if (xhr.lastResponseLen === false) {
            currentResponse = responseBuffer;
            xhr.lastResponseLen = responseBuffer.length;
        } else {
            currentResponse = responseBuffer.substring(xhr.lastResponseLen);
            xhr.lastResponseLen = responseBuffer.length;
        }

        if ('string' === typeof(currentResponse)) {
            processMessage(currentResponse);
        }
    };

    xhr.onreadystatechange = function() {

        if (xhr.readyState === XMLHttpRequest.DONE) {

            app.httpRequests.splice(
                app.httpRequests.indexOf(xhr), 1
            );

            if (xhr.status === 200 && xhr.streaming == false) {
                processMessage(xhr.responseText);
            } else {
                var failedResponseEvent = GluePHP.Factory.App.createFailedResponseEvent(request);
                app.dispatchInLocal('app.failed_response', failedResponseEvent);
            }
        }
    };

    xhr.open(this.requestMethod, this.url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.send(this.requestKey + '=' + JSON.stringify(requestEvent.request));
    app.httpRequests.push(xhr);

    if (true === app.debug) {
        console.log('Remote event: ' + name, event);
    }

    this.buffer = {};

    for (var update of request.serverUpdates) {
        var component = this.getComponent(update.componentId);
        if (component) {
            var event = GluePHP.Factory.Component.createRemoteUpdateEvent(update.data);
            component.dispatchInLocal('remote_update', event);
        }
    }

    function processMessage(text) {

        if ('string' !== typeof(text)) {
            return
        }

        var lines = text.split('%G_MSG%');
        for (var id in lines) {
            var line = lines[id];
            try {

                if (! line.length) {
                    continue;
                }

                var message = JSON.parse(line);
                if (message.hasOwnProperty('code')) {

                    var responseEvent = GluePHP.Factory.App.createResponseEvent(message);
                    app.dispatchInLocal('app.response', responseEvent);

                    var response = responseEvent.response;
                    response.request = xhr.request;
                    app.processResponse(response);

                } else {
                    app.runAction(message);
                }
            } catch (e) {
                console.log('Invalid message line: ', line, ';;; Error: ', e);
            }
        }
    }
};

App.prototype.dispatch = function(name, event) {

    if (! this.eventRecord.hasOwnProperty(name)) {
        return;
    }

    this.dispatchInLocal(name, event);

    if (! event.propagationStopped) {
        this.dispatchInRemote(name, event);
    }
};

App.prototype.buildRequest = function(name, event) {

    var updates = [];
    for (var componentId in this.buffer) {
        var update = {
            componentId: componentId,
            data: this.buffer[componentId],
        };
        updates.push(update);
    }

    var data = {},
        recordData = this.eventRecord[name];

    if (recordData instanceof Array) {
        for (var prop of recordData) {
            if ('undefined' != typeof(event[prop])) {
                data[prop] = event[prop];
            }
        }
    }

    var filterEventData = GluePHP.Factory.App.createFilterEventDataEvent(name, event, data);
    this.dispatchInLocal('app.filter_event_data', filterEventData);

    return {
        appToken: this.token,
        status: this.getStatus(),
        eventName: name,
        eventData: filterEventData.data,
        serverUpdates: updates,
    };
};

App.prototype.registerUpdate = function(componentId, attribute, value) {

    var component = this.getComponent(componentId);

    if (! (component instanceof GluePHP.Component)) {
        return;
    }

    if (! (component.model.hasOwnProperty(attribute))) {
        return;
    }

    if (! (this.buffer.hasOwnProperty(componentId))) {
        this.buffer[componentId] = {};
    }

    this.buffer[componentId][attribute] = value;
};

App.prototype.runAction = function(action) {

    if (true === this.debug) {
        console.log('Action:', action);
    }

    var event = GluePHP.Factory.App.createAppActionEvent(action);
    this.dispatchInLocal('app.action', event);

    return this.actionHandlers[action.handler](action.data, this);
};

App.prototype.processResponse = function(response) {

    var app = this;

    if (true === this.debug) {
        console.log('Response:', response);
    }

    if (response.code === 200) {

        response.request.serverUpdates.forEach(function(serverUpdate) {
            var component = app.getComponent(serverUpdate.componentId);
            component.dispatchInLocal(
                'end_remote_update',
                GluePHP.Factory.Component.createEndRemoteUpdateEvent(serverUpdate.data)
            )
        });

        for (var id in response.actions) {
            app.runAction(response.actions[id]);
        }

    } else {
        var event = GluePHP.Factory.App.createResponseErrorEvent(response);
        app.dispatchInLocal('app.response_error', event);
    }
};

App.prototype.processComponent = function(component) {
    for (var id in this.processors) {
        var processor = this.processors[id];
        processor(component);
    }
};

App.prototype.registerEvent = function(name, data = null) {
    this.eventRecord[name] = data;
};

GluePHP.App = App;

})(window.GluePHP = window.GluePHP || {});

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

///////////////////////
// GluePHP.Component //
///////////////////////

(function(GluePHP) {
'use strict';

function Component(id, app, model = {}, element) {

    GluePHP.BaseEntity.call(this);

    this.id = id;
    this.app = app;
    this.model = Object.seal(model);
    this.element = element;
    this.childrenClass = 'gphp-' + id + '-children';
    this.childrenElement = element instanceof Element ?
        element.querySelector('.gphp-children') : null;
};

Component.prototype = Object.create(GluePHP.BaseEntity.prototype);
Component.prototype.constructor = Component;

Component.prototype.dispatchInApp = function(eventName, event) {
    var eventNameInApp = this.id + '.' + eventName;
    this.app.dispatch(eventNameInApp, event);
};

Component.prototype.dispatch = function(eventName, event) {

    this.dispatchInLocal(eventName, event);

    if (! event.propagationStopped) {
        this.dispatchInApp(eventName, event);
    }
};

GluePHP.Component = Component;

})(window.GluePHP = window.GluePHP || {});
