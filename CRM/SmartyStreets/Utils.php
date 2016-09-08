<?php


class CRM_SmartyStreets_Utils {

  /**
   * Function to add settings object for the liveaddress widget
   *
   * @param null $mappings
   */
  public static function addSmartyStreetsSettings($mappings = null, $customSettings = array()) {
    $var = CRM_Core_Config::singleton();
    $url = $var->extensionsURL;
    $plugin = CRM_Core_Resources::singleton()->getUrl("com.aghstrategies.smartystreets", "liveaddress.jquery.js", true);
    $helper = "//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/3.2/jquery.liveaddress.min.js";
    /*** Get state Abbreviations ***/
    $sql = "SELECT abbreviation, name FROM civicrm_state_province WHERE country_id = 1228";
    $dao = CRM_Core_DAO::executeQuery($sql);
    $abbrevate = array();
    while ($dao->fetch()) {
      $abbrevate[$dao->abbreviation] = $dao->name;
    }
    /*** Get state id's' ***/
    $sql = "SELECT id, name FROM civicrm_state_province WHERE country_id = 1228";
    $dao = CRM_Core_DAO::executeQuery($sql);
    $stateIDs = array();
    while($dao->fetch()){
      $stateIDs[$dao->id] = $dao->name;
    }
    $settings =  CRM_Core_BAO_Setting::getItem("SmartyStreets Settings");
    foreach ($settings as $setting => $value) {
      if($value == ""){
        $settings[$setting] = 0;
      }
    }

    if(!empty($customSettings)) {
      $settings = array_merge($settings, $customSettings);
    }

    $config = array(
      'settings' => $settings,
      'json_abbreviate' => $abbrevate,
      'json_states' => $stateIDs,
      'plugin'=> $plugin,
      'helper' => $helper,
    );

    if ($mappings) {
      $config['Mappings'] = $mappings;
    }

    CRM_Core_Resources::singleton()->addSetting(array('SmartyStreets' => $config));
  }


  /**
   * Add the liveaddress widget to the form.
   */
  public static function addSmartyStreetsWidget() {
    CRM_Core_Resources::singleton()->addScriptUrl('//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/3.2/jquery.liveaddress.min.js', 33, 'html-header');
    CRM_Core_Resources::singleton()->addScriptFile('com.aghstrategies.smartystreets', 'smartystreets.js', 10, 'page-footer');
  }

}