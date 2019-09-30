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
     * @param {string} _color - the color of the object "red" or "#FF0000".
     * @param {decimal} _radius - radius of the object.
     * @param {int} _widthSegments - number of triangles that represents the object.
     * @param {int} _heightSegments - number of triangles that represents the object.
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
        //create the sphere with the need radius.
        let geometry  = new THREE.SphereGeometry(this.radius, this.widthSegments, this.heightSegments);
        //create the material that will be used the skin the our sphere
        //in this case just a simple color skin.
        let material = new THREE.MeshBasicMaterial( { color: this.color } );
        //link the geometry and the material.
        this.objectMesh = new THREE.Mesh(geometry, material); 
    }

    //============GETTERS==================================
    
    getMesh = function() {
        return this.objectMesh;
    }


   
}

