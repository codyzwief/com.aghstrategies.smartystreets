<?php

require_once 'CRM/Core/Page.php';

class CRM_Admin_Page_Download extends CRM_Core_Page {
	function run(){
  ini_set('max_execution_time', 0); //7200 seconds = 2 hours
  /*************/
  require_once 'CRM/Core/DAO/Address.php';
  $address = CRM_Core_DAO_Address::export();
	$sql = 'SELECT address.id, address.contact_id, address.street_address, address.supplemental_address_1, address.supplemental_address_2, address.city, state.name, state.abbreviation, address.postal_code FROM civicrm_address address JOIN civicrm_state_province state ON state.id = address.state_province_id  WHERE contact_id IN (SELECT id FROM `civicrm_contact` WHERE contact_type IN ( "Individual", "Organization", "Household"))';
     $_dao = new CRM_Core_DAO();
     $_dao->query($sql, $i18nRewrite);
     $result = $_dao->getDatabaseResult();
     $total = ($result->numRows());
		while ($result){
			$file = fopen('query.txt', 'w+') or die("Could not open file");
			$array = $result->fetchRow();
			foreach ($array as $line) {
				 fputcsv($file, $line, ";");
			}
			fclose($file);
		}
		fseek($output, 0);
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename=data.csv');
		fpassthru($output);
		ini_set('max_execution_time', 60); //1 minute
	}
}

?>