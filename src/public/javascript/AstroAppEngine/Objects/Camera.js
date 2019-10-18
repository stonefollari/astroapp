/**
 * This class will Create the Camera for a our world.
 * 
 * Author Francis Perez Last Updated: 10/18/2019
 */
class Camera {
    CAMERA_POSITION_DEFAULT_X = 8.284;
    CAMERA_POSITION_DEFAULT_Y = 0.184;
    CAMERA_POSITION_DEFAULT_Z = 0.732;
    CAMERA_VERTICAL_FIELD_OF_VIEW = 45;
    CAMERA_NEAR_PLANE = 0.001;
    CAMERA_FAR_PLANE = 1000;

    t3Camera = null;
    t3CameraDebuger = null;

    constructor() {
        this.create();
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
        return this.t3Camera.position.x + "|" + this.t3Camera.position.y + "|" +this.t3Camera.position.z
    }
}