<?php
/**
* @version $Id: admin.config.html.php 6070 2006-12-20 02:09:09Z robs $
* @package Joomla
* @subpackage Config
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
* @subpackage Config
*/
class HTML_config {

	function showconfig( &$row, &$lists, $option) {
		global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_session_type, $mainframe;

		$tabs = new mosTabs(0);
		?>
		<script type="text/javascript">
		<!--
		function saveFilePerms() {
			var f = document.adminForm;
			if (f.filePermsMode0.checked)
				f.config_fileperms.value = '';
			else {
				var perms = 0;
				if (f.filePermsUserRead.checked) perms += 400;
				if (f.filePermsUserWrite.checked) perms += 200;
				if (f.filePermsUserExecute.checked) perms += 100;
				if (f.filePermsGroupRead.checked) perms += 40;
				if (f.filePermsGroupWrite.checked) perms += 20;
				if (f.filePermsGroupExecute.checked) perms += 10;
				if (f.filePermsWorldRead.checked) perms += 4;
				if (f.filePermsWorldWrite.checked) perms += 2;
				if (f.filePermsWorldExecute.checked) perms += 1;
				f.config_fileperms.value = '0'+''+perms;
			}
		}
		function changeFilePermsMode(mode) {
			if(document.getElementById) {
				switch (mode) {
					case 0:
						document.getElementById('filePermsValue').style.display = 'none';
						document.getElementById('filePermsTooltip').style.display = '';
						document.getElementById('filePermsFlags').style.display = 'none';
						break;
					default:
						document.getElementById('filePermsValue').style.display = '';
						document.getElementById('filePermsTooltip').style.display = 'none';
						document.getElementById('filePermsFlags').style.display = '';
				} // switch
			} // if
			saveFilePerms();
		}
		function saveDirPerms() {
			var f = document.adminForm;
			if (f.dirPermsMode0.checked)
				f.config_dirperms.value = '';
			else {
				var perms = 0;
				if (f.dirPermsUserRead.checked) perms += 400;
				if (f.dirPermsUserWrite.checked) perms += 200;
				if (f.dirPermsUserSearch.checked) perms += 100;
				if (f.dirPermsGroupRead.checked) perms += 40;
				if (f.dirPermsGroupWrite.checked) perms += 20;
				if (f.dirPermsGroupSearch.checked) perms += 10;
				if (f.dirPermsWorldRead.checked) perms += 4;
				if (f.dirPermsWorldWrite.checked) perms += 2;
				if (f.dirPermsWorldSearch.checked) perms += 1;
				f.config_dirperms.value = '0'+''+perms;
			}
		}
		function changeDirPermsMode(mode) 	{
			if(document.getElementById) {
				switch (mode) {
					case 0:
						document.getElementById('dirPermsValue').style.display = 'none';
						document.getElementById('dirPermsTooltip').style.display = '';
						document.getElementById('dirPermsFlags').style.display = 'none';
						break;
					default:
						document.getElementById('dirPermsValue').style.display = '';
						document.getElementById('dirPermsTooltip').style.display = 'none';
						document.getElementById('dirPermsFlags').style.display = '';
				} // switch
			} // if
			saveDirPerms();
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;

			// do field validation
			if (form.config_session_type.value != <?php echo $row->config_session_type; ?> ){
				if ( confirm('Sei sicuro di voler modificare il `Metodo sessione autenticazione`? \n\n Questa opzione cancella tutte le sessioni attalmente aperte nel lato pubblico del sito \n\n') ) {
					submitform( pressbutton );
				} else {
					return;
				}
			} else {
				submitform( pressbutton );
			}
		}
		//-->
		</script>
		<form action="index2.php" method="post" name="adminForm">
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="250"><table class="adminheading"><tr><th nowrap="nowrap" class="config">Configurazione Generale</th></tr></table></td>
			<td width="270">
				<span class="componentheading">il file <strong>configuration.php</strong> &#232; :
				<?php echo is_writable( '../configuration.php' ) ? '<b><font color="green"> Scrivibile</font></b>' : '<b><font color="red"> Non scrivibile</font></b>' ?>
				</span>
			</td>
			<?php
			if (mosIsChmodable('../configuration.php')) {
				if (is_writable('../configuration.php')) {
					?>
					<td>
						<input type="checkbox" id="disable_write" name="disable_write" value="1"/>
						<label for="disable_write">Rendi non scrivibile dopo il salvataggio</label>
					</td>
					<?php
				} else {
					?>
					<td>
						<input type="checkbox" id="enable_write" name="enable_write" value="1"/>
						<label for="enable_write">Oltrepassa protezione scrittura durante il salvataggio</label>
					</td>
				<?php
				} // if
			} // if
			?>
		</tr>
		</table>
			<?php
		$tabs->startPane("configPane");
		$tabs->startTab("Sito","site-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Sito offline:</td>
				<td><?php echo $lists['offline']; ?></td>
			</tr>
			<tr>
				<td valign="top">Messaggio offline:</td>
				<td><textarea class="text_area" cols="60" rows="2" style="width:500px; height:40px" name="config_offline_message"><?php echo $row->config_offline_message; ?></textarea><?php
					$tip = 'Un messaggio che viene mostrato quando il sito &egrave; offline';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td valign="top">Messaggio errore di sistema:</td>
				<td><textarea class="text_area" cols="60" rows="2" style="width:500px; height:40px" name="config_error_message"><?php echo $row->config_error_message; ?></textarea><?php
					$tip = 'Un messaggio che viene mostrato se Joomla! non riesce a collegarsi al database';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Nome sito:</td>
				<td><input class="text_area" type="text" name="config_sitename" size="50" value="<?php echo $row->config_sitename; ?>"/></td>
			</tr>
			<tr>
				<td>Mostra collegamenti non autorizzati:</td>
				<td><?php echo $lists['shownoauth']; ?><?php
					$tip = 'Se si, mostra il collegamento ai contenuti registrati anche se non siamo connessi.  Gli utenti devono invece essere collegati per vederli.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Permetti registrazione utenti:</td>
				<td><?php echo $lists['allowUserRegistration']; ?><?php
					$tip = 'Se si, permette agli utenti di effettuare la procedura di auto registrazione direttamente dal sito';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Usa attivazione nuovi account:</td>
				<td><?php echo $lists['useractivation']; ?>
				<?php
					$tip = 'Se si, gli utenti ricevo una email di attivazione con il collegamento web per attivare il proprio account. Senza attivazione gli utenti non saranno in grado di connettersi al sito.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Richiedi E-mail unica:</td>
				<td><?php echo $lists['uniquemail']; ?><?php
					$tip = 'Se si, gli utenti non possono utilizzare pi&ugrave; volte la stessa email per registrare ulteriori account';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Front-end Login:</td>
				<td>
					<?php echo $lists['frontend_login']; ?>
					<?php
					$tip = 'Se `No`, disabilita la pagina Front-end login e il modulo quando non viene associata a nessuna voce di menu. In questo caso disabilita anche le funzioni registrazione';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Parametri Front-end Utente:</td>
				<td>
					<?php echo $lists['frontend_userparams']; ?>
					<?php
					$tip = 'Se `No`, disabilita le funzioni dei parametri front-end per gli utenti';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Debug sito:</td>
				<td>
					<?php echo $lists['debug']; ?>
					<?php
					$tip = 'Se si, mostra informazioni diagnostiche ed errori SQL se presenti';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Editor WYSIWYG predefinito:</td>
				<td><?php echo $lists['editor']; ?></td>
			</tr>
			<tr>
				<td>Lunghezza liste:</td>
				<td>
					<?php echo $lists['list_limit']; ?>
					<?php
					$tip = 'Specificare la lunghezza predefinita delle liste visualizzate';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Icona preferiti del sito:</td>
				<td>
				<input class="text_area" type="text" name="config_favicon" size="20" value="<?php echo $row->config_favicon; ?>"/>
				<?php
				$tip = 'Se lasciata in bianco o non trovata, viene utilizzata una icona predefinita (favicon.ico).';
				echo mosToolTip( $tip );
				?>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Locale","Locale-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Lingua:</td>
				<td><?php echo $lists['lang']; ?></td>
			</tr>
			<tr>
				<td width="185">Time Offset:</td>
				<td>
				<?php echo $lists['offset']; ?>
				<?php
				$tip = "Data ed ora configurata: " . mosCurrentDate(_DATE_FORMAT_LC2);
				echo mosToolTip( $tip );
				?>
				</td>
			</tr>
			<tr>
				<td width="185">Server Offset:</td>
				<td>
				<input class="text_area" type="text" name="config_offset" size="15" value="<?php echo $row->config_offset; ?>" disabled="disabled" />
				</td>
			</tr>
			<tr>
				<td width="185">Codice nazione:</td>
				<td>
				<input class="text_area" type="text" name="config_locale" size="15" value="<?php echo $row->config_locale; ?>"/>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Contenuti","content-page");
			?>
			<table class="adminform">
			<tr>
				<td colspan="3">* Con questi parametri controlliamo le caratteristiche dei contenuti*<br/><br/></td>
			</tr>
			<tr>
				<td width="250">Titoli Ipertestuali:</td>
				<td width="150"><?php echo $lists['link_titles']; ?></td>
				<td><?php
					$tip = 'Se si, il titolo della notizia diventa ipertesto';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Collegamento leggi tutto:</td>
				<td><?php echo $lists['readmore']; ?></td>
				<td><?php
					$tip = 'Se settato su mostra, viene attivato il collegamento <em>leggi tutto</em> quando, oltre al testo introduttivo, esiste anche un testo esteso';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Valutazione/Voto notizie:</td>
				<td><?php echo $lists['vote']; ?></td>
				<td><?php
					$tip = 'Se settato su mostra, un sistema di votazione viene abilitato per gli articoli';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Nome autore:</td>
				<td><?php echo $lists['hideAuthor']; ?></td>
				<td><?php
					$tip = 'Se settato su mostra, il nome autore viene mostrato.  Questo parametro globale pu&ograve; essere individualmente modificato ulteriormente dai parametri dei contenuti.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Data ed ora di creazione:</td>
				<td><?php echo $lists['hideCreateDate']; ?></td>
				<td><?php
					$tip = 'Se settato su mostra, viene mostrata la data ed ora di creazione. Questo parametro globale pu&ograve; essere individualmente modificato ulteriormente dai parametri dei contenuti.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Data ed ora delle modifiche:</td>
				<td><?php echo $lists['hideModifyDate']; ?></td>
				<td><?php
					$tip = 'Se settato su mostra, viene mostrata la data ed ora delle modifiche.  Questo parametro globale pu&ograve; essere individualmente modificato ulteriormente dai parametri dei contenuti.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Visite:</td>
				<td><?php echo $lists['hits']; ?></td>
				<td><?php
					$tip = 'Se settato su mostra, viene mostrato il numero di visite di ogni specifico contenuto.  Questo parametro globale pu&ograve; essere individualmente modificato ulteriormente dai parametri dei contenuti.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Icona PDF:</td>
				<td><?php echo $lists['hidePdf']; ?></td>
				<?php
				if (!is_writable( "$mosConfig_absolute_path/media/" )) {
					echo "<td align=\"left\">";
					echo mosToolTip('Opzione non disponibile quando /cartella la Media non &#232; scrivibile');
					echo "</td>";
				} else {
					?>
					<td>&nbsp;</td>
					<?php
				}
				?>
			</tr>
			<tr>
				<td>Icona stampa:</td>
				<td><?php echo $lists['hidePrint']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Icona E-mail:</td>
				<td><?php echo $lists['hideEmail']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Icone:</td>
				<td><?php echo $lists['icons']; ?></td>
				<td><?php echo mosToolTip('Stampa, PDF ed E-mail utilizzano Icone o Testo'); ?></td>
			</tr>
			<tr>
				<td>Tabella dei contenuti per gli articoli multi pagina:</td>
				<td><?php echo $lists['multipage_toc']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Bottone indietro:</td>
				<td><?php echo $lists['back_button']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Navigatore contenuti:</td>
				<td><?php echo $lists['item_navigation']; ?></td>
				<td>&nbsp;</td>
			</tr>
			</table>
			<input type="hidden" name="config_multilingual_support" value="<?php echo $row->config_multilingual_support?>">
			<?php
		$tabs->endTab();
		$tabs->startTab("Database","db-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Nome Host:</td>
				<td><input class="text_area" type="text" name="config_host" size="25" value="<?php echo $row->config_host; ?>"/></td>
			</tr>
			<tr>
				<td>Username MySQL:</td>
				<td><input class="text_area" type="text" name="config_user" size="25" value="<?php echo $row->config_user; ?>"/></td>
			</tr>
			<tr>
				<td>Database MySQL:</td>
				<td><input class="text_area" type="text" name="config_db" size="25" value="<?php echo $row->config_db; ?>"/></td>
			</tr>
			<tr>
				<td>Prefisso database MySQL:</td>
				<td>
				<input class="text_area" type="text" name="config_dbprefix" size="10" value="<?php echo $row->config_dbprefix; ?>"/>
				&nbsp;<?php echo mosWarning('!! NON MODIFICARE SENZA AVER PRIMA COSTRUITO UN DATABASE CON QUESTO PREFISSO APPLICATO ALLE TABELLE !!'); ?>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Server","server-page");
			?>
			<table class="adminform">
			<tr>
				<td width="215">Percorso (Path) assoluto:</td>
				<td width="420"><strong><?php echo $row->config_absolute_path; ?></strong></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Indirizzo del sito:</td>
				<td><strong><?php echo $row->config_live_site; ?></strong></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Parola segreta:</td>
				<td><strong><?php echo $row->config_secret; ?></strong></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Compressione pagine GZIP:</td>
				<td>
				<?php echo $lists['gzip']; ?>
				<?php echo mosToolTip('Compress buffered output se supportato'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Vita sessione lato pubblico:</td>
				<td>
				<input class="text_area" type="text" name="config_lifetime" size="10" value="<?php echo $row->config_lifetime; ?>"/>
				&nbsp;seconds&nbsp;
				<?php echo mosWarning('Auto logout dopo questo periodo di inattività per gli utenti del <strong>sito/front-end</strong>. Un valore troppo alto potrebbe essere un rischio per la sicurezza!'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Vita sessione lato amministratore:</td>
				<td>
				<input class="text_area" type="text" name="config_session_life_admin" size="10" value="<?php echo $row->config_session_life_admin; ?>"/>
				&nbsp;seconds&nbsp;
				<?php echo mosWarning('Auto logout dopo questo periodo di inattività per gli utenti del <strong>admin/back-end</strong>. Un valore troppo alto potrebbe essere un rischio per la sicurezza!'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Ricorda scadenza pagina amministratore:</td>
				<td>
				<?php echo $lists['admin_expired']; ?>
				<?php echo mosToolTip('Se la sessione &egrave; scaduta, quando rientrate entro 10 minuti di sconnessione, verrete reindirizzati alla pagina che stavate visualizzando prima della sconnessione'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Metodo sessione autenticazione:</td>
				<td>
				<?php echo $lists['session_type']; ?>
				&nbsp;&nbsp;
				<?php echo mosWarning('NOn modificate senza sapere bene cosa state facendo!<br /><br /> Se avete un numero di utenti che utilizzano AOL o dei server Proxy, dovete prendere in considerazione l&acute;utilizzo dell&acute;impostazione Livello 2' ); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Rapporti errori:</td>
				<td><?php echo $lists['error_reporting']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Server per le guide di aiuto:</td>
				<td><input class="text_area" type="text" name="config_helpurl" size="50" value="<?php echo $row->config_helpurl; ?>"/></td>
			</tr>
			<tr>
				<?php
				$mode = 0;
				$flags = 0644;
				if ($row->config_fileperms!='') {
					$mode = 1;
					$flags = octdec($row->config_fileperms);
				} // if
				?>
				<td valign="top">Creazione file:</td>
				<td>
					<fieldset><legend>Permessi file</legend>
						<table cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td><input type="radio" id="filePermsMode0" name="filePermsMode" value="0" onclick="changeFilePermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
								<td><label for="filePermsMode0">Nessun CHMOD a nuovi file (usa quelli predefiniti del server)</label></td>
							</tr>
							<tr>
								<td><input type="radio" id="filePermsMode1" name="filePermsMode" value="1" onclick="changeFilePermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
								<td>
									<label for="filePermsMode1">CHMOD nuovi file</label>
									<span id="filePermsValue"<?php if (!$mode) echo ' style="display:none"'; ?>>
									to:	<input class="text_area" type="text" readonly="readonly" name="config_fileperms" size="4" value="<?php echo $row->config_fileperms; ?>"/>
									</span>
									<span id="filePermsTooltip"<?php if ($mode) echo ' style="display:none"'; ?>>
									&nbsp;<?php echo mosToolTip('Seleziona questa opzione per definire i permessi per i nuovi file creati '); ?>
									</span>
								</td>
							</tr>
							<tr id="filePermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
								<td>&nbsp;</td>
								<td>
									<table cellpadding="0" cellspacing="1" border="0">
										<tr>
											<td style="padding:0px">User:</td>
											<td style="padding:0px"><input type="checkbox" id="filePermsUserRead" name="filePermsUserRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsUserRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsUserWrite" name="filePermsUserWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsUserWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsUserExecute" name="filePermsUserExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="3"><label for="filePermsUserExecute">execute</label></td>
										</tr>
										<tr>
											<td style="padding:0px">Group:</td>
											<td style="padding:0px"><input type="checkbox" id="filePermsGroupRead" name="filePermsGroupRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsGroupRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsGroupWrite" name="filePermsGroupWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsGroupWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsGroupExecute" name="filePermsGroupExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" width="70"><label for="filePermsGroupExecute">execute</label></td>
											<td><input type="checkbox" id="applyFilePerms" name="applyFilePerms" value="1"/></td>
											<td nowrap="nowrap">
												<label for="applyFilePerms">
													Applica ai file esistenti
													&nbsp;<?php
													echo mosWarning(
														'Controlla qui i flag che vengono applicati ai permessi di <em>tutti i file esistenti</em> del sito.<br/>'.
														'<b>UTILIZZO INAPPROPRIATO DI QUESTA OPZIONE POTREBBE RENDERE IL SITO NON OPERATIVO!</b>'
													);?>
												</label>
											</td>
										</tr>
										<tr>
											<td style="padding:0px">World:</td>
											<td style="padding:0px"><input type="checkbox" id="filePermsWorldRead" name="filePermsWorldRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsWorldRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsWorldWrite" name="filePermsWorldWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsWorldWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsWorldExecute" name="filePermsWorldExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="4"><label for="filePermsWorldExecute">execute</label></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<?php
				$mode = 0;
				$flags = 0755;
				if ($row->config_dirperms!='') {
					$mode = 1;
					$flags = octdec($row->config_dirperms);
				} // if
				?>
				<td valign="top">Creazione Cartelle:</td>
				<td>
					<fieldset><legend>Permessi cartelle</legend>
						<table cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td><input type="radio" id="dirPermsMode0" name="dirPermsMode" value="0" onclick="changeDirPermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
								<td><label for="dirPermsMode0">Nessun CHMOD a nuove cartelle (usa quelli predefiniti del server)</label></td>
							</tr>
							<tr>
								<td><input type="radio" id="dirPermsMode1" name="dirPermsMode" value="1" onclick="changeDirPermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
								<td>
									<label for="dirPermsMode1">CHMOD nuove cartelle</label>
									<span id="dirPermsValue"<?php if (!$mode) echo ' style="display:none"'; ?>>
									to: <input class="text_area" type="text" readonly="readonly" name="config_dirperms" size="4" value="<?php echo $row->config_dirperms; ?>"/>
									</span>
									<span id="dirPermsTooltip"<?php if ($mode) echo ' style="display:none"'; ?>>
									&nbsp;<?php echo mosToolTip('Seleziona questa opzione per definire i permessi per nuove cartelle create'); ?>
									</span>
								</td>
							</tr>
							<tr id="dirPermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
								<td>&nbsp;</td>
								<td>
									<table cellpadding="1" cellspacing="0" border="0">
										<tr>
											<td style="padding:0px">User:</td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsUserRead" name="dirPermsUserRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsUserRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsUserWrite" name="dirPermsUserWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsUserWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsUserSearch" name="dirPermsUserSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="3"><label for="dirPermsUserSearch">search</label></td>
										</tr>
										<tr>
											<td style="padding:0px">Group:</td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsGroupRead" name="dirPermsGroupRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsGroupRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsGroupWrite" name="dirPermsGroupWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsGroupWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsGroupSearch" name="dirPermsGroupSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" width="70"><label for="dirPermsGroupSearch">search</label></td>
											<td><input type="checkbox" id="applyDirPerms" name="applyDirPerms" value="1"/></td>
											<td nowrap="nowrap">
												<label for="applyDirPerms">
													Applica alle cartelle esistenti
													&nbsp;<?php
													echo mosWarning(
														'Controlla qui i flag che vengono applicati ai permessi di <em>tutte le cartelle esistenti</em> del sito.<br/>'.
														'<b>UTILIZZO INAPPROPRIATO DI QUESTA OPZIONE POTREBBE RENDERE IL SITO NON OPERATIVO!</b>'
													);?>
												</label>
											</td>
										</tr>
										<tr>
											<td style="padding:0px">World:</td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsWorldRead" name="dirPermsWorldRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsWorldRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsWorldWrite" name="dirPermsWorldWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsWorldWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsWorldSearch" name="dirPermsWorldSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="3"><label for="dirPermsWorldSearch">search</label></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
				<td>&nbsp;</td>
			  </tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Metadata","metadata-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185" valign="top">Meta Description globale del sito:</td>
				<td><textarea class="text_area" cols="50" rows="3" style="width:500px; height:50px" name="config_MetaDesc"><?php echo $row->config_MetaDesc; ?></textarea></td>
			</tr>
			<tr>
				<td valign="top">Meta Keywords globale del sito:</td>
				<td><textarea class="text_area" cols="50" rows="3" style="width:500px; height:50px" name="config_MetaKeys"><?php echo $row->config_MetaKeys; ?></textarea></td>
			</tr>
			<tr>
				<td valign="top">Mostra Meta Tag Titolo:</td>
				<td>
				<?php echo $lists['MetaTitle']; ?>
				&nbsp;&nbsp;&nbsp;
				<?php echo mosToolTip('Mostra il Meta Tag Titolo negli articoli visualizzati'); ?>
				</td>
			  	</tr>
			<tr>
				<td valign="top">Mostra Meta Tag Autore:</td>
				<td>
				<?php echo $lists['MetaAuthor']; ?>
				&nbsp;&nbsp;&nbsp;
				<?php echo mosToolTip('Mostra il Meta Tag Autore negli articoli visualizzati'); ?>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Mail","mail-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Mailer:</td>
				<td><?php echo $lists['mailer']; ?></td>
			</tr>
			<tr>
				<td>Mail da:</td>
				<td><input class="text_area" type="text" name="config_mailfrom" size="50" value="<?php echo $row->config_mailfrom; ?>"/></td>
			</tr>
			<tr>
				<td>Nome da:</td>
				<td><input class="text_area" type="text" name="config_fromname" size="50" value="<?php echo $row->config_fromname; ?>"/></td>
			</tr>
			<tr>
				<td>Percorso (Path) Sendmail:</td>
				<td><input class="text_area" type="text" name="config_sendmail" size="50" value="<?php echo $row->config_sendmail; ?>"/></td>
			</tr>
			<tr>
				<td>SMTP Auth:</td>
				<td><?php echo $lists['smtpauth']; ?></td>
			</tr>
			<tr>
				<td>SMTP User:</td>
				<td><input class="text_area" type="text" name="config_smtpuser" size="50" value="<?php echo $row->config_smtpuser; ?>"/></td>
			</tr>
			<tr>
				<td>SMTP Pass:</td>
				<td><input class="text_area" type="text" name="config_smtppass" size="50" value="<?php echo $row->config_smtppass; ?>"/></td>
			</tr>
			<tr>
				<td>SMTP Host:</td>
				<td><input class="text_area" type="text" name="config_smtphost" size="50" value="<?php echo $row->config_smtphost; ?>"/></td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Cache","cache-page");
			?>
			<table class="adminform" border="0">
			<?php
			if (is_writeable($row->config_cachepath)) {
				?>
				<tr>
					<td width="185">Abilitare cache:</td>
					<td width="500"><?php echo $lists['caching']; ?></td>
					<td>&nbsp;</td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td>Cartella cache:</td>
				<td>
				<input class="text_area" type="text" name="config_cachepath" size="50" value="<?php echo $row->config_cachepath; ?>"/>
				<?php
				if (is_writeable($row->config_cachepath)) {
					echo mosToolTip('La cartella cache &egrave; <b>Scrivibile</b>');
				} else {
					echo mosWarning('La cartella cache &egrave; NON SCRIVIBILE - configurare questa cartella con comando CHMOD 755 prima di attivare la cache');
				}
				?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Durata cache:</td>
				<td><input class="text_area" type="text" name="config_cachetime" size="5" value="<?php echo $row->config_cachetime; ?>"/> secondi</td>
				<td>&nbsp;</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Statistiche","stats-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Statistiche:</td>
				<td width="100"><?php echo $lists['enable_stats']; ?></td>
				<td><?php echo mostooltip('Abilita/disabilita collezione delle statistiche del sito'); ?></td>
			</tr>
			<tr>
				<td>Rapporto visite per data:</td>
				<td><?php echo $lists['log_items']; ?></td>
				<td><span class="error"><?php echo mosWarning('ATTENZIONE : Un numero considerevole di dati verranno storicizzati'); ?></span></td>
			</tr>
			<tr>
				<td>Rapporto stringhe di ricerca:</td>
				<td><?php echo $lists['log_searches']; ?></td>
				<td>&nbsp;</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("SEO","seo-page");
			?>
			<table class="adminform">
			<tr>
				<td width="200"><strong>Ottimizzazione motori di ricerca</strong></td>
				<td width="100">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Search Engine Friendly URL:</td>
				<td><?php echo $lists['sef']; ?>&nbsp;</td>
				<td><span class="error"><?php echo mosWarning('Solo Apache! Rinominare htaccess.txt in .htaccess prima di attivarlo. Se il sito non si trova nella root del server esempio <em>www.miosito.com/joomla</em> aprire il file htaccess.txt con un editor di testo e seguire le istruzioni indicate nel file stesso prima di rinominarlo. '); ?></span></td>
			</tr>
			<tr>
				<td>Titoli pagina dinamici:</td>
				<td><?php echo $lists['pagetitles']; ?></td>
				<td><?php echo mosToolTip('Dinamicamente viene modificato il titolo della pagina per rispecchiare il contenuto della stessa'); ?></td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->endPane();
		
		// show security setting check
		josSecurityCheck();
		?>

		<input type="hidden" name="option" value="<?php echo $option; ?>"/>
		<input type="hidden" name="config_absolute_path" value="<?php echo $row->config_absolute_path; ?>"/>
		<input type="hidden" name="config_live_site" value="<?php echo $row->config_live_site; ?>"/>
		<input type="hidden" name="config_secret" value="<?php echo $row->config_secret; ?>"/>
	  	<input type="hidden" name="task" value=""/>
		</form>
		<script  type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}

}
?>