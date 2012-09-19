<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task) {
  case "new":
    menuglossary::NEW_MENU();
    break;

  case "edit":
    menuglossary::EDIT_MENU();
    break;

  case "config":
    menuglossary::CONFIG_MENU();
    break;

  case "about":
    menuglossary::ABOUT_MENU();
    break;

  default:
	menuglossary::DEFAULT_MENU();
    break;
}
?>
