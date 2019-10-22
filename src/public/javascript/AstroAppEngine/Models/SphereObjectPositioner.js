/**
 * This class will position an object on Sphere.
 * 
 * Author Francis Perez Last Updated: 10/20/2019
 */
class SphereObjectPositioner {


     //==========Static functions=========================
    static positionObject(_sphereObject, _sphereRadius, _childObject, _latitude, _longitude ) {
        let startingDegree = 90;
        let negative_int = -1

        //Convert lat long position to local world position based on rads.
        let radLat = THREE.Math.degToRad(startingDegree - _latitude);
        let radLong = THREE.Math.degToRad(startingDegree - (_longitude * negative_int));

        //Move the dot on the local sphere.
        _childObject.position.setFromSphericalCoords(_sphereRadius, radLat, radLong);
        //Position the dot on the surface of the sphere based on its radius.
        _childObject.rotation.z = THREE.Math.degToRad(startingDegree);
    }
}