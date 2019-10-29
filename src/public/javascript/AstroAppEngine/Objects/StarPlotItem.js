/**
 * This class will extend the Dot object, give it the properties of star that will be ploted on the Celestial Sphere.
 * 
 * Author Francis Perez Last Updated: 10/21/2019
 */

import Dot from "./Dot.js";

export default class StarPlotItem extends Dot{
    name;
    rightAscension;
    declination;
    altitude;
    azimuth;
    connectedTo;

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
        this.rightAscension = _jsonObject["right ascension"];
        this.declination = _jsonObject["declination"];
        this.altitude = _jsonObject["altitude"];
        this.azimuth = _jsonObject["azimuth"];
        this.connectedTo = _jsonObject["connection"];
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
}