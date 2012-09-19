<?php
/**
* @version 1.0
* @package Jim
* @copyright (C) 2006 Laurent Belloeil
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @website www.comeonjoomla.net
*/

DEFINE ('_JIM_VERSION','RC1');
// module
// module
DEFINE ('_JIM_MSG','Nachricht');
DEFINE ('_JIM_MSGS','Nachrichten');
DEFINE ('_JIM_UHAVE','Ungelesen.');
// component
DEFINE ('_USRL_USERLIST','Benutzerliste');
DEFINE ('_USRL_HAS','hat');
DEFINE ('_USRL_USERS','registrierte Benutzer');
DEFINE ('_USRL_SEARCH_ALERT','Bitte einen Wert eingeben um zu suchen!');
DEFINE ('_USRL_SEARCH','Finde Benutzer');
DEFINE ('_USRL_ENTER_EMAIL','Email des Benutzers, Name oder Benutzername eingeben');
DEFINE ('_USRL_SEARCH_BUTTON','Suche');
DEFINE ('_USRL_SHOW_ALL','Zeig alle Benutzer');
DEFINE ('_USRL_NAME','Name');
DEFINE ('_USRL_USERNAME','Benutername');
DEFINE ('_USRL_USERTYPE','Benutzertyp');
DEFINE ('_USRL_LIST_ALL','Alle auflisten');
DEFINE ('_USRL_PAGE','Seite');
DEFINE ('_USRL_RESULTS','Ergebnisse');
DEFINE ('_USRL_OF_TOTAL','von insgesamt');
DEFINE ('_USRL_NO_RESULTS','Keine Ergebnisse');
DEFINE ('_USRL_FIRST_PAGE','erste Seite');
DEFINE ('_USRL_PREV_PAGE','vorherige Seite');
DEFINE ('_USRL_NEXT_PAGE','nächste Seite');
DEFINE ('_USRL_END_PAGE','Endseite');
DEFINE ('_JIM_TITLE','Private Messaging');
DEFINE ('_JIM_INBOX','Posteingang');
DEFINE ('_JIM_NO_MSG','Du hast keine Nachrichten');
DEFINE ('_JIM_DELETE','Löschen');
DEFINE ('_JIM_STATUS','Status');
DEFINE ('_JIM_FROM','Von');
DEFINE ('_JIM_SENTDATE',' Datum');
DEFINE ('_JIM_DELETE_SEL','Auswahl löschen');
DEFINE ('_JIM_READ','Lese Nachricht');
DEFINE ('_JIM_MESSAGE','Nachricht');
DEFINE ('_JIM_SENTTIME','Abgeschickt um');
DEFINE ('_JIM_SUBJECT','Betreff');
DEFINE ('_JIM_TO','An');
DEFINE ('_JIM_REPLY','Antworten');
DEFINE ('_JIM_REPLY_SENT','Deine Antwort wurde gesendet.');
DEFINE ('_JIM_MSG_DELETED','Deine Nachricht wurde gelöscht');
DEFINE ('_JIM_NEW','Neue Nachricht');
DEFINE ('_JIM_NO_REC','Bitte wähle einen Empfänger aus');
DEFINE ('_JIM_MSG_SENT','Deine Nachricht wurde gesendet.');
DEFINE ('_JIM_SEND','Nachricht abschicken');
DEFINE ('_JIM_SELECT','Benutzer hinzufügen');
DEFINE ('_JIM_MUREAD','Nachricht ungelesen');
DEFINE ('_JIM_MREAD','Nachricht gelesen');
DEFINE ('_JIM_CLICK','Klicke um die Nachricht zu lesen');
DEFINE ('_JIM_NONE','[kein Betreff]');

DEFINE ('_JIM_PMS','PRIVATE MESSAGING');
DEFINE ('_JIM_RE','RE:');
DEFINE ('_JIM_ERROR','Es ist ein Fehler aufgetreten');
DEFINE ('_JIM_SELECT_TO_DELETE','Bitte wähle zu erst eine Nachricht aus!');
DEFINE ('_JIM_VIEWMESSAGE','Zeige Nachricht');
DEFINE ('_JIM_REPLY_QUOTE','%s schrieb:');
DEFINE ('_JIM_RE','Re:');
DEFINE('_JIM_MAILMSG','Hallo %s, <br /><br /> Du hast eine neue Nachricht von %s am %s erhalten. <br /><br /> Um diese Nachricht anzuzeigen oder zu beantworten logge dich bitte ein %s. <br /><br /> Grüße, <br /><br /> %s Team.<br /><br />');
DEFINE('_JIM_MAILSUB','%s : Du hast eine neue private Nachricht!');
DEFINE('_JIM_CONNECTING','Verbinden');
DEFINE('_JIM_USERDOESNTEXIST','Fehler beim Senden der Nachricht: Benutzer existiert nicht!');
// Admin component
DEFINE('_JIM_COMPNAME','JIM Joomla Internal Messaging');
DEFINE('_JIM_GENERALTAG','General');
DEFINE('_JIM_LICENSETAG','License');
DEFINE('_JIM_EMAILNOTIFY','Emailbenachrichtigung');
DEFINE('_JIM_EMAILNOTIFY_MSG','Sofortige Emailbenachrichtigung für Benutzer an/ausschalten');
DEFINE('_JIM_REFRESHRATE','Module Aktualisierungs Rate');
DEFINE('_JIM_REFRESHRATE_MSG','Wie oft soll das Module überprüfen ob neue Nachrichten angekommen sind? Beispiel: 1 Überprüfung pro 10 Sekunden');
DEFINE('_JIM_TXTCOLUMNS','Textfeld Größe : Columns');
DEFINE('_JIM_TXTCOLUMNS_MSG','Größe der "Neue Nachrichten Box" - Anzahl an columns');
DEFINE('_JIM_TXTROWS','Textfeld Größe : Rows');
DEFINE('_JIM_TXTROWS_MSG','Größe der "Neue Nachrichten Box" - Anzahl an rows.');
DEFINE('_JIM_USERHIDDEN','Verstecke Benutzer in der Liste ');
DEFINE('_JIM_USERHIDDEN_MSG','Der Benutzer, welcher in der Suche Benutzername Box nicht aufgelistet werden soll, z.B Admin.');
DEFINE('_JIM_CBLINK','Verlinke Benutzer zum CB');
DEFINE('_JIM_CBLINK_MSG','Verlinkt Benutzer mit ihrem Community Builder Profil');
DEFINE('_JIM_ALLOWSEARCH','Erlaube Benutzernamesuche');
DEFINE('_JIM_ALLOWSEARCH_MSG','Schaltet die Benutzernamesuche an/aus (Autocomplete)');
DEFINE('_JIM_CONFIGSAVED','Änderungen erfolgreich gespeichert!');
DEFINE('_JIM_CONFIGERROR','Config file is not writeable!');
DEFINE('_JIM_MODCSS','Use buttons or tabs?');//changed in RC1
DEFINE('_JIM_MODCSS_MSG','Select yes for buttons or no for tabs');//changed in RC1
//Added in RC1 to display outbox
DEFINE('_JIM_READ_STATUS','Read');
DEFINE('_JIM_OUTBOX','Outbox');
//Added in 1.0 stable to manage language files in next releases. Not yet used
DEFINE('_JIM_LANG_AUTHOR',"Laurent Belloeil");
DEFINE('_JIM_LANG_URI',"http://www.comeonjoomla.net");
DEFINE('_JIM_LANG_MAIL',"lbelloeil@comeonjoomla.net");
DEFINE('_JIM_LANG_DATE',"06/25/2006");
// added in 1.0.1 to ensure security
DEFINE('_JIM_NOAUTH',"Please login or register to send messages");
?>
