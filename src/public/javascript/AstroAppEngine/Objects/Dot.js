/**
 * This class will Create simple Sphere.
 * 
 * Author Francis Perez Last Updated: 9/29/2019
 */
export default class Dot {
    color;
    radius;
    widthSegments;
    heightSegments;
    objectMesh;
    geometry;
    material;

    /**
     * 
     * @param {string} _color - The color of the object "red" or "#FF0000".
     * @param {decimal} _radius - Radius of the object.
     * @param {int} _widthSegments - Number of triangles that represents the object.
     * @param {int} _heightSegments - Number of triangles that represents the object.
     * @param {Dot} _dotToCopy - Create a new dot based on this passed Object. If set all other paramenters will be overwriten. (Null by default)
     */
    constructor(_color, _radius, _widthSegments, _heightSegments, _dotToCopy) {
       if (_dotToCopy) {
            //copy item properties from sent in Dot.
            this.color = _dotToCopy.getColor();
            this.radius = _dotToCopy.getRadius();
            this.widthSegments = _dotToCopy.getWidthSegments();
            this.heightSegments = _dotToCopy.getHeightSegments();
            //Create this dot with the reused 3d items.
            this.createCopy(_dotToCopy);
        } else {
            this.color = _color;
            this.radius = _radius;
            this.widthSegments = _widthSegments;
            this.heightSegments = _heightSegments;
            //Create a new dot with sent in paramters.
            this.create();
        }

    }

  

    //==========private functions=========================
    
     /**
     * Initialize all need objects for the creation for a simple Sphere.
     */
    create() {
        //Create the sphere with the need radius.
        this.geometry  = new THREE.SphereGeometry(this.radius, this.widthSegments, this.heightSegments);
        //Create the material that will be used the skin the our sphere.
        //In this case just a simple color skin.
        this.material = new THREE.MeshBasicMaterial( { color: this.color } );
        //Link the geometry and the material.
        this.objectMesh = new THREE.Mesh(this.geometry, this.material); 
    }

      /**
     * Creates a new Dot object with same geometry and material. Returns a Dot.
     */
    createCopy(_dotToCopy)  {
         //Reuse the geometry.
         this.geometry  = _dotToCopy.getGeometry();
         //Reuse the material.
         this.material = _dotToCopy.getMaterial();
         //Link the geometry and the material.
         this.objectMesh = new THREE.Mesh(this.geometry, this.material); 
    }

    //============GETTERS==================================
    
    getMesh = function() {
        return this.objectMesh;
    }


    getColor = function() {
        return this.color;
    }

    getRadius= function() {
        return this.radius;
    }

    getWidthSegments = function() {
        return this.widthSegments;
    }

    getHeightSegments = function() {
        return this.heightSegments;
    }

    getGeometry = function() {
        return this.geometry;
    }

    getMaterial = function() {
        return this.material;
    }   
}

