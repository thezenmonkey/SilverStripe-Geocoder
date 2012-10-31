# SilverStripe Google GeoCoder Class
This is a simple class to speed up Geocoding on DataObjects.
## How to Use
Add the class to your mysite/code directory and add the following lines to your _config.php 
```php
global $_GOOGLE_API;
$_GOOGLE_API = "Your Google API Key";
define("KEY", $_GOOGLE_API);
```
Finally on your DataObject you can call
```php
Geocoder::Geocode($address);
```
The function will return an the folioing array
```php
$array = array("Lat" => "The Latitude", "Lon" => "The Longitude");
```
Errors will be emailed to the Site Admin
