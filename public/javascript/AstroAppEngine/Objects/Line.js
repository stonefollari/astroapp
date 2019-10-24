/**
 * This class will Create simple line between two objects.
 * 
 * Author Francis Perez Last Updated: 10/19/2019
 */
class Line {
    color;
    thickness;
    object1;
    object2;
    objectMesh;

    /**
     * 
     * @param {string} _color - The color of the object "red" or "#FF0000".
     * @param {decimal} _thickness - The thickness of the line.
     * @param {int} _objectMesh1 - Connect the to this object.
     * @param {int} _objectMesh2 - Connect the to this object.
     */
    constructor(_color, _thickness, _object1, _object2) {
        this.color = _color;
        this.thickness = _thickness;
        this.object1 = _object1;
        this.object2 = _object2;
        this.create();
    }

     //==========private functions=========================

     /**
     * Initialize all need objects for the creation for a simple line.
     */
    create() {
        //Create the material that will be used the skin the our line.
        //In this case just a simple color skin.
        let material = new THREE.LineBasicMaterial( { color: this.color, linewidth: this.thickness } );
        
        let geometry = new THREE.Geometry();
        geometry.vertices.push(this.object1.getMesh().position);
        geometry.vertices.push(this.object2.getMesh().position);


        //Link the geometry and the material.
        this.objectMesh = new THREE.Line( geometry, material );
    }

    //============GETTERS==================================
    
    getMesh = function() {
        return this.objectMesh;
    }


   
}