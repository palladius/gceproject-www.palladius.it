<?php
/**
* @version $Id: url.menu.html.php 5539 2006-10-21 18:15:59Z friesengeist $
* @package Joomla
* @subpackage Menus
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
* Writes the edit form for new and existing content item
*
* A new record is defined when <var>$row</var> is passed with the <var>id</var>
* property set to 0.
* @package Joomla
* @subpackage Menus
*/
class url_menu_html {

	function edit( $menu, $lists, $params, $option ) {
		global $mosConfig_live_site;
		?>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (trim(form.name.value) == ""){
				alert( "Il collegamento deve avere un nome" );
			} else if (trim(form.link.value) == ""){
				alert( "Inserire una url." );
			} else {
				submitform( pressbutton );
			}
		}
		</script>

		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo $menu->id ? 'Modifica' : 'Aggiungi';?> Voce di menu :: Collegamento - URL
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr valign="top">
			<td width="60%">
				<table class="adminform">
				<tr>
					<th colspan="2">
					Dettagli
					</th>
				</tr>
				<tr>
					<td width="20%" align="right">
					Nome:
					</td>
					<td width="80%">
					<input class="inputbox" type="text" name="name" size="50" maxlength="150" value="<?php echo htmlspecialchars( $menu->name, ENT_QUOTES ); ?>" />
					</td>
				</tr>
				<tr>
					<td width="20%" align="right">
					Collegamento:
					</td>
					<td width="80%">
					<input class="inputbox" type="text" name="link" size="50" maxlength="250" value="<?php echo $menu->link; ?>" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					Al Click, apri in:
					</td>
					<td>
					<?php echo $lists['target']; ?>
					</td>
				</tr>
				<tr>
					<td align="right">
					Parent Item:
					</td>
					<td>
					<?php echo $lists['parent']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					Ordinamento:
					</td>
					<td>
					<?php echo $lists['ordering']; ?>
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
					Pubblicazione:
					</td>
					<td>
					<?php echo $lists['published']; ?>
					</td>
				</tr>
				</table>
			</td>
			<td width="40%">
				<table class="adminform">
				<tr>
					<th>
					Parametri
					</th>
				</tr>
				<tr>
					<td>
					<?php echo $params->render();?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="id" value="<?php echo $menu->id; ?>" />
		<input type="hidden" name="menutype" value="<?php echo $menu->menutype; ?>" />
		<input type="hidden" name="type" value="<?php echo $menu->type; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}
}
?>