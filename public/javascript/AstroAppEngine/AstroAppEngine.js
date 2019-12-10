/**
 * This class will Create the engine the powers the constellations simulation.
 *
 * Author Francis Perez Last Updated: 12/7/2019
 */

import Camera from "./Objects/Camera.js";
import StarField from "./Objects/StarField.js";
import Earth from "./Objects/Earth.js";
import Sun from "./Objects/Sun.js";
import CelestialSphere from "./Objects/CelestialSphere.js";

export default class AstroAppEngine {
    CONSTELLATIONS_CONTROLLER_ACTION_URL = "/home/display/";
    IMAGE_ROOT = "/img/";
    WIDTH_SEGMENTS = 45;
    HEIGHT_SEGMENTS = 45;
    SPACE_WORLD_COLOR = "black";
    SPACE_WORLD_LIGHT_COLOR = "white";
    STARS_RADIUS = 8;
    EARTH_RADIUS = 1;
    SUN_RADIUS = .2;
    SUN_POSITION_X = 25;
    CELESTIAL_SPHERE_RADIUS = 6;
    T3_SPACE_TIME_FRAMES_PER_SECONDS = 1 / 30;
    T3_MOUSE_CONTROLS_MIN_DISTANCE = 1;
    T3_MOUSE_CONTROLS_MAX_DISTANCE = 20;
    T3_MOUSE_CONTROLS_MAX_INERTIA_ENABLED = true;
    T3_MOUSE_CONTROLS_MAX_INERTIA_FACTOR = .09;
    CAMERA_FORWARD_DELTA = .001;
    GROUD_LOOK_SPEED = .09;
    GROUD_MOVE_SPEED = 0;
    JS_DOM_RESIZE_EVENT = "resize";
    HTTP_GET_VERB = "GET";
    HTTP_JSON_VERB = "json";

    htmlHostControlObject = null;

    isDebugObjectsShown = false;
    hostElementId = "";

    t3spaceTime = null;
    t3Scene = null;
    t3CameraDebuger = null;
    t3Renderer = null;
    t3GlobeMouseControls = null;
    t3GroundMouseControls = null;
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
        this.setUpT3GlobeMouseControls();
        this.setupT3InitSceneItems();
        this.screenRenderer();
    }

    /**
     * Move camera to this location and move camera to look up to the stars.
     * @param {decimal} _latitude - Latitude of where the user still be looking up to the sky from.
     * @param {decimal} _longitude - Longitude of where the user still be looking up to the sky from.
     */
    moveLocation(_latitude, _longitude) {

        //Move the lat long dot where the user is.
        this.earth.moveLocationDotPosition(_latitude, _longitude);

        //Move our observers dot above the users "head".
        this.celestialSphere.moveObserversDotPosition(_latitude, _longitude);
    }

    /**
     * Move the user's view down to Earth and looking up into space.
     */
    moveCameraToGroundBasedOnLocation() {
        //Creat the url of where constellations data is.
        let urlLiveServer = this.CONSTELLATIONS_CONTROLLER_ACTION_URL + this.earth.getLat() + "/" + this.earth.getLong();
        //Download the constellations data. When set camera to look at sky.
        $.ajax({url: urlLiveServer,
            type: this.HTTP_GET_VERB,
            dataType: this.HTTP_JSON_VERB,
            context: this,
            complete: function (data) {
                //alert(data.responseText);
                this.positionTheCameraLookingToSky(data.responseText);
            }});
    }

    /**
     * Return a parameter from the url string after the "?" (ie http://somewebsite.com?param1=someValue).
     * @param {String} _parameter - The parameter to retrive from the url string.
     * @param {String} _defaultvalue - If parameter does not exists, this value will be returned.
     */
    getUrlParameters(_parameter, _defaultvalue) {

        //Create dictionary to hold url parameters.
        var urlParamters = {};
        //Parse the url string after the "?" into the dictionary.
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            urlParamters[key] = value;
        });

        //Get the index value of the the parameter we are looking for.
        if (window.location.href.indexOf(_parameter) > -1) {
            //If the param is found then place the value in the temp variable.
            return urlParamters[_parameter];
        } else {
            //Param was not found, just return the default value.
            return _defaultvalue;
        }
    }

    //==========private functions=========================

    positionTheCameraLookingToSky(_starData) {
        //Remove the globe controls.
       this.removeT3MouseControls();

        //Stop the earth from spining if it is.
        this.setIsEarthRotationOn(false);

        //Plot the downloaded stars.
        this.celestialSphere.plotStars(_starData);


        //Turn on the ground, now that we are going to be on the earth.
        this.earth.setGroundIsVisible(true);

        //Move the camera to the location dot on the earth.
        this.worldCamera.moveTo(this.earth.getLocationDot().getMesh().getWorldPosition());

        //Tell the camera to look at the point above the user's head.
        this.worldCamera.lookAt(this.celestialSphere.getObserversDot().getMesh().getWorldPosition());

        //Move the camera forward.
        this.worldCamera.moveForward(this.CAMERA_FORWARD_DELTA);

        //Turn on user's head movement controls.
        this.setUpT3GroundControls();
    }

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
     * Set up the mouse controls, allow user to control the camera when viewing the earth from space.
     */
    setUpT3GlobeMouseControls() {
        //Tell the engine what html control is our scene readered too.
        this.t3GlobeMouseControls = new THREE.OrbitControls(this.worldCamera.getMesh(), this.htmlHostControlObject);
        this.t3GlobeMouseControls.screenSpacePanning = true;
        //Give controls some inertia when panning.
        this.t3GlobeMouseControls.enableDamping = this.T3_MOUSE_CONTROLS_MAX_INERTIA_ENABLED;
        this.t3GlobeMouseControls.dampingFactor = this.T3_MOUSE_CONTROLS_MAX_INERTIA_FACTOR;

        //Set the range of allow zoom.
        this.t3GlobeMouseControls.minDistance = this.T3_MOUSE_CONTROLS_MIN_DISTANCE;
        this.t3GlobeMouseControls.maxDistance = this.T3_MOUSE_CONTROLS_MAX_DISTANCE;
        this.t3GlobeMouseControls.enabled = this.isMouseControlOn;
    }

    /**
     * Setup the ground mouse controls. This are used for the when the user is on the ground.
     */
    setUpT3GroundControls() {
        //Tell the engine what html control is our scene readered too.
        this.t3GroundMouseControls = new THREE.FirstPersonControls(this.worldCamera.getMesh(), this.htmlHostControlObject);
        //Set the mouse speeds.
        this.t3GroundMouseControls.lookSpeed = this.GROUD_LOOK_SPEED;
        //Dont let user move side to side or forward/back.
        this.t3GroundMouseControls.movementSpeed = this.GROUD_MOVE_SPEED;
    }

    /**
     * Setup the dimensions of the screen render from the html control that is hosting the 3d scene.
     */
    setUpT3RenderSize() {
        //Set the render to the correct size of the hosting control.
        this.t3Renderer.setSize(this.htmlHostControlObject.offsetWidth, this.htmlHostControlObject.offsetHeight);
    }

    /**
     * Update the engine when the window is resized.
     */
    hookUpWindowOnResizeEvent() {
        
        //Hook up to the browser resize event.
        window.addEventListener(this.JS_DOM_RESIZE_EVENT, () => {

            //Remove the render.
            this.setUpT3RenderSize();

            //Calculate the new screen ratio.
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
        this.earth = new Earth(this.EARTH_RADIUS, this.WIDTH_SEGMENTS, this.HEIGHT_SEGMENTS, this.IMAGE_ROOT, this.t3Scene);
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
        let reqId = requestAnimationFrame(() => {
            this.screenRenderer()
        });
        //Add a tick to the our space time.
        this.t3spaceTimeDelta += this.t3spaceTime.getDelta();

        //Can we rendere a new frame.
        if (this.t3spaceTimeDelta > this.T3_SPACE_TIME_FRAMES_PER_SECONDS) {

            //Tell all objects to update themselves.
            this.screenUpdate();

            //Tell 3d engine to reneder a frame.
            this.t3Renderer.render(this.t3Scene, this.worldCamera.getMesh());
            //Add time ticks.
            this.t3spaceTimeDelta %= this.T3_SPACE_TIME_FRAMES_PER_SECONDS;
        }
    }
    /**
     * Update our screen object positions. This function will be called by the system at a 30 frames per seconds.
     */
    screenUpdate() {

        // Update the earth's internal calculations.
        this.earth.update();

        //Update mouse controls. if they are instantiated.
        if (this.t3GlobeMouseControls) {
            this.t3GlobeMouseControls.update(this.t3spaceTimeDelta);
        }

        //update grond mouse controls if they are instantiated.
        if (this.t3GroundMouseControls) {
            this.t3GroundMouseControls.update(this.t3spaceTimeDelta);
        }

        //Update the camera's internal calculations.
        this.worldCamera.update();
    }
    /**
     * Removes the mouse controls, that allow orbiting of the the earth.
     */
    removeT3MouseControls() {

        if (!this.t3GlobeMouseControls) {
            return;
        }

        this.t3GlobeMouseControls.dispose();
        this.t3GlobeMouseControls = null;
    }

    //============GETTERS==================================
    getIsDebugObjectsShown = function () {
        return this.isDebugObjectsShown;
    }

    getIsMouseControlOn = function () {
        return this.t3GlobeMouseControls.enabled;
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
        this.t3GlobeMouseControls.enabled = _on;
    }

    setIsEarthRotationOn = function (_rotate) {
        this.earth.setIsEarthRotationOn(_rotate);
    }

    setIsCelestSphereVisible = function (_visible) {
        this.celestSphere.setIsVisible(_visible);
    }
}
