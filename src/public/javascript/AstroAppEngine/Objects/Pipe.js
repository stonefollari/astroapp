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
     * @param {string} _color - the color of the object "red" or "#FF0000"
     * @param {decimal} _width - with of the object
     * @param {decimal} _height - height on the object
     * @param {int} _segments - number of triangles that represents the object
     * @param {boolean} _isHollow - is the pipe empty
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
        //create geometry, a cylinder.
        let geometry  = new THREE.CylinderGeometry(this.width, this.width, this.height, this.segments, this.segments, this.isHollow);
        //create the material that will be used the skin the our sphere
        //in this case just a simple color skin.
        let material = new THREE.MeshBasicMaterial( { color: this.color } );
        //link the geometry and the material.
        this.hostingObjectMesh = new THREE.Mesh( geometry, material );
    }

    //============GETTERS==================================
    
    getMesh = function() {
        return this.hostingObjectMesh;
    }

}

