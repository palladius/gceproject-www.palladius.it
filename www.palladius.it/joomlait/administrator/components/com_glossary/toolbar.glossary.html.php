<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


class menuglossary {

  
function NEW_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::save();
	mosMenuBar::spacer();
    mosMenuBar::cancel();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

  
function EDIT_MENU() {
    mosMenuBar::startTable();
	mosMenuBar::save();
    mosMenuBar::spacer();
	mosMenuBar::cancel();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

  
function CONFIG_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::save( 'savesettings', 'Save' );
    mosMenuBar::back();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

  
function ABOUT_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::back();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

   
function DEFAULT_MENU() {
    mosMenuBar::startTable();
	mosMenuBar::publishList();
	mosMenuBar::spacer();
	mosMenuBar::unpublishList();
	mosMenuBar::spacer();
    mosMenuBar::addNew();
	mosMenuBar::spacer();
    mosMenuBar::editList();
	mosMenuBar::spacer();
    mosMenuBar::deleteList();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

}
?>
