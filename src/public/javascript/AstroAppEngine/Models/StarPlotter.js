/**
 * This class will plot stars on the Celestial Sphere.
 * 
 * Author Francis Perez Last Updated: 10/18/2019
 */
class StarPlotter {
    STARTING_DEGREE = 90;
    STAR_DOT_RADIUS = .01;
    STAR_COLOR = "white";
    
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
        //alert(this.starsCollectionJsonObject [0]['name']);

        
    }

    //==========private functions=========================

    parseJsonToStarPlotItems() {
        this.starPlotItemsArray = new Array();
        
        for (let k = 0; k < this.starsCollectionJsonObject.length; k++) {
            let newStarItem = new StarPlotItem(this.starsCollectionJsonObject[k], 
                                            this.STAR_COLOR,this.STAR_DOT_RADIUS, 
                                            this.widthSegments, this.heightSegments);

            this.starPlotItemsArray.push(newStarItem);
        }
    }

    placeStars() {
        for (let k = 0; k < this.starPlotItemsArray.length; k++) {
            //let starDot = new Dot(this.STAR_COLOR,this.STAR_DOT_RADIUS, this.widthSegments, this.heightSegments);
            //this.starPlotItemsArray[k].setStarDot(starDot);

            this.celestialSphere.getMesh().add(this.starPlotItemsArray[k].getMesh());

            //Convert lat long position to local world position based on rads.
            //alert(this.starPlotItemsArray[k].getDeclination());
            let radLat = THREE.Math.degToRad(this.STARTING_DEGREE - this.starPlotItemsArray[k].getDeclination());
            let radLong = THREE.Math.degToRad(this.STARTING_DEGREE - this.starPlotItemsArray[k].getRightAscension());

            //Move the dot on the local sphere.
            this.starPlotItemsArray[k].getMesh().position.setFromSphericalCoords(this.celestialSphere.getRadius(), radLat, radLong);
            //Position the dot on the surface of the earth based on its radius.
            this.starPlotItemsArray[k].getMesh().rotation.z = THREE.Math.degToRad(90);
        }
    }
    
}