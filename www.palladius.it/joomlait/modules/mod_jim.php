<?php
/**
* @version 1.0.0
* @package Jim
* @copyright (C) 2006 Laurent Belloeil
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @website www.comeonjoomla.net
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// Main Url
$url="$mosConfig_absolute_path/components/com_jim";

global $JimConfig,$option;
if (file_exists( "$url/language/$mosConfig_lang.php" )){
	include_once( "$url/language/$mosConfig_lang.php" ) ;
}else{
	include_once( "$url/language/english.php" ) ;
}
if (!isset($JimConfig)) {
	require_once($mosConfig_absolute_path."/components/com_jim/config.jim.php");
}

if ($JimConfig["Jim_css"]==_CMN_YES){
?>
	<style type="text/css" media="screen">@import "components/com_jim/buttons.css";</style>		
<?php
}else{
?>
	<style type="text/css" media="screen">@import "components/com_jim/tabs.css";</style>		
<?php
}

?>
<div class="table.moduletable">
<!--before connection-->
<div id="mesg"><?php echo _JIM_CONNECTING;?>...</div>

<script>
var the_count = 0;
var the_timeout;
var req;

checkMail();
function checkMail()
{
	doCheck('','');
	the_timeout = setTimeout("checkMail();", <?php echo $JimConfig["refresh_rate"];?>000);
}

function loadXMLDoc(url)
{
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
		req.onreadystatechange = processReqChange;
		req.open("GET", url, true);
		req.send(null);

	} else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
		if (req) {
			req.onreadystatechange = processReqChange;
			req.open("GET", url, true);
			req.send();

		}
	}
}

function doCheck(input, response)
{
	if (response != ''){
		divid  = document.getElementById('mesg');

		if (response > 0) {
			image_in = '<img src="<?php echo $mosConfig_live_site?>/components/com_jim/images/0.png" align="absmiddle" border="0"> ';
			}
			else {
			image_in = '<img src="<?php echo $mosConfig_live_site?>/components/com_jim/images/1.png" align="absmiddle" border="0"> ';
			}
			module_in =  "<a href='index.php?option=com_jim' class='pmmodule'>" + image_in  +	response + ' <?php echo _JIM_UHAVE;?>' + "</a>";;
			
				divid.innerHTML= module_in;
		}
	else
	{
		url  = 'index2.php?option=com_jim&task=xml&no_html=1';
		loadXMLDoc(url);
	}

}


function processReqChange()
{
	if (req.readyState == 4) {
		if (req.status == 200) {
			response  = req.responseXML.documentElement;
			method    = response.getElementsByTagName('method')[0].firstChild.data;
			result    = response.getElementsByTagName('result')[0].firstChild.data;
			eval(method + '(\'\', \''+ result+'\')');
		} else {
			alert("There was a problem retrieving the XML data:\n" + req.statusText);
		}
	}
}
</script>
</div>
