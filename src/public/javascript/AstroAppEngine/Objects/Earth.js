/**
 * This class will Create the earth and its need objects.
 *
 * Author Francis Perez Last Updated: 9/29/2019
 */
class Earth {
    TEXTURE_MAP_NAME = "earthlights2k.jpg";
    TEXTUREMAP_MAP_REPEAT_Y = -1;
    TEXTUREMAP_MAP_REPEAT_X = -1;
    LOCATION_DOT_COLOR = "red";
    LOCATION_DOT_RADIUS = .01;
    LOCATION_DOT_DEFAULT_LAT = 0;
    LOCATION_DOT_DEFAULT_LONG = 0;
    PRIME_MERIDIAN_COLOR = "yellow";
    EQUATOR_COLOR = "yellow";
    MERIDIAN_WIDTH = .009;
    MERIDIAN_HEIGHT = .009;
    CELESTIAL_SPHERE_RADIUS = 2;
    EARTHS_TILT = -23.5;
    PRIME_MERIDIAN_TILT = 90;
    EARTHS_ROTATION_DEFAULT_DEGREE = .08;
    EARTHS_STARTING_DEGREE = 90;
    EARTHS_DEFAULT_ROTATOIN_STARTING_POINT = 180;
    MATH_NEGATIVE_INT = -1;
    AXIS_COLOR = "yellow";
    AXIS_WIDTH = .01;
    AXIS_EXTENSION_HEIGHT = .5;

    texturePath;
    radius;
    widthSegments;
    heightSegments;
    isEarthRotationOn = false;

    earth = null;
    equator = null;
    primeMeridian = null;
    axis = null;
    celestSphere = null;

    locationDot = null;
    locationDotLatitude = 0;
    locationDotLongitude = 0;

    hostingObjectMesh = null;


    /**
     *
     * @param {decimal} _radius - Radius of the object.
     * @param {int} _widthSegments - Number of triangles that represents the object.
     * @param {int} _heightSegments - Number of triangles that represents the object.
     */
    constructor(_radius, _widthSegments, _heightSegments, _imgRoot) {
        this.radius = _radius;
        this.widthSegments = _widthSegments;
        this.heightSegments = _heightSegments;
        this.texturePath = _imgRoot + this.TEXTURE_MAP_NAME;
        this.create();
    }

    //==========public functions==========================

    /**
     * Updated the earth objects/positions/locations based on the current world ticks.
     */
    update() {
        if (this.isEarthRotationOn) {
            this.hostingObjectMesh.rotation.y += THREE.Math.degToRad(this.EARTHS_ROTATION_DEFAULT_DEGREE);
        }
    }

    /**
     * Move the lat long dot to a passed in lat long values.
     * @param {decimal} _latitude
     * @param {decimal} _longitude
     */
    moveLocationDotPosition(_latitude, _longitude) {
        //Save the new location of the dot.
        this.locationDotLatitude = _latitude;
        this.locationDotLongitude = _longitude;

        //Convert lat long position to local world position based on rads.
        let radLat = THREE.Math.degToRad(this.EARTHS_STARTING_DEGREE - _latitude);
        let radLong = THREE.Math.degToRad(this.EARTHS_STARTING_DEGREE - (_longitude * this.MATH_NEGATIVE_INT));

        //Move the dot on the local sphere.
        this.locationDot.getMesh().position.setFromSphericalCoords(this.radius, radLat, radLong);
        //Position the dot on the surface of the earth based on its radius.
        this.locationDot.getMesh().rotation.z = THREE.Math.degToRad(this.EARTHS_STARTING_DEGREE);
    }

    //==========private functions=========================

    /**
     * Creates the earth with texture.
     * Returns a sphere mesh.
     */
    create() {
        //Create the earth sphere.
        this.earth = this.createEarth();
        //Create the location dot to use as our lat long pin point.
        this.locationDot = new Dot(this.LOCATION_DOT_COLOR, this.LOCATION_DOT_RADIUS, this.widthSegments, this.heightSegments)
        //Create the meridian.
        this.primeMeridian = new Pipe(this.PRIME_MERIDIAN_COLOR, this.radius + this.MERIDIAN_HEIGHT, this.MERIDIAN_WIDTH, this.widthSegments, true);
        //Create the equator.
        this.equator = new Pipe(this.EQUATOR_COLOR, this.radius + this.MERIDIAN_HEIGHT, this.MERIDIAN_WIDTH, this.widthSegments, true);
        //Create our spining axis.
        this.axis = new Pipe(this.EQUATOR_COLOR, this.AXIS_WIDTH, this.radius + this.AXIS_EXTENSION_HEIGHT, this.widthSegments, false);

        //Create the object that will host all of our scene objects.
        this.hostingObjectMesh = new THREE.Object3D();
        //Add earth to the "hosting object".
        this.hostingObjectMesh.add(this.earth);
        //Add location dot to the "hosting object".
        this.hostingObjectMesh.add(this.locationDot.getMesh());
        //Add meridian to the "hosting object".
        this.hostingObjectMesh.add(this.primeMeridian.getMesh());
        //Add equator to the "hosting object".
        this.hostingObjectMesh.add(this.equator.getMesh());
        //Add axis to the "hosting object".
        this.hostingObjectMesh.add(this.axis.getMesh());

        //Aet prime vertical.
        this.primeMeridian.getMesh().rotation.x = THREE.Math.degToRad(this.PRIME_MERIDIAN_TILT);

        //Earth's tilt.
        this.hostingObjectMesh.rotation.x = THREE.Math.degToRad(this.EARTHS_TILT);

        //Set move the start dot position.
        this.moveLocationDotPosition(this.LOCATION_DOT_DEFAULT_LAT, this.LOCATION_DOT_DEFAULT_LONG);
    }


    createEarth() {
        //Create the sphere for the earth.
        let geometry = new THREE.SphereGeometry(this.radius, this.widthSegments, this.heightSegments);

        //Load the earth texture from url path.
        let textureMap = THREE.ImageUtils.loadTexture(this.texturePath);
        textureMap.wrapS = THREE.RepeatWrapping;
        textureMap.wrapT = THREE.RepeatWrapping;

        //Flip the texture so that it appears correct.
        textureMap.repeat.y = this.TEXTUREMAP_MAP_REPEAT_Y;
        textureMap.repeat.x = this.TEXTUREMAP_MAP_REPEAT_X;

        //Load texture into the material.
        let material = new THREE.MeshPhongMaterial({
            map : textureMap
        });

        //Link the geometry and the material.
        let mesh = new THREE.Mesh(geometry, material);

        //Rotate the earth so coordinates work.
        mesh.rotation.x = THREE.Math.degToRad(this.EARTHS_DEFAULT_ROTATOIN_STARTING_POINT);
        return mesh;
   }

    //============GETTERS==================================
    getMesh = function() {
        return this.hostingObjectMesh;
    }

    getIsEquatorVisable = function() {
        return this.equator.getMesh().visible;
    }

    getIsPrimeMeridianVisible = function() {
        return this.primeMeridian.getMesh().visible;
    }

    getIsAxisVisible = function() {
        return this.axis.getMesh().visible;
    }

    getIsLocationDotVisible = function() {
        return this.locationDot.getMesh().visible;
    }

    getIsEarthRotationOn = function() {
        return this.isEarthRotationOn;
    }

    getLocationDot = function(){
        return this.locationDot;
    }

    //============SETTERS==================================
    setIsEquatorVisible = function (_visible) {
        this.equator.getMesh().visible = _visible;
    }

    setIsPrimeMeridianVisible = function (_visible) {
        this.primeMeridian.getMesh().visible = _visible;
    }

    setIsAxisVisible = function (_visible) {
        this.axis.getMesh().visible = _visible;
    }

    setIsLocationDotVisible = function (_visible) {
        this.isLocationDotVisible = _visible;
    }

    setIsEarthRotationOn = function (_rotate) {
        this.isEarthRotationOn = _rotate;
    }
}

