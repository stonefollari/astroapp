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

