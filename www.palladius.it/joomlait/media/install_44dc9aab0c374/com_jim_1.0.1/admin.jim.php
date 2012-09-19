<?php
/**
* @version 1.0.1
* @package Jim
* @copyright (C) 2006 Laurent Belloeil
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @website www.comeonjoomla.net
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'admin_html' ) );
require_once($mosConfig_absolute_path."/components/com_jim/config.jim.php");
if (file_exists($mosConfig_absolute_path.'/components/com_jim/language/'.$mosConfig_lang.'.php')) {
	require_once($mosConfig_absolute_path.'/components/com_jim/language/'.$mosConfig_lang.'.php');
} else {
	require_once($mosConfig_absolute_path.'/components/com_jim/language/english.php');
}

switch ($task) {

	case "savesettings":
	saveConfig ();
	break;
	
	default:
	showConfig( $JimConfig );
	break;
	
}

function showConfig($JimConfig) {
	global $acl;
	
   //echo $JimConfig["emailnotify"];
    $lists['emailnotify']=yesnoRadioList_M("emailnotify"," class='inputbox' size='2'",$JimConfig["emailnotify"]);
	$lists['link2cb']=yesnoRadioList_M("link2cb"," class='inputbox' size='2'",$JimConfig["link2cb"]);
	$lists['autocomplete']=yesnoRadioList_M("autocomplete"," class='inputbox' size='2'",$JimConfig["autocomplete"]);
	$lists['Jim_css']=yesnoRadioList_M("Jim_css"," class='inputbox' size='2'",$JimConfig["Jim_css"]);
	

	HTML_jim::showConfig($lists,$JimConfig);
}


function saveConfig () {
	
	$configfile = "../components/com_jim/config.jim.php";
	@chmod ($configfile, 0707);
	$permission = is_writable($configfile);
	if (!$permission) {
		mosRedirect("index2.php?option=com_jim",_JIM_CONFIGERROR);
		break;
	}
	

	$emailnotify = mosGetParam($_POST,'emailnotify');
	$msgbox_cols = mosGetParam($_POST,"msgbox_cols");
	$msgbox_rows = mosGetParam($_POST,"msgbox_rows");
	
	$refresh_rate = mosGetParam($_POST,"refresh_rate");
	$hide_user = mosGetParam($_POST,"hide_user");
	$link2cb = mosGetParam($_POST,"link2cb");
	$autocomplete = mosGetParam($_POST,"autocomplete");
	$Jim_css = mosGetParam($_POST,"Jim_css");

	
	
	$c_content= "<?php\n";
	$c_content .= "// ----------------------------------------------------------------------------- //\n";
	$c_content .= "// ----------------------------------------------------------------------------- //\n";
	$c_content .= "// -------------      Jim Private Messaging System       --------------------- //\n";
	$c_content .= "// -------------	           Opensource Version             --------------------- //\n";
	$c_content .= "// ------------- Copyright (c) 2004  By Danial Taherzadeh ---------------------- //\n";
	$c_content .= "// -------------         <www.taher-zadeh.com>	          --------------------- //\n";
	$c_content .= "// ----------------------------------------------------------------------------- //\n";
	$c_content .= "// ----------------------------------------------------------------------------- //\n";
	$c_content .= "// This program is a free software released under GNU GPL license. This program  //\n";
	$c_content .= "// is provided WITHOUT ANY WARRANTY; without even the implied warranty of        //\n";
	$c_content .= "// MERCHANTABILITYor FITNESS FOR A PARTICULAR PURPOSE.                           //\n";
	$c_content .= "// ----------------------------------------------------------------------------- //\n";
	$c_content .= "//             Version : RC1 FR 1.2 											//\n";
	$c_content .= "//             Release date : 09.03.2006  by http://comeonjoomla.net             //\n";
	$c_content .= "//     Based on                  											    //\n";
	$c_content .= "//             Version : RC1      Release date : 18.05.2005                    //\n";
	$c_content .= "// ----------------------------------------------------------------------------- //\n";
	$c_content .= "defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );\n";
	
	$c_content .= "\$JimConfig['emailnotify']=".$emailnotify.";\n";
	$c_content .= "\$JimConfig['msgbox_cols']=".$msgbox_cols.";\n";
	$c_content .= "\$JimConfig[\"msgbox_rows\"]=".$msgbox_rows.";\n";
	$c_content .= "\$JimConfig[\"refresh_rate\"]=".$refresh_rate.";\n";
	$c_content .= "\$JimConfig[\"hide_user\"]=\"".$hide_user."\";\n";
	$c_content .= "\$JimConfig[\"autocomplete\"]=".$autocomplete.";\n";
	$c_content .= "\$JimConfig[\"link2cb\"]=".$link2cb.";\n";
	$c_content .= "\$JimConfig[\"Jim_css\"]=".$Jim_css.";\n";
	$c_content .= "?>\n";
	
	echo $c_content;
		
	if ($fp = fopen("$configfile", "w")) {
		fputs($fp, $c_content, strlen($c_content));
		fclose ($fp);
	}
	mosRedirect("index2.php?option=com_jim", _JIM_CONFIGSAVED);

}

/**
	* Writes a yes/no radio list
	* @param string The value of the HTML name attribute
	* @param string Additional HTML attributes for the <select> tag
	* @param mixed The key that is selected
	* @returns string HTML for the radio list
	*/
	function yesnoRadioList_M( $tag_name, $tag_attribs, $selected, $yes=_CMN_YES, $no=_CMN_NO ) {
		//echo $tag_name.'='.$selected.'<br />';
		$arr = array(
		mosHTML::makeOption( '0', $no, true ),
		mosHTML::makeOption( '1', $yes, true )
		);
		return radioList_M( $arr, $tag_name, $tag_attribs, $selected );
	}

	/**
	* Generates an HTML radio list
	* @param array An array of objects
	* @param string The value of the HTML name attribute
	* @param string Additional HTML attributes for the <select> tag
	* @param mixed The key that is selected
	* @param string The name of the object varible for the option value
	* @param string The name of the object varible for the option text
	* @returns string HTML for the select list
	*/
	function radioList_M( &$arr, $tag_name, $tag_attribs, $selected=null, $key='value', $text='text' ) {
		reset( $arr );
		$html = "";
		for ($i=0, $n=count( $arr ); $i < $n; $i++ ) {
			$k = $arr[$i]->$key;
			$t = $arr[$i]->$text;
			$id = @$arr[$i]->id;

			$extra = '';
			$extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
			if (is_array( $selected )) {
				foreach ($selected as $obj) {
					$k2 = $obj->$key;
					if ($k == $k2) {
						$extra .= " selected=".$selected."\"";
						break;
					}
				}
			} else {
				$extra .= ($t == $selected ? " checked=\"checked\"" : "");
			}
			$html .= "\n\t<input type=\"radio\" name=\"$tag_name\" value=\"".$t."\"$extra $tag_attribs />" . $t;
		}
		$html .= "\n";
		return $html;
	}

