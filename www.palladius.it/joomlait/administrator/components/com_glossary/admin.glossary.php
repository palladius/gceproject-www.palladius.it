<?
##########################################
# Glossary Component for Mambo			 #
# Copyright  : Martin Brampton			 #
# Homepage 	 : www.remository.com	  	 #
# Version    : 1.9.2	       			 #
# License    : Released under GPL        #
##########################################
# Based on: 							 #
##########################################
# Glossary 1.3 (Michelle Farran)		 #
# and									 #
# AkoBook - A Mambo Guestbook Component! #
# Copyright (C) 2003  by  Arthur Konze   #
# Homepage   : www.mamboportal.com       #
# Version    : 3.0 beta 1                #
# License    : Released under GPL        #
##########################################
# Translation: Arthur Konze              #
# Homepage   : www.konze.de              #
##########################################

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once("components/com_glossary/class.glossary.php");
require_once( $mainframe->getPath( 'admin_html' ) );

$cid = mosGetParam( $_POST, 'cid', array(0) );
if (is_array($cid)) foreach ($cid as $k=>$v) $cid[$k] = intval($v);
else $cid = intval($cid);
$id = intval(mosGetParam($_REQUEST, 'id', 0));


switch ($task) {

  case "categories":
    mosRedirect( "index2.php?option=categories&section=com_glossary" );
    break;

  case "publish":
    publishGlossary( $id, 1, $option );
    break;

  case "unpublish":
    publishGlossary( $id, 0, $option );
    break;

  case "new":
    editGlossary( $option, $database, 0 );
    break;

  case "edit":
    editGlossary( $option, $database, $id[0] );
    break;

  case "remove":
    removeGlossary( $database, $id, $option );
    break;

  case "cancel":
	cancelGlossary( $option );
	break;

  case "save":
    saveGlossary( $option, $database );
    break;

  case "config":
    showConfig( $option );
    break;

  case "savesettings":
    saveConfig ($option, $gl_autopublish, $gl_notify, $gl_notify_email, $gl_thankuser, $gl_perpage, $gl_sorting, $gl_allowentry, $gl_anonentry, $gl_hidedef, $gl_hideauthor, $gl_showcategories, $gl_beginwith, $gl_shownumberofentries, $gl_showcatdescriptions, $gl_useeditor);
    break;

  case "about":
    showAbout();
    break;

  default:
    showGlossary( $option, $database );
    break;
}

echo "<p><font class='small'>&copy; 2005-2006 by <a href='http://www.remository.com/' target='_blank'>Martin Brampton</a> and <a href='http://www.zechmann.com' target='_blank'>Bernhard Zechmann</a></font></p>";


function showGlossary ( $option, &$db ) {
  global $database, $mainframe;

  $catid = $mainframe->getUserStateFromRequest( "catid{$option}", 'catid', 0 );
  $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
  $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
  $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
  $search = $database->getEscaped( trim( strtolower( $search ) ) );

  $where = array();
  if ($catid > 0) {
	$where[] = "catid='$catid'";
  }
  if ($search) {
    $where[] = "LOWER(tterm) LIKE '%$search%'";
  }

  // get the total number of records
  $db->setQuery( "SELECT count(*) FROM #__glossary ".(count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "") );
  $total = $db->loadResult();
  echo $db->getErrorMsg();

  $db->setQuery( "SELECT * FROM #__glossary"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . "\nORDER BY tterm DESC"
    . "\nLIMIT $limitstart,$limit"
  );

  $rows = $db->loadObjectList();
  if ($db->getErrorNum()) {
    echo $db->stderr();
    return false;
  }

  include_once("includes/pageNavigation.php");
  $pageNav = new mosPageNav( $total, $limitstart, $limit  );

  // Source: MOS - admin.weblinks.php
  $database->setQuery( "SELECT a.*, cc.name AS category"
	. "\nFROM #__glossary AS a"
	. "\nLEFT JOIN #__categories AS cc ON cc.id = a.catid"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	. "\nORDER BY a.tterm"
	. "\nLIMIT $pageNav->limitstart,$pageNav->limit"
  );

  $rows = $database->loadObjectList();
  if ($database->getErrorNum()) {
	echo $database->stderr();
	return false;
  }
  
  // get list of categories
  $categories[] = mosHTML::makeOption( '0', 'Select Category' );
  $categories[] = mosHTML::makeOption( '-1', '- All Categories' );
  $database->setQuery( "SELECT id AS value, title AS text FROM #__categories"
	. "\nWHERE section='com_glossary' ORDER BY ordering" );
  $categories = array_merge( $categories, $database->loadObjectList() );

  $clist = mosHTML::selectList( $categories, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"',
	'value', 'text', $catid );

  HTML_Glossary::showGlossaryEntries( $option, $rows, $search, $pageNav, $clist );
}

function removeGlossary( &$db, $cid, $option ) {
  if (count( $cid )) {
    $cids = implode( ',', $cid );
    $db->setQuery( "DELETE FROM #__glossary WHERE id IN ($cids)" );
    if (!$db->query()) {
      echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
    }
  }
  mosRedirect( "index2.php?option=$option" );
}

function publishGlossary( $cid=null, $publish=1,  $option ) {
  global $database;

  if (!is_array( $cid ) || count( $cid ) < 1) {
    $action = $publish ? 'publish' : 'unpublish';
    echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
    exit;
  }

  $cids = implode( ',', $cid );

  $database->setQuery( "UPDATE #__glossary SET published='$publish' WHERE id IN ($cids)" );
  if (!$database->query()) {
    echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
    exit();
  }
  
  mosRedirect( "index2.php?option=$option" );
}

function editGlossary( $option, &$db, $id ) {
  global $mosConfig_absolute_path, $mosConfig_live_site;

  $row = new mosGlossary( $db );

  if ($id) {
    $db->setQuery( "SELECT * FROM #__glossary WHERE id = $id" );
    $rows = $db->loadObjectList();;
    $row = $rows[0];
  } else {
    // initialise new record
    $row->published = 0;
  }

  // make the select list for the image positions
  $yesno[] = mosHTML::makeOption( '0', 'No' );
  $yesno[] = mosHTML::makeOption( '1', 'Yes' );

  // Source: MOS - admin.weblinks.php
  // get list of categories
	$categories[] = mosHTML::makeOption( '0', 'Select Category' );
	$db->setQuery( "SELECT id AS value, name AS text FROM #__categories"
	  . "\nWHERE section='com_glossary' ORDER BY ordering" );
	$categories = array_merge( $categories, $db->loadObjectList() );

	if (count( $categories ) < 1) {
	  mosRedirect( "index2.php?option=categories&section=$option",
	    'You must add a category for this section first.' );
	}

	$clist = mosHTML::selectList( $categories, 'catid', 'class="inputbox" size="1"',
	  'value', 'text', intval( $row->catid ) );


  // build the html select list
  $publist = mosHTML::selectList( $yesno, 'published', 'class="inputbox" size="2"', 'value', 'text', $row->published );

  HTML_Glossary::editGlossary( $option, $row, $publist, $clist );
}

function saveGlossary( $option, &$db ) {
  global $my;

  $row = new mosGlossary( $db );
  if (!$row->bind( $_POST )) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
  $row->_tbl_key = "id";

  if (!$row->store()) {
   echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

  mosRedirect( "index2.php?option=$option" );
}

/**
* Cancels an edit operation
* @param string The current url option
*/
function cancelGlossary( $option ) {
	mosRedirect( "index2.php?option=$option&task=view", "Edit Canceled" );
}

############################################################################

function showConfig( $option ) {
  global $mosConfig_absolute_path;
  require($mosConfig_absolute_path."/administrator/components/com_glossary/config.glossary.php");
?>
    <script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
      var form = document.adminForm;
      if (pressbutton == 'cancel') {
        submitform( pressbutton );
        return;
      }
      if (form.gl_perpage.value == ""){
        alert( "You must set entries per page greater 0!" );
      } else {
        submitform( pressbutton );
      }
    }
    </script>
      <?php
        $yesno[] 	= mosHTML::makeOption( '0', 'No' );
        $yesno[] 	= mosHTML::makeOption( '1', 'Yes' );
        $mybegin[]	= mosHTML::makeOption('all','Show all entries');
        $mybegin[]	= mosHTML::makeOption('nothing','Show nothing');
        $mybegin[]	= mosHTML::makeOption('first','Letter of first found entry');
      ?>
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname">
	    <img src="components/com_glossary/images/logo.png" valign="top">&nbsp;Glossary
      </td>
    </tr>
  </table>	
  <form action="index2.php" method="post" name="adminForm" id="adminForm">
  <script language="javascript" src="js/dhtml.js"></script>
  <table cellpadding="3" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="" class="tabpadding">&nbsp;</td>
      <td id="tab1" class="offtab" onclick="dhtml.cycleTab(this.id)">Backend</td>
      <td id="tab2" class="offtab" onclick="dhtml.cycleTab(this.id)">Frontend</td>
      <td width="90%" class="tabpadding">&nbsp;</td>
    </tr>
  </table>

  <div id="page1" class="pagetext">
  <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminform">
    <tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Autopublish entries:</strong></td>
      <td align="left" valign="top">
      <?php
        $yn_gl_autopublish = mosHTML::selectList( $yesno, 'gl_autopublish', 'class="inputbox" size="2"', 'value', 'text', $gl_autopublish );
        echo $yn_gl_autopublish;
      ?>
      </td>
      <td align="left" valign="top">Autopublish new entries to the glossary.</td>
    </tr>
    <tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Notify webmaster:</strong></td>
      <td align="left" valign="top">
      <?php
        $yn_gl_notify = mosHTML::selectList( $yesno, 'gl_notify', 'class="inputbox" size="2"', 'value', 'text', $gl_notify );
        echo $yn_gl_notify;
      ?>
      </td>
      <td align="left" valign="top">Notify webmaster when new entries arrive.</td>
    </tr>
    <tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Webmaster's email:</strong></td>
      <td align="left" valign="top"><input type="text" name="gl_notify_email" value="<? echo "$gl_notify_email"; ?>"></td>
      <td align="left" valign="top">Email address, where notifications are send to.</td>
    </tr>
    <tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Thank user:</strong></td>
      <td align="left" valign="top">
      <?php
        $yn_gl_thankuser = mosHTML::selectList( $yesno, 'gl_thankuser', 'class="inputbox" size="2"', 'value', 'text', $gl_thankuser );
        echo $yn_gl_thankuser;
      ?>
      </td>
      <td align="left" valign="top">Send 'Thank You' mail to the user.</td>
    </tr>
  </table>
  </div>
  <div id="page2" class="pagetext">
  <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminform">
    <tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Entries per Page:</strong></td>
      <td align="left" valign="top"><input type="text" name="gl_perpage" value="<? echo "$gl_perpage"; ?>"></td>
      <td align="left" valign="top">Number of entries shown per page.</td>
    </tr>
    <tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Allow Entries:</strong></td>
      <td align="left" valign="top">
      <?php
        $yn_gl_allowentry = mosHTML::selectList( $yesno, 'gl_allowentry', 'class="inputbox" size="2"', 'value', 'text', $gl_allowentry );
        echo $yn_gl_allowentry;
      ?>
      </td>
      <td align="left" valign="top">Allow the users to write new entries. (Editors, Publishers, Admins and Super Admins are allways allowed to add entries.)</td>
    </tr>
    <tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Anonymous Entries:</strong></td>
      <td align="left" valign="top">
      <?php
        $yn_gl_anonentry = mosHTML::selectList( $yesno, 'gl_anonentry', 'class="inputbox" size="2"', 'value', 'text', $gl_anonentry );
        echo $yn_gl_anonentry;
      ?>
      </td>
      <td align="left" valign="top">Allow unregistered users to write entries.</td>
    </tr>
    <tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Show Author:</strong></td>
      <td align="left" valign="top">
      <?php
        $yn_gl_hideauthor = mosHTML::selectList( $yesno, 'gl_hideauthor', 'class="inputbox" size="2"', 'value', 'text', $gl_hideauthor );
        echo $yn_gl_hideauthor;
      ?>
      </td>
      <td align="left" valign="top">Show author details like name, location etc.</td>
    </tr>
	<tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Use default Editor:</strong></td>
      <td align="left" valign="top">
      <?php
        $yn_gl_useeditor = mosHTML::selectList( $yesno, 'gl_useeditor', 'class="inputbox" size="2"', 'value', 'text', $gl_useeditor );
        echo $yn_gl_useeditor;
      ?>
      </td>
      <td align="left" valign="top">Yes to use the default editor to add entries or No to use simple textarea</td>
    </tr>
    <tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Show Categories:</strong></td>
      <td align="left" valign="top">
      <?php
        $yn_gl_showcategories = mosHTML::selectList( $yesno, 'gl_showcategories', 'class="inputbox" size="2"', 'value', 'text', $gl_showcategories );
        echo $yn_gl_showcategories;
      ?>
      </td>
      <td align="left" valign="top">If disabled the glossary will only show the first published category</td>
    </tr>
	<tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Show Category Desciptions:</strong></td>
      <td align="left" valign="top">
      <?php
        $yn_gl_showcatdescriptions = mosHTML::selectList( $yesno, 'gl_showcatdescriptions', 'class="inputbox" size="2"', 'value', 'text', $gl_showcatdescriptions );
        echo $yn_gl_showcatdescriptions;
      ?>
      </td>
      <td align="left" valign="top">If disabled the glossary descriptions will not be display on frontend</td>
    </tr>
    <tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Begin with:</strong></td>
      <td align="left" valign="top">
      <?php
        $sel_gl_beginwith= mosHtml::selectList($mybegin,'gl_beginwith','class="inputbox"','value','text',$gl_beginwith);
        echo $sel_gl_beginwith;
      ?>
      </td>
      <td align="left" valign="top">What shall the user see first, when open a categrory</td>
    </tr>
	<tr align="center" valign="middle">
      <td align="left" valign="top"><strong>Show number of entries:</strong></td>
      <td align="left" valign="top">
      <?php
        $yn_gl_shownumberofentries = mosHTML::selectList( $yesno, 'gl_shownumberofentries', 'class="inputbox" size="2"', 'value', 'text', $gl_shownumberofentries );
        echo $yn_gl_shownumberofentries;
      ?>
      </td>
      <td align="left" valign="top">YES shows the number of entries on the frontpage.</td>
    </tr>
  </table>
  </div>
  <script language="javascript" type="text/javascript">dhtml.cycleTab('tab1');</script>
  <input type="hidden" name="id" value="">
  <input type="hidden" name="task" value="">
  <input type="hidden" name="option" value="<?php echo $option; ?>">
</form>
<?php
}

############################################################################

function saveConfig ($option, $gl_autopublish, $gl_notify, $gl_notify_email, $gl_thankuser, $gl_perpage, $gl_sorting, $gl_allowentry, $gl_anonentry, $gl_hidedef, $gl_hideauthor, $gl_showcategories, $gl_beginwith, $gl_shownumberofentries, $gl_showcatdescriptions, $gl_useeditor) {
  $configfile = "components/com_glossary/config.glossary.php";
  @chmod ($configfile, 0766);
  $permission = is_writable($configfile);
  if (!$permission) {
    mosRedirect("index2.php?option=$option&task=config", "Config file not writeable!");
    break;
  }

  $config = "<?php\n";
  $config .= "\$gl_allowentry = \"$gl_allowentry\";\n";
  $config .= "\$gl_autopublish = \"$gl_autopublish\";\n";
  $config .= "\$gl_notify = \"$gl_notify\";\n";
  $config .= "\$gl_notify_email = \"$gl_notify_email\";\n";
  $config .= "\$gl_thankuser = \"$gl_thankuser\";\n";
  $config .= "\$gl_perpage = \"$gl_perpage\";\n";
  $config .= "\$gl_sorting = \"$gl_sorting\";\n";
  $config .= "\$gl_showrating = \"$gl_hidedef\";\n";
  $config .= "\$gl_anonentry = \"$gl_anonentry\";\n";
  $config .= "\$gl_hideauthor = \"$gl_hideauthor\";\n";
  $config .= "\$gl_showcategories = \"$gl_showcategories\";\n";
  $config .= "\$gl_beginwith = \"$gl_beginwith\";\n";
  $config .= "\$gl_shownumberofentries = \"$gl_shownumberofentries\";\n";
  $config .= "\$gl_showcatdescriptions = \"$gl_showcatdescriptions\";\n";
  $config .= "\$gl_useeditor = \"$gl_useeditor\";\n";
  $config .= "?>";

  if ($fp = fopen("$configfile", "w")) {
    fputs($fp, $config, strlen($config));
    fclose ($fp);
  }
  mosRedirect("index2.php?option=$option&task=config", "Settings saved");
}

############################################################################

function showAbout() {
  # Show about screen to user
  HTML_Glossary::showAbout();
}

############################################################################
?>
