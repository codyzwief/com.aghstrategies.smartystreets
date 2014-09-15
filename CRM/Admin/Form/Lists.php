<?php

class CRM_Admin_Form_Lists extends CRM_Admin_Form {
		
	public $_settings;
	
  function preProcess() {
    $this->_settings = CRM_Core_BAO_Setting::getItem("Smartystreets Settings");	
    parent::preProcess();
  }

  function buildQuickForm() {
  	$element =& $this->add('text', 'csv_path', ts('Required. Absolute Path to the everything.csv file.'),  array('size' => CRM_Utils_Type::HUGE), true);    
    parent::buildQuickForm();
  }
  
   public function postProcess(){
   	$params = $this->exportValues();
   	//$file = "/srv/www/odbdev/everything.csv";
   	$file = $params["csv_path"];
    // set all necessary values in the settings table
    ini_set('max_execution_time', 7200); //7200 seconds = 2 hours 
    $var = CRM_Core_Config::singleton();
		$url = $var->extensionsURL;
    if (file_exists($file)) { 
	    $handle = fopen($file,"r"); 
      $row = fgetcsv($handle,0,",","'");
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
      	if($value == "AddonCode"){
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
      		$address_id = $key;
      	}
      	
      	if($value == "[contact_id]"){
      		$contact_id = $key;
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
	    		  
	    		  if($row[$addOnZip] != ""){
	    		  	$additionalZip == $row[$addOnZip];
	    		  } else {
	    		  	$additionalZip == NULL;
	    		  }
	    		  
	    		  /*** break up street address ***/
            if (($pos = strpos($row[$street_address_line], "Apt")) !== FALSE) { 
    					$aptString = substr($row[$street_address_line], $pos); 
    					$arr = explode("Apt", $row[$street_address_line]);
              $new_street_line = $arr[0];
						} elseif  (($pos = strpos($row[$street_address_line], "#")) !== FALSE) { 
    						$aptString = substr($row[$street_address_line], $pos); 
    						$arr = explode("#", $row[$street_address_line]);
              	$new_street_line = $arr[0];
						} elseif  (($pos = strpos($row[$street_address_line], "Unit")) !== FALSE) { 
    						$aptString = substr($row[$street_address_line], $pos); 
    						$arr = explode("Unit", $row[$street_address_line]);
              	$new_street_line = $arr[0]; 
            } else {
								$new_street_line = $row[$street_address_line];
								$aptString = NULL;
						}
						
	    		  $street_array = explode(",", $new_street_line);
	    		  $streets = explode(" ", $street_array[0]);
	    		  if (end($streets) == "") { 
                array_pop($streets); 
            }
	    		  $street_number = $streets[0];
	    		  $suffix = preg_replace("/[^a-z,A-z.]/", "", $street_number);
	    		  $street_type = array_pop($streets);	    		  
	    		  $post = $street_array[1];
	    		  $sql="";
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
           	       	street_unit = "'.$aptString.'",
           	       	timezone = "'.$timezone.'"           	       	
           	      WHERE id = '.$row[$address_id].' AND contact_id = '.$row[$contact_id];
           	if(is_numeric($row[$address_id]) && $row[$street_address_line] != ""){
          		$dao = CRM_Core_DAO::executeQuery($sql);
           	}
        }
      }
      ini_set('max_execution_time', 60); //1 minute
    }
  } //end of function
} // end cla