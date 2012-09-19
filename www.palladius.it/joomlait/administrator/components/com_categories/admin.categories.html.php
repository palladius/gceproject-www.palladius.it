<?php
/**
* @version $Id: admin.categories.html.php 6000 2006-12-13 19:52:58Z friesengeist $
* @package Joomla
* @subpackage Categories
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
* @subpackage Categories
*/
class categories_html {

	/**
	* Writes a list of the categories for a section
	* @param array An array of category objects
	* @param string The name of the category section
	*/
	function show( &$rows, $section, $section_name, &$pageNav, &$lists, $type ) {
		global $my;

		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<?php
			if ( $section == 'content') {
				?>
				<th class="categories">
				Gestione Categorie <small><small>[ Contenuti: Tutti ]</small></small>
				</th>
				<td width="right">
				<?php echo $lists['sectionid'];?>
				</td>
				<?php
			} else {
				if ( is_numeric( $section ) ) {
					$query = 'com_content&sectionid=' . $section;
				} else {
					if ( $section == 'com_contact_details' ) {
						$query = 'com_contact';
					} else {
						$query = $section;
					}
				}
				?>
				<th class="categories">
				Gestione Categorie <small><small>[ <?php echo $section_name;?> ]</small></small>
				</th>
				<?php
			}
			?>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="10" align="left">
			#
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
			</th>
			<th class="title">
			Nome categoria
			</th>
			<th width="10%">
			Pubblicazione
			</th>
			<?php
			if ( $section <> 'content') {
				?>
				<th colspan="2" width="5%">
				Riordina
				</th>
				<?php
			}
			?>
			<th width="2%">
			Ordine
			</th>
			<th width="1%">
			<a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Salva Ordine" /></a>
			</th>
			<th width="10%">
			Accesso
			</th>
			<?php
			if ( $section == 'content') {
				?>
				<th width="12%" align="left">
				Sezione
				</th>
				<?php
			}
			?>
			<th width="5%" nowrap="nowrap">
			ID categoria
			</th>
			<?php
			if ( $type == 'content') {
				?>
				<th width="5%">
				# Attive
				</th>
				<th width="5%">
				# Cestinate
				</th>
				<?php
			} else {
				?>
				<th width="20%">
				</th>
				<?php
			}
			?>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= &$rows[$i];
			mosMakeHtmlSafe($row);
			$row->sect_link = 'index2.php?option=com_sections&task=editA&hidemainmenu=1&id='. $row->section;

			$link = 'index2.php?option=com_categories&section='. $section .'&task=editA&hidemainmenu=1&id='. $row->id;
			if ($row->checked_out_contact_category) {
				$row->checked_out = $row->checked_out_contact_category;
			}
			$access 	= mosCommonHTML::AccessProcessing( $row, $i );
			$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );
			$published 	= mosCommonHTML::PublishedProcessing( $row, $i );
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
				if ( $row->checked_out_contact_category && ( $row->checked_out_contact_category != $my->id ) ) {
					echo stripslashes( $row->name ) .' ( '. stripslashes( $row->title ) .' )';
				} else {
					?>
					<a href="<?php echo $link; ?>">
					<?php echo stripslashes( $row->name ) .' ( '. stripslashes( $row->title ) .' )'; ?>
					</a>
					<?php
				}
				?>
				</td>
				<td align="center">
				<?php echo $published;?>
				</td>
				<?php
				if ( $section != 'content' ) {
					?>
					<td>
					<?php echo $pageNav->orderUpIcon( $i ); ?>
					</td>
					<td>
					<?php echo $pageNav->orderDownIcon( $i, $n ); ?>
					</td>
					<?php
				}
				?>
				<td align="center" colspan="2">
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
				</td>
				<td align="center">
				<?php echo $access;?>
				</td>
				<?php
				if ( $section == 'content' ) {
					?>
					<td align="left">
					<a href="<?php echo $row->sect_link; ?>" title="Modifica Sezione">
					<?php echo $row->section_name; ?>
					</a>
					</td>
					<?php
				}
				?>
				<td align="center">
				<?php echo $row->id; ?>
				</td>
				<?php
				if ( $type == 'content') {
					?>
					<td align="center">
					<?php echo $row->active; ?>
					</td>
					<td align="center">
					<?php echo $row->trash; ?>
					</td>
					<?php
				} else {
					?>
					<td>
					</td>
					<?php
				}
				$k = 1 - $k;
				?>
			</tr>
			<?php
		}
		?>
		</table>

		<?php echo $pageNav->getListFooter(); ?>

		<input type="hidden" name="option" value="com_categories" />
		<input type="hidden" name="section" value="<?php echo $section;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="chosen" value="" />
		<input type="hidden" name="act" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="type" value="<?php echo $type; ?>" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing categories
	* @param mosCategory The category object
	* @param string
	* @param array
	*/
	function edit( &$row, &$lists, $redirect, $menus ) {
		if ($row->image == "") {
			$row->image = 'blank.png';
		}

		if ( $redirect == 'content' ) {
			$component = 'Contenuti';
		} else {
			$component = ucfirst( substr( $redirect, 4 ) );
			if ( $redirect == 'com_contact_details' ) {
				$component = 'Contatti';
			}
		}
		mosMakeHtmlSafe( $row, ENT_QUOTES, 'description' );
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton, section) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( pressbutton == 'menulink' ) {
				if ( form.menuselect.value == "" ) {
					alert( "Seleziona un menu" );
					return;
				} else if ( form.link_type.value == "" ) {
					alert( "Seleziona un tipo menu" );
					return;
				} else if ( form.link_name.value == "" ) {
					alert( "Inserire un nome a questa voce di menu" );
					return;
				}
			}

			if ( form.name.value == "" ) {
				alert("La categoria deve avere un nome");
			} else {
				<?php getEditorContents( 'editor1', 'description' ) ; ?>
				submitform(pressbutton);
			}
		}
		</script>

		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="categories">
			<small>
			<?php echo $row->id ? 'Modifica' : 'Nuova';?>: Categoria
			</small>
			<small><small>
			[ <?php echo $component; ?>: <?php echo stripslashes($row->name); ?> ]
			</small></small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td valign="top" width="60%">
				<table class="adminform">
				<tr>
					<th colspan="3">
					Dettagli categoria:
					</th>
				<tr>
				<tr>
					<td>
					Titolo categoria:
					</td>
					<td colspan="2">
					<input class="text_area" type="text" name="title" value="<?php echo stripslashes( $row->title ); ?>" size="50" maxlength="50" title="Un nome corto che appare nel menu" />
					</td>
				</tr>
				<tr>
					<td>
					Nome categoria:
					</td>
					<td colspan="2">
					<input class="text_area" type="text" name="name" value="<?php echo stripslashes( $row->name ); ?>" size="50" maxlength="255" title="Un titolo esteso come intestazione" />
					</td>
				</tr>
				<tr>
					<td>
					Sezione:
					</td>
					<td colspan="2">
					<?php echo $lists['section']; ?>
					</td>
				</tr>
				<tr>
					<td>
					Ordine:
					</td>
					<td colspan="2">
					<?php echo $lists['ordering']; ?>
					</td>
				</tr>
				<tr>
					<td>
					Immagine:
					</td>
					<td>
					<?php echo $lists['image']; ?>
					</td>
					<td rowspan="5" width="50%">
					<script language="javascript" type="text/javascript">
					if (document.forms[0].image.options.value!=''){
					  jsimg='../images/stories/' + getSelectedValue( 'adminForm', 'image' );
					} else {
					  jsimg='../images/M_images/blank.png';
					}
					document.write('<img src=' + jsimg + ' name="imagelib" width="80" height="80" border="2" alt="Anteprima" />');
					</script>
					</td>
				</tr>
				<tr>
					<td>
					Posizione immagine:
					</td>
					<td>
					<?php echo $lists['image_position']; ?>
					</td>
				</tr>
				<tr>
					<td>
					Livello di accesso:
					</td>
					<td>
					<?php echo $lists['access']; ?>
					</td>
				</tr>
				<tr>
					<td>
					Pubblicazione:
					</td>
					<td>
					<?php echo $lists['published']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
					Descrizione:
					</td>
				</tr>
				<tr>
					<td colspan="3">
					<?php
					// parameters : areaname, content, hidden field, width, height, rows, cols
					editorArea( 'editor1',  $row->description , 'description', '100%;', '300', '60', '20' ) ; ?>
					</td>
				</tr>
				</table>
			</td>
			<td valign="top" width="40%">
			<?php
			if ( $row->id > 0 ) {
			?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					Collegamento al menu
					</th>
				<tr>
				<tr>
					<td colspan="2">
					Questa opzione crea una nuova voce di menu nel menu selezionato
					<br /><br />
					</td>
				<tr>
				<tr>
					<td valign="top" width="100">
					Seleziona un menu
					</td>
					<td>
					<?php echo $lists['menuselect']; ?>
					</td>
				<tr>
				<tr>
					<td valign="top" width="100">
					Seleziona un tipo menu
					</td>
					<td>
					<?php echo $lists['link_type']; ?>
					</td>
				<tr>
				<tr>
					<td valign="top" width="100">
					Nome voce di menu
					</td>
					<td>
					<input type="text" name="link_name" class="inputbox" value="" size="25" />
					</td>
				<tr>
				<tr>
					<td>
					</td>
					<td>
					<input name="menu_link" type="button" class="button" value="Collegamento al menu" onClick="submitbutton('menulink');" />
					</td>
				<tr>
				<tr>
					<th colspan="2">
					Collegamenti menu esistenti
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
					mosCommonHTML::menuLinksSecCat( $menus );
				}
				?>
				<tr>
					<td colspan="2">
					</td>
				</tr>
				</table>
			<?php
			} else {
			?>
			<table class="adminform" width="40%">
					<tr>
						<th>
						&nbsp;
						</th>
					</tr>
					<tr>
						<td>
						Collegamenti menu disponibili dopo il salvataggio
						</td>
					</tr>
					</table>
					<?php
				}
				// content
				if ( $row->section > 0 || $row->section == 'content' ) {
					?>
					<br />
					<table class="adminform">
					<tr>
						<th colspan="2">
						Cartelle MOSImage
						</th>
					<tr>
					<tr>
						<td colspan="2">
						<?php echo $lists['folders']; ?>
						</td>
					<tr>	
			</table>
			<?php
			}
			?>
			</td>
		</tr>
		</table>

		<input type="hidden" name="option" value="com_categories" />
		<input type="hidden" name="oldtitle" value="<?php echo $row->title ; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="sectionid" value="<?php echo $row->section; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}


	/**
	* Form to select Section to move Category to
	*/
	function moveCategorySelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect ) {
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th class="categories">
			Sposta categoria
			</th>
		</tr>
		</table>

		<br />
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (!getSelectedValue( 'adminForm', 'sectionmove' )) {
				alert( "Seleziona una Sezione dove spostare la Categoria" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>		
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong>Sposta alla sezione:</strong>
			<br />
			<?php echo $SectionList ?>
			<br /><br />
			</td>
			<td align="left" valign="top" width="20%">
			<strong>Categorie in fase di spostamento:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->name ."</li>";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top" width="20%">
			<strong>Contenuti in fase di spostamento:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $contents as $content ) {
				echo "<li>". $content->title ."</li>";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top">
			Questa opzione sposta le categorie nella lista
			<br />
			e tutti gli oggetti associati alla categoria (anche quelli i lista)
			<br />
			nella sezione selezionata.
			</td>.
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="section" value="<?php echo $sectionOld;?>" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		<input type="hidden" name="task" value="" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}


	/**
	* Form to select Section to copy Category to
	*/
	function copyCategorySelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect ) {
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th class="categories">
			Copia categoria
			</th>
		</tr>
		</table>

		<br />
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (!getSelectedValue( 'adminForm', 'sectionmove' )) {
				alert( "Selezina la Sezione dove copiare la Categoria" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong>Copia nella sezione:</strong>
			<br />
			<?php echo $SectionList ?>
			<br /><br />
			</td>
			<td align="left" valign="top" width="20%">
			<strong>Categorie in fase di copia:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->name ."</li>";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top" width="20%">
			<strong>Contenuti in fase di copia:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $contents as $content ) {
				echo "<li>". $content->title ."</li>";
				echo "\n <input type=\"hidden\" name=\"item[]\" value=\"$content->id\" />";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top">
			Questa opzione copia le categorie nella lista
			<br />
			e tutti gli oggetti associati alla categoria (anche quelli i lista)
			<br />
			nella sezione selezionata.
			</td>.
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="section" value="<?php echo $sectionOld;?>" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		<input type="hidden" name="task" value="" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}

}
?>