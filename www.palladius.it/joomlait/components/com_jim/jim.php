<?php
/**
* @version 1.0.1
* @package Jim
* @copyright (C) 2006 Laurent Belloeil
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @website www.comeonjoomla.net
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$page = mosGetParam($_REQUEST,"task",null);
$action = trim( mosGetParam( $_REQUEST, 'action', null ) ) ;
$rep_i = intval(trim( mosGetParam( $_REQUEST, 'rep_i', 0 )) ) ;
$id = intval(trim( mosGetParam( $_REQUEST, 'id', 0 )) ) ;
$rid = intval(trim( mosGetParam( $_REQUEST, 'rid', 0 )) ) ;
$title = trim(mosGetParam( $_REQUEST, 'title', '' ));

$new_to = trim(mosGetParam( $_REQUEST, 'new_to', '' ));
$new_title = trim(mosGetParam( $_REQUEST, 'new_title', '' ));
$new_message = trim(mosGetParam( $_REQUEST, 'new_message', '' ));



$Itemid = intval( mosGetParam( $_REQUEST, 'Itemid', null ) );

// backward compatibility
if ($page === null) {
	$page = mosGetParam($_REQUEST,"page",'');
}

// backward compatibility
if ($page != 'new') {
	$mid = intval (trim( mosGetParam( $_REQUEST, 'id', null ) ));
}
else {
	$to = trim( mosGetParam( $_REQUEST, 'id', null ) );
}

include_once($mosConfig_absolute_path."/components/com_jim/config.jim.php");
require_once( $mainframe->getPath( 'front_html' ) );

# Get the right language if it exists
if (file_exists($mosConfig_absolute_path.'/components/com_jim/language/'.$mosConfig_lang.'.php')) {
	require_once($mosConfig_absolute_path.'/components/com_jim/language/'.$mosConfig_lang.'.php');
} else {
	require_once($mosConfig_absolute_path.'/components/com_jim/language/english.php');
}

$my_id = $my->id;
$gid = $my->gid;

if (!$my->id){
   JimOS_html::notconnected();
} else {

     switch ($page) {
     
     	case "xml":
     	showXmlOutput();
     	break;
     
     	case "deletemsgs":
     	deleteMessages();
     	break;
     
     	case "deletemsg":
     	deleteSMessage($id);
     	break;
     
     	case "view":
     	showHeader ($page);
     	viewMessage($id);
     	showFooter();
     	break;
     
     	case "viewsent":
     	showHeader ($page);
     	viewSent($id);
     	showFooter();
     	break;
     
     	case "inbox":
     	showHeader ($page);
     	showInbox();
     	showFooter();
     	break;
     
     	case "outbox":
     	showHeader ($page);
     	showOutbox();
     	showFooter();
     	break;
     
     	case "leavemsgs":
     	leaveMessages();
     	break;
     
     	case "leavemsg":
     	leaveSMessage($id);
     	break;
     
     	case "new":
     	showHeader ($page);
     	cnewMessage ( $to, $title);
     	showFooter();
     	break;
     
     	case "sendpm":
     	sendPM($my->username, $new_to , $new_title, $new_message,$rid);
     	break;
     
     	default:
     	showHeader ($page);
     	showInbox();
     	showFooter();
     	break;
     
     }
}
     
     function showXmlOutput() {
     	global $my, $database;
     
     	if ($my->id) {
     		$sql = "SELECT count(*) FROM #__jim "
     		."\n WHERE username='$my->username' AND readstate=0";
     
     		$database->setQuery($sql);
     		$howmany = $database->loadResult();
     
     		header('Content-Type: text/xml');
     		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
     		header("Cache-Control: no-store, no-cache, must-revalidate");
     		header("Cache-Control: post-check=0, pre-check=0", false);
     		header("Pragma: no-cache");
     
               echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'; ?>
               
               <response>
                 <method>doCheck</method>
                 <result><?php echo $howmany;?></result>
               </response>
               <?php
     	}
     }
     
     function showHeader ($page) {
     	JimOS_html::showHeader($page);
     }
     function showfooter () {
     	JimOS_html::showFooter();
     }
     
     function showInbox () {
     	global $database,$my;
     
     	$limit = intval( mosGetParam( $_REQUEST, 'limit', 10) );
     	$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
     
     	$query = "SELECT count(id) FROM #__jim WHERE username='$my->username'";
     	$database->setQuery($query);
     	$total = $database->loadResult();
     
     	if ($total <= $limit) {
     		$limitstart = 0;
     	}
     
     	$database->setQuery("SELECT j.*, u.id as uid FROM #__jim as j  "
     	. "\n left join #__users as u on u.username=j.whofrom"
     	. "\n WHERE j.username='$my->username'"
     	. "\n order by j.date desc"
     	. "\n LIMIT $limitstart, $limit");
     
     	$rows = $database->loadObjectList();
     
     	require_once("includes/pageNavigation.php");
     	$pageNav = new mosPageNav( $total, $limitstart, $limit );
     
     	JimOS_html::showInbox($rows, $pageNav);
     
     }
     
     function showOutbox () {
     	global $database,$my;
     
     	$limit = intval( mosGetParam( $_REQUEST, 'limit', 10) );
     	$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
     
     	$query = "SELECT count(id) FROM #__jim WHERE whofrom='$my->username'";
     	$database->setQuery($query);
     	$total = $database->loadResult();
     
     	if ($total <= $limit) {
     		$limitstart = 0;
     	}
     /* SELECT j.*, u.name as uname,u.id as uid 
     	FROM jos_jim as j
     	left join jos_users as u on u.username=j.whofrom
     	WHERE (j.whofrom='globule' and j.outbox=1)
     	order by j.date desc
     */
     	$jimquery ="SELECT j.*, u.name as uname,u.id as uid "
     	."\nFROM #__jim as j"
     	."\n left join #__users as u on u.username=j.username"
     	."\n WHERE (j.whofrom='$my->username' and j.outbox=1)"
     	. "\n order by j.date desc";
     	$database->setQuery($jimquery);
     
     	$rows = $database->loadObjectList();
     
     	require_once("includes/pageNavigation.php");
     	$pageNav = new mosPageNav( $total, $limitstart, $limit );
     
     	JimOS_html::showOutbox($rows, $pageNav);
     
     }
     
     function deleteMessages() {
     	global $database,$my;
     
     	$inb_delete = trim( mosGetParam( $_POST, 'delm', null ) );
     
     	if (isset($inb_delete))
     	{
     		// get the list of message IDs to be deleted in an array
               $del_ids =   mosGetParam( $_POST, 'delete', array() ) ;
     
     		// Ensure to be INT values
               array_walk($del_ids,"intval");
     
     		// convert to a comma separated string list and remove right spaces (chop)
               $del_ides_c =chop( implode(",",array_keys($del_ids)));
     
     		if ($del_ides_c !== "") {
     			$database->setQuery("delete from #__jim where id in ($del_ides_c) and username='$my->username'");
     
     			if ($database->query()) {
     				mosRedirect("index.php?option=com_jim",_JIM_MSG_DELETED );}
     				else
     				{
     					mosRedirect("index.php?option=com_jim",_JIM_ERROR );}
     		}
     		else
     		{
     			mosRedirect("index.php?option=com_jim",_JIM_SELECT_TO_DELETE );}
     	}
     }
     
     function leaveMessages() {
     	global $database,$my;
     	$inb_delete = trim( mosGetParam( $_POST, 'leaveme', null ) );
     
     	if (isset($inb_delete))
     	{
     		$del_ids =   mosGetParam( $_POST, 'leave', array() ) ;
     		array_walk($del_ids,"intval");
     		$del_ides_c =chop( implode(",",array_keys($del_ids)));
     
     		if ($del_ides_c !== "") {
     			$jimquery = "update #__jim set outbox=0 where id in ($del_ides_c) and whofrom='$my->username'";
     			$database->setQuery($jimquery);
     
     			if ($database->query())
     			{
     				$jimmessage = _JIM_MSG_DELETED;
     			} else	{
     				$jimmessage = _JIM_ERROR;
     			}
     		}
     		else
     		{
     			$jimmessage = _JIM_SELECT_TO_DELETE ;
     		}
     		
     			//$jimmessage = _JIM_MSG_DELETED . $jimquery; //for debug
     		mosRedirect("index.php?option=com_jim&task=outbox", $jimmessage );
     	}
     }
     
     function leaveSMessage ($id) {
     	global $my, $database;
     
     	$id = intval($id);
     
     	if ($id ) {
     		$jimquery = "update #__jim set outbox=0 where id=$id and whofrom='$my->username'";
     		$database->setQuery($jimquery);
     
     		if ($database->query()) {
     			//$jimmessage = _JIM_MSG_DELETED . $jimquery; //for debug
     			mosRedirect('index.php?option=com_jim&task=outbox', $jimmessage);
     		}
     	}
     }
     
     function deleteSMessage ($id) {
     	global $my, $database;
     
     	$id = intval($id);
     
     	if ($id ) {
     		$database->setQuery("delete from #__jim where id=$id and username='$my->username'");
     
     		if ($database->query()) {
     			mosRedirect('index.php?option=com_jim',_JIM_MSG_DELETED);
     		}
     	}
     }
     
     
     
     function viewMessage ($mid) {
     	global $database, $my;
     
     	$database->setQuery("SELECT j.*, u.name as uname,u.id as uid FROM #__jim as j"
     	."\n left join #__users as u on u.username=j.whofrom"
     	."\n WHERE j.id=$mid and j.username='$my->username'");
     	$rows = $database->loadObjectList();
     	$row = $rows[0];
     
     	if ( count($rows) > 0 )
     	{
     		if ($row->readstate == 0)
     		{
     			$database->setQuery("update #__jim set readstate='1' where id='$mid'");
     			$database->query();
     		}
     		JimOS_html::viewMessage($row);
     	}
     }
     
     function viewSent ($mid) {
     	global $database, $my;
     
     	$jimquery ="SELECT j.*, u.name as uname,u.id as uid, u.username as username"
     	."\nFROM #__jim as j"
     	."\n left join #__users as u on u.username=j.username"
     	."\n WHERE (j.id=$mid and j.whofrom='$my->username' and j.outbox=1)";
          $database->setQuery($jimquery);
     
     	$rows = $database->loadObjectList();
     	$row = $rows[0];
     
     	if ( count($rows) > 0 )
     	{
     		JimOS_html::viewSent($row);
     	}
     }
     
     
     function  cnewMessage ( $to, $title) {
     	global $database,$JimConfig;
     
     	// Autocomplete feature (search user)
     
     	$rid = intval(mosGetParam($_REQUEST,"rid",0));
     	$query = "SELECT id, name, username FROM #__users"
     	.(($JimConfig['hide_user'])?"\n where username not in ('". $JimConfig['hide_user']."')":"\n"); 
     	$database->setQuery($query);	
     
     	$rows = $database->loadObjectList();
     	echo $database->getErrorMsg();
     
     	if (count($rows)) {
     		foreach ($rows as $t_row) {
     			$t_userList[] = "'".$t_row->username."'";
     		}
     	}
     
     	if ($rid) {
     		$query = "SELECT whofrom, subject, message FROM #__jim"
     		."\n where id= $rid";
     
     		$database->setQuery($query);
     		$r_rows = $database->loadObjectList();
     		$rtitle = $r_rows[0]->subject;
     		$rmsg = $r_rows[0]->message;
     		$to = $r_rows[0]->whofrom;
     
     		$quote = sprintf( _JIM_REPLY_QUOTE, $to);
     
     		$rmsg = "\n\n". str_replace( "\n" , "\n" . ">", $quote. "\n" . $rmsg ) . "\n";
         $rmsg = str_replace( "\'" , "'", $rmsg);
     
     		if (strpos($rtitle, _JIM_RE) === false ) {
           $rtitle = "\n\n". str_replace( "\'" , "'", $rtitle);
     			$rtitle=_JIM_RE.$rtitle;
     		}
     
     
     	}
     	$userList = implode(",",$t_userList);
     
     	JimOS_html::newMessage($row, $title, $to,$userList, $rtitle,$rmsg, $rid);
     
     }
     
     function sendPM ($who, $to , $title, $message,$rid) {
     	global $mosConfig_offset, $my, $database, $JimConfig,$mosConfig_sitename, $mosConfig_live_site;
     	global $mosConfig_mailfrom;
     	$rid = intval(mosGetParam($_REQUEST,"rid",0));
     	$now = date( "Y-m-d H:i:s", time() + $mosConfig_offset*60*60 );
     	$database->setQuery("select count(id) from #__users where username = '$to'");
     	$user_exists = $database->loadResult();
     	
     	if ($user_exists == 0 ) {
     		mosRedirect('index.php?option=com_jim',_JIM_USERDOESNTEXIST);
     	}
     	
     	$title = removeEvilTags(addslashes($title));
     	$message=removeEvilTags(addslashes($message));
     	$to=removeEvilTags(addslashes($to));
     
     	if (chop ($title) == '')
     	{
     		$title = _JIM_NONE;
     	}
     
     	$database->setQuery("INSERT INTO #__jim ( id, username, whofrom, date, readstate, subject, message) VALUES "
     	."\n ('','$to','$my->username','$now',0,'$title','$message')");
     
     	if( $database->query()) {
     
     		if ($JimConfig["emailnotify"]) {
     
     			$database->setQuery("select name, email from #__users"
     			."\n where username= '$to'");
     
     			$mail_user = $database->loadObjectList();
     			$mail_to = $mail_user[0]->email;
     			$mail_user_name = $mail_user[0]->name;
     
     			$m_sub = sprintf( _JIM_MAILSUB, $mosConfig_sitename);
     			$m_msg = sprintf( _JIM_MAILMSG,  $mail_user_name, $my->username,$mosConfig_sitename, $mosConfig_live_site,$mosConfig_sitename );
     
     			$head= "MIME-Version: 1.0\n";
     			$head .= "Content-type: text/html; charset=iso-8859-1\n";
     			$head .= "X-Priority: 1\n";
     			$head .= "X-MSMail-Priority: High\n";
     			$head .= "X-Mailer: php\n";
     			$head .= "From: \"".$mosConfig_sitename."\" <".$mosConfig_mailfrom.">\n";
     
     			@mail($mail_to, $m_sub, $m_msg, $head);
     		}
               if ($rid){
          		mosRedirect('index.php?option=com_jim', _JIM_REPLY_SENT);             
               }else{
          		mosRedirect('index.php?option=com_jim', _JIM_MSG_SENT);
               }
     
     	}
     }
     
     
     
     
     $allowedTags = '';
     
     /**
     * Disallow these attributes/prefix within a tag
     */
     $stripAttrib = 'javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|'.
     'onmousemove|onmouseout|onkeypress|onkeydown|onkeyup';
     
     /**
     * @return string
     * @param string
     * @desc Strip forbidden tags and delegate tag-source check to removeEvilAttributes()
     */
     function removeEvilTags($source)
     {
     	global $allowedTags;
     	$source = strip_tags($source, $allowedTags);
     	return preg_replace('/<(.*?)>/ie', "'<'.removeEvilAttributes('\\1').'>'", $source);
     }
     
     /**
     * @return string
     * @param string
     * @desc Strip forbidden attributes from a tag
     */
     function removeEvilAttributes($tagSource)
     {
     	global $stripAttrib;
     	return stripslashes(preg_replace("/$stripAttrib/i", 'forbidden', $tagSource));
     }
