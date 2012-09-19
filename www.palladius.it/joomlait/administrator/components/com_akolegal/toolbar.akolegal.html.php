<?php
/**
* AkoLegal - A Mambo Disclaimer Component
* @version 2.0
* @package AkoLegal
* @copyright (C) 2003, 2004 by Arthur Konze - All rights reserved!
* @license http://www.konze.de/content/view/8/26/ Copyrighted Commercial Software
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
class menuakolegal {
  function CONFIG_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::save( 'savesettings', 'Save Settings' );
    mosMenuBar::back();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }
   function FILE_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::save( 'savefile', 'Save File' );
    mosMenuBar::cancel();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }
  function ABOUT_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::back();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }
}
?>
