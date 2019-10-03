
/**
 * This class will Create the engine the powers the constellations simulation.
 *
 * Author Francis Perez Last Updated: 9/29/2019
 */
class AstroAppEngine {
    WIDTH_SEGMENTS = 40;
    HEIGHT_SEGMENTS = 40;
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
    CAMERA_POSITION_DEFAULT_X = 0;
    CAMERA_POSITION_DEFAULT_Y = 0
    CAMERA_POSITION_DEFAULT_Z = 15;
    CAMERA_VERTICAL_FIELD_OF_VIEW = 45;
    CAMERA_NEAR_PLANE = 1;
    CAMERA_FAR_PLANE = 1000;

    htmlHostControlObject = null;

    isDebugObjectsShown = false;
    isMouseControlOn = false;
    hostElementId = "";

    t3spaceTime = null;
    t3Scene = null;
    t3Camera = null;
    t3Renderer = null;
    t3MouseControls = null;
    t3spaceTimeDelta = 0;

    earth = null;
    celestialSphere = null;

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

        this.setUpT3Scene();
        this.hookUpWindowOnResizeEvent();
        this.setUpT3MouseControls();
        this.setupT3InitSceneItems();
        this.screenRenderer();
    }

    bringUpLocation(_latitude, _longitude) {
        this.earth.moveLocationDotPosition(_latitude, _longitude);
    }

    //==========private functions=========================

    /**
     * Setup the 3d engine and project to hmtl control.
     */
    setUpT3Scene() {
        let cameraAspectRatio = window.innerWidth / window.innerHeight;

        // Setup the 3d scene.
        this.t3Scene = new THREE.Scene();
        // Setup the camera.
        this.t3Camera = new THREE.PerspectiveCamera(this.CAMERA_VERTICAL_FIELD_OF_VIEW, cameraAspectRatio , this.CAMERA_NEAR_PLANE, this.CAMERA_FAR_PLANE);
        this.t3Camera.position.set(this.CAMERA_POSITION_DEFAULT_X, this.CAMERA_POSITION_DEFAULT_Y, this.CAMERA_POSITION_DEFAULT_Z);

        // Create the renderer and set it properties
        this.t3Renderer = new THREE.WebGLRenderer({antialias: true});
        // Set the world color
        this.t3Renderer.setClearColor(this.SPACE_WORLD_COLOR);
        // Set the renderer size based on where we are projecting too
        this.t3Renderer.setSize(window.innerWidth, window.innerHeight);

        // Light our scene.
        let light = new THREE.AmbientLight(this.SPACE_WORLD_LIGHT_COLOR);
        // Tell the light to cast a shadow.
        light.castShadow = true;
        // Insert the light into the scene.
        this.t3Scene.add(light);

        // Project the 3d scene to the hosting html object.
        this.htmlHostControlObject.appendChild(this.t3Renderer.domElement);
    }

    /**
     * Set up the mouse controls, allow user to control the camera.
     */
    setUpT3MouseControls() {
        // Check to see if we want to allow the user to move the camera.
        if (this.isMouseControlOn === false) {
            return;
        }

        // Tell the engine what html control is our scene readered too.
        this.t3MouseControls = new THREE.OrbitControls(this.t3Camera, this.htmlHostControlObject);
        // Set the range of allow zoom.
        this.t3MouseControls.minDistance = this.T3_MOUSE_CONTROLS_MIN_DISTANCE;
        this.t3MouseControls.maxDistance = this.T3_MOUSE_CONTROLS_MAX_DISTANCE;
    }

    /**
     * Update the engine when the window is resized.
     */
    hookUpWindowOnResizeEvent() {

        // Hook up to the browser resize event.
        window.addEventListener('resize', () => {

            this.t3Renderer.setSize(window.innerWidth, window.innerHeight);

            this.t3Camera.aspect = window.innerWidth /  window.innerHeight;
            this.t3Camera.updateProjectionMatrix();
        });

    }

    setupT3InitSceneItems() {

        // Create our "galaxy" sphere that we will set the user in.
        let stars = new StarField(this.STARS_RADIUS, this.WIDTH_SEGMENTS, this.HEIGHT_SEGMENTS);
        this.t3Scene.add(stars.getMesh());

        // Create the earth and place it in the middle of the scene
        this.earth = new Earth(this.EARTH_RADIUS, this.WIDTH_SEGMENTS, this.HEIGHT_SEGMENTS);
        //add earth to the scene.
        this.t3Scene.add(this.earth.getMesh());

        // Create the sun.
        let sun = new Sun(this.SUN_RADIUS, this.WIDTH_SEGMENTS, this.HEIGHT_SEGMENTS);
        // Add sun the the scene.
        this.t3Scene.add(sun.getMesh());
        // Move the sun off center.
        sun.getMesh().position.x = this.SUN_POSITION_X;


        // Create celestialSphere
        this.celestialSphere = new CelestialSphere(this.CELESTIAL_SPHERE_RADIUS, this.WIDTH_SEGMENTS, this.HEIGHT_SEGMENTS);
        this.t3Scene.add(this.celestialSphere.getMesh());
    }

    screenRenderer() {

        // Ask the browser for the next animation frame and when ready run the this function again.
        let reqId = requestAnimationFrame(()=> {this.screenRenderer()});
        // Add a tick to the our space time
        this.t3spaceTimeDelta += this.t3spaceTime.getDelta();

        // Can we rendere a new frame.
        if (this.t3spaceTimeDelta > this.T3_SPACE_TIME_FRAMES_PER_SECONDS ){

            // Tell all objects to update themselves.
            this.screenUpdate();

            // Tell 3d engine to reneder a frame.
            this.t3Renderer.render(this.t3Scene, this.t3Camera);
            // Add ticks.
            this.t3spaceTimeDelta %= this.T3_SPACE_TIME_FRAMES_PER_SECONDS;
        }
    };

    screenUpdate() {
        // Update objects
        this.earth.update();

        // Update mouse control if they are active.
        if (this.t3MouseControls !== null) {
            this.t3MouseControls.update();
        }

        // Keep looking at the earth objects.
        this.t3Camera.lookAt(this.earth.getMesh().position);
    };

    //============GETTERS==================================
    getIsDebugObjectsShown = function() {
        return this.isDebugObjectsShown;
    }

    getIsMouseControlOn = function() {
        return this.isMouseControlOn;
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
        this.isMouseControlOn = _on;
        this.setUpT3MouseControls();
    }

    setIsEarthRotationOn = function (_rotate) {
        this.earth.setIsEarthRotationOn(_rotate);
    }

    setIsCelestSphereVisible  = function (_visible) {
        this.celestSphere.setIsVisable(_visible);
    }
}
