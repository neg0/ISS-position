# Avanti Technical Test

* Symfony 4 Skeleton
* PHP7 OOP
* PHPUnit

## Endpoints
__Get ISS position:__
```
GET /iss/position HTTP/1.1
Host: localhost
```

__Response__
```
{
    "id": 25544,
    "name": "iss",
    "coordinates": {
        "latitude": 40.517156343912,
        "longitude": 44.920639186041
    }
}
```

__Get ISS Distance from another coordinate:__
```
POST /iss/position/distance HTTP/1.1
Host: localhost
Content-Type: application/json
{
	"latitude": 53.480759,
	"longitude": -2.242631
}
```

__Response__
```json
{
    "distance": "11,872.13",
    "unit": "Kilometer"
}
```

### Controllers
- Methods in each Controller prefixed with CRUD, to identify propose of each endpoint on a first glance.
- Instead of injecting services used in Controller inside Constructor, I inserted them individually for each endpoint, to avoid instantiation of SatelliteBuilder twice inside the Controller for better performance.

### Architecture
Main dependency in Guzzle library, I created a Bridge _(Bridge Pattern) GoF_ to import this into the project. There is an alternative of Guzzle Bundle for Symfony but given my experience working with the bundle, I believe this way is more efficient for purpose of this application.

### Validation
- POST method is validated using Symfony Form and Validator but creation of object is through DataMapper and using Rich Data Model with validation logic inside constructor instead of creating a custom validator for longitude and latitude.

### Calculating Distance
Calculating between two coordinates are implemented using Haversine formula. The Haversine formula is an equation important in navigation, giving great-circle distances between two points on a sphere from their longitudes and latitudes.

In this scenario we need to have radius and earth radius is 6,371 kilometer, but distance from earth to International Space Station (ISS) is 408 kilometer, so I added the distance to the original earth radius to get an accurate distance.

### UnitTest
Report generated at the root named `coverage.xml`, I created Services TDD and as a result all services are unit tested.

_Current Status:_
18 tests, 36 assertions
85% files, 44% lines