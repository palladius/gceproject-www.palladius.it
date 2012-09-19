<?php
/**
* @version $Id: admin.users.html.php 6070 2006-12-20 02:09:09Z robs $
* @package Joomla
* @subpackage Users
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
* @subpackage Users
*/
class HTML_users {

	function showUsers( &$rows, $pageNav, $search, $option, $lists ) {
		?>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="user">
			Gestione utenti
			</th>
			<td>
			Filtro:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo htmlspecialchars( $search );?>" class="inputbox" onChange="document.adminForm.submit();" />
			</td>
			<td width="right">
			<?php echo $lists['type'];?>
			</td>
			<td width="right">
			<?php echo $lists['logged'];?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="2%" class="title">
			#
			</th>
			<th width="3%" class="title">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title">
			Nome
			</th>
			<th width="15%" class="title" >
			Nome utente
			</th>
			<th width="5%" class="title" nowrap="nowrap">
			Connesso
			</th>
			<th width="5%" class="title">
			Abilitato
			</th>
			<th width="15%" class="title">
			Gruppo
			</th>
			<th width="15%" class="title">
			E-Mail
			</th>
			<th width="10%" class="title">
			Ultima visita
			</th>
			<th width="1%" class="title">
			ID
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	=& $rows[$i];

			$img 	= $row->block ? 'publish_x.png' : 'tick.png';
			$task 	= $row->block ? 'unblock' : 'block';
			$alt 	= $row->block ? 'Abilita' : 'Blocca';
			$link 	= 'index2.php?option=com_users&amp;task=editA&amp;id='. $row->id. '&amp;hidemainmenu=1';
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $i+1+$pageNav->limitstart;?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id ); ?>
				</td>
				<td>
				<a href="<?php echo $link; ?>">
				<?php echo $row->name; ?>
				</a>
				<td>
				<?php echo $row->username; ?>
				</td>
				</td>
				<td align="center">
				<?php echo $row->loggedin ? '<img src="images/tick.png" width="12" height="12" border="0" alt="" />': ''; ?>
				</td>
				<td>
				<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</td>
				<td>
				<?php echo $row->groupname; ?>
				</td>
				<td>
				<a href="mailto:<?php echo $row->email; ?>">
				<?php echo $row->email; ?>
				</a>
				</td>
				<td nowrap="nowrap">
				<?php echo mosFormatDate( $row->lastvisitDate, _CURRENT_SERVER_TIME_FORMAT ); ?>
				</td>
				<td>
				<?php echo $row->id; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}

	function edituser( &$row, &$contact, &$lists, $option, $uid, &$params ) {
		global $my, $acl;
		global $mosConfig_live_site;
		
		mosMakeHtmlSafe( $row );
		
		$tabs = new mosTabs( 0 );

		mosCommonHTML::loadOverlib();
		$canBlockUser 	= $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'user properties', 'block_user' );
		$canEmailEvents = $acl->acl_check( 'workflow', 'email_events', 'users', $acl->get_group_name( $row->gid, 'ARO' ) );
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

			// do field validation
			if (trim(form.name.value) == "") {
				alert( "Inserire un nome." );
			} else if (form.username.value == "") {
				alert( "inserire un user name." );
			} else if (r.exec(form.username.value) || form.username.value.length < 3) {
				alert( "Username inserito contiene caratteri non validi o troppo corto." );
			} else if (trim(form.email.value) == "") {
				alert( "Inserire indirizzo e-mail." );
			} else if (form.gid.value == "") {
				alert( "Assegnare utente ad un gruppo." );
			} else if (trim(form.password.value) != "" && form.password.value != form.password2.value){
				alert( "Password non corrisponde." );
			} else if (form.gid.value == "29") {
				alert( "Selezionare altro gruppo in quanto `Public Front-end` opzione non selezionabile" );
			} else if (form.gid.value == "30") {
				alert( "Selezionare altro gruppo in quanto `Public Back-end` opzione non selezionabile" );
			} else {
				submitform( pressbutton );
			}
		}

		function gotocontact( id ) {
			var form = document.adminForm;
			form.contact_id.value = id;
			submitform( 'contact' );
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="user">
			<small><?php echo $row->id ? 'Modifica' : 'Aggiungi';?>:</small>  Utente
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">
					Dettagli utente
					</th>
				</tr>
				<tr>
					<td width="130">
					Name:
					</td>
					<td>
					<input type="text" name="name" class="inputbox" size="40" value="<?php echo $row->name; ?>" maxlength="50" />
					</td>
				</tr>
				<tr>
					<td>
					Nome utente:
					</td>
					<td>
					<input type="text" name="username" class="inputbox" size="40" value="<?php echo $row->username; ?>" maxlength="25" />
					</td>
				<tr>
					<td>
					E-mail:
					</td>
					<td>
					<input class="inputbox" type="text" name="email" size="40" value="<?php echo $row->email; ?>" />
					</td>
				</tr>
				<tr>
					<td>
					Nuova password:
					</td>
					<td>
					<input class="inputbox" type="password" name="password" size="40" value="" />
					</td>
				</tr>
				<tr>
					<td>
					Verifica password:
					</td>
					<td>
					<input class="inputbox" type="password" name="password2" size="40" value="" />
					</td>
				</tr>
				<tr>
					<td valign="top">
					Gruppo:
					</td>
					<td>
					<?php echo $lists['gid']; ?>
					</td>
				</tr>
				<?php
				if ($canBlockUser) {
					?>
					<tr>
						<td>
						Blocca utente
						</td>
						<td>
						<?php echo $lists['block']; ?>
						</td>
					</tr>
					<?php
				}
				if ($canEmailEvents) {
					?>
					<tr>
						<td>
						Ricevi e-mail di sistema
						</td>
						<td>
						<?php echo $lists['sendEmail']; ?>
						</td>
					</tr>
					<?php
				}
				if( $uid ) {
					?>
					<tr>
						<td>
						Data registrazione
						</td>
						<td>
						<?php echo $row->registerDate;?>
						</td>
					</tr>
				<tr>
					<td>
					Data ultima visita
					</td>
					<td>
					<?php echo $row->lastvisitDate;?>
					</td>
				</tr>
					<?php
				}
				?>
				<tr>
					<td colspan="2">&nbsp;

					</td>
				</tr>
				</table>
			</td>
			<td width="40%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="1">
					<?php echo 'Parametri'; ?>
					</th>
				</tr>
				<tr>
					<td>
					<?php echo $params->render( 'params' );?>
					</td>
				</tr>
				</table>

				<?php
				if ( !$contact ) {
					?>
					<table class="adminform">
					<tr>
						<th>
						Informazioni contatto
						</th>
					</tr>
					<tr>
						<td>
						<br />
						Nessun dettaglio contatto collegato a questo utente:
						<br />
						Vedi <strong>'Componenti -> Contatti -> Gestione Contatti'</strong> per gestire i dettagli.
						<br /><br />
						</td>
					</tr>
					</table>
					<?php
				} else {
					?>
					<table class="adminform">
					<tr>
						<th colspan="2">
						Informazioni contatto
						</th>
					</tr>
					<tr>
						<td width="15%">
						Nome:
						</td>
						<td>
						<strong>
						<?php echo $contact[0]->name;?>
						</strong>
						</td>
					</tr>
					<tr>
						<td>
						Posizione:
						</td>
						<td >
						<strong>
						<?php echo $contact[0]->con_position;?>
						</strong>
						</td>
					</tr>
					<tr>
						<td>
						Telefono:
						</td>
						<td >
						<strong>
						<?php echo $contact[0]->telephone;?>
						</strong>
						</td>
					</tr>
					<tr>
						<td>
						Fax:
						</td>
						<td >
						<strong>
						<?php echo $contact[0]->fax;?>
						</strong>
						</td>
					</tr>
					<tr>
						<td></td>
						<td >
						<strong>
						<?php echo $contact[0]->misc;?>
						</strong>
						</td>
					</tr>
					<?php
					if ($contact[0]->image) {
						?>
						<tr>
							<td></td>
							<td valign="top">
							<img src="<?php echo $mosConfig_live_site;?>/images/stories/<?php echo $contact[0]->image; ?>" align="middle" alt="Contatto" />
							</td>
						</tr>
						<?php
					}
					?>
					<tr>
						<td colspan="2">
						<br /><br />
						<input class="button" type="button" value="modifica i dettagli contatto" onclick="javascript: gotocontact( '<?php echo $contact[0]->id; ?>' )">
						<i>
						<br />
						'Componenti -> Contatti -> Gestione contatti'.
						</i>
						</td>
					</tr>
					</table>
					<?php
				}
				?>
			</td>
		</tr>
		</table>

		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="contact_id" value="" />
		<?php
		if (!$canEmailEvents) {
			?>
			<input type="hidden" name="sendEmail" value="0" />
			<?php
		}
		?>
		</form>
		<?php
	}
}
?>