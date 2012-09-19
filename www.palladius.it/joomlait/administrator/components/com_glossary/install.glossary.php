<?
// $Id: install.glossary.php,v 1.0 2006/06/24 23:00:00 bzechmann Exp $
/**
* @component: Glossary
* @cms: Joomla/Mambo Component
* @ Autor   : Bernhard Zechmann & Martin Brampton
* @ Website : www.remository.com
* @ Download: 
* @ All rights reserved
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function changeIcon($name,$option,$icon) {
  global $database;
  $database->setQuery( "UPDATE #__components"
  ."\n SET admin_menu_img = '".$icon."'"
  ."\n WHERE name = '".$name."' AND `option` = '".$option."'");
  if (!$database->query()) {
    echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
    exit();
  }	
}

function com_install() {
  global $database;

  echo "Correcting images... ";
  changeIcon("View Terms","com_glossary","js/ThemeOffice/edit.png");
  changeIcon("Categories","com_glossary","js/ThemeOffice/categories.png");
  changeIcon("Edit Config","com_glossary","js/ThemeOffice/config.png");
  changeIcon("About Glossary","com_glossary","js/ThemeOffice/help.png");
  changeIcon("Glossary","com_glossary","../administrator/components/com_glossary/images/icon.png");
  echo "<b>OK</b><br />";
  
  $database->setQuery( "UPDATE #__components"
  ."\n SET link = ''"
  ."\n WHERE name = 'Glossary' AND `option` = 'com_glossary'");
  if (!$database->query()) {
    echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
    exit();
  }	


# Set up new icons for admin menu
/*$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/edit.png' WHERE admin_menu_link='option=com_glossary&task=view'");
$iconresult[0] = $database->query();
$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/config.png' WHERE admin_menu_link='option=com_glossary&task=config'");
$iconresult[1] = $database->query();
$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/user.png' WHERE admin_menu_link='option=com_glossary&task=language'");
$iconresult[2] = $database->query();
$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/credits.png' WHERE admin_menu_link='option=com_glossary&task=about'");
$iconresult[3] = $database->query();
*/


# Show installation result to user
?>
<center>
<table width="100%" border="0">
  <tr>
    <td><img src="components/com_glossary/images/logo.png"></td>&nbsp;
    <td>
      <strong>Glossary Component</strong><br/>
      <font class="small">&copy; Copyright 2006 by Martin Bramton and Bernhard Zechmann</font><br/>
      <br/>
      This component is released under the terms and conditions of the <a href="index2.php?option=com_admisc&task=license">GNU General Public License</a>.
    </td>
  </tr>
  <tr>
    <td>
      <code>Installation: <font color="green">succesfull</font></code>
    </td>
  </tr>
</table>
</center>
<?
}
?>