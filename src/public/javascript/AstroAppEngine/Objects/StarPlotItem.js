/**
 * This class will Create the Camera for a our world.
 * 
 * Author Francis Perez Last Updated: 10/18/2019
 */

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
        this.ConnectedTo = _jsonObject["ConnectedTo"];
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