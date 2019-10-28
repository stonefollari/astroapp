/**
 * This class will plot stars on the Celestial Sphere.
 * 
 * Author Francis Perez Last Updated: 10/18/2019
 */


import StarPlotItem from "../Objects/StarPlotItem.js";
import Line from "../Objects/Line.js";
import SphereObjectPositioner from "./SphereObjectPositioner.js";


export default class StarPlotter {
    STARTING_DEGREE = 90;
    STAR_DOT_RADIUS = .01;
    STAR_COLOR = "white";
    CONNECTING_LINE_COLOR = "white";
    CONNECTING_LINE_THICKNESS = .009;
    
    starsCollectionJsonObject = null;
    celestialSphere = null;

    starPlotItemsArray = null;

    widthSegments;
    heightSegments;
       
    /**
     * 
     * @param {CelestialSphere} _celestialSphere  - The Celestial Sphere where the stars where be ploted too.
     */
    constructor(_celestialSphere, _widthSegments, _heightSegments) {
        this.celestialSphere = _celestialSphere;
        this.widthSegments = _widthSegments;
        this.heightSegments = _heightSegments;
    }

    //==========public functions=========================

    /**
     * Plot the stars on the reference Celestial Sphere.
     * @param {string} _starsCollectionFile - JSON string of array items that are the stars.
     */
    plot(_starsCollectionFile) {
        this.starsCollectionJsonObject = $.parseJSON(_starsCollectionFile);
        this.parseJsonToStarPlotItems();
        this.placeStars();
        this.placeConnections();
    }

    //==========private functions=========================

    /**
     * Convert the json object into an array of StarPlotItems.
     */
    parseJsonToStarPlotItems() {
        this.starPlotItemsArray = new Array();
        
        for (let k = 0; k < this.starsCollectionJsonObject.length; k++) {
            
            let newStarItem = new StarPlotItem(this.starsCollectionJsonObject[k], 
                                            this.STAR_COLOR,this.STAR_DOT_RADIUS, 
                                            this.widthSegments, this.heightSegments);

            this.starPlotItemsArray.push(newStarItem);
        }
    }

    /**
     * Plot the stars on the celestial shpere.
     */
    placeStars() {
        for (let k = 0; k < this.starPlotItemsArray.length; k++) {
            //Add the star object on to the sphere.
            this.celestialSphere.getMesh().add(this.starPlotItemsArray[k].getMesh());

            //Move the star it place on the celestial sphere.
            SphereObjectPositioner.positionObject(this.celestialSphere.getMesh(), 
                                                  this.celestialSphere.getRadius(),
                                                  this.starPlotItemsArray[k].getMesh(),                                                   
                                                  this.starPlotItemsArray[k].getDeclination(), 
                                                  this.starPlotItemsArray[k].getRightAscension());
                                                  
        }
    }

    /**
     * Plot the connecting line between starts.
     */
    placeConnections() {

        for (let k = 0; k < this.starPlotItemsArray.length; k++) {
            
            //Get the name of the what other star this star is connection to.
            let connectedToStarName = this.starPlotItemsArray[k].getConnectedTo();
            
            //if no name, then the star is not connect to any other star, just skip.
            if (!connectedToStarName) {
                continue;
            }

            //Go get the star that this one is connected too.
            let connectedToStarObject = this.retriveStarByName(connectedToStarName);
            //If the connecting star can not found, just skip.
            if (!connectedToStarObject) {
                continue;
            }

            //Creat the connecting line.
            let line = new Line(this.CONNECTING_LINE_COLOR, this.CONNECTING_LINE_THICKNESS, this.starPlotItemsArray[k], connectedToStarObject);
            //Add the line to sphere.
            this.celestialSphere.getMesh().add(line.getMesh());
        }
    }

    /**
     * Get the star object from the star array based on the name.
     * @param {String} _name - The name of the star.
     */
    retriveStarByName(_name) {
        for (let k = 0; k < this.starPlotItemsArray.length; k++) {
            if (this.starPlotItemsArray[k].getName() === _name) {
                return this.starPlotItemsArray[k];
            }
        }

        return null;
    }

    
    
}