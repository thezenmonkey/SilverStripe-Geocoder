# SilverStripe Google GeoCoder Class
This is a simple class to speed up Geocoding on DataObjects.

On your DataObject you can call
```php
Geocoder::Geocode($address);
```
The function will return an the folioing array
```php
$array = array("Lat" => "The Latitude", "Lon" => "The Longitude");
```
Errors will be emailed to the Site Admin
