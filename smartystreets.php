<?php

require_once 'smartystreets.civix.php';

function smartystreets_civicrm_buildForm($formName, &$form){
  if ($formName != "CRM_Contribute_Form_Contribution_Confirm") {
    CRM_SmartyStreets_Utils::addSmartyStreetsWidget();
  }
}

function smartystreets_civicrm_alterContent( &$content, $context, $tplName, &$object ) {
  $tpl = explode("/", $tplName);
  if($context = "form" && $tpl[1] != "Report"){
    CRM_SmartyStreets_Utils::addSmartyStreetsSettings();
  }
}

function smartystreets_civicrm_navigationMenu( &$params ) {
  // Add menu entry for extension administration page
  _smartystreets_civix_insert_navigation_menu($params, 'Administer/Localization', array(
    'name'       => 'SmartyStreets API Configuration',
    'url'        => 'civicrm/admin/setting/smartystreets',
    'permission' => 'administer CiviCRM',
  ));
  /* _smartystreets_civix_insert_navigation_menu($params, 'Administer/Customize Data and Screens', array(
     'name'       => 'SmartyStreets List Import/Export',
     'url'        => 'civicrm/admin/setting/smartystreets_lists',
     'permission' => 'administer CiviCRM',
   ));*/
}
/**
 * Implementation of hook_civicrm_config
 */
function smartystreets_civicrm_config(&$config) {
  _smartystreets_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function smartystreets_civicrm_xmlMenu(&$files) {
  $files[] = dirname(__FILE__)."/xml/Menu/smartystreets.xml";
}

/**
 * Implementation of hook_civicrm_install
 */
function smartystreets_civicrm_install() {
  return _smartystreets_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function smartystreets_civicrm_uninstall() {
  return _smartystreets_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function smartystreets_civicrm_enable() {
  $invalidMessage = "Address not verified";
  $ambiguousMessage = "Choose the correct address";
  CRM_Core_BAO_Setting::setItem(1, "SmartyStreets Settings", "auto_verify");
  CRM_Core_BAO_Setting::setItem(1, "SmartyStreets Settings", "geolocate");
  CRM_Core_BAO_Setting::setItem(1, "SmartyStreets Settings", "UI");
  CRM_Core_BAO_Setting::setItem(0, "SmartyStreets Settings", "debug");
  CRM_Core_BAO_Setting::setItem("10", "SmartyStreets Settings", "autocomplete");
  CRM_Core_BAO_Setting::setItem("3", "SmartyStreets Settings", "candidates");
  CRM_Core_BAO_Setting::setItem($invalidMessage, "SmartyStreets Settings", "invalid");
  CRM_Core_BAO_Setting::setItem($ambiguousMessage, "SmartyStreets Settings", "ambiguous");
  $session = CRM_Core_Session::singleton();
  $session->replaceUserContext(CRM_Utils_System::url('civicrm/admin/setting/smartystreets'));
  return _smartystreets_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function smartystreets_civicrm_disable() {
  return _smartystreets_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function smartystreets_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _smartystreets_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function smartystreets_civicrm_managed(&$entities) {
  return _smartystreets_civix_civicrm_managed($entities);
}
