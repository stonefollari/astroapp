/**
 * This class will Create the background star field.
 * 
 * Author Francis Perez Last Updated: 9/29/2019
 */
class StarField {
    TEXTURE_MAP_PATH = "./img/galaxy_starfield.png";
    TEXTURE_X_REPEAT = 4;
    TEXTURE_Y_REPEAT = 4;

    radius;
    widthSegments;
    heightSegments;

    hostingObjectMesh;

    /**
     * 
     * @param {decimal} _radius 
     * @param {int} _widthSegments 
     * @param {int} _heightSegments 
     */
    constructor(_radius, _widthSegments, _heightSegments) {
        this.radius = _radius;
        this.widthSegments = _widthSegments;
        this.heightSegments = _heightSegments;
        this.hostingObjectMesh = this.create();
    }

    //==========private functions=========================


    /**
     * Creates the a field of stars as the background of the space scene.
     */
    create() {

        //create the sphere the the scene will sit in, this will be our "galaxy".
        let geometry = new THREE.SphereGeometry(this.radius, this.widthSegments, this.heightSegments);

        //load the star texture from url path.
        let textureMap = THREE.ImageUtils.loadTexture(this.TEXTURE_MAP_PATH);

        //set how the texture is layed out on the sphere.
        textureMap.wrapS = THREE.RepeatWrapping;
        textureMap.wrapT = THREE.RepeatWrapping;
        textureMap.repeat.set(this.TEXTURE_X_REPEAT, this.TEXTURE_Y_REPEAT);

        //position the texture on the back of the sphere.
        let material = new THREE.MeshPhongMaterial({
            map : textureMap,
            side: THREE.BackSide
        });

        //link the geometry and the material.
        let mesh = new THREE.Mesh(geometry, material);
        return mesh;
    }

     //============GETTERS==================================
    
     getMesh = function() {
        return this.hostingObjectMesh;
    }
}

