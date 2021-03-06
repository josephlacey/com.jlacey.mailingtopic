<?php

require_once 'mailingtopic.civix.php';
use CRM_Mailingtopic_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function mailingtopic_civicrm_config(&$config) {
  _mailingtopic_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function mailingtopic_civicrm_xmlMenu(&$files) {
  _mailingtopic_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function mailingtopic_civicrm_install() {
  _mailingtopic_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function mailingtopic_civicrm_postInstall() {
  _mailingtopic_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function mailingtopic_civicrm_uninstall() {
  _mailingtopic_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function mailingtopic_civicrm_enable() {
  _mailingtopic_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function mailingtopic_civicrm_disable() {
  _mailingtopic_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function mailingtopic_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _mailingtopic_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function mailingtopic_civicrm_managed(&$entities) {
  _mailingtopic_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function mailingtopic_civicrm_caseTypes(&$caseTypes) {
  _mailingtopic_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function mailingtopic_civicrm_angularModules(&$angularModules) {
  _mailingtopic_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function mailingtopic_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _mailingtopic_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function mailingtopic_civicrm_entityTypes(&$entityTypes) {
  _mailingtopic_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
 */
function mailingtopic_civicrm_alterMailParams(&$params, $context) {
  //Get all current location types
  $locationTypes = CRM_Core_PseudoConstant::get(
    'CRM_Core_DAO_Address',
    'location_type_id',
    array('labelColumn' => 'display_name'
  ));
  //Find potential mailing topics
  preg_match_all('#\[(.*?)\]#', $params['Subject'], $match);
  //Process the mailing topic
  foreach($match[1] as $key => $mailing_topic_name) {
    //Check if match is a mailing topic
    if ($mailing_topic_id = array_search($mailing_topic_name, $locationTypes)) {
      //Remove mailing topic from outgoing subject
      $params['Subject'] = str_replace($match[0][$key], '', $params['Subject']);
      //If a mailing topic exists, see if the contact has a relevant email
      $default_email = civicrm_api3('Email', 'get', array(
        'sequential' => 1,
        'email' => $params['toEmail'],
        'is_primary' => 1
      ));
      //Don't change if the mailing topic email is already selected as primary
      if ($mailling_topic_id != $default_email['values'][0]['location_type_id']) {
        $mailing_topic_email = civicrm_api3('Email', 'get', array(
          'sequential' => 1,
          'contact_id' => $default_email['values'][0]['contact_id'],
          'location_type_id' => $locationTypes[$mailing_topic_id],
        ));
        //Change email address if it exists
        if ($mailing_topic_email['count'] == 1) {
          $params['toEmail'] = $mailing_topic_email['values'][0]['email'];
        }
      }
    }
  }
}
