/**
 * This class will plot stars on the Celestial Sphere.
 * 
 * Author Francis Perez Last Updated: 10/18/2019
 */
class StarPlotter {
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
        //alert(_starsCollectionFile);
        this.starsCollectionJsonObject = $.parseJSON(_starsCollectionFile);
        this.parseJsonToStarPlotItems();
        this.placeStars();
        this.placeConnections();
        //alert(this.starsCollectionJsonObject [0]['name']);
    }

    //==========private functions=========================

    parseJsonToStarPlotItems() {
        this.starPlotItemsArray = new Array();
        
        for (let k = 0; k < this.starsCollectionJsonObject.length; k++) {
            //alert(this.starsCollectionJsonObject[k]["connectedTo"]);
            let newStarItem = new StarPlotItem(this.starsCollectionJsonObject[k], 
                                            this.STAR_COLOR,this.STAR_DOT_RADIUS, 
                                            this.widthSegments, this.heightSegments);

            this.starPlotItemsArray.push(newStarItem);
        }
    }

    placeStars() {
        for (let k = 0; k < this.starPlotItemsArray.length; k++) {
            //et starDot = new Dot(this.STAR_COLOR,this.STAR_DOT_RADIUS, this.widthSegments, this.heightSegments);
            //this.starPlotItemsArray[k].setStarDot(starDot);

            this.celestialSphere.getMesh().add(this.starPlotItemsArray[k].getMesh());

            //Move the star it place on the celestial sphere.
            SphereObjectPositioner.positionObject(this.celestialSphere.getMesh(), 
                                                  this.celestialSphere.getRadius(),
                                                  this.starPlotItemsArray[k].getMesh(),                                                   
                                                  this.starPlotItemsArray[k].getDeclination(), 
                                                  this.starPlotItemsArray[k].getRightAscension());
                                                  
            //Convert lat long position to local world position based on rads.
            //let radLat = THREE.Math.degToRad(this.STARTING_DEGREE - this.starPlotItemsArray[k].getDeclination());
            //let radLong = THREE.Math.degToRad(this.STARTING_DEGREE - this.starPlotItemsArray[k].getRightAscension());

            //Move the dot on the local sphere.
            //this.starPlotItemsArray[k].getMesh().position.setFromSphericalCoords(this.celestialSphere.getRadius(), radLat, radLong);
            //Position the dot on the surface of the earth based on its radius.
            //this.starPlotItemsArray[k].getMesh().rotation.z = THREE.Math.degToRad(this.STARTING_DEGREE);
        }
    }

    placeConnections() {

        for (let k = 0; k < this.starPlotItemsArray.length; k++) {
            
            let connectedToStarName = this.starPlotItemsArray[k].getConnectedTo();
            //alert(connectedToStarName);
            if (!connectedToStarName) {
                continue;
            }

            let connectedToStarObject = this.retriveStarByName(connectedToStarName);
            if (!connectedToStarObject) {
                continue;
            }

            //Creat the connecting line.
            let line = new Line(this.CONNECTING_LINE_COLOR, this.CONNECTING_LINE_THICKNESS, this.starPlotItemsArray[k], connectedToStarObject);
            //Add the line to sphere.
            this.celestialSphere.getMesh().add(line.getMesh());

            console.log(connectedToStarObject.getMesh().position.x);
        }
    }

    retriveStarByName(_name) {
        for (let k = 0; k < this.starPlotItemsArray.length; k++) {
            if (this.starPlotItemsArray[k].getName() === _name) {
                return this.starPlotItemsArray[k];
            }
        }

        return null;
    }

    
    
}