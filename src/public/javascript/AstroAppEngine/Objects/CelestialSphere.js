/**
 * This class will Create the Celestial Sphere and all its need objects.
 * 
 * Author Francis Perez Last Updated: 9/29/2019
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

    radius;
    widthSegments;
    heightSegments;

    hostingObjectMesh;
    celestialSphere = null;
    celestialEquator = null;
    celestialEcliptic = null;
    celestialAxis = null;
    celestialVernalEquinox = null;

    /**
     * 
     * @param {decimal} _radius - radius of the object.
     * @param {int} _widthSegments - number of triangles that represents the object.
     * @param {int} _heightSegments - number of triangles that represents the object.
     */
    constructor(_radius, _widthSegments, _heightSegments) {
        this.radius = _radius;
        this.widthSegments = _widthSegments;
        this.heightSegments = _heightSegments;
        this.create();
    }

    //==========private functions=========================

    /**
     * Initialize all need objects for the creation of the Celestial Sphere and its child objects.
     */
    create() {

        //create geometry.
        this.celestialSphere = this.createCelestialSphere();
        //create the equator.
        this.celestialEquator = new Pipe(this.CELESTIAL_EQUATOR_COLOR, this.radius + this.MERIDIAN_HEIGHT, this.MERIDIAN_WIDTH, this.widthSegments, true);
        //create eceliptic.
        this.celestialEcliptic = new Pipe(this.CELESTIAL_ECLIPTIC_COLOR, this.radius + this.MERIDIAN_HEIGHT, this.MERIDIAN_WIDTH, this.widthSegments, true);
        //create the equinox.
        this.celestialVernalEquinox = new Pipe(this.CELESTIAL_VERNAL_EQUINOX_COLOR, this.radius + this.MERIDIAN_HEIGHT, this.MERIDIAN_WIDTH, this.widthSegments, true);

        //create the object that will host all of our scene objects.
        this.hostingObjectMesh = new THREE.Object3D();
        //add the celestial sphere to the "hosting object".
        this.hostingObjectMesh.add(this.celestialSphere);
        //add the Equator to the "hosting object".
        this.hostingObjectMesh.add(this.celestialEquator.getMesh());
        //add the Ecliptic to the "hosting object".
        this.hostingObjectMesh.add(this.celestialEcliptic.getMesh());
        //add the Equinox to the "hosting object".
        this.hostingObjectMesh.add(this.celestialVernalEquinox.getMesh());

        //tilt the the entire hosting object to match earth's tilt.
        this.hostingObjectMesh.rotation.x = THREE.Math.degToRad(this.HOSTING_OBJECT_TILT);

        //untilt the ecliptic plane to be parallel the sun at a 0 degree tilt.
        this.celestialEcliptic.getMesh().rotation.x = THREE.Math.degToRad(this.ECLIPTIC_TILT);

        //set the Vernal Equinox where coordinates will start
        //this is the point where Ecliptic and vernal equinox meet, with a positive slope.
        this.celestialVernalEquinox.getMesh().rotation.x = THREE.Math.degToRad(this.VERNAL_EQUINOX_TILT);
    }

    /**
     * Create the geometry of a sphere with that represents the celestial sphere.
     */
    createCelestialSphere() {

        //create the sphere with the need radius.
        let geometry = new THREE.SphereGeometry(this.radius, this.widthSegments, this.heightSegments);
        //create the material that will be used the skin the our sphere.
        //in the case we just need a transparent sphere.        
        let material = new THREE.MeshBasicMaterial({
            Color: this.COLOR,
            opacity: 0,
            transparent: true,
            depthWrite: true,
            wireframe: true,
            renderOrder: 1
        });
        //link the geometry and the material.
        let mesh = new THREE.Mesh(geometry, material);
        return mesh;
    }



    //============SETTERS==================================
    setIsVisable = function (_visable) {
        return this.mesh.material.opacity = _visable;
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

    getIsVisable = function () {
        return this.hostingObjectMesh.Visable;
    }

    getIsCelestialEquatorVisable = function () {
        return this.celestialEquator.getMesh().visible;
    }

    getIsCelestialEclipticVisible = function () {
        return this.celestialEcliptic.getMesh().visible;
    }

    getIsCelestialEclipticVisible = function () {
        return this.celestialEcliptic.getMesh().visible;
    }

    getIsCelestialVernalEquinoxVisible = function () {
        this.celestialVernalEquinox.getMesh().material.wireframe;
    }
}
