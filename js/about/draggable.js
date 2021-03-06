@@ -0,0 +1,644 @@
import {closest} from 'shared/utils';

import {Accessibility, Mirror} from './Plugins';

import {
  MouseSensor,
  TouchSensor,
} from './Sensors';

import {
  DraggableInitializedEvent,
  DraggableDestroyEvent,
} from './DraggableEvent';

import {
  DragStartEvent,
  DragMoveEvent,
  DragOutContainerEvent,
  DragOutEvent,
  DragOverContainerEvent,
  DragOverEvent,
  DragStopEvent,
  DragPressureEvent,
} from './DragEvent';

import {
  MirrorCreatedEvent,
  MirrorAttachedEvent,
  MirrorMoveEvent,
  MirrorDestroyEvent,
} from './MirrorEvent';

const onDragStart = Symbol('onDragStart');
const onDragMove = Symbol('onDragMove');
const onDragStop = Symbol('onDragStop');
const onDragPressure = Symbol('onDragPressure');
const getAppendableContainer = Symbol('getAppendableContainer');

const defaults = {
  draggable: '.draggable-source',
  handle: null,
  delay: 100,
  placedTimeout: 800,
  plugins: [],
  sensors: [],
  classes: {
    'container:dragging': 'draggable-container--is-dragging',
    'source:dragging': 'draggable-source--is-dragging',
    'source:placed': 'draggable-source--placed',
    'container:placed': 'draggable-container--placed',
    'body:dragging': 'draggable--is-dragging',
    'draggable:over': 'draggable--over',
    'container:over': 'draggable-container--over',
    mirror: 'draggable-mirror',
  },
};

/**
 * This is the core draggable library that does the heavy lifting
 * @class Draggable
 * @module Draggable
 */
export default class Draggable {

  /**
   * Draggable constructor.
   * @constructs Draggable
   * @param {HTMLElement[]|NodeList|HTMLElement} containers - Draggable containers
   * @param {Object} options - Options for draggable
   */
  constructor(containers = [document.body], options = {}) {

    /**
     * Draggable containers
     * @property containers
     * @type {HTMLElement[]}
     */
    if (containers instanceof NodeList || containers instanceof Array) {
      this.containers = [...containers];
    } else if (containers instanceof HTMLElement) {
      this.containers = [containers];
    } else {
      throw new Error('Draggable containers are expected to be of type `NodeList`, `HTMLElement[]` or `HTMLElement`');
    }

    this.options = {...defaults, ...options};
    this.callbacks = {};

    /**
     * Current drag state
     * @property dragging
     * @type {Boolean}
     */
    this.dragging = false;

    /**
     * Active plugins
     * @property plugins
     * @type {Plugin[]}
     */
    this.plugins = [];

    /**
     * Active sensors
     * @property sensors
     * @type {Sensor[]}
     */
    this.sensors = [];

    this[onDragStart] = this[onDragStart].bind(this);
    this[onDragMove] = this[onDragMove].bind(this);
    this[onDragStop] = this[onDragStop].bind(this);
    this[onDragPressure] = this[onDragPressure].bind(this);

    document.addEventListener('drag:start', this[onDragStart], true);
    document.addEventListener('drag:move', this[onDragMove], true);
    document.addEventListener('drag:stop', this[onDragStop], true);
    document.addEventListener('drag:pressure', this[onDragPressure], true);

    this.addPlugin(...[Mirror, Accessibility, ...this.options.plugins]);
    this.addSensor(...[MouseSensor, TouchSensor, ...this.options.sensors]);

    const draggableInitializedEvent = new DraggableInitializedEvent({
      draggable: this,
    });

    this.trigger(draggableInitializedEvent);
  }

  /**
   * Destroys Draggable instance. This removes all internal event listeners and
   * deactivates sensors and plugins
   */
  destroy() {
    document.removeEventListener('drag:start', this.dragStart, true);
    document.removeEventListener('drag:move', this.dragMove, true);
    document.removeEventListener('drag:stop', this.dragStop, true);
    document.removeEventListener('drag:pressure', this.dragPressure, true);

    const draggableDestroyEvent = new DraggableDestroyEvent({
      draggable: this,
    });

    this.trigger(draggableDestroyEvent);

    this.removePlugin(...this.plugins.map((plugin) => plugin.constructor));
    this.removeSensor(...this.sensors.map((sensor) => sensor.constructor));
  }

  /**
   * Adds plugin to this draggable instance. This will end up calling the attach method of the plugin
   * @param {...typeof Plugin} plugins - Plugins that you want attached to draggable
   * @return {Draggable}
   * @example draggable.addPlugin(CustomA11yPlugin, CustomMirrorPlugin)
   */
  addPlugin(...plugins) {
    const activePlugins = plugins.map((Plugin) => new Plugin(this));
    activePlugins.forEach((plugin) => plugin.attach());
    this.plugins = [...this.plugins, ...activePlugins];
    return this;
  }

  /**
   * Removes plugins that are already attached to this draggable instance. This will end up calling
   * the detach method of the plugin
   * @param {...typeof Plugin} plugins - Plugins that you want detached from draggable
   * @return {Draggable}
   * @example draggable.removePlugin(MirrorPlugin, CustomMirrorPlugin)
   */
  removePlugin(...plugins) {
    const removedPlugins = this.plugins.filter((plugin) => plugins.includes(plugin.constructor));
    removedPlugins.forEach((plugin) => plugin.detach());
    this.plugins = this.plugins.filter((plugin) => !plugins.includes(plugin.constructor));
    return this;
  }

  /**
   * Adds sensors to this draggable instance. This will end up calling the attach method of the sensor
   * @param {...typeof Sensor} sensors - Sensors that you want attached to draggable
   * @return {Draggable}
   * @example draggable.addSensor(ForceTouchSensor, CustomSensor)
   */
  addSensor(...sensors) {
    const activeSensors = sensors.map((Sensor) => new Sensor(this.containers, this.options));
    activeSensors.forEach((sensor) => sensor.attach());
    this.sensors = [...this.sensors, ...activeSensors];
    return this;
  }

  /**
   * Removes sensors that are already attached to this draggable instance. This will end up calling
   * the detach method of the sensor
   * @param {...typeof Sensor} sensors - Sensors that you want attached to draggable
   * @return {Draggable}
   * @example draggable.removeSensor(TouchSensor, DragSensor)
   */
  removeSensor(...sensors) {
    const removedSensors = this.sensors.filter((sensor) => sensors.includes(sensor.constructor));
    removedSensors.forEach((sensor) => sensor.detach());
    this.sensors = this.sensors.filter((sensor) => !sensors.includes(sensor.constructor));
    return this;
  }

  /**
   * Adds container to this draggable instance
   * @param {...HTMLElement} containers - Containers you want to add to draggable
   * @return {Draggable}
   * @example draggable.addPlugin(CustomA11yPlugin, CustomMirrorPlugin)
   */
  addContainer(...containers) {
    this.containers = [...this.containers, ...containers];
    return this;
  }

  /**
   * Removes container from this draggable instance
   * @param {...HTMLElement} containers - Containers you want to remove from draggable
   * @return {Draggable}
   * @example draggable.removePlugin(MirrorPlugin, CustomMirrorPlugin)
   */
  removeContainer(...containers) {
    this.containers = this.containers.filter((container) => !containers.includes(container));
    return this;
  }

  /**
   * Adds listener for draggable events
   * @param {String} type - Event name
   * @param {Function} callback - Event callback
   * @return {Draggable}
   * @example draggable.on('drag:start', (dragEvent) => dragEvent.cancel());
   */
  on(type, callback) {
    if (!this.callbacks[type]) {
      this.callbacks[type] = [];
    }

    this.callbacks[type].push(callback);
    return this;
  }

  /**
   * Removes listener from draggable
   * @param {String} type - Event name
   * @param {Function} callback - Event callback
   * @return {Draggable}
   * @example draggable.off('drag:start', handlerFunction);
   */
  off(type, callback) {
    if (!this.callbacks[type]) { return null; }
    const copy = this.callbacks[type].slice(0);
    for (let i = 0; i < copy.length; i++) {
      if (callback === copy[i]) {
        this.callbacks[type].splice(i, 1);
      }
    }
    return this;
  }

  /**
   * Triggers draggable event
   * @param {AbstractEvent} event - Event instance
   * @return {Draggable}
   * @example draggable.trigger(event);
   */
  trigger(event) {
    if (!this.callbacks[event.type]) { return null; }
    const callbacks = [...this.callbacks[event.type]];
    for (let i = callbacks.length - 1; i >= 0; i--) {
      const callback = callbacks[i];
      callback(event);
    }
    return this;
  }

  /**
   * Returns class name for class identifier
   * @param {String} name - Name of class identifier
   * @return {String|null}
   */
  getClassNameFor(name) {
    return this.options.classes[name] || defaults.classes[name];
  }

  /**
   * Returns true if this draggable instance is currently dragging
   * @return {Boolean}
   */
  isDragging() {
    return Boolean(this.dragging);
  }

  /**
   * Drag start handler
   * @private
   * @param {Event} event - DOM Drag event
   */
  [onDragStart](event) {
    const sensorEvent = getSensorEvent(event);
    const {target, container, originalEvent} = sensorEvent;

    if (!this.containers.includes(container)) {
      return;
    }

    if (this.options.handle && target && !closest(target, this.options.handle)) {
      sensorEvent.cancel();
      return;
    }

    // Find draggable source element
    this.originalSource = closest(target, this.options.draggable);
    this.sourceContainer = container;

    if (!this.originalSource) {
      sensorEvent.cancel();
      return;
    }

    this.dragging = true;

    this.source = this.originalSource.cloneNode(true);

    if (!isDragEvent(originalEvent)) {
      const appendableContainer = this[getAppendableContainer]({source: this.originalSource});
      this.mirror = this.source.cloneNode(true);

      const mirrorCreatedEvent = new MirrorCreatedEvent({
        source: this.source,
        originalSource: this.originalSource,
        mirror: this.mirror,
        sourceContainer: container,
        sensorEvent,
      });

      const mirrorAttachedEvent = new MirrorAttachedEvent({
        source: this.source,
        originalSource: this.originalSource,
        mirror: this.mirror,
        sourceContainer: container,
        sensorEvent,
      });

      this.trigger(mirrorCreatedEvent);
      appendableContainer.appendChild(this.mirror);
      this.trigger(mirrorAttachedEvent);
    }

    this.originalSource.parentNode.insertBefore(this.source, this.originalSource);

    this.originalSource.style.display = 'none';
    this.source.classList.add(this.getClassNameFor('source:dragging'));
    this.sourceContainer.classList.add(this.getClassNameFor('container:dragging'));
    document.body.classList.add(this.getClassNameFor('body:dragging'));
    applyUserSelect(document.body, 'none');

    if (this.mirror) {
      const mirrorMoveEvent = new MirrorMoveEvent({
        source: this.source,
        mirror: this.mirror,
        originalSource: this.originalSource,
        sourceContainer: container,
        sensorEvent,
      });

      this.trigger(mirrorMoveEvent);
    }

    const dragEvent = new DragStartEvent({
      source: this.source,
      mirror: this.mirror,
      originalSource: this.originalSource,
      sourceContainer: container,
      sensorEvent,
    });

    this.trigger(dragEvent);

    if (!dragEvent.canceled()) {
      return;
    }

    if (this.mirror) {
      this.mirror.parentNode.removeChild(this.mirror);
    }

    this.source.classList.remove(this.getClassNameFor('source:dragging'));
    this.sourceContainer.classList.remove(this.getClassNameFor('container:dragging'));
    document.body.classList.remove(this.getClassNameFor('body:dragging'));
  }

  /**
   * Drag move handler
   * @private
   * @param {Event} event - DOM Drag event
   */
  [onDragMove](event) {
    if (!this.dragging) {
      return;
    }

    const sensorEvent = getSensorEvent(event);
    const {container} = sensorEvent;
    let target = sensorEvent.target;

    const dragMoveEvent = new DragMoveEvent({
      source: this.source,
      mirror: this.mirror,
      originalSource: this.originalSource,
      sourceContainer: container,
      sensorEvent,
    });

    this.trigger(dragMoveEvent);

    if (dragMoveEvent.canceled()) {
      sensorEvent.cancel();
    }

    if (this.mirror && !dragMoveEvent.canceled()) {
      const mirrorMoveEvent = new MirrorMoveEvent({
        source: this.source,
        mirror: this.mirror,
        originalSource: this.originalSource,
        sourceContainer: container,
        sensorEvent,
      });

      this.trigger(mirrorMoveEvent);
    }

    target = closest(target, this.options.draggable);
    const withinCorrectContainer = closest(sensorEvent.target, this.containers);
    const overContainer = sensorEvent.overContainer || withinCorrectContainer;
    const isLeavingContainer = this.currentOverContainer && (overContainer !== this.currentOverContainer);
    const isLeavingDraggable = this.currentOver && (target !== this.currentOver);
    const isOverContainer = overContainer && (this.currentOverContainer !== overContainer);
    const isOverDraggable = withinCorrectContainer && target && (this.currentOver !== target);

    if (isLeavingDraggable) {
      const dragOutEvent = new DragOutEvent({
        source: this.source,
        mirror: this.mirror,
        originalSource: this.originalSource,
        sourceContainer: container,
        sensorEvent,
        over: this.currentOver,
      });

      this.trigger(dragOutEvent);

      this.currentOver.classList.remove(this.getClassNameFor('draggable:over'));
      this.currentOver = null;
    }

    if (isLeavingContainer) {
      const dragOutContainerEvent = new DragOutContainerEvent({
        source: this.source,
        mirror: this.mirror,
        originalSource: this.originalSource,
        sourceContainer: container,
        sensorEvent,
        overContainer: this.overContainer,
      });

      this.trigger(dragOutContainerEvent);

      this.currentOverContainer.classList.remove(this.getClassNameFor('container:over'));
      this.currentOverContainer = null;
    }

    if (isOverContainer) {
      overContainer.classList.add(this.getClassNameFor('container:over'));

      const dragOverContainerEvent = new DragOverContainerEvent({
        source: this.source,
        mirror: this.mirror,
        originalSource: this.originalSource,
        sourceContainer: container,
        sensorEvent,
        overContainer,
      });

      this.trigger(dragOverContainerEvent);

      this.currentOverContainer = overContainer;
    }

    if (isOverDraggable) {
      target.classList.add(this.getClassNameFor('draggable:over'));

      const dragOverEvent = new DragOverEvent({
        source: this.source,
        mirror: this.mirror,
        originalSource: this.originalSource,
        sourceContainer: container,
        sensorEvent,
        overContainer,
        over: target,
      });

      this.trigger(dragOverEvent);

      this.currentOver = target;
    }
  }

  /**
   * Drag stop handler
   * @private
   * @param {Event} event - DOM Drag event
   */
  [onDragStop](event) {
    if (!this.dragging) {
      return;
    }

    this.dragging = false;

    const sensorEvent = getSensorEvent(event);
    const dragStopEvent = new DragStopEvent({
      source: this.source,
      mirror: this.mirror,
      originalSource: this.originalSource,
      sensorEvent: event.sensorEvent,
      sourceContainer: this.sourceContainer,
    });

    this.trigger(dragStopEvent);

    this.source.parentNode.insertBefore(this.originalSource, this.source);
    this.source.parentNode.removeChild(this.source);
    this.originalSource.style.display = '';

    this.source.classList.remove(this.getClassNameFor('source:dragging'));
    this.originalSource.classList.add(this.getClassNameFor('source:placed'));
    this.sourceContainer.classList.add(this.getClassNameFor('container:placed'));
    this.sourceContainer.classList.remove(this.getClassNameFor('container:dragging'));
    document.body.classList.remove(this.getClassNameFor('body:dragging'));
    applyUserSelect(document.body, '');

    if (this.currentOver) {
      this.currentOver.classList.remove(this.getClassNameFor('draggable:over'));
    }

    if (this.currentOverContainer) {
      this.currentOverContainer.classList.remove(this.getClassNameFor('container:over'));
    }

    if (this.mirror) {
      const mirrorDestroyEvent = new MirrorDestroyEvent({
        source: this.source,
        mirror: this.mirror,
        sourceContainer: sensorEvent.container,
        sensorEvent,
      });

      this.trigger(mirrorDestroyEvent);

      if (!mirrorDestroyEvent.canceled()) {
        this.mirror.parentNode.removeChild(this.mirror);
      }
    }

    const lastSource = this.originalSource;
    const lastSourceContainer = this.sourceContainer;

    setTimeout(() => {
      if (lastSource) {
        lastSource.classList.remove(this.getClassNameFor('source:placed'));
      }

      if (lastSourceContainer) {
        lastSourceContainer.classList.remove(this.getClassNameFor('container:placed'));
      }
    }, this.options.placedTimeout);

    this.source = null;
    this.mirror = null;
    this.originalSource = null;
    this.currentOverContainer = null;
    this.currentOver = null;
    this.sourceContainer = null;
  }

  /**
   * Drag pressure handler
   * @private
   * @param {Event} event - DOM Drag event
   */
  [onDragPressure](event) {
    if (!this.dragging) {
      return;
    }

    const sensorEvent = getSensorEvent(event);
    const source = this.source || closest(sensorEvent.originalEvent.target, this.options.draggable);

    const dragPressureEvent = new DragPressureEvent({
      sensorEvent,
      source,
      pressure: sensorEvent.pressure,
    });

    this.trigger(dragPressureEvent);
  }

  /**
   * Returns appendable container for mirror based on the appendTo option
   * @private
   * @param {Object} options
   * @param {HTMLElement} options.source - Current source
   * @return {HTMLElement}
   */
  [getAppendableContainer]({source}) {
    const appendTo = this.options.appendTo;

    if (typeof appendTo === 'string') {
      return document.querySelector(appendTo);
    } else if (appendTo instanceof HTMLElement) {
      return appendTo;
    } else if (typeof appendTo === 'function') {
      return appendTo(source);
    } else {
      return document.body;
    }
  }
}

function getSensorEvent(event) {
  return event.detail;
}

function isDragEvent(event) {
  return /^drag/.test(event.type);
}

function applyUserSelect(element, value) {
  element.style.webkitUserSelect = value;
  element.style.mozUserSelect = value;
  element.style.msUserSelect = value;
  element.style.oUserSelect = value;
  element.style.userSelect = value;
}
