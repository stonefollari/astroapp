/**
 * This class will Create a pipe object.
 * 
 * Author Francis Perez Last Updated: 9/29/2019
 */
export default class Pipe {
    TEXTUREMAP_REPEAT_SQUARE = 1000;
    color;
    width;
    height;
    segments;
    isHollow;
    texturePath;
    hostingObjectMesh;

    /**
     * 
     * @param {string} _color - The color of the object "red" or "#FF0000".
     * @param {decimal} _width - With of the object.
     * @param {decimal} _height - Height on the object.
     * @param {int} _segments - Number of triangles that represents the object.
     * @param {boolean} _isHollow - Is the pipe empty.
     * @param {string} _texturePath - a url of a texture, (Null by default)
     */
    constructor(_color, _width, _height, _segments, _isHollow, _texturePath) {
        this.color = _color;
        this.width = _width;
        this.height = _height;
        this.segments = _segments;
        this.isHollow = _isHollow;
        this.texturePath = _texturePath;
        this.create();
    }

     //==========private functions=========================
     
    /**
     * Creates a pipe.
     */
    create() {
        //Create geometry, a cylinder.
        let geometry  = new THREE.CylinderGeometry(this.width, this.width, this.height, this.segments, this.segments, this.isHollow);
        let material = null;

        //Check to see if a texture path was sent in.
        if (this.texturePath){
            //Load the earth texture from url path.
            let textureMap = THREE.ImageUtils.loadTexture(this.texturePath);
            textureMap.wrapS = THREE.RepeatWrapping;
            textureMap.wrapT = THREE.RepeatWrapping;
            textureMap.repeat.set( this.TEXTUREMAP_REPEAT_SQUARE, this.TEXTUREMAP_REPEAT_SQUARE );
            //Load texture into the material.
            material = new THREE.MeshPhongMaterial({map : textureMap});
        } else {
            //Create the material that will be used the skin the our sphere.
            //In this case just a simple color skin.
            material = new THREE.MeshBasicMaterial( { color: this.color } );
        }

        //Link the geometry and the material.
        this.hostingObjectMesh = new THREE.Mesh( geometry, material );
    }

    //============GETTERS==================================
    
    getMesh = function() {
        return this.hostingObjectMesh;
    }

}

