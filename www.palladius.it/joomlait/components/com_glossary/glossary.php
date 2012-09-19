<?php
##########################################
# Glossary Component for Mambo			 #
# Copyright  : Martin Brampton	         #
# Homepage   : www.remository.com    	 #
# Version    : 1.9.2  	                 #
# License    : Released under GPL        #
##########################################
# Based on			         			#	 										 #
##########################################
# AkoBook - A Mambo Guestbook Component! #
# Copyright (C) 2003  by  Arthur Konze   #
# Homepage   : www.mamboportal.com       #
# Version    : 3.0 beta 1                #
# License    : Released under GPL        #
##########################################

# Don't allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

# Get the right language if it exists
if (file_exists('components/com_glossary/languages/'.$mosConfig_lang.'.php')) {
  require_once('components/com_glossary/languages/'.$mosConfig_lang.'.php');
} else {
  require_once('components/com_glossary/languages/english.php');
}

# Variables - Don't change anything here!!!
require_once( $mainframe->getPath( 'front_html' ) );
require_once( $mainframe->getPath( 'class' ) );
$glversion = "V1.9.2";
$catid=mosGetParam( $_REQUEST, 'catid',0 );
$func=mosGetParam( $_REQUEST, 'func','' );
$letter = mosGetParam ($_REQUEST, 'letter', '');
if ($letter) $letter = substr($letter,0,10);

$glossary = new glossaryGlossary;

$mainframe->setPageTitle(_GLOSSARY_TITLE);


function GlossaryABC(&$glossary, $letter, $page=1){
    global $Itemid, $catid;
	$myabc = $glossary->abcplus_key();
	$nav = '<div align=center>';
	foreach ($glossary->abcplus() as $i=>$ltrval) {
		$key = $myabc[$i];
		if ($letter == $key) $nav .= "<b>$ltrval</b>";
		else {
			$url = sefRelToAbs("index.php?option=com_glossary&func=display&letter=$key&Itemid=$Itemid&catid=$catid&page=$page");
			$nav .= "<a href='$url'>$ltrval</a>";
		}
		$nav .= ' | ';
	}
	return substr($nav,0,strlen($nav)-3)."\n</div>\n\n";  // end of HTML
}

# Functions of Glossary
function GlossaryHeader(&$glossary, $letter, $catid=0) {
    global $Itemid, $database, $my, $is_editor;
    ?>
    <table class='contentpaneopen' width="100%">
    <tr><td><div class='componentheading'>
    <?php
	if ($catid != 0) {
	    $database->setQuery("SELECT title FROM #__categories WHERE id = '$catid'");
	    echo $database->loadResult();
		?>
		</div></td></tr>
		<?php
		if ($glossary->gl_showcatdescriptions) {
		  echo "<tr><td colspan='2'>";
		  $database->setQuery("SELECT description FROM #__categories WHERE id = '$catid'");
	      echo $database->loadResult();
		  echo "<br /></td /></tr />";
		}
		?>		
		</table>
		<table class='contentpaneopen' width="100%">
		<tr><td><form action='index.php' method=get>
		<input type='hidden' name='option' value='com_glossary'>
		<input type='hidden' name='catid' value='<?php echo $catid; ?>'>
		<input type='hidden' name='func' value='display'>
		<input type="text" class="inputbox" name="search" size=10 value="<?php echo _GLOSSARY_SEARCHSTRING ?>"
        <button type="submit" class="button"><?php echo _GLOSSARY_SEARCHBUTTON ?></button>
		</form></td>
		<td align='right'>
		<?php
	    if ($glossary->gl_showcategories) {
	    	$url = sefRelToAbs("index.php?option=com_glossary&Itemid=$Itemid");
      		echo'<a href="'.$url.'">'._GLOSSARY_VIEW.'</a>';
      	}
		# BZE: only show, if entries are allowed or is_editor
        # Check for Editor rights
        $is_editor = (strtolower($my->usertype) == 'editor' || strtolower($my->usertype) == 'publisher' || strtolower($my->usertype) == 'manager' || strtolower($my->usertype) == 'administrator' || strtolower($my->usertype) == 'super administrator' );

	    if (($glossary->gl_allowentry) OR ($is_editor)) {
	    	$url = sefRelToAbs("index.php?option=com_glossary&letter=$letter&catid=$catid&Itemid=$Itemid&func=submit");
			echo '<br><a href="'.$url.'">'._GLOSSARY_SUBMIT.'</a>';
		}
	    ?>
	    </td></tr><tr><td colspan="2"><br />
	    <?php echo GlossaryABC($glossary, $letter); ?>
	    <br /><br /></td></tr><tr><td colspan='2'>
	    <?php
	}
	else {
    	echo _GLOSSARY_TITLE;
    	?>
		</div></td></tr>
		<?php
		if ($glossary->gl_showcatdescriptions) {
		  echo "<tr><td colspan='2'>";
		  $database->setQuery("SELECT description FROM #__categories WHERE id = '$catid'");
	      echo $database->loadResult();
		  echo "<br /></td /></tr />";
		}
		?>
		<tr><td colspan="2">
		<?php
	}
}

function GlossaryFooter(&$glossary, $letter, $catid) {
    global $glversion,$func;
    echo '<br/><br/>';
	if ($catid <> '' AND $func <> 'submit') {
	    echo GlossaryABC($glossary, $letter);
	    echo '<br/><br/>';
	}
	?>
    </td></tr></table width="50%">
	<center><span class="small"><a href="http://www.remository.com/" target="_blank">
	Glossary <?php echo $glversion; ?></a></span></center>
	<?php
}

function is_email($email) {
    return preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email);
}

function textwrap($text, $width = 75) {
	if ($text) return preg_replace("/([^\n\r ?&\.\/<>\"\\-]{".$width."})/i"," \\1\n",$text);
}

function showTerms(&$glossary, $catid, $letter) {
	global $Itemid, $database, $page, $mosConfig_dbprefix, $search, $my, $is_editor;
	if (!$letter) {
		$count_query = '';
	  	switch ($glossary->gl_beginwith){
			case 'all':
  				$letter='All';
  				echo "<font size='4'><strong>"._GLOSSARY_ALL."</strong></font>";
  				break;
  			case 'first':
  				$sql="SELECT tterm FROM ".$mosConfig_dbprefix."glossary WHERE published = 1 AND catid=$catid Order BY tterm ASC";
  				$letter_result=$database->setquery($sql);
  				$row=$database->loadObjectList();
  				$letter=ucfirst(substr($row->tterm,0,1));
  				if (!in_array($letter,glossaryGlossary::abc())) $letter="Other";
  				echo "<font size='4'><strong>$letter</strong></font>";
  				break;
  			default:
  				$letter='[nothing]';
  				echo "<font size='2'><strong>"._GLOSSARY_SELECT."</strong></font>";
  				break;
  		}
  	}
	else {
  		if ($letter=='All') {
		  $count_query  = "SELECT id FROM ".$mosConfig_dbprefix."glossary WHERE published = 1 AND catid=$catid";
		  echo "<font size='4'><strong>"._GLOSSARY_ALL."</strong></font>";
		}
  		elseif ($letter=='Other') {
		  $count_query  = "SELECT id FROM ".$mosConfig_dbprefix."glossary WHERE published = 1 AND catid=$catid AND tterm NOT RLIKE \"^\[A-Za-z]\"";
		  echo "<font size='4'><strong>"._GLOSSARY_OTHER."</strong></font>";
		}
  		elseif ($letter=='[nothing]') {
		  $count_query  = "";
		  echo "";
		}
  		else {
  			$letter = $database->getEscaped($letter);
			$count_query  = "SELECT id FROM ".$mosConfig_dbprefix."glossary WHERE published = 1 AND catid=$catid AND tterm LIKE '$letter%'";
			echo "<font size='4'><strong>".$letter."</strong></font>";
		}
	}
	# Feststellen der Anzahl der verfügbaren Datensätze
	if (!$count_query) {
	  $count_query  = "SELECT id FROM ".$mosConfig_dbprefix."glossary WHERE published = 1 AND catid=$catid";
	}
	
	$count_result = $database->setquery($count_query);
	$count_result = $database->query();
	$count        = mysql_num_rows($count_result);
	# Berechnen der Gesamtseiten
	$gesamtseiten = floor($count / $glossary->gl_perpage);
	$seitenrest   = $count % $glossary->gl_perpage;
	if ($seitenrest>0) $gesamtseiten++;
	# Feststellen der aktuellen Seite
	if (isset($page)) {
		if ($page > $gesamtseiten) $page = $gesamtseiten;
		elseif ($page < 1) $page = 1;
	}
	else $page = 1;
	# BZE show number of entries
	if ($glossary->gl_shownumberofentries) {
	   	echo '<p>'._GLOSSARY_BEFOREENTRIES." $count "._GLOSSARY_AFTERENTRIES.'<br/>';
	}
	echo '<br/>';
	
	if ($letter=='[nothing]') {
	  echo "";
	  echo "<table width='100%' border='0' cellspacing='1' cellpadding='4'>";
	} else {
	  echo '<br/>'._GLOSSARY_PAGES.' ';
  	  # Ausgeben der Seite zurueck Funktion
	  $seiterueck = $page - 1;
	  if ($seiterueck > 0) echo '<a href="'.sefRelToAbs("index.php?option=com_glossary&func=display&letter=$letter&page=$seiterueck&catid=$catid&Itemid=$Itemid").'"><b>«</b></a>';
	  
	  #Ausgeben der einzelnen Seiten
	  for ($i=1; $i <= $gesamtseiten; $i++) {
		if ($i==$page) echo "$i ";
		else {
			$url = sefRelToAbs("index.php?option=com_glossary&func=display&letter=$letter&page=$i&catid=$catid&Itemid=$Itemid");
			echo '<a href="'.$url."\">$i</a> ";
        }
	  }
	  # Ausgeben der Seite vorwärts Funktion
	  $seitevor = $page + 1;
	  if ($seitevor<=$gesamtseiten) {
		$url = sefRelToAbs("index.php?option=com_glossary&func=display&letter=$letter&Itemid=$Itemid&catid=$catid&page=$seitevor");
		echo '<a href="'.$url.'"><b>»</b></a> ';
  	  }
	  # Limit und Seite Vor- & Rueckfunktionen
	  $start = ( $page - 1 ) * $glossary->gl_perpage;
	  // Database Query
	?>
	  </p>
	  <br>
	  <table width="100%" border="0" cellspacing="1" cellpadding="4">
	  <tr><td width="30%" height="20" class="sectiontableheader"> <?php echo _GLOSSARY_TERM; ?> </td>
	  <td width="70%" height="20" class="sectiontableheader"> <?php echo _GLOSSARY_DEFINITION; ?> </td></tr>
	<?php
	}
	$line = 1;
	$sqlsuffix = "WHERE published=1 AND catid=$catid";
  	if ($search) $sqlsuffix .= " AND tdefinition LIKE \"%$search%\" OR tterm LIKE \"%$search%\"";
	elseif ($letter) {
		#if ($letter == 'Other') $sqlsuffix .= " AND tterm REGEXP \"^\[1-9]\"";
		if ($letter == 'Other') $sqlsuffix .= " AND tterm NOT RLIKE \"^\[A-Za-z]\"";
		elseif ($letter != 'All') $sqlsuffix .= " AND tterm LIKE \"$letter%\"";
    }
  	// get the total number of records
  	if (!isset($start)) $start = 0;
	$query1=" SELECT * FROM ".$mosConfig_dbprefix."glossary $sqlsuffix ORDER BY tterm LIMIT $start,$glossary->gl_perpage ";
	$database->setQuery($query1);
	$items = $database->loadObjectList();
	if ($items) {
		foreach ($items as $row1) {
			$linecolor = ($line % 2) + 1;
			echo "<tr class='sectiontableentry".$linecolor."'><td width='30%' valign='top'><a name='$row1->id'></a><b>$row1->tterm</b>";
			if($glossary->gl_hideauthor){
				$row1->tname = textwrap($row1->tname,20);
				if ($row1->tname<>""){
					if ($row1->tpage<>"") {
						# Check if URL is in right format
						if (substr($row1->tpage,0,7)!="http://") $row1->tpage="http://$row1->tpage";
						echo "<br><a href='$row1->tpage' target='_blank'><span class='small'>"._GLOSSARY_AUTHOR.": $row1->tname</span></a>";
					}
					else echo '<br><span class="small">'._GLOSSARY_AUTHOR.": $row1->tname</span>";
				}
			}
			echo '</td><td valign=top>';
			echo textwrap($row1->tdefinition,80);
			if ($row1->tcomment) {
				$origcomment = $row1->tcomment;
				echo "<hr><span class='small'><b>"._GLOSSARY_ADMINSCOMMENT.":</b> $origcomment</span>";
			}
			echo "</td></tr>";
			echo "<tr class='sectiontableentry".$linecolor."'><td width='30%' valign='top'>";
			echo "&nbsp;</td>";
			echo "<td width='70%' valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
			if ($is_editor) {
				echo "<td align='left'><b>"._GLOSSARY_ADMIN.":</b> ";
				echo "<a href='".sefRelToAbs("index.php?option=com_glossary&Itemid=$Itemid&func=comment&letter=$letter&id=$row1->id&catid=$row1->catid")."'>"._GLOSSARY_ACOMMENT."</a> - ";
				if ($row1->tcomment) echo "<a href='".sefRelToAbs("index.php?option=com_glossary&letter=$letter&Itemid=$Itemid&func=comment&opt=del&id=$row1->id&catid=$row1->catid")."'>"._GLOSSARY_ACOMMENTDEL."</a> - ";
				echo "<a href='".sefRelToAbs("index.php?option=com_glossary&Itemid=$Itemid&func=submit&letter=$letter&id=$row1->id&catid=$row1->catid")."'>"._GLOSSARY_AEDIT."</a> - ";
				echo "<a href='".sefRelToAbs("index.php?option=com_glossary&Itemid=$Itemid&func=delete&letter=$letter&id=$row1->id&catid=$row1->catid")."'>"._GLOSSARY_ADELETE."</a></td>";
			}
			echo '</tr></table>';
			$line++;
		}
		}
	echo "</table>";
}

    // Check for Editor rights
    $is_editor = (strtolower($my->usertype) == 'editor' || strtolower($my->usertype) == 'publisher' || strtolower($my->usertype) == 'manager' || strtolower($my->usertype) == 'administrator' || strtolower($my->usertype) == 'super administrator' );
    $is_user   = (strtolower($my->usertype) <> '');
    
    switch ($func) {
		case 'popup':
			// get the record
	        GlossaryHeader($glossary, $letter);
			$template = $mainframe->getTemplate();
			$database->setQuery( "SELECT tterm, tdefinition FROM #__glossary WHERE id='$term' AND published=1");
			$rows = $database->loadObjectList();
	        $row = $rows[0];
	        ?>
			<h1 class='contentHeading'>
			<? echo $row->tterm; ?>
			</h1>
	        <p>
			<? echo $row->tdefinition; ?>
	        <p><a href='javascript:history.go(-1);'><span class="small">Back</span></a>
	        <?
			break;
		#########################################################################################
		case 'search':
			GlossaryHeader($glossary, $letter, $catid);
			HTML_glossary::searchHTML();
			break;
		#########################################################################################
		case 'delete':
			GlossaryHeader($glossary, $letter, $catid);
			HTML_glossary::deleteHTML($letter, $catid);
			break;
		#########################################################################################
		case 'comment':
			GlossaryHeader($glossary, $letter, $catid);
			HTML_glossary::commentHTML($letter, $catid);
			break;
		#########################################################################################
		case 'entry':
			global $ttext,$id;
			# Clear any HTML
			$ttext = strip_tags($ttext);
			# Check if entry was edited by editor
			$tname = $database->getEscaped($tname);
			$tmail = $database->getEscaped($tmail);
			$tloca = $database->getEscaped($tloca);
			$tpage = $database->getEscaped($tpage);
			$tterm = $database->getEscaped($tterm);
			$tdefinition = $database->getEscaped($tdefinition);
			if (($is_editor) AND ($id)) {
				$query1 = "UPDATE #__glossary SET catid='$catid', tname='$tname', tmail='$tmail', tloca='$tloca', tpage='$tpage', tterm='$tterm', tdefinition='$tdefinition' WHERE id=$id";
				$database->setQuery( $query1 );
				$database->query();
			}
			else {
				$tip   = getenv('REMOTE_ADDR');
				$tdate = date("y/m/d g:i:s");
				$query2 = "INSERT INTO #__glossary SET catid='$catid',tname='$tname',tdate='$tdate',tmail='$tmail', tloca='$tloca', tpage='$tpage', tterm='$tterm', tdefinition='$tdefinition'";
				if ($glossary->gl_autopublish) $query2 .= ",published='1'";
				$database->setQuery( $query2 );
				$database->query();
				if ($glossary->gl_notify AND is_email($glossary->gl_notify_email) ) {
					$tmailtext = _GLOSSARY_ADMINMAIL."\r\n\r\nName: ".$tname."\r\nText: ".$tterm."\r\n\r\n"._GLOSSARY_MAILFOOTER;
					mail($glossary->gl_notify_email,_GLOSSARY_ADMINMAILHEADER,$tmailtext,"From: ".$glossary->gl_notify_email);
				}
				if ($glossary->gl_thankuser AND is_email($tmail) ) {
					$tmailtext = _GLOSSARY_USERMAIL."\r\n\r\nName: ".$tname."\r\nText: ".$tterm."\r\n\r\n"._GLOSSARY_MAILFOOTER;
					mail($tmail,_GLOSSARY_USERMAILHEADER,$tmailtext,"From: ".$glossary->gl_notify_email);
				}
			}
			echo "<SCRIPT> alert('"._GLOSSARY_SAVED."'); document.location.href='index.php?option=com_glossary&func=display&letter=$letter&Itemid=$Itemid&catid=$catid';</SCRIPT>";
			break;
		#########################################################################################
		case 'submit':
			GlossaryHeader($glossary, $letter);
			if (($glossary->gl_allowentry) OR ($is_editor)) {
			  HTML_glossary::submitHTML($glossary, $letter, $catid);
			break;
			}
		#########################################################################################
		case 'display':
			GlossaryHeader($glossary, $letter, $catid);
			showTerms($glossary, $catid, $letter);
			break;
		#########################################################################################
		default:
			$func = '';
			if ($glossary->gl_showcategories) {
				GlossaryHeader($glossary, $letter);
				$database->setQuery( "SELECT * FROM #__categories WHERE section='com_glossary' AND published=1 ORDER BY ordering" );
				$categories = $database->loadObjectList();
				if (count( $categories ) > 1 || (count( $categories ) < 2 )) {
					foreach ($categories as $row2) {
						if ($row2->access<=$gid) {
							echo "<img src='images/M_images/arrow.png' /> <a href='index.php?option=com_glossary&func=display&Itemid=$Itemid&catid=$row2->id'>$row2->name</A><br />";
							# BZE, description for categories
							if ($glossary->gl_showcatdescriptions) {
							  echo "$row2->description<br />";
							}
							if($row2->count > 0) echo "<i>(".$row2->numitems." "._CHECKED_IN_ITEMS.")</i>";
						}
						else {
							echo $row2->name;
							?>
							<a href="<?php echo sefRelToAbs("index.php?option=com_comprofiler&amp;task=registers"); ?>">
							( <?php echo _E_REGISTERED; ?> )</a>
							<?php
						} ?>
						<br />
						<?php
					}
				}
			}
			else{
				$database->setQuery("SELECT id FROM #__categories WHERE section='com_glossary' AND published=1 ORDER BY ordering");
				$catid = $database->loadResult();
				GlossaryHeader($glossary, $letter, $catid);
				showTerms($glossary, $catid, $letter);
			}
			break;
    }
    GlossaryFooter($glossary, $letter, $catid);

?>
