/**
 * This class allow the user to move their heads when viewing the stars from earth.
 * 
 * Author Francis Perez Last Updated: 10/21/2019
 */
class CameraMouseMoverOnEarth {
    hostingElement = null;
    celestialSphere = null;
    camera = null;
    isEnabled;
    isMouseButtonPressed;
    
    constructor(_hostingElement, _celestialSphere, _camera) {
        this.hostingElement =_hostingElement ;
        this.celestialSphere = _celestialSphere;
        this.camera = _camera;
        this.isEnabled = false;
        this.hookUpMouseEvents();
    }

    //==========private functions=========================
    hookUpMouseEvents() {
        this.isMouseButtonPressed = false;
        var self = this;
        this.hostingElement.addEventListener("mousemove", function(event) {self.mouseMovedEvent.call(self, event);}, false);
        this.hostingElement.addEventListener("mousedown", function(event) {self.mouseButtonPressedEvent.call(self, event);}, false);   
        this.hostingElement.addEventListener("mouseup", function(event) {self.mouseButtonReleasedEvent.call(self, event);}, false);   
    }

    /**
     * This will process the mouse move event.
     */
    mouseMovedEvent(event) {
        
        if (this.isEnabled === false || this.isMouseButtonPressed === false)
            return;


        console.log(event.pageX + " " + event.pageY);
    }

     /**
     * This will process the mouse buttons being pressed.
     */
    mouseButtonPressedEvent(event) {
        this.isMouseButtonPressed = true;
    }

     /**
     * This will process the mouse buttons being released.
     */
    mouseButtonReleasedEvent(event) {
        this.isMouseButtonPressed = false;
    }

    //============GETTERS==================================

    getIsEnabled = function() {
        return this.isEnabled;
    }

     //============SETTERS==================================

     setIsEnabled = function(_isEnabled) {
        return this.isEnabled = _isEnabled;
    }

}