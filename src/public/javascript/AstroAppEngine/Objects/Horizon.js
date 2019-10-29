import Pipe from "./Pipe.js";
import SphereObjectPositioner from "../Libs/SphereObjectPositioner.js";

export default class Horizon {
    color;
    radius;
    widthSegments;
    heightSegments;
    groundAltitude;
    objectOuter;
    objectInner;
    ground;

    
    constructor(_color, _radius, _groundAltitude, _widthSegments, _heightSegments) {
        this.color = _color;
        this.radius = _radius;
        this.widthSegments = _widthSegments;
        this.heightSegments = _heightSegments;
        this.groundAltitude = _groundAltitude;
        this.create();
    }

    //==========public functions==========================
    positionHorizon(_latitude, _longitude) {
        this.objectOuter.rotation.y = THREE.Math.degToRad(90 - ( 360 -  _longitude));
        this.objectInner.rotation.x = THREE.Math.degToRad(90 - (_latitude));
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
           opacity: 0,
           transparent: true,
           depthWrite: true,
           wireframe: true,
           renderOrder: 1
       });

        //Link the geometry and the material on sphere X.
        this.objectInner = new THREE.Mesh(geometry, material); 
        

        //Create the object that will host all of our scene objects, group host.
        this.objectOuter = new THREE.Object3D();
        //Add the X object to the group.
        this.objectOuter.add(this.objectInner);
        

        //Create the horizon "ground".
        this.ground = new Pipe(this.color, 4, .001, this.widthSegments, false);
        this.objectInner.add(this.ground.getMesh());

        //Poition the "ground" at a standard location.
        this.ground.getMesh().position.y = this.groundAltitude;
        this.objectInner.rotation.x = THREE.Math.degToRad(90);
        this.objectOuter.rotation.y = THREE.Math.degToRad(90);
    }

    //============SETTERS==================================
    setIsVisible = function(_isVisible) {
        if (_isVisible) {
            this.objectInner.add(this.ground.getMesh());
            //this.ground.getMesh().material.opacity  = 1;
        } else {
            this.objectInner.remove(this.ground.getMesh());
            //this.ground.getMesh().material.opacity  = 0;
        }
        
    }

    //============GETTERS==================================
    
    getMesh = function() {
        return this.objectOuter;
    }


   
}
