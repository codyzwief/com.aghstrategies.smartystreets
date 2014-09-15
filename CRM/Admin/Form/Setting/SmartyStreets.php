<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.4                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2013                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*/

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2013
 * $Id: Display.php 36505 2011-10-03 14:19:56Z lobo $
 *
 */

/**
 * This class generates form components for the display preferences
 *
 */
class CRM_Admin_Form_Setting_SmartyStreets extends CRM_Admin_Form_Setting {
		
	public $_settings;
	
  function preProcess() {
    $this->_settings = CRM_Core_BAO_Setting::getItem(SMARTYSTREETS_SETTINGS);	
    parent::preProcess();
  }

  function buildQuickForm() {
  	$element =& $this->add('text', 'HTML_KEY', ts('Required. Your SmartyStreets API key.'),  array('size' => CRM_Utils_Type::HUGE), true);
    
    $element =& $this->add('checkbox',
      'auto_verify',
      ts(' Verify the address as the user types it in')
    );
    $element =& $this->add('checkbox',
      'geolocate',
      ts('Whether to attempt to show autocomplete results in the user\'s city based on their IP address.')
    );
    $element =& $this->add('select','autocomplete',
      ts('The number of suggestions to show while the user types a street line. Set to 0 or false to disable autocomplete. Note: Address suggestions are not necessarily valid. The addresses must still go through verification.'),
      array(0,1,2,3,4,5,6,7,8,9,10)
    );
      $element =& $this->add('select','candidates',
      ts('The number of matches to return when the address response is ambiguous. Note: If you set this to 1, all ambiguous addresses will appear to be perfectly valid instead.'),
      array(0,1,2,3,4,5,6,7,8,9,10)
      );
    $element =& $this->add('textarea',
      'invalid',
      ts('Default: "Address not verified" The message to display when an address is invalid. Should be short.')
    );
    $element =& $this->add('textarea',
      'ambiguous',
      ts('Default: "Choose the correct address" The message to display when an address is ambiguous. Should be short.')
    );
    $element =& $this->add('checkbox',
      'debug',
      ts('If true, debug and log info will be printed to the console, and mapped fields will be highlighted and labeled.')
    );
    $element =& $this->add('checkbox',
      'UI',
      ts('Provide and execute the default UI for handling address verification results. Disable this to use your own interface.')
    );
    parent::buildQuickForm();
  }
  
	 function setDefaultValues() {
	 	$defaults =  CRM_Core_BAO_Setting::getItem("SmartyStreets Settings");
    return $defaults;
  }
  
   public function postProcess(){
    // store the submitted values in an array
    $params = $this->exportValues();
    // set all necessary values in the settings table
    CRM_Core_BAO_Setting::setItem($params["HTML_KEY"], "SmartyStreets Settings", "HTML_KEY");
    CRM_Core_BAO_Setting::setItem($params["auto_verify"], "SmartyStreets Settings", "auto_verify");
    CRM_Core_BAO_Setting::setItem($params["geolocate"], "SmartyStreets Settings", "geolocate");
    CRM_Core_BAO_Setting::setItem($params["invalid"], "SmartyStreets Settings", "invalid");
    CRM_Core_BAO_Setting::setItem($params["ambiguous"], "SmartyStreets Settings", "ambiguous");
    CRM_Core_BAO_Setting::setItem($params["UI"], "SmartyStreets Settings", "UI");
    CRM_Core_BAO_Setting::setItem($params["debug"], "SmartyStreets Settings", "debug");
    CRM_Core_BAO_Setting::setItem($params["autocomplete"], "SmartyStreets Settings", "autocomplete");
    CRM_Core_BAO_Setting::setItem($params["candidates"], "SmartyStreets Settings", "candidates");
    // return message
    CRM_Core_Session::setStatus(ts('SmartyStreets Settings have been Updated'));
  } //end of function
} // end class

