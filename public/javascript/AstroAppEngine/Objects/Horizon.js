/**
 * This class will Create the earth's Horizon when the user is on the ground viewing the stars.
 *
 * Author Francis Perez Last Updated: 12/7/2019
 */
import Pipe from "./Pipe.js";

export default class Horizon {
    TEXTURE_MAP_NAME = "grass2.jpg";
    MATERIAL_OPACITY =  0;
    MATERIAL_TRANSPARENT =  true;
    MATERIAL_DEPTHWRITE = true;
    MATERIAL_WIREFRAME =  true;
    MATERIAL_RENDERORDER = 1;
    GIMBAL_STARTING_DEGREE = 90;
    GIMBAL_STARTING_DEGREE_Longitude = 360;
    GROUND_HEIGHT = .001;

    texturePath;
    color;
    radius;
    widthSegments;
    heightSegments;
    groundAltitude;
    objectOuter;
    objectInner;
    ground;

    
    constructor(_color, _radius, _groundAltitude, _widthSegments, _heightSegments, _imgRoot) {
        this.color = _color;
        this.radius = _radius;
        this.widthSegments = _widthSegments;
        this.heightSegments = _heightSegments;
        this.groundAltitude = _groundAltitude;
        this.texturePath = _imgRoot + this.TEXTURE_MAP_NAME;
        this.create();
    }

    //==========public functions==========================
    positionHorizon(_latitude, _longitude) {
        this.objectOuter.rotation.y = THREE.Math.degToRad(this.GIMBAL_STARTING_DEGREE - ( this.GIMBAL_STARTING_DEGREE_Longitude -  _longitude));
        this.objectInner.rotation.x = THREE.Math.degToRad(this.GIMBAL_STARTING_DEGREE - (_latitude));
    }


     //==========private functions=========================

     /**
     * Initialize all need objects for the creation of the horizon.
     */
    create() {
       //Create the sphere with the need radius.
       let geometry = new THREE.SphereGeometry(this.radius, this.widthSegments, this.heightSegments);
       //Create the material that will be used the skin the our sphere.
       //In the case we just need a transparent spheres.        
       let material = new THREE.MeshBasicMaterial({
           opacity: this.MATERIAL_OPACITY,
           transparent: this.MATERIAL_TRANSPARENT,
           depthWrite: this.MATERIAL_DEPTHWRITE,
           wireframe: this.MATERIAL_WIREFRAME,
           renderOrder: this.MATERIAL_RENDERORDER
       });

        //Link the geometry and the material on sphere X.
        this.objectInner = new THREE.Mesh(geometry, material); 
        

        //Create the object that will host all of our scene objects, group host.
        this.objectOuter = new THREE.Object3D();
        //Add the X object to the group.
        this.objectOuter.add(this.objectInner);
        

        //Create the horizon "ground".
        this.ground = new Pipe(this.color, this.radius, this.GROUND_HEIGHT, this.widthSegments, false, this.texturePath);
        this.objectInner.add(this.ground.getMesh());

        //Poition the "ground" at a standard location.
        this.ground.getMesh().position.y = this.groundAltitude;
        this.objectInner.rotation.x = THREE.Math.degToRad(this.GIMBAL_STARTING_DEGREE);
        this.objectOuter.rotation.y = THREE.Math.degToRad(this.GIMBAL_STARTING_DEGREE);
    }

    //============SETTERS==================================
    setIsVisible = function(_isVisible) {
        if (_isVisible) {
            this.objectInner.add(this.ground.getMesh());
        } else {
            this.objectInner.remove(this.ground.getMesh());
        }   
    }

    //============GETTERS==================================
    
    getMesh = function() {
        return this.objectOuter;
    }


   
}
