<?php
/**
* @version 1.0.1
* @package Jim
* @copyright (C) 2006 Laurent Belloeil
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @website www.comeonjoomla.net
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class JimOS_html {
	function JimOS_html () {

	}

function notconnected() {
         echo _JIM_NOAUTH;
}

function showInbox ($rows, $pageNav) {
		global $mosConfig_live_site, $mosConfig_absolute_path, $JimConfig;
	?>
	
	<script>	
	function CheckAll(cb) {
		var fmobj = document.jimform;
		for (var i=0;i<fmobj.elements.length;i++) {
			var e = fmobj.elements[i];
			if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
				e.checked = fmobj.allbox.checked;
			}
		}
	}
	</script>
<?php
	include_once($mosConfig_absolute_path."/components/com_jim/jim_showinbox.html.php");
// end of ShowInbox function
}

function showOutbox ($rows, $pageNav) {
		global $mosConfig_live_site, $mosConfig_absolute_path, $JimConfig;
	?>
	
	<script>	
	function CheckAll(cb) {
		var fmobj = document.jimform;
		for (var i=0;i<fmobj.elements.length;i++) {
			var e = fmobj.elements[i];
			if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
				e.checked = fmobj.allbox.checked;
			}
		}
	}
	</script>
<?php
	include_once($mosConfig_absolute_path."/components/com_jim/jim_showoutbox.html.php");
	// end of ShowInbox function
}



function showHeader($page) {
	global $mosConfig_live_site, $mosConfig_absolute_path, $JimConfig;
	if ($JimConfig["Jim_css"]==_CMN_YES)
	{
		include_once($mosConfig_absolute_path."/components/com_jim/header_buttons.html.php");
	} else {
		include_once($mosConfig_absolute_path."/components/com_jim/header_tabs.html.php");
	}
?>
	<div style="clear: left;"></div>
	<div id="jim-body">
<?php
}
function showFooter() {
?>
	</div>
<?php
}


function viewMessage ($row) {
	global $mosConfig_live_site,$JimConfig;
?>
<table cellspacing="0" cellpadding="5" border="0" width="100%">
	<tr>
		<th colspan="2" class="Jimtitle">
		</th>
	</tr>
	<tr class="sectiontableheader">
		<th colspan="2">
<?php 		echo _JIM_VIEWMESSAGE;?>
		</th>
	</tr>

	<tr class="sectiontableentry1">
		<th align="right" width="70"><?php echo _JIM_SUBJECT?>:</th>
		<td><?php echo stripslashes($row->subject)?></td>
	</tr>
	<tr class="sectiontableentry2">
		<th align="right"><?php echo _JIM_FROM?>:</th>
		<td>
<?php
			if ($JimConfig["link2cb"])
{?>
				<a href="index.php?option=com_comprofiler&task=userProfile&user=<?php echo $row->uid?>">
<?php
			}
			echo $row->whofrom;
		
			if ($JimConfig["link2cb"]) {
?>
				</a>
<?php 
			}
?>
			(<?php echo $row->uname?>)
		</td>
	</tr>
	<tr class="sectiontableentry1">
		<th align="right"><?php echo _JIM_SENTDATE?>:</th>
		<td><?php echo $row->date?></td>
	</tr>

	<tr class="sectiontableheader">
		<th colspan="2">
<?php		echo _JIM_MESSAGE;?>
		</th>
	</tr>

	<tr>
		<td colspan="2">
			<table cellspacing="0" cellpadding="5" border="0" width=100%>
				<tr>
					<td>
<?php					echo nl2br( stripslashes($row->message))?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr class="sectiontableentry2">
		<td align="right" colspan="2" >
			<a href="index.php?option=com_jim&task=new&rid=<?php echo $row->id?>" />
				<img src="<?php echo $mosConfig_live_site."/components/com_jim/images/3.png"?>" border="0" align="absmiddle">
<?php 			echo _JIM_REPLY?>
			</a>
|
			<a href="index.php?option=com_jim&task=deletemsg&id=<?php echo $row->id?>" />
				<img src="<?php echo $mosConfig_live_site."/components/com_jim/images/delete.png"?>" border="0" align="absmiddle">
<?php 			echo _JIM_DELETE?>
			</a>
		</td>
	</tr>
</table>
<?php //end of viewMessage function
}


function viewSent ($row) {
	global $mosConfig_live_site, $JimConfig;
?>
<table cellspacing="0" cellpadding="5" border="0" width="100%">
	<tr>
		<th colspan="2" class="Jimtitle">
		</th>
	</tr>
	<tr class="sectiontableheader">
		<th colspan="2">
<?php 		echo _JIM_VIEWMESSAGE;?>
		</th>
	</tr>

	<tr class="sectiontableentry1">
		<th align="right" width="70"><?php echo _JIM_SUBJECT?>:</th>
		<td><?php echo stripslashes($row->subject)?></td>
	</tr>
	<tr class="sectiontableentry2">
		<th align="right"><?php echo _JIM_TO?>:</th>
		<td>
<?php
			if ($JimConfig["link2cb"])
{?>
				<a href="index.php?option=com_comprofiler&task=userProfile&user=<?php echo $row->uid?>">
<?php
			}
			echo $row->username;
		
			if ($JimConfig["link2cb"]) {
?>
				</a>
<?php 
			}
?>
			(<?php echo $row->uname?>)
		</td>
	</tr>
	<tr class="sectiontableentry1">
		<th align="right"><?php echo _JIM_SENTDATE?>:</th>
		<td><?php echo $row->date?></td>
	</tr>

	<tr class="sectiontableheader">
		<th colspan="2">
<?php		echo _JIM_MESSAGE;?>
		</th>
	</tr>

	<tr>
		<td colspan="2">
			<table cellspacing="0" cellpadding="5" border="0" width=100%>
				<tr>
					<td>
<?php					echo nl2br( stripslashes($row->message))?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr class="sectiontableentry2">
		<td align="right" colspan="2" >
			<a href="index.php?option=com_jim&task=leavemsg&id=<?php echo $row->id?>" />
				<img src="<?php echo $mosConfig_live_site."/components/com_jim/images/delete.png"?>" border="0" align="absmiddle">
<?php 			echo _JIM_DELETE?>
			</a>
		</td>
	</tr>
</table>
<?php //end of viewSent function
}


function newMessage ($row, $msgid, $to,$userList, $rtitle,$rmsg, $rid) {
		global $mosConfig_live_site,$JimConfig;

?>
<style type="text/css" media="screen">@import "components/com_jim/includes/actb2.css";</style>		
<script language="javascript" type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/components/com_jim/includes/actb2.js"></script>
<script>
var customarray=new Array(<?php echo $userList;?>);
</script>

<script language="Javascript">
function validate(){
	forma = document.send;

	if (document.send.new_to.value==""){
		alert("<?php echo _JIM_NO_REC?>");
		return 0;
	}
	else {
		document.send.submit();
	}

}
</script>


<table cellspacing="0" cellpadding="5" border="0" class="contentpane" align=center>
     <form method="post" action="index.php" name="send">
          <tr>
               <th colspan="2" class="Jimtitle">
               </th>
          </tr>
          <tr class=sectiontableentry1>
               <td width=10% align="right"><b><?php echo _JIM_TO?>:</b></td>
               <td width=100% class="sectiontableentry2" >
                    <input type="text"  name="new_to" size="30" class="inputbox" value="<?php echo $to;?>"  <?php if ($JimConfig['autocomplete']) { ?> autocomplete="off" onkeydown='actb_checkkey(event);' onkeyup='actb_tocomplete(this,event,customarray)' onblur='actb_removedisp(this)'  onkeypress="return handleEnter(this, event)" <?php } ?>>
               </td>
          </tr>
          <tr>
               <td align="right"><b><?php echo _JIM_SUBJECT?>:</b></td>
               <td>
                   <input type="text" class="inputbox" name="new_title" size="30" value="<?php 
// title forwarding
if ($title) {
	echo $title;
}
else if ($rtitle) {
	echo $rtitle;
}
?>">
               </td>
          </tr>
          <tr >
          <th valign="top" align="right">
<?php echo _JIM_MESSAGE?>:</b></th>
               <td width="100%" class="sectiontableentry2">
                    <textarea name="new_message" class="inputbox" rows="<?php echo $JimConfig["msgbox_rows"];?>" cols="<?php echo $JimConfig["msgbox_cols"];?>">
<?php 
// title forwarding
if ($rmsg) {
	echo $rmsg;
}
?>
</textarea>
               </td>
          </tr>
          <tr>
               <td colspan="2" align="center" class="sectiontableheader">
                    <input name="button" type="button" class="button"  onClick="validate();" value="<?php echo _JIM_SEND?>">
                    <input type="hidden" name="task" value="sendpm">
                    <input type="hidden" name="rid" value="<?php echo $rid?>">
                    <input type="hidden" name="option" value="com_jim">
               </td>
          </tr>
</table>
</form>
<?php
	}
}
?>
