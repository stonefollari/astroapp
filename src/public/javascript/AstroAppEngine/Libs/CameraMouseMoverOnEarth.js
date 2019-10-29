/**
 * This class allow the user to move their heads when viewing the stars from earth.
 * 
 * Author Francis Perez Last Updated: 10/21/2019
 */
export default class CameraMouseMoverOnEarth {
    MOUSE_POSITION_EMPTY = -1;
    hostingElement = null;
    celestialSphere = null;
    worldCamera = null;
    isEnabled;
    isMouseButtonPressed;
    mouseButtonDownPositionX;
    mouseButtonDownPositionY;
    
    constructor(_hostingElement, _celestialSphere, _worldCamera) {
        this.hostingElement =_hostingElement ;
        this.celestialSphere = _celestialSphere;
        this.worldCamera = _worldCamera;
        this.isEnabled = false;
        this.mouseButtonDownPositionX = -1;
        this.mouseButtonDownPositionY = -1;
        this.hookUpMouseEvents();
    }

    //==========private functions=========================
    hookUpMouseEvents() {
        this.isMouseButtonPressed = false;

        //Create new object to hold are current scope of 'this' class.
        var self = this;

        //Attach the listener functios the the mouse events, send the current 'this' context, so the current class can be accessed.
        this.hostingElement.addEventListener("mousemove", function(event) {self.mouseMovedEvent.call(self, event);}, false);
        this.hostingElement.addEventListener("mousedown", function(event) {self.mouseButtonPressedEvent.call(self, event);}, false);   
        this.hostingElement.addEventListener("mouseup", function(event) {self.mouseButtonReleasedEvent.call(self, event);}, false);   
    }

    /**
     * This will process the mouse move event.
     */
    mouseMovedEvent(event) {
        //Skip processing mouse move event if button is not pressed.
        if (this.isEnabled === false || this.isMouseButtonPressed === false)
            return;

        //Set the mouse click position x and y, if they are empty.
        if (this.mouseButtonDownPositionX === this.MOUSE_POSITION_EMPTY && this.mouseButtonDownPositionY === this.MOUSE_POSITION_EMPTY) {
            this.mouseButtonDownPositionX = event.pageX;
            this.mouseButtonDownPositionY = event.pageY;
        }
        
        let currentX =  event.pageX;
        let currentY =  event.pageY;
        
        let deltaX = currentX - this.mouseButtonDownPositionX;
        let deltaY = currentY - this.mouseButtonDownPositionY;

        let observersLat = this.celestialSphere.getObserversLatitude() ;
        let observersLng = this.celestialSphere.getObserversLongitude();

        if (deltaY > 0) {
            observersLat += .04;
        } else {
            observersLat -= .04;
        }

        if (deltaY <= 0) {
        //    observersLng += .01;
        } else {
        //    observersLng -= .01;
        }

        this.celestialSphere.moveObserversDotPosition(observersLat, observersLng);
        //this.worldCamera.getMesh().lookAt(this.celestialSphere.getObserversDot().getMesh().getWorldPosition());

        console.log(observersLat + " " + observersLng);
        console.log(deltaX + " " + deltaY);
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
        this.mouseButtonDownPositionX = this.MOUSE_POSITION_EMPTY;
        this.mouseButtonDownPositionY = this.MOUSE_POSITION_EMPTY;
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