/**
 * This class will Create a pipe object.
 * 
 * Author Francis Perez Last Updated: 9/29/2019
 */
class Pipe {
    color;
    width;
    height;
    segments;
    isHollow;

    hostingObjectMesh;

    /**
     * 
     * @param {string} _color - The color of the object "red" or "#FF0000".
     * @param {decimal} _width - With of the object.
     * @param {decimal} _height - Height on the object.
     * @param {int} _segments - Number of triangles that represents the object.
     * @param {boolean} _isHollow - Is the pipe empty.
     */
    constructor(_color, _width, _height, _segments, _isHollow) {
        this.color = _color;
        this.width = _width;
        this.height = _height;
        this.segments = _segments;
        this.isHollow = _isHollow;
        this.create();
    }

     //==========private functions=========================
     
    /**
     * Creates a pipe.
     */
    create() {
        //Create geometry, a cylinder.
        let geometry  = new THREE.CylinderGeometry(this.width, this.width, this.height, this.segments, this.segments, this.isHollow);
        //Create the material that will be used the skin the our sphere.
        //In this case just a simple color skin.
        let material = new THREE.MeshBasicMaterial( { color: this.color } );
        //Link the geometry and the material.
        this.hostingObjectMesh = new THREE.Mesh( geometry, material );
    }

    //============GETTERS==================================
    
    getMesh = function() {
        return this.hostingObjectMesh;
    }

}
