/**
 * This class will extend the Dot object, give it the properties of star that will be ploted on the Celestial Sphere.
 * 
 * Author Francis Perez Last Updated: 12/7/2019
 */

import Dot from "./Dot.js";

export default class StarPlotItem extends Dot {
    JSON_MAP_NAME = "name";
    JSON_MAP_RIGHT_ASCENSION = "right ascension";
    JSON_MAP_DECLINATION = "declination";
    JSON_MAP_ALTITUDE = "altitude";
    JSON_MAP_AZIMUTH = "azimuth";
    JSON_MAP_CONNECTION = "connection";


    name;
    rightAscension;
    declination;
    altitude;
    azimuth;
    connectedTo;

    /**
     * 
     * @param {Json} _jsonObject - Json Objects of stars.
     * @param {Dot} _primeDot - A Dot to copy.
     */
    constructor(_jsonObject, _primeDot) {
        super(null, null, null, null, _primeDot);
        this.name = _jsonObject[this.JSON_MAP_NAME];
        this.rightAscension = _jsonObject[this.JSON_MAP_RIGHT_ASCENSION];
        this.declination = _jsonObject[this.JSON_MAP_DECLINATION];
        this.altitude = _jsonObject[this.JSON_MAP_ALTITUDE];
        this.azimuth = _jsonObject[this.JSON_MAP_AZIMUTH];
        this.connectedTo = _jsonObject[this.JSON_MAP_CONNECTION];
    }

    //============SETTERS==================================

    setName = function (_name) {
        return this.name = _name;
    }

    setRightAscension = function (_rightAscension) {
        return this.rightAscension = _rightAscension;
    }

    setDeclination = function (_declination) {
        return this.declination = _declination;
    }

    setAltitude = function (_altitude) {
        return this.altitude = _altitude;
    }

    setAzimuth = function (_azimuth) {
        return this.azimuth = _azimuth;
    }

    setConnectedTo = function (_connectedTo) {
        return this.connectedTo = _connectedTo;
    }

    //============GETTERS==================================

    getName = function () {
        return this.name;
    }

    getRightAscension = function (_rigtAscension) {
        return this.rightAscension;
    }

    getDeclination = function () {
        return this.declination;
    }

    getAltitude = function () {
        return this.altitude;
    }

    getAzimuth = function () {
        return this.azimuth;
    }

    getConnectedTo = function () {
        return this.connectedTo;
    }
}