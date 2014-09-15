<?php
require_once 'CRM/Core/Page.php';
	//$file = $_FILES[csv_upload][tmp_name];
    $file = "/srv/www/odbdev/everything.csv";
	    $handle = fopen($file,"r"); 
      $countFirstRow = false;
      $row = fgetcsv($handle,1000,",","'");
      foreach ($row as $key => $value){
      	if($value == "DeliveryLine1"){
      		$street_address_line = $key;
      	}
      	if($value == "DeliveryLine2"){
      		$supp_address_1 = $key;
      	}
      	if($value == "City"){
      		$city = $key;
      	}
      	if($value == "State"){
      		$state_abb = $key;
      	}
      	if($value == "FullZIPCode"){
      		$postal_code = $key;
      	}
      	if($value == "ADDonCode"){
      		$addOnZip = $key;
      	}
      	if($value == "CountyName"){
      		$countyName = $key;
      	}
      	if($value == "Latitude"){
      		$geo_code_1 = $key;
      	}
      	if($value == "Longitude"){
      		$geo_code_2 = $key;
      	}
      	if($value == "[id]"){
      		$address_id= $key;
      	}
      	if($value == "TimeZone"){
      		$time = $key;
      	}
      	if($value == "UTCOffset"){
      		$UTC = $key;
      	}
      }
      while ($row = fgetcsv($handle,1000,",","'")) {
        if ($row[$street_address_line] != "DeliveryLine1") {
        	  /*** get state id ***/
        	  if($row[$state_abb] != ""){
        	  	$sql = 'SELECT id FROM civicrm_state_province WHERE abbreviation = "'.$row[$state_abb].'" AND country_id = "1228"';
		        	$dao = CRM_Core_DAO::executeQuery($sql);
		        	while ($dao->fetch()) {
	      				$state = $dao->id; 
	    				}
        	  }
	    		  /*** get county id ***/
	    		  if($row[$countyName] != "") {
	    		  	$sql = 'SELECT id FROM civicrm_county WHERE name = "'.$row[$countyName].'" AND state_province_id = "'.$state.'"';
		        	$dao = CRM_Core_DAO::executeQuery($sql);
		        	while ($dao->fetch()) {
	      				$county = $dao->id; 
	    				}
	    		  }
	    		  /*** get timezone info ***/
	    		  if($row[$time] != "None"){
	    		  	$timezone = "UTC".$row[$UTC];
	    		  } else {
	    		  	$timezone = NULL;
	    		  }
	    		  /*** break up street address ***/
	    		  $street_array = explode(",", $row[$street_address_line]);
	    		  $streets = explode(" ", $street_array[0]);
	    		  $street_number = $streets[0];
	    		  $suffix = preg_replace("/[^a-z,A-z.]/", "", $street_number);
	    		  $street_type = array_pop($streets);
        	  $sql = 'UPDATE civicrm_address SET 
           	       	street_address = "'.$row[$street_address_line].'",
           	       	supplemental_address_1 = "'.$row[$supp_address_1].'",
           	       	city = "'.$row[$city].'",
           	       	state_province_id = "'.$state.'",
           	       	postal_code = "'.$row[$postal_code].'",
           	       	postal_code_suffix = "'.$row[$addOnZip].'",
           	       	geo_code_1 = "'.$row[$geo_code_1].'",
           	       	geo_code_2 = "'.$row[$geo_code_2].'",
           	       	county_id = "'.$county.'",
           	       	street_number = "'.$street_number.'",
           	       	street_number_suffix = "'.$suffix.'",
           	       	street_type = "'.$street_type.'",
           	       	street_number_postdirectional = "'.$post.'",
           	       	timezone = "'.$timezone.'"           	       	
           	      WHERE id = '.$row[$address_id];
           	if(is_int($row[$address_id])){
          		$dao = CRM_Core_DAO::executeQuery($sql);
           	}
        }
      }
?>