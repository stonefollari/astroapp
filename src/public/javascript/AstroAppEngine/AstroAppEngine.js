/**
 * This class will Create the engine the powers the constellations simulation.
 *
 * Author Francis Perez Last Updated: 10/21/2019
 */

import Pipe from "./Objects/Pipe.js";
import Camera from "./Objects/Camera.js";
import StarField from "./Objects/StarField.js";
import Earth from "./Objects/Earth.js";
import Sun from "./Objects/Sun.js";
import CelestialSphere from "./Objects/CelestialSphere.js";
import CameraMouseMoverOnEarth from "./Libs/CameraMouseMoverOnEarth.js";

export default class AstroAppEngine {
    IMAGE_ROOT = "./img/";
    WIDTH_SEGMENTS = 80;
    HEIGHT_SEGMENTS = 80;
    SPACE_WORLD_COLOR = "black";
    SPACE_WORLD_LIGHT_COLOR = "white";
    STARS_RADIUS = 30;
    EARTH_RADIUS = 1;
    SUN_RADIUS = .2;
    SUN_POSITION_X = 25;
    CELESTIAL_SPHERE_RADIUS = 4;
    T3_SPACE_TIME_FRAMES_PER_SECONDS = 1 / 30;
    T3_MOUSE_CONTROLS_MIN_DISTANCE = 1;
    T3_MOUSE_CONTROLS_MAX_DISTANCE = 20;
    T3_MOUSE_CONTROLS_MAX_INERTIA_ENABLED = true;
    T3_MOUSE_CONTROLS_MAX_INERTIA_FACTOR = .09;

    htmlHostControlObject = null;

    isDebugObjectsShown = false;
    hostElementId = "";

    t3spaceTime = null;
    t3Scene = null;
    t3CameraDebuger = null;
    t3Renderer = null;
    t3MouseControls = null;
    t3spaceTimeDelta = 0;

    worldCamera = null;
    earth = null;
    celestialSphere = null;
    earthCameraMover = null;

    constructor() {

    }

    //==========public functions==========================

    /**
     * Set where the engine will render space to.
    */
    run(_hostingElemenId) {

        // Setup the ticking clock for the simulation.
        this.t3spaceTime = new THREE.Clock();

        this.hostElementId = _hostingElemenId;

        // Get the html object that we need to project too
        this.htmlHostControlObject = window.document.getElementById(_hostingElemenId);
       
        //Set our world and objects.
        this.setUpT3World(); 
        this.hookUpWindowOnResizeEvent();
        this.setUpT3MouseControls();
        this.setupT3InitSceneItems();
        this.screenRenderer();

        this.earthCameraMover = new CameraMouseMoverOnEarth(this.htmlHostControlObject,  this.celestialSphere, this.worldCamera);    
    }

    /**
     * Move camera to this location and move camera to look up to the stars.
     * @param {decimal} _latitude Latitude of where the user still be looking up to the sky from.
     * @param {decimal} _longitude Longitude of where the user still be looking up to the sky from.
     */
    bringUpLocation(_latitude, _longitude) {
        
        //Creat the url of where constellations data is.
        let url = "./javascript/sampleConst.Json";

        //Download the constellations data.
        $.ajax({url: url, type:'GET', dataType: 'json', context: this, 
                complete: function(data) {
                    this.t3MouseControls.enabled  = false;
                    this.setIsEarthRotationOn(false);
                    this.celestialSphere.plotStars(data.responseText);
                    this.earth.moveLocationDotPosition(_latitude, _longitude);
                    this.celestialSphere.moveObserversDotPosition(_latitude, _longitude);

                    //Move the camera to the long lat point.
                    this.worldCamera.getMesh().position.x = this.earth.getLocationDot().getMesh().getWorldPosition().x;
                    this.worldCamera.getMesh().position.y = this.earth.getLocationDot().getMesh().getWorldPosition().y;
                    this.worldCamera.getMesh().position.z = this.earth.getLocationDot().getMesh().getWorldPosition().z;
                   
                    this.worldCamera.getMesh().lookAt(this.celestialSphere.getObserversDot().getMesh().getWorldPosition());
                    this.earthCameraMover.setIsEnabled(true);

                }});        
    }

    //==========private functions=========================

    /**
     * Setup the 3d engine and project to hmtl control.
     */
    setUpT3World() {
        this.setUpT3Rendere();
        this.setUpT3Scene();
        this.setUpT3Camera();    
        this.setUpT3WorldLights();
    }

    /**
     * Start up the T3 WebGl Renderer.
     */
    setUpT3Rendere() {
        //Create the renderer and set it properties.
        this.t3Renderer = new THREE.WebGLRenderer({antialias: true});
        //Set the world color.
        this.t3Renderer.setClearColor(this.SPACE_WORLD_COLOR);
        //Set the renderer size based on where we are projecting too.
        this.setUpT3RenderSize(); 
        
    }

    /**
     * Start up the T3 Scene.
     */
    setUpT3Scene() {
        //Setup the 3d scene.
        this.t3Scene = new THREE.Scene();
       
        //Project the 3d scene to the hosting html object.
        this.htmlHostControlObject.appendChild(this.t3Renderer.domElement);
    }

    /**
     * Setup the camera and position it in the space.
     */
    setUpT3Camera() {
        //create our world camera.
        this.worldCamera = new Camera();
    }

    /**
     * Setup the light in the worlds and insert into the scene.
     */
    setUpT3WorldLights() {
        //Light our scene.
        let light = new THREE.AmbientLight(this.SPACE_WORLD_LIGHT_COLOR);
        //Tell the light to cast a shadow.
        light.castShadow = true;

         //Insert the light into the scene.
         this.t3Scene.add(light);
    }
   
    /**
     * Set up the mouse controls, allow user to control the camera.
     */
    setUpT3MouseControls() {        
        //Tell the engine what html control is our scene readered too.
        this.t3MouseControls = new THREE.OrbitControls(this.worldCamera.getMesh(), this.htmlHostControlObject);

        //Give controls some inertia when panning.
        this.t3MouseControls.enableDamping = this.T3_MOUSE_CONTROLS_MAX_INERTIA_ENABLED;
        this.t3MouseControls.dampingFactor = this.T3_MOUSE_CONTROLS_MAX_INERTIA_FACTOR;
        
        //Set the range of allow zoom.
        this.t3MouseControls.minDistance = this.T3_MOUSE_CONTROLS_MIN_DISTANCE;
        this.t3MouseControls.maxDistance = this.T3_MOUSE_CONTROLS_MAX_DISTANCE;
        this.t3MouseControls.enabled = this.isMouseControlOn;
    }

    setUpT3RenderSize() {
        //Set the render to the correct size of the hosting control.
        this.t3Renderer.setSize(this.htmlHostControlObject.offsetWidth, this.htmlHostControlObject.offsetHeight);
    }

    /**
     * Update the engine when the window is resized.
     */
    hookUpWindowOnResizeEvent() {

        //Hook up to the browser resize event.
        window.addEventListener('resize', () => {

            this.setUpT3RenderSize();            

            this.worldCamera.getMesh().aspect = this.htmlHostControlObject.offsetWidth / this.htmlHostControlObject.offsetHeight;

            //Update the camera internal sized so the the screen size changes get applied to the camera.
            this.worldCamera.getMesh().updateProjectionMatrix();
        });

    }

    /**
     * Insert all our need objects into our world: earth, stars, celestial sphere.
     */
    setupT3InitSceneItems() {

        //Create our "galaxy" sphere that we will set the user in.
        let stars = new StarField(this.STARS_RADIUS, this.WIDTH_SEGMENTS, this.HEIGHT_SEGMENTS, this.IMAGE_ROOT);
        this.t3Scene.add(stars.getMesh());

        //Create the earth and place it in the middle of the scene.
        this.earth = new Earth(this.EARTH_RADIUS, this.WIDTH_SEGMENTS, this.HEIGHT_SEGMENTS, this.IMAGE_ROOT);
        //Add earth to the scene.
        this.t3Scene.add(this.earth.getMesh());

        //Create the sun.
        let sun = new Sun(this.SUN_RADIUS, this.WIDTH_SEGMENTS, this.HEIGHT_SEGMENTS, this.IMAGE_ROOT);
        //Add sun the the scene.
        this.t3Scene.add(sun.getMesh());
        //Move the sun off center.
        sun.getMesh().position.x = this.SUN_POSITION_X;

        //Create celestialSphere.
        this.celestialSphere = new CelestialSphere(this.CELESTIAL_SPHERE_RADIUS, this.WIDTH_SEGMENTS, this.HEIGHT_SEGMENTS);
        this.t3Scene.add(this.celestialSphere.getMesh());

         //Keep looking at the earth objects.
         this.worldCamera.getMesh().lookAt(this.earth.getMesh().position);
    }

    /**
     * Update our screen display. This function will be called by the system at a 30 frames per seconds.
     */
    screenRenderer() {

        //Ask the browser for the next animation frame and when ready run the this function again.
        let reqId = requestAnimationFrame(()=> {this.screenRenderer()});
        //Add a tick to the our space time.
        this.t3spaceTimeDelta += this.t3spaceTime.getDelta();

        //Can we rendere a new frame.
        if (this.t3spaceTimeDelta > this.T3_SPACE_TIME_FRAMES_PER_SECONDS ) {

            //Tell all objects to update themselves.
            this.screenUpdate();

            //Tell 3d engine to reneder a frame.
            this.t3Renderer.render(this.t3Scene, this.worldCamera.getMesh());
            //Add ticks.
            this.t3spaceTimeDelta %= this.T3_SPACE_TIME_FRAMES_PER_SECONDS;
        }
    };

     /**
     * Update our screen object positions. This function will be called by the system at a 30 frames per seconds.
     */
    screenUpdate() {
        // Update objects.
        this.earth.update();

        //Update mouse controls.
        this.t3MouseControls.update(this.t3spaceTimeDelta);
        
        
        if (this.celestialSphere.getObserversDot())
            this.worldCamera.getMesh().lookAt(this.celestialSphere.getObserversDot().getMesh().getWorldPosition());

        //if (this.isDebugObjectsShown) {
            console.log("Camera Position: " + this.worldCamera.getPositions());
        //}
        
       
    };

    //============GETTERS==================================
    getIsDebugObjectsShown = function() {
        return this.isDebugObjectsShown;
    }

    getIsMouseControlOn = function() {
        return this.t3MouseControls.enabled;
    }

    getIsEarthRotationOn = function () {
        return this.earth.getIsEarthRotationOn();
    }

    //============SETTERS==================================
    setIsDebugObjectsShown = function (_shown) {
        this.isDebugObjectsShown = _shown;
        this.earth.setIsPrimeMeridianVisible(this.isDebugObjectsShown);
        this.earth.setIsEquatorVisible(this.isDebugObjectsShown);
        this.earth.setIsAxisVisible(this.isDebugObjectsShown);
        this.celestialSphere.setIsCelestialEquatorVisible(this.isDebugObjectsShown);
        this.celestialSphere.setIsCelestialEclipticVisible(this.isDebugObjectsShown);
        this.celestialSphere.setIsWireframeVisible(this.isDebugObjectsShown);
        this.celestialSphere.SetIsCelestialVernalEquinoxVisible(this.isDebugObjectsShown);
    }

    setIsMouseControlOn = function (_on) {
        this.t3MouseControls.enabled = _on;
    }

    setIsEarthRotationOn = function (_rotate) {
        this.earth.setIsEarthRotationOn(_rotate);
    }

    setIsCelestSphereVisible  = function (_visible) {
        this.celestSphere.setIsVisible(_visible);
    }
}
