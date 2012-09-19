<?php
/**
* @version $Id: admin.typedcontent.html.php 5948 2006-12-06 22:42:31Z facedancer $
* @package Joomla
* @subpackage Content
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

/**
* @package Joomla
* @subpackage Content
*/
class HTML_typedcontent {

	/**
	* Writes a list of the content items
	* @param array An array of content objects
	*/
	function showContent( &$rows, &$pageNav, $option, $search, &$lists ) {
		global $my, $acl, $database;

		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="edit">
			Gestione contenuti statici
			</th>
			<td>
			Filtro:&nbsp;
			</td>
			<td>
			<input type="text" name="search" value="<?php echo htmlspecialchars( $search );?>" class="text_area" onChange="document.adminForm.submit();" />
			</td>
			<td>
			&nbsp;&nbsp;&nbsp;Ordine:&nbsp;
			</td>
			<td>
			<?php echo $lists['order']; ?>
			</td>
			<td width="right">
			<?php echo $lists['authorid'];?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="5">
			#
			</th>
			<th width="5px">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title">
			Titolo
			</th>
			<th width="5%">
			Pubblicazione
			</th>
			<th width="2%">
			Ordine
			</th>
			<th width="1%">
			<a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Salva ordine" /></a>
			</th>
			<th width="10%">
			Accesso
			</th>
			<th width="5%">
			ID
			</th>
			<th width="1%" align="left">
			Link
			</th>
			<th width="20%" align="left">
			Autore
			</th>
			<th align="center" width="10">
			Data
			</th>
		</tr>
		<?php
		$k = 0;
		$nullDate = $database->getNullDate();
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			mosMakeHtmlSafe($row);

			$now = _CURRENT_SERVER_TIME;
			if ( $now <= $row->publish_up && $row->state == 1 ) {
			// Published
				$img = 'publish_y.png';
				$alt = 'Pubblicato';
			} else if ( ( $now <= $row->publish_down || $row->publish_down == $nullDate ) && $row->state == 1 ) {
			// Pending
				$img = 'publish_g.png';
				$alt = 'Pubblicato';
			} else if ( $now > $row->publish_down && $row->state == 1 ) {
			// Expired
				$img = 'publish_r.png';
				$alt = 'Scaduto';
			} elseif ( $row->state == 0 ) {
			// Unpublished
				$img = 'publish_x.png';
				$alt = 'Non pubblicato';
			}
			
			// correct times to include server offset info
			$row->publish_up 	= mosFormatDate( $row->publish_up, _CURRENT_SERVER_TIME_FORMAT );			
			if (trim( $row->publish_down ) == $nullDate || trim( $row->publish_down ) == '' || trim( $row->publish_down ) == '-' ) {
				$row->publish_down = 'Mai';
			}
			$row->publish_down 	= mosFormatDate( $row->publish_down, _CURRENT_SERVER_TIME_FORMAT );		
			
			$times = '';
				if ($row->publish_up == $nullDate) {
					$times .= "<tr><td>Inizio: Adesso</td></tr>";
				} else {
					$times .= "<tr><td>Inizio: $row->publish_up</td></tr>";
				}
			if ($row->publish_down == $nullDate || $row->publish_down == 'Never') {
				$times .= "<tr><td>Termine: Nessuna scadenza</td></tr>";
				} else {
				$times .= "<tr><td>Termine: $row->publish_down</td></tr>";
			}

			if ( !$row->access ) {
				$color_access = 'style="color: green;"';
				$task_access = 'accessregistered';
			} else if ( $row->access == 1 ) {
				$color_access = 'style="color: red;"';
				$task_access = 'accessspecial';
			} else {
				$color_access = 'style="color: black;"';
				$task_access = 'accesspublic';
			}

			$link = 'index2.php?option=com_typedcontent&task=edit&hidemainmenu=1&id='. $row->id;

			$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );

			if ( $acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_users' ) ) {
				if ( $row->created_by_alias ) {
					$author = $row->created_by_alias;
				} else {
					$linkA 	= 'index2.php?option=com_users&task=editA&hidemainmenu=1&id='. $row->created_by;
					$author = '<a href="'. $linkA .'" title="Modifica utente">'. $row->creator .'</a>';
				}
			} else {
				if ( $row->created_by_alias ) {
					$author = $row->created_by_alias;
				} else {
					$author = $row->creator;
				}
			}

			$date = mosFormatDate( $row->created, '%x' );
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo $checked; ?>
				</td>
				<td>
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					echo $row->title;
					if ( $row->title_alias ) {
						echo ' (<i>'. $row->title_alias .'</i>)';
					}
				} else {
					?>
					<a href="<?php echo $link; ?>" title="Modifica contenuto statico">
					<?php
					echo $row->title;
					if ( $row->title_alias ) {
						echo ' (<i>'. $row->title_alias .'</i>)';
					}
					?>
					</a>
					<?php
				}
				?>
				</td>
				<?php
				if ( $times ) {
					?>
					<td align="center">
					<a href="javascript: void(0);" onMouseOver="return overlib('<table><?php echo $times; ?></table>', CAPTION, 'Informazioni pubblicazione', BELOW, RIGHT);" onMouseOut="return nd();" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->state ? "unpublish" : "publish";?>')">
					<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
					</a>
					</td>
					<?php
				}
				?>
				<td align="center" colspan="2">
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
				</td>
				<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task_access;?>')" <?php echo $color_access; ?>>
				<?php echo $row->groupname;?>
				</a>
				</td>
				<td align="center">
				<?php echo $row->id;?>
				</td>
				<td align="center">
				<?php echo $row->links;?>
				</td>
				<td align="left">
				<?php echo $author;?>
				</td>
				<td>
				<?php echo $date; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>

		<?php echo $pageNav->getListFooter(); ?>
		<?php mosCommonHTML::ContentLegend(); ?>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}

	function edit( &$row, &$images, &$lists, &$params, $option, &$menus ) {
		global $database;
		
		mosMakeHtmlSafe( $row );
		
		$create_date = null;
		$mod_date 		= null;
		$nullDate 		= $database->getNullDate();
		
		if ( $row->created != $nullDate ) {
			$create_date 	= mosFormatDate( $row->created, '%A, %d %B %Y %H:%M', '0' );
		}
		if ( $row->modified != $nullDate ) {
			$mod_date 		= mosFormatDate( $row->modified, '%A, %d %B %Y %H:%M', '0' );
		}
		
		$tabs = new mosTabs( 1 );
		// used to hide "Reset Hits" when hits = 0
		if ( !$row->hits ) {
			$visibility = "style='display: none; visibility: hidden;'";
		} else {
			$visibility = "";
		}

		mosCommonHTML::loadOverlib();
		mosCommonHTML::loadCalendar();
		?>
		<script language="javascript" type="text/javascript">
		var folderimages = new Array;
		<?php
		$i = 0;
		foreach ($images as $k=>$items) {
			foreach ($items as $v) {
				echo "folderimages[".$i++."] = new Array( '$k','".addslashes( $v->value )."','".addslashes( $v->text )."' );\t";
			}
		}
		?>
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( pressbutton ==' resethits' ) {
				if (confirm('Sei sicuro di voler resettare le viste a zero? \nOgni modifica non salvata a questo contenuto viene persa.')){
					submitform( pressbutton );
					return;
				} else {
					return;
				}
			}

			if ( pressbutton == 'menulink' ) {
				if ( form.menuselect.value == "" ) {
					alert( "Selezionare un menu" );
					return;
				} else if ( form.link_name.value == "" ) {
					alert( "Inserire un nome per questa voce di menu" );
					return;
				}
			}

			var temp = new Array;
			for (var i=0, n=form.imagelist.options.length; i < n; i++) {
				temp[i] = form.imagelist.options[i].value;
			}
			form.images.value = temp.join( '\n' );

			try {
				document.adminForm.onsubmit();
			}
			catch(e){}
			if (trim(form.title.value) == ""){
				alert( "Il contenuto deve avere un titolo" );
			} else if (trim(form.name.value) == ""){
				alert( "Il contenuto deve avere un nome" );
			} else {
				if ( form.reset_hits.checked ) {
					form.hits.value = 0;
				} else {
				}
				<?php getEditorContents( 'editor1', 'introtext' ) ; ?>
				submitform( pressbutton );
			}
		}
		</script>

		<table class="adminheading">
		<tr>
			<th class="edit">
			<small>
			<?php echo $row->id ? 'Modifica' : 'Nuovo';?>:</small>  Contenuto statico

			</th>
		</tr>
		</table>

		<form action="index2.php" method="post" name="adminForm">

		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="3">
					Dettagli
					</th>
				</tr>
				<tr>
					<td align="left">
					Titolo:
					</td>
					<td>
					<input class="inputbox" type="text" name="title" size="30" maxlength="100" value="<?php echo $row->title; ?>" />
					</td>
				</tr>
				<tr>
					<td align="left">
					Titolo Alias:
					</td>
					<td>
					<input class="inputbox" type="text" name="title_alias" size="30" maxlength="100" value="<?php echo $row->title_alias; ?>" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" colspan="2">
					Testo: (richiesto)<br />
					<?php
					// parameters : areaname, content, hidden field, width, height, rows, cols
					editorArea( 'editor1',  $row->introtext, 'introtext', '100%;', '400', '65', '50' );
					?>
					</td>
				</tr>
				</table>
			</td>
			<td width="40%" valign="top">
				<?php
				$tabs->startPane("content-pane");
				$tabs->startTab("Pubblicazione","publish-page");
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					Informazioni pubblicazione
					</th>
				</tr>
				<tr>
					<td valign="top" align="right" width="120">
					Stato:
					</td>
					<td>
					<?php echo $row->state > 0 ? 'Pubblicato' : 'Non pubblicato'; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					Pubblicazione:
					</td>
					<td>
					<input type="checkbox" name="published" value="1" <?php echo $row->state ? 'checked="checked"' : ''; ?> />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					Livello accesso:
					</td>
					<td>
					<?php echo $lists['access']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					Alias autore:
					</td>
					<td>
					<input type="text" name="created_by_alias" size="30" maxlength="100" value="<?php echo $row->created_by_alias; ?>" class="inputbox" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					Modifica creatore:
					</td>
					<td>
					<?php echo $lists['created_by']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					Sovrascrivi data creazione
					</td>
					<td>
					<input class="inputbox" type="text" name="created" id="created" size="25" maxlength="19" value="<?php echo $row->created; ?>" />
					<input name="reset" type="reset" class="button" onClick="return showCalendar('created', 'y-mm-dd');" value="...">
					</td>
				</tr>
				<tr>
					<td align="right">
					Inizio pubblicazione:
					</td>
					<td>
					<input class="inputbox" type="text" name="publish_up" id="publish_up" size="25" maxlength="19" value="<?php echo $row->publish_up; ?>" />
					<input type="reset" class="button" value="..." onclick="return showCalendar('publish_up', 'y-mm-dd');">
					</td>
				</tr>
				<tr>
					<td align="right">
					Termine pubblicazione:
					</td>
					<td>
					<input class="inputbox" type="text" name="publish_down" id="publish_down" size="25" maxlength="19" value="<?php echo $row->publish_down; ?>" />
					<input type="reset" class="button" value="..." onclick="return showCalendar('publish_down', 'y-mm-dd');">
					</td>
				</tr>
				</table>
				<br />
				<table class="adminform" width="100%">
				<?php
				if ( $row->id ) {
					?>
					<tr>
						<td>
						<strong>ID contenuto:</strong>
						</td>
						<td>
						<?php echo $row->id; ?>
						</td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td width="120" valign="top" align="right">
					<strong>Stato</strong>
					</td>
					<td>
					<?php echo $row->state > 0 ? 'Pubblicato' : ($row->state < 0 ? 'Archiviato' : 'Non pubblicato');?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<strong>Visite</strong>
					</td>
					<td>
					<?php echo $row->hits;?>
					<div <?php echo $visibility; ?>>
					<input name="reset_hits" type="button" class="button" value="Resetta contatore visite" onClick="submitbutton('resethits');">
					</div>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<strong>Versione</strong>
					</td>
					<td>
					<?php echo $row->version;?> times
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<strong>Creato il</strong>
					</td>
					<td>
						<?php
						if ( !$create_date ) {
							?>
							Nuovo documento
							<?php
						} else {
							echo $create_date;
						}
						?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<strong>Ultima modifica</strong>
					</td>
					<td>
						<?php
						if ( !$mod_date ) {
							?>
							Non modificato
							<?php
						} else {
							echo $mod_date;
							?>
							<br />
							<?php
							echo $row->modifier;
						}
						?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<strong>Scadenza</strong>
					</td>
					<td>
					<?php echo "$row->publish_down";?>
					</td>
				</tr>
				</table>
				<?php
				$tabs->endTab();
				$tabs->startTab("Immagini","images-page");
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					Controllo MOSImage
					</th>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
						<tr>
							<td width="48%" valign="top">
								<div align="center">
									Galleria Immagini:
									<br />
									<?php echo $lists['imagefiles'];?>
								</div>
							</td>
							<td width="2%">
								<input class="button" type="button" value=">>" onclick="addSelectedToList('adminForm','imagefiles','imagelist')" title="Aggiungi"/>
								<br/>
								<input class="button" type="button" value="<<" onclick="delSelectedFromList('adminForm','imagelist')" title="Rimuovi"/>
							</td>
							<td width="48%">
								<div align="center">
									Immagini contenuti:
									<br />
									<?php echo $lists['imagelist'];?>
									<br />
									<input class="button" type="button" value="Su" onclick="moveInList('adminForm','imagelist',adminForm.imagelist.selectedIndex,-1)" />
									<input class="button" type="button" value="Gi&ugrave;" onclick="moveInList('adminForm','imagelist',adminForm.imagelist.selectedIndex,+1)" />
								</div>
							</td>
						</tr>
						</table>
						Sotto-cartella: <?php echo $lists['folders'];?>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<div align="center">
							Anteprima:<br/>
							<img name="view_imagefiles" src="../images/M_images/blank.png" width="100" />
						</div>
					</td>
					<td valign="top">
						<div align="center">
							Immagine attiva:<br/>
							<img name="view_imagelist" src="../images/M_images/blank.png" width="100" />
						</div>
					</td>
				</tr>
				<tr>
					<td>
					Modifica caratteristiche immagine selezionata:
						<table>
						<tr>
							<td align="right">
							Sorgente
							</td>
							<td>
							<input type="text" name= "_source" value="" />
							</td>
						</tr>
						<tr>
							<td align="right">
							Alllineamento
							</td>
							<td>
							<?php echo $lists['_align']; ?>
							</td>
						</tr>
						<tr>
							<td align="right">
							Alt Text
							</td>
							<td>
							<input type="text" name="_alt" value="" />
							</td>
						</tr>
						<tr>
							<td align="right">
							Bordo
							</td>
							<td>
							<input type="text" name="_border" value="" size="3" maxlength="1" />
							</td>
						</tr>
						<tr>
							<td align="right">
							Didascalia:
							</td>
							<td>
							<input class="text_area" type="text" name="_caption" value="" size="30" />
							</td>
						</tr>
						<tr>
							<td align="right">
							Posizione disdascalia:
							</td>
							<td>
							<?php echo $lists['_caption_position']; ?>
							</td>
						</tr>
						<tr>
							<td align="right">
							Allineamento didascalia:
							</td>
							<td>
							<?php echo $lists['_caption_align']; ?>
							</td>
						</tr>
						<tr>
							<td align="right">
							Larghezza didascalia:
							</td>
							<td>
							<input class="text_area" type="text" name="_width" value="" size="5" maxlength="5" />
							</td>
						</tr>
						<tr>
							<td colspan="2">
							<input class="button" type="button" value="Applica" onClick="applyImageProps()" />
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
				<?php
				$tabs->endTab();
				$tabs->startTab("Parametri","params-page");
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					Controllo parametri
					</th>
				</tr>
				<tr>
					<td>
					<?php echo $params->render();?>
					</td>
				</tr>
				</table>
				<?php
				$tabs->endTab();
				$tabs->startTab("Meta Info","metadata-page");
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					Meta Data
					</th>
				</tr>
				<tr>
					<td align="left">
					Descrizione:<br />
					<textarea class="inputbox" cols="40" rows="5" name="metadesc" style="width:300px"><?php echo str_replace('&','&amp;',$row->metadesc); ?></textarea>
					</td>
				</tr>
				<tr>
					<td align="left">
					Keywords:<br />
					<textarea class="inputbox" cols="40" rows="5" name="metakey" style="width:300px"><?php echo str_replace('&','&amp;',$row->metakey); ?></textarea>
					</td>
				</tr>
				</table>
				<?php
				$tabs->endTab();
				$tabs->startTab("Link al Menu","link-page");
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					Collegamento al menu
					</th>
				</tr>
				<tr>
					<td colspan="2">
					Possiamo creare un <strong>'Collegamento - Contenuto Statico'</strong> nel menu selezionato
					<br /><br />
					</td>
				</tr>
				<tr>
					<td valign="top" width="90px">
					Seleziona un menu
					</td>
					<td>
					<?php echo $lists['menuselect']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" width="90px">
					Nome voce di menu
					</td>
					<td>
					<input type="text" name="link_name" class="inputbox" value="" size="30" />
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
					<input name="menu_link" type="button" class="button" value="Collegamento al menu" onClick="submitbutton('menulink');" />
					</td>
				</tr>
				<tr>
					<th colspan="2">
					Collegamenti al menu esistenti
					</th>
				</tr>
				<?php
				if ( $menus == NULL ) {
					?>
					<tr>
						<td colspan="2">
						Nessuno
						</td>
					</tr>
					<?php
				} else {
					mosCommonHTML::menuLinksContent( $menus );
				}
				?>
				<tr>
					<td colspan="2">
					</td>
				</tr>
				</table>
				<?php
				$tabs->endTab();
				$tabs->endPane();
				?>
			</td>
		</tr>
		</table>

		<input type="hidden" name="images" value="" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="hits" value="<?php echo $row->hits; ?>" />
		<input type="hidden" name="task" value="" />
		</form>
		<?php
	}
}
?>