/**
 * This class will Create a sun object.
 *
 * Author Francis Perez Last Updated: 9/29/2019
 */
class Sun {
    TEXTURE_MAP_NAME = "sunmap.jpg";

    texturePath;
    radius;
    widthSegments;
    heightSegments;

    hostingObjectMesh;

    /**
     *
     * @param {decimal} _radius - radius of the object.
     * @param {int} _widthSegments - number of triangles that represents the object.
     * @param {int} _heightSegments - number of triangles that represents the object.
     */
    constructor(_radius, _widthSegments, _heightSegments, _imgRoot) {
        this.radius = _radius;
        this.widthSegments = _widthSegments;
        this.heightSegments = _heightSegments;
        this.texturePath = _imgRoot + this.TEXTURE_MAP_NAME;
        this.create();
    }

     //==========private functions=========================

    /**
     * Creates the sun object
     */
    create() {
         //create the sphere for the earth.
         let geometry = new THREE.SphereGeometry(this.radius, this.widthSegments, this.heightSegments);

         //load the earth texture from url path.
         let textureMap = THREE.ImageUtils.loadTexture(this.texturePath);

         //load texture into the material.
         let material = new THREE.MeshPhongMaterial({
             map : textureMap
         });

         //link the geometry and the material.
         this.hostingObjectMesh = new THREE.Mesh(geometry, material);
    }

    //============GETTERS==================================

    getMesh = function() {
        return this.hostingObjectMesh;
    }



}

