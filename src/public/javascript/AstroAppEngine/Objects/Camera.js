/**
 * This class will Create the Camera for a our world.
 * 
 * Author Francis Perez Last Updated: 10/21/2019
 */
export default class Camera {
    CAMERA_POSITION_DEFAULT_X = 4.284;
    CAMERA_POSITION_DEFAULT_Y = 0.094;
    CAMERA_POSITION_DEFAULT_Z = 0.375;
    CAMERA_VERTICAL_FIELD_OF_VIEW = 45;
    CAMERA_NEAR_PLANE = 0.001;
    CAMERA_FAR_PLANE = 1000;

    t3Camera = null;
    t3CameraDebuger = null;

    constructor() {
        this.create();
    }

    //==========public functions==========================

    /**
     * Update the internal calculations.
     */
    update() {
        this.t3Camera.updateProjectionMatrix();
    }
    /**
     * 
     * @param {vector3d} position - Where to move the camera to.
     */
    moveTo(position) {
        //Set the camera position from incoming position.
        this.t3Camera.position.x = position.x;
        this.t3Camera.position.y = position.y;
        this.t3Camera.position.z = position.z;    
    }

    /**
     * 
     * @param {decimal} delta - By how much to move the camera forward by.
     */
    moveForward(delta) {
        //Set an emtpry vector.
        var directionVector = new THREE.Vector3();
        //Fill the direction vector witht the camera's current vector.
        this.t3Camera.getWorldDirection( directionVector );
        //Move the camera forward by some delta.
        this.t3Camera.position.addScaledVector( directionVector, delta );
    }

    /**
     * 
     * @param {vector3d} position - The vector to look at.
     */
    lookAt(position) {
        //Tell camera to look at some point.
        this.t3Camera.lookAt(position);
    }

    //==========private functions=========================

    /**
     * Setup the camera and position it in the space.
     */
    create() {
        //calculate the aspect ratio of the screen.
        let cameraAspectRatio = window.innerWidth / window.innerHeight;
       
        //Setup the camera.
        this.t3Camera = new THREE.PerspectiveCamera(this.CAMERA_VERTICAL_FIELD_OF_VIEW, cameraAspectRatio , this.CAMERA_NEAR_PLANE, this.CAMERA_FAR_PLANE);
        this.t3Camera.position.set(this.CAMERA_POSITION_DEFAULT_X, this.CAMERA_POSITION_DEFAULT_Y, this.CAMERA_POSITION_DEFAULT_Z);        
    }

    //============GETTERS==================================

    getMesh = function() {
        return this.t3Camera;
    }

    getPositions = function() {
        return this.t3Camera.position.x + "|" + this.t3Camera.position.y + "|" + this.t3Camera.position.z
    }
}