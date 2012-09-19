<?php
/**
* @version 1.0.1
* @package Jim
* @copyright (C) 2006 Laurent Belloeil
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @website www.comeonjoomla.net
*/

function com_install ()
{
	
	mosRedirect("index2.php?option=com_jim","Jim Successfully Installed");
	
}
require_once($mosConfig_absolute_path."/components/com_jim/readme.txt");

?>
                                          
