<?
/**
* AkoLegal - A Mambo Disclaimer Component
* @version 2.0
* @package AkoLegal
* @copyright (C) 2003, 2004 by Arthur Konze - All rights reserved!
* @license http://www.konze.de/content/view/8/26/ Copyrighted Commercial Software
**/

function com_install() {
global $database;

# Set up new icons for admin menu
$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/config.png' WHERE admin_menu_link='option=com_akolegal&task=config'");
$iconresult[0] = $database->query();
$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/user.png' WHERE admin_menu_link='option=com_akolegal&task=language'");
$iconresult[1] = $database->query();
$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/user.png' WHERE admin_menu_link='option=com_akolegal&task=footer'");
$iconresult[2] = $database->query();
$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/credits.png' WHERE admin_menu_link='option=com_akolegal&task=about'");
$iconresult[3] = $database->query();

# Show installation result to user
?>
<center>
<table width="100%" border="0">
  <tr>
    <td><img src="components/com_akolegal/images/logo.png"></td>
    <td>
      <strong>AkoLegal - footer and legal information component</strong><br/>
      <font class="small">&copy; Copyright 2004 by Arthur Konze</font><br/>
    </td>
  </tr>
</table>
</center>
<?
}
?>