<?php

class Geocoder {
	
	public function Geocode($address) {
		global $_GOOGLE_API;
		//CODE FROM GOOGLE
		//---------------------------------------------------------
		
		// Initialize delay in geocode speed
		$delay = 0;
		$base_url = "http://maps.google.com/maps/geo?output=xml" . "&key=" . KEY;
		
		
		
		// Iterate through the rows, geocoding each address
		$geocode_pending = true;
		
		while ($geocode_pending) {
			//$address = $this->Address." ".$this->City()->Title." Ontario ".$this->PostalCode;
			$request_url = $base_url . "&q=" . urlencode($address);
			$xml = simplexml_load_file($request_url);					
			
			if (!$xml){
				FormResponse::status_message(sprintf($request_url),'bad');
				return FormResponse::respond();
			}
			$status = $xml->Response->Status->code;
			if (strcmp($status, "200") == 0) {
			  // Successful geocode
			  $geocode_pending = false;
			  $coordinates = $xml->Response->Placemark->Point->coordinates;
			  $coordinatesSplit = split(",", $coordinates);
			  // Format: Longitude, Latitude, Altitude
			  $lat = $coordinatesSplit[1];
			  $lng = $coordinatesSplit[0];
			
			  //$this->Lat = $lat;
			  //$this->Lon = $lng;
			  
			  $LatLon = array(
			  	"Lat" => $lat,
			  	"Lon" => $lng
			  );
			  
			  return $LatLon;
			  
			} else if (strcmp($status, "620") == 0) {
			  // sent geocodes too fast
			  $delay += 100000;
			} else {
			  // failure to geocode
			  $geocode_pending = false;
			  $errorMes = "Address " . $address . " failed to geocoded. Received status " . $status . "\n";
			  FormResponse::status_message(sprintf('Invalid query'),'bad');
			  $From = "geocode@mysite.com";
				$To = Email::getAdminEmail();
				$Subject = "GeoCoder Error";
				$body = $errorMes . "Address " . $address . " failed to geocoded. Received status " . $status . "\n";
				$email = new Email($From, $To, $Subject, $body);
				//send mail
				$email->sendPlain();
			  return FormResponse::respond();
			  echo "Address " . $address . " failed to geocoded. ";
			  echo "Received status " . $status . "\n";
			}
		usleep($delay);
		}

	}
	
	
	
}