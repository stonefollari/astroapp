/**
 * This class will Create the Celestial Sphere and all its need objects.
 * 
 * Author Francis Perez Last Updated: 10/21/2019
 */
class CelestialSphere {
    CELESTIAL_EQUATOR_COLOR = "red";
    CELESTIAL_ECLIPTIC_COLOR = "blue";
    CELESTIAL_VERNAL_EQUINOX_COLOR = "green";
    COLOR = 'black';
    MERIDIAN_WIDTH = .009;
    MERIDIAN_HEIGHT = .009;
    HOSTING_OBJECT_TILT = -23.5;
    ECLIPTIC_TILT = 23.5;
    VERNAL_EQUINOX_TILT = 90;
    OBSERVERS_DOT_COLOR = "green";
    OBSERVERS_DOT_RADIUS = .01;

    radius;
    widthSegments;
    heightSegments;

    hostingObjectMesh;
    celestialSphere = null;
    celestialEquator = null;
    celestialEcliptic = null;
    celestialAxis = null;
    celestialVernalEquinox = null;
    observersDot = null;

    starPlotter = null;

    /**
     * 
     * @param {decimal} _radius - Radius of the object.
     * @param {int} _widthSegments - Number of triangles that represents the object.
     * @param {int} _heightSegments - Number of triangles that represents the object.
     */
    constructor(_radius, _widthSegments, _heightSegments) {
        this.radius = _radius;
        this.widthSegments = _widthSegments;
        this.heightSegments = _heightSegments;
        this.starPlotter = new StarPlotter(this, this.widthSegments, this.heightSegments);
        this.create();
    }
    
    //==========public functions=========================

    /**
     * Place the stars on the Celestial Sphere.
     * @param {json} starsCollectionFile - A JSON array of star items.
     */
    plotStars(_starsCollectionFile) {
        this.starPlotter.plot(_starsCollectionFile);
    }

    //==========private functions=========================

    /**
     * Initialize all need objects for the creation of the Celestial Sphere and its child objects.
     */
    create() {

        //Create geometry.
        this.celestialSphere = this.createCelestialSphere();
        //Create the equator.
        this.celestialEquator = new Pipe(this.CELESTIAL_EQUATOR_COLOR, this.radius + this.MERIDIAN_HEIGHT, this.MERIDIAN_WIDTH, this.widthSegments, true);
        //Create eceliptic.
        this.celestialEcliptic = new Pipe(this.CELESTIAL_ECLIPTIC_COLOR, this.radius + this.MERIDIAN_HEIGHT, this.MERIDIAN_WIDTH, this.widthSegments, true);
        //Create the equinox.
        this.celestialVernalEquinox = new Pipe(this.CELESTIAL_VERNAL_EQUINOX_COLOR, this.radius + this.MERIDIAN_HEIGHT, this.MERIDIAN_WIDTH, this.widthSegments, true);

        //Create the object that will host all of our scene objects.
        this.hostingObjectMesh = new THREE.Object3D();
        //Add the celestial sphere to the "hosting object".
        this.hostingObjectMesh.add(this.celestialSphere);
        //Add the Equator to the "hosting object".
        this.hostingObjectMesh.add(this.celestialEquator.getMesh());
        //Add the Ecliptic to the "hosting object".
        this.hostingObjectMesh.add(this.celestialEcliptic.getMesh());
        //Add the Equinox to the "hosting object".
        this.hostingObjectMesh.add(this.celestialVernalEquinox.getMesh());

        //Tilt the the entire hosting object to match earth's tilt.
        this.hostingObjectMesh.rotation.x = THREE.Math.degToRad(this.HOSTING_OBJECT_TILT);

        //Untilt the ecliptic plane to be parallel the sun at a 0 degree tilt.
        this.celestialEcliptic.getMesh().rotation.x = THREE.Math.degToRad(this.ECLIPTIC_TILT);

        //Set the Vernal Equinox where coordinates will start
        //This is the point where Ecliptic and vernal equinox meet, with a positive slope.
        this.celestialVernalEquinox.getMesh().rotation.x = THREE.Math.degToRad(this.VERNAL_EQUINOX_TILT);
    }

    /**
     * Create the geometry of a sphere with that represents the celestial sphere.
     */
    createCelestialSphere() {

        //Create the sphere with the need radius.
        let geometry = new THREE.SphereGeometry(this.radius, this.widthSegments, this.heightSegments);
        //Create the material that will be used the skin the our sphere.
        //In the case we just need a transparent sphere.        
        let material = new THREE.MeshBasicMaterial({
            Color: this.COLOR,
            opacity: 0,
            transparent: true,
            depthWrite: true,
            wireframe: true,
            renderOrder: 1
        });
        //Link the geometry and the material.
        let mesh = new THREE.Mesh(geometry, material);
        return mesh;
    }

    /**
     * Move the lat long dot to a passed in lat long values.
     * @param {decimal} _latitude
     * @param {decimal} _longitude
     */
    moveObserversDotPosition(_latitude, _longitude) {
        
        this.observersDot = new Dot(this.OBSERVERS_DOT_COLOR, this.OBSERVERS_DOT_RADIUS,
                               this.widthSegments, this.heightSegments);

        this.celestialSphere.add(this.observersDot.getMesh());
        //this.observersDot.getMesh().position

        //Move the dot on the local sphere.
       SphereObjectPositioner.positionObject(this.celestialSphere, this.radius, this.observersDot.getMesh(), 
                                             _latitude,  _longitude);
    }

    //============SETTERS==================================
    setIsVisible = function (_visible) {
        return this.mesh.material.opacity = _visible;
    }

    setIsCelestialEquatorVisible = function (_visible) {
        this.celestialEquator.getMesh().visible = _visible;
    }

    setIsCelestialEclipticVisible = function (_visible) {
        this.celestialEcliptic.getMesh().visible = _visible;
    }

    setIsWireframeVisible = function (_visible) {
        this.celestialSphere.material.wireframe = _visible;
    }

    SetIsCelestialVernalEquinoxVisible = function (_visible) {
        this.celestialVernalEquinox.getMesh().material.visible = _visible;
    }

    //============GETTERS==================================

    getMesh = function () {
        return this.hostingObjectMesh;
    }

    getIsVisible = function () {
        return this.hostingObjectMesh.Visable;
    }

    getIsCelestialEquatorVisible = function () {
        return this.celestialEquator.getMesh().visible;
    }

    getIsCelestialEclipticVisible = function () {
        return this.celestialEcliptic.getMesh().visible;
    }

    getIsCelestialEclipticVisible = function () {
        return this.celestialEcliptic.getMesh().visible;
    }

    getIsCelestialVernalEquinoxVisible = function () {
        return this.celestialVernalEquinox.getMesh().material.wireframe;
    }

    getRadius = function () {
        return this.radius;
    }

    getObserversDot = function () {
        return this.observersDot;
    }

}

