<?php
/**
* AkoLegal - A Mambo Disclaimer Component
* @version 2.0
* @package AkoLegal
* @copyright (C) 2003, 2004 by Arthur Konze - All rights reserved!
* @license http://www.konze.de/content/view/8/26/ Copyrighted Commercial Software
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );
require_once( $mainframe->getPath( 'toolbar_default' ) );

switch ($task) {
  case "config":
    menuakolegal::CONFIG_MENU();
    break;

  case "language";
    menuakolegal::FILE_MENU();
    break;

  case "footer";
    menuakolegal::FILE_MENU();
    break;

  case "about":
    menuakolegal::ABOUT_MENU();
    break;

  default:
    menuakolegal::CONFIG_MENU();
    break;
}
?>
