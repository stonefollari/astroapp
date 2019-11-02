/**
 * This class will plot stars on the Celestial Sphere.
 * 
 * Author Francis Perez Last Updated: 11/2/2019
 */

import StarPlotItem from "../Objects/StarPlotItem.js";
import Line from "../Objects/Line.js";
import SphereObjectPositioner from "./SphereObjectPositioner.js";
import Dot from "../Objects/Dot.js";


export default class StarPlotter {
    STARTING_DEGREE = 90;
    STAR_DOT_RADIUS = .01;
    STAR_COLOR = "white";
    CONNECTING_LINE_COLOR = "white";
    CONNECTING_LINE_THICKNESS = .009;
    
    starsCollectionJsonObject;
    celestialSphere;
    starPlotItemsArray;
    widthSegments;
    heightSegments;
       
    /**
     * 
     * @param {CelestialSphere} _celestialSphere  - The Celestial Sphere where the stars where be ploted too.
     * @param {int} _widthSegments - Number of triangles that represents the object.
     * @param {int} _heightSegments - Number of triangles that represents the object.
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
        //Convert json string to json object.
        this.starsCollectionJsonObject = $.parseJSON(_starsCollectionFile);
        this.parseJsonToStarPlotItems();
        this.placeConnections();

        //Release the memory used for the json file.
        this.starsCollectionJsonObject = null;
        //Lease the memory used for the array;
        this.starPlotItemsArray = null;
    }

    //==========private functions=========================

    /**
     * Convert the json object into an array of StarPlotItems.
     */
    parseJsonToStarPlotItems() {
        this.starPlotItemsArray = new Array();
        let newStarItem = null;

        let celestialSphere = this.celestialSphere.getMesh();
        let celestialSphereRadius = this.celestialSphere.getRadius();

        //Create the sphere with the need radius.
        let geometry  = new THREE.SphereGeometry(.01, 10, 10);
        //Create the material that will be used the skin the our sphere.
        //In this case just a simple color skin.
        let material = new THREE.MeshBasicMaterial( { color: "white" } );

        //Create a dot that wil be our dot to copy when we place the star. This will speed the plotting process.
        let primeDot = new Dot(this.STAR_COLOR, this.STAR_DOT_RADIUS, this.widthSegments, this.heightSegments);

        for (let k = 0; k < this.starsCollectionJsonObject.length; k++) {
            this.placeStars(celestialSphere, celestialSphereRadius, this.starsCollectionJsonObject[k], primeDot);           
        }
    }

    /**
     * Plot the stars on the celestial sphere.
     * @param {Mesh} _celestialSphere - The sphere to the place the object on. 
     * @param {decimal} _celestialSphereRadius - The radius of the sphere where objects will be placed on. 
     * @param {JsonObject} _starPlotItem - The star information.
     * @param {Dot} _primeDot - The Dot that will be used for the reuse object.
     */
    placeStars(_celestialSphere, _celestialSphereRadius,  _starPlotItem, _primeDot) {
         //Create a new star object based on the primeDot.
         let newStarItem = new StarPlotItem(_starPlotItem, _primeDot);
         this.starPlotItemsArray.push(newStarItem);

         //Add the new star to the celestial sphere.
         _celestialSphere.add(newStarItem.getMesh());

         //Position the star based on the Json object position.
         SphereObjectPositioner.positionObject(_celestialSphere, 
                                               _celestialSphereRadius,
                                               newStarItem.getMesh(),                                                   
                                               _starPlotItem["declination"], 
                                               _starPlotItem["right ascension"]);   
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
        //Scan the array to find the star by its name.
        for (let k = 0; k < this.starPlotItemsArray.length; k++) {
            if (this.starPlotItemsArray[k].getName() === _name) {
                //Star found, return object.
                return this.starPlotItemsArray[k];
            }
        }

        return null;
    }    
}