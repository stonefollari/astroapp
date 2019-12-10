/**
 * This class will position an object on Sphere.
 * 
 * Author Francis Perez Last Updated: 11/2/2019
 */
export default class SphereObjectPositioner {


     //==========Static functions=========================
    static positionObject(_sphereObject, _sphereRadius, _childObject, _latitude, _longitude ) {
        let STARTING_DEGREE = 90;
        let NEGATIVE_INT = -1;

        //Convert lat long position to local world position based on rads.
        let radLat = THREE.Math.degToRad(STARTING_DEGREE - _latitude);
        let radLong = THREE.Math.degToRad(STARTING_DEGREE - (_longitude * NEGATIVE_INT));

        //Move the dot on the local sphere.
        _childObject.position.setFromSphericalCoords(_sphereRadius, radLat, radLong);
        
        //Position the dot on the surface of the sphere based on its radius.
        _childObject.rotation.z = THREE.Math.degToRad(STARTING_DEGREE);
    }
}