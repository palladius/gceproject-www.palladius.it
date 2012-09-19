<?php

// Part of Glossary, copyright (c) Martin Brampton 2005.
// For further information please refer to http://www.remository.com

# Don't allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class glossary_row {
	var $tname = '';
	var $tmail = '';
	var $tpage = '';
	var $tloca = '';
	var $tterm = '';
	var $tdefinition = '';
}

class HTML_glossary {

	function deleteHTML ($letter, $catid) {
		global $my, $is_editor, $is_admin, $Itemid, $database;
		$id = intval(mosGetParam( $_REQUEST, 'id', 0 ));
		$submit = mosGetParam($_POST,'submit','');

		# Main Part of Subfunction
		if ($is_editor){
			if ($submit) {
				$sql = "DELETE FROM #__glossary WHERE id='$id'";
				$database->setquery($sql);
				$database->query();
				echo "<script type='text/javascript'> alert('"._GLOSSARY_DELMESSAGE."'); document.location.href='index.php?option=com_glossary&func=display&Itemid=$Itemid&letter=$letter&catid=$catid';</script>";
			}
			else {
				$sql="SELECT * FROM #__glossary WHERE id = '$id'";
				$database->setQuery($sql);
				$database->loadObject($row);
				#Show the Original Entry
				echo "<table width='100%' border='0' cellspacing='1' cellpadding='4'>";
				echo "<tr><td width='30%' height='20' class='sectiontableheader'>"._GLOSSARY_TERM."</td>";
				echo "<td width='70%' height='20' class='sectiontableheader'>"._GLOSSARY_DEFINITION."</td></tr>";
				echo "<tr class='sectiontableentry1'><td width='30%' valign='top'><b>$row->tname</b><br/>";
				if ($row->tloca) echo "<br /><span class='small'>"._GLOSSARY_FROM." $row->tloca</span>";
				if ($row->tmail) echo "<a href='mailto:$row->tmail'><img src='components/com_glossary/images/email.gif' alt='$row->tmail' hspace='3' border='0'></a>";
				if ($row->tpage) echo "<a href='$row->tpage' target='_blank'><img src='components/com_glossary/images/homepage.gif' alt='$row->tpage' hspace='3' border='0'></a>";
				echo "$row->tdate</td>";
				$origtext = preg_replace("/(\015\012)|(\015)|(\012)/","&nbsp;<br />", $row->tdefinition);
				echo "<td width='70%' valign='top'><span class='small'>$row->tterm<hr></span>$origtext</td></tr>";
				echo "</table>";
				echo "<form method='post' action='index.php?option=com_glossary&Itemid=$Itemid&func=delete&id=$id'>";
				echo "<input type='hidden' name='catid' value='$catid'>";
				echo "<input type='hidden' name='letter' value='$letter'>";
				echo "<input class='button' type='submit' name='submit' value='"._GLOSSARY_ADELETE."'></form>";
			}
		}
		else {
			$url = sefRelToAbs("index.php?option=com_glossary&Itemid=$Itemid");
			echo "<p><a href='$url'>Back</a></p>";
		}
	}
	
	function searchHTML () {
		
	}
	
	function commentHTML ($letter, $catid) {
		global $Itemid, $is_editor, $database;
		# Javascript for SmilieInsert and Form Check
		?>
		<script type="text/javascript">
		function validate(){
			if (document.glossaryForm.tcomment.value==''){ }
			else {
				document.glossaryForm.action = 'index.php';
				document.glossaryForm.submit();
			}
		}
		</script>
		<?php
		# Main Part of Subfunction
		if ($is_editor){
			$id=intval(mosGetParam( $_REQUEST, 'id',0 ));
			if (mosGetParam( $_REQUEST, 'opt','' )=='del'){
				$sql = "UPDATE #__glossary SET tcomment='' WHERE id=$id";
				$database->setQuery($sql);
				$database->query();
				echo "<script> alert('"._GLOSSARY_COMMENTDELETED."'); document.location.href='index.php?option=com_glossary&func=display&letter=$letter&Itemid=$Itemid&catid=$catid';</script>";
			}
			else {
				$tcomment = mosGetParam($_POST,'tcomment','');
				if ($tcomment) {
					$tcomment = $database->getEscaped($tcomment);
					$sql = "UPDATE #__glossary SET tcomment='$tcomment' WHERE id=$id";
					$database->setQuery($sql);
					$database->query();
					echo "<script> alert('"._GLOSSARY_COMMENTSAVED."'); document.location.href='index.php?option=com_glossary&func=display&letter=$letter&Itemid=$Itemid&catid=$catid';</script>";
				}
				else {
					$tname = mosGetParam($_POST,'tname','');
					$sql="SELECT * FROM #__glossary WHERE id = '$id'";
					$database->setQuery($sql);
					$database->loadObject($row);
					#Show the Original Entry
					echo "<table width='100%' border='0' cellspacing='1' cellpadding='4'>";
					echo "<tr><td width='30%' height='20' class='sectiontableheader'>"._GLOSSARY_NAME."</td>";
					echo "<td width='70%' height='20' class='sectiontableheader'>"._GLOSSARY_ENTRY."</td></tr>";
					echo "<tr class='sectiontableentry1'><td width='30%' valign='top'><b>".$row->tterm."</b>";
					if ($tname<>"") echo "<br /><span class='small'>"._GLOSSARY_AUTHOR.": ".$row->tname."</span>";
					echo "</td>";

					echo "<td width='70%' valign='top'><span class='small'>"._GLOSSARY_SIGNEDON." $row->tdate<hr></span>$row->tdefinition</td></tr>";
					echo "<tr class='sectiontableentry1'><td width='30%' valign='top'>";
					if ($row->tloca<>"") echo _GLOSSARY_FROM."<span class='small'>: ".$row->tloca."</span><br>";
					if ($row->tmail<>"") echo "<a href='mailto:".$row->tmail."'><img src='components/com_glossary/images/email.gif' alt='".$row->tmail."' hspace='3' border='0'></a>";
					if ($row->tpage<>"") echo "<a href='".$row->tpage."' target='_blank'><img src='components/com_glossary/images/homepage.gif' alt='".$row->tpage."' hspace='3' border='0'></a>";
					echo "</td></tr>";
					# Admins Comment here
					echo "<form name='glossaryForm' action='index.php' target='_top' method='post'>";
					echo "<input type='hidden' name='id' value='$id'>";
					echo "<input type='hidden' name='letter' value='$letter'>";
					echo "<input type='hidden' name='catid' value='$catid'>";
					echo "<input type='hidden' name='option' value='com_glossary'>";
					echo "<input type='hidden' name='Itemid' value='$Itemid'>";
					echo "<input type='hidden' name='func' value='comment'>";
					echo "<tr class='sectiontableentry2'><td valign='top'><b>"._GLOSSARY_ADMINSCOMMENT."</b><br /><br />";
					echo "</td>";
					echo "<td valign='top'><textarea cols='40' rows='8' name='tcomment' class='inputbox' wrap='virtual'>".$row->tcomment."</textarea></td></tr>";
					echo "<tr><td><input type='button' name='send' value='"._GLOSSARY_SENDFORM."' class='button' onclick='submit()'></td>";
					echo "<td align='right'><input type='reset' value='"._GLOSSARY_CLEARFORM."' name='reset' class='button'></td></tr></form></table>";
				}
			}
		}
		else echo "<p><a href='index.php?option=com_glossary&Itemid=$Itemid'>Back</a></p>";
	}
	
	function submitHTML (&$glossary, $letter, $catid) {
		global $my, $is_editor, $is_admin, $is_user, $database, $Itemid;
		global $mosConfig_absolute_path;
        require($mosConfig_absolute_path."/administrator/components/com_glossary/config.glossary.php");
		$id= intval(mosGetParam( $_REQUEST, 'id',0 ));
		# Check if Registered Users only
		if (!$glossary->gl_anonentry AND !$is_user) echo _GLOSSARY_ONLYREGISTERED;
		else {
			# Javascript for SmilieInsert and Form Check
			?>
			<script type="text/javascript">
			function validate(){
				//if ((document.glossaryForm.tname.value=='') || (document.glossaryForm.tterm.value=='') || (document.glossaryForm.tdefinition.value=='') || (document.glossaryForm.catid.value=='0')){
				if ((document.glossaryForm.tname.value=='') || (document.glossaryForm.tterm.value=='') || (document.glossaryForm.catid.value=='0')){
					alert("<?php echo _GLOSSARY_VALIDATE; ?>");
				}
				else {
					document.glossaryForm.action = 'index.php';
					document.glossaryForm.submit();
				}
			}
			</script>
			<table align='center' width='90%' cellpadding='0' cellspacing='4' border='0'>
			<form name='glossaryForm' action='index.php' target='_top' method='post'>
			<?php
			# Check if User is Admin and if he wants to edit
			if ((($is_editor) OR ($is_admin)) AND ($id)) {
				echo "<input type='hidden' name='id' value='$id'>";
				$sql="SELECT * FROM #__glossary WHERE id='$id'";
				$database->setQuery($sql);
				$database->loadObject($row);
			}
			// get list of categories
			$categories[] = mosHTML::makeOption( '0', _SEL_CATEGORY );
			$database->setQuery( "SELECT id AS value, name AS text FROM #__categories WHERE section='com_glossary' ORDER BY ordering" );
			$categories = array_merge( $categories, $database->loadObjectList() );
			if (count( $categories ) < 1) {
				mosRedirect( "index2.php?option=categories&section=$option",
				'You must add a category for this section first.' );
			}
			if (!isset($row)) $row = new glossary_row;
			$clist = mosHTML::selectList( $categories, 'catid', 'class="inputbox" size="1"','value', 'text', intval($catid));
			echo "<input type='hidden' name='option' value='com_glossary'>";
			echo "<input type='hidden' name='letter' value='$letter'>";
			echo "<input type='hidden' name='Itemid' value='$Itemid'>";
			echo "<input type='hidden' name='func' value='entry'>";
			//echo "<input type='hidden' name='catid' value='$catid'>";
			echo "<tr><td width='130'>"._GLOSSARY_ENTERNAME."</td><td><input type='text' name='tname' style='width:245px;' class='inputbox' value='$row->tname'></td></tr>";
			echo "<tr><td width='130'>"._GLOSSARY_ENTERMAIL."</td><td><input type='text' name='tmail' style='width:245px;' class='inputbox' value='$row->tmail'></td></tr>";
			echo "<tr><td width='130'>"._GLOSSARY_ENTERPAGE."</td><td><input type='text' name='tpage' style='width:245px;' class='inputbox' value='$row->tpage'></td></tr>";
			echo "<tr><td width='130'>"._GLOSSARY_ENTERLOCA."</td><td><input type='text' name='tloca' style='width:245px;' class='inputbox' value='$row->tloca'></td></tr>";
			echo "<tr><td width='130'>&nbsp;</td><td>&nbsp;</td></tr>";
			echo "<tr><td width='130'>"._GLOSSARY_GLOSSARY."</td><td>$clist</td></tr>";
			echo "<tr><td width='130'>"._GLOSSARY_ENTERTERM."</td><td><input type='text' name='tterm' style='width:245px;' class='inputbox' value='$row->tterm'></td></tr>";
			echo "<tr><td width='130' valign='top'>"._GLOSSARY_ENTERDEFINITION."<br /><br />";
			echo "</td><td valign='top' width='420'>";
			
			if ($glossary->gl_useeditor) {
			  getEditorContents( 'editor1', 'tdefinition' );
			  editorArea( 'editor1', $row->tdefinition, 'tdefinition', '400', '100', '50', '20' );
			} 
			else {		
			  echo "<textarea style='width:245px;' rows='8' name='tdefinition' class='inputbox' wrap='virtual'>$row->tdefinition</textarea>";
			}
			echo "</td></tr>";
			echo "<tr><td width='130'><input type='button' name='send' value='"._GLOSSARY_SENDFORM."' class='button' onClick='validate()'></td>";
			echo "<td align='right'><input type='reset' value='"._GLOSSARY_CLEARFORM."' name='reset' class='button'></td></tr></form></table>";
			# Close RegUserOnly Check
		}
	}
	
}

?>
