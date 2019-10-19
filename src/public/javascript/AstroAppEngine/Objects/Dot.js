/**
 * This class will Create simple Sphere.
 * 
 * Author Francis Perez Last Updated: 9/29/2019
 */
class Dot {
    color;
    radius;
    widthSegments;
    heightSegments;
    objectMesh;

    /**
     * 
     * @param {string} _color - The color of the object "red" or "#FF0000".
     * @param {decimal} _radius - Radius of the object.
     * @param {int} _widthSegments - Number of triangles that represents the object.
     * @param {int} _heightSegments - Number of triangles that represents the object.
     */
    constructor(_color, _radius, _widthSegments, _heightSegments) {
        this.color = _color;
        this.radius = _radius;
        this.widthSegments = _widthSegments;
        this.heightSegments = _heightSegments;
        this.create();
    }

     //==========private functions=========================

     /**
     * Initialize all need objects for the creation for a simple Sphere.
     */
    create() {
        //Create the sphere with the need radius.
        let geometry  = new THREE.SphereGeometry(this.radius, this.widthSegments, this.heightSegments);
        //Create the material that will be used the skin the our sphere.
        //In this case just a simple color skin.
        let material = new THREE.MeshBasicMaterial( { color: this.color } );
        //Link the geometry and the material.
        this.objectMesh = new THREE.Mesh(geometry, material); 
    }

    //============GETTERS==================================
    
    getMesh = function() {
        return this.objectMesh;
    }


   
}

class StarPlotItem extends Dot{
    name;
    rightAscension;
    declination;
    altitude;
    azimuth;
    connectedTo;

    //starDot = null;

    /**
     * 
     * @param {string} _name - Name of star.
     * @param {decimal} _rightAscension - Position on the horizontal.
     * @param {decimal} _declination - Position on the vertical.
     * @param {decimal} _altitude  - Position, as orgin of long/lat, on the vertical.
     * @param {decimal _azimuth - Position, as orgin of long/lat, on the horizontal.
     * @param {string} _connectedTo 
     */
    constructor(_jsonObject, _color, _radius, _widthSegments, _heightSegments) {
        super(_color, _radius, _widthSegments, _heightSegments);
        this.name = _jsonObject["name"];
        this.rightAscension = _jsonObject["rightAscension"];
        this.declination = _jsonObject["declination"];
        this.altitude = _jsonObject["altitude"];
        this.azimuth = _jsonObject["azimuth"];
        this.connectedTo = _jsonObject["connectedTo"];
    }

    //============SETTERS==================================

    setName= function (_name) {
        return this.name = _name;
    }

    setRightAscension= function (_rightAscension) {
        return this.rightAscension = _rightAscension;
    }

    setDeclination= function (_declination) {
        return this.declination = _declination;
    }

    setAltitude= function (_altitude) {
        return this.altitude = _altitude;
    }

    setAzimuth= function (_azimuth) {
        return this.azimuth = _azimuth;
    }

    setConnectedTo= function (_connectedTo) {
        return this.connectedTo = _connectedTo;
    }

    //setStarDot = function (_starDotObject) {
    //    return this.starDot = _starDotObject;
    //}

    //============GETTERS==================================

    getName= function () {
        return this.name;
    }

    getRightAscension= function (_rigtAscension) {
        return this.rightAscension;
    }

    getDeclination= function () {
        return this.declination;
    }

    getAltitude= function () {
        return this.altitude;
    }

    getAzimuth= function () {
        return this.azimuth;
    }

    getConnectedTo= function () {
        return this.connectedTo;
    }

    //getStarDot = function () {
    //    return this.starDot;
    //}
}