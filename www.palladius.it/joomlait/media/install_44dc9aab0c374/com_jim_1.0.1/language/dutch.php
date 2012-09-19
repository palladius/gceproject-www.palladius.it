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
DEFINE ('_JIM_MSG','bericht');
DEFINE ('_JIM_MSGS','berichten');
DEFINE ('_JIM_UHAVE','Ongelezen.');
// component
DEFINE ('_USRL_USERLIST','Gebruikerslijst');
DEFINE ('_USRL_HAS','heeft');
DEFINE ('_USRL_USERS','geregistreerde gebruikers');
DEFINE ('_USRL_SEARCH_ALERT','Vul een zoekwoord in!');
DEFINE ('_USRL_SEARCH','Vindt gebruikers');
DEFINE ('_USRL_ENTER_EMAIL','Vul de naam, gebruikersnaam of emailadres van de gebruiker in');
DEFINE ('_USRL_SEARCH_BUTTON','Zoeken');
DEFINE ('_USRL_SHOW_ALL','Toon alle gebruikers');
DEFINE ('_USRL_NAME','Naam');
DEFINE ('_USRL_USERNAME','Gebruikersnaam');
DEFINE ('_USRL_USERTYPE','Gebruikersrang');
DEFINE ('_USRL_LIST_ALL','Toon alles');
DEFINE ('_USRL_PAGE','Pagina');
DEFINE ('_USRL_RESULTS','Resultaten');
DEFINE ('_USRL_OF_TOTAL','van totaal');
DEFINE ('_USRL_NO_RESULTS','Geen resultaten');
DEFINE ('_USRL_FIRST_PAGE','eerste pagina');
DEFINE ('_USRL_PREV_PAGE','vorige pagina');
DEFINE ('_USRL_NEXT_PAGE','volgende pagina');
DEFINE ('_USRL_END_PAGE','laatste pagina');
DEFINE ('_JIM_TITLE','Prive berichten');
DEFINE ('_JIM_INBOX','Inbox');
DEFINE ('_JIM_NO_MSG','U heeft geen nieuwe berichten.');
DEFINE ('_JIM_DELETE','Verwijder');
DEFINE ('_JIM_STATUS','Status');
DEFINE ('_JIM_FROM','Van');
DEFINE ('_JIM_SENTDATE',' Datum');
DEFINE ('_JIM_DELETE_SEL','Verwijder geselecteerde berichten');
DEFINE ('_JIM_READ','Lees bericht');
DEFINE ('_JIM_MESSAGE','Bericht');
DEFINE ('_JIM_SENTTIME','Verzonden op');
DEFINE ('_JIM_SUBJECT','Onderwerp');
DEFINE ('_JIM_TO','Aan');
DEFINE ('_JIM_REPLY','Antwoorden');
DEFINE ('_JIM_REPLY_SENT','Uw antwoord werd verzonden.');
DEFINE ('_JIM_MSG_DELETED','Uw bericht werd verwijderd.');
DEFINE ('_JIM_NEW','Nieuw bericht');
DEFINE ('_JIM_NO_REC','Selecteer een ontvanger');
DEFINE ('_JIM_MSG_SENT','Uw bericht werd verzonden.');
DEFINE ('_JIM_SEND','Verzend bericht');
DEFINE ('_JIM_SELECT','Gebruiker toevoegen');
DEFINE ('_JIM_MUREAD','Ongelezen bericht');
DEFINE ('_JIM_MREAD','Bericht gelezen');
DEFINE ('_JIM_CLICK','Klik hier om het bericht te lezen');
DEFINE ('_JIM_NONE','[GEEN]');

DEFINE ('_JIM_PMS','PRIVE BERICHTEN');
DEFINE ('_JIM_RE','Aw:');
DEFINE ('_JIM_ERROR','Er heeft zich een fout voorgedaan!');
DEFINE ('_JIM_SELECT_TO_DELETE','Selecteer eerst een bericht!');
DEFINE ('_JIM_VIEWMESSAGE','Bekijk bericht');
DEFINE ('_JIM_REPLY_QUOTE','%s schreef:');
DEFINE ('_JIM_RE','Aw:');
DEFINE('_JIM_MAILMSG','Beste %s, <br /><br /> U heeft een nieuw bericht ontvangen van %s op %s. <br /><br /> Indien u op dit bericht wenst te antwoorden, logt u in op %s. <br /><br /> Met vriendelijke groet, <br /><br /> %s Team.<br /><br />');
DEFINE('_JIM_MAILSUB','%s : U heeft een nieuw bericht!');
DEFINE('_JIM_CONNECTING','Bezig met verbinden');
DEFINE('_JIM_USERDOESNTEXIST','Error bij het verzenden van het bericht : Deze gebruiker bestaat niet!');
// Admin component
DEFINE('_JIM_COMPNAME','JIM Joomla Internal Messaging');
DEFINE('_JIM_GENERALTAG','Algemeen');
DEFINE('_JIM_LICENSETAG','Licentie');
DEFINE('_JIM_EMAILNOTIFY','Email Notificatie');
DEFINE('_JIM_EMAILNOTIFY_MSG','Zet emailnotificatie aan of uit voor de gebruikers.');
DEFINE('_JIM_REFRESHRATE','Module verversingstijd');
DEFINE('_JIM_REFRESHRATE_MSG','Het aantal seconden dat dient te verstrijken voor er gecontroleerd wordt op nieuwe berichten in seconden. Bijvoorbeeld 1 controle per 10 seconden');
DEFINE('_JIM_TXTCOLUMNS','Tekstvakgrootte : kolommen');
DEFINE('_JIM_TXTCOLUMNS_MSG','Grootte van de het tekstvak waar u een bericht schrijft - aantal kolommen');
DEFINE('_JIM_TXTROWS','Tekstvakgrootte : Rijen');
DEFINE('_JIM_TXTROWS_MSG','Grootte van de het tekstvak waar u een bericht schrijft - aantal rijen.');
DEFINE('_JIM_USERHIDDEN','Verberg gebruikers in de lijst ');
DEFINE('_JIM_USERHIDDEN_MSG','De gebruikers waarvan u niet wenst dat deze getoond worden in de zoek gebruikers box, zoals admin.');
DEFINE('_JIM_CBLINK','Link gebruikers aan CB');
DEFINE('_JIM_CBLINK_MSG','Link de gebruikers aan het Community builder profiel.');
DEFINE('_JIM_ALLOWSEARCH','Zoeken in gebruikersnamen toestaan');
DEFINE('_JIM_ALLOWSEARCH_MSG','Schakel het zoeken naar gebruikers aan of uit (Automatisch voltooien)');
DEFINE('_JIM_CONFIGSAVED','Instellingen succesvol opgeslagen!');
DEFINE('_JIM_CONFIGERROR','Configuratiebestand is tegen schrijven beveiligd!');
DEFINE('_JIM_MODCSS','Gebruik Knoppen of Tabs');//changed in RC1
DEFINE('_JIM_MODCSS_MSG','Selecteer Yes voor knoppen of NO voor tabs');//changed in RC1
//Added in RC1 to display outbox
DEFINE('_JIM_READ_STATUS','Gelezen');
DEFINE('_JIM_OUTBOX','Outbox');
//Added in 1.0 stable to manage language files in next releases. Not yet used
DEFINE('_JIM_LANG_AUTHOR',"Laurent Belloeil");
DEFINE('_JIM_LANG_URI',"http://www.comeonjoomla.net");
DEFINE('_JIM_LANG_MAIL',"lbelloeil@comeonjoomla.net");
DEFINE('_JIM_LANG_DATE',"06/25/2006");
// added in 1.0.1 to ensure security
DEFINE('_JIM_NOAUTH',"Graag inloggen of registreren om een bericht te versturen");

?>
