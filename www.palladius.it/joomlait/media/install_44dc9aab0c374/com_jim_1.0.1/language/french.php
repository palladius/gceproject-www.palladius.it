<?php
/**
* @version 1.0
* @package Jim
* @copyright (C) 2006 Laurent Belloeil
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @website www.comeonjoomla.net
*/


DEFINE ('_JIM_VERSION',"2.5.0");
// module
DEFINE ('_JIM_MSG',"message");
DEFINE ('_JIM_MSGS',"messages");
DEFINE ('_JIM_UHAVE',"non-lus.");
// component
DEFINE ('_USRL_USERLIST',"Membres");
DEFINE ('_USRL_HAS',"a");
DEFINE ('_USRL_USERS',"utilisateurs enregistr�s");
DEFINE ('_USRL_SEARCH_ALERT',"Veuillez entrer une valeur � rechercher!");
DEFINE ('_USRL_SEARCH',"Trouver un membre");
DEFINE ('_USRL_ENTER_EMAIL',"Entrez un nom ou un Email");
DEFINE ('_USRL_SEARCH_BUTTON',"Rechercher");
DEFINE ('_USRL_SHOW_ALL',"Voir tous les membres");
DEFINE ('_USRL_NAME',"Nom");
DEFINE ('_USRL_USERNAME',"Nom d'utilisateur");
DEFINE ('_USRL_USERTYPE',"Type d'utilisateur");
DEFINE ('_USRL_LIST_ALL',"Voir tous");
DEFINE ('_USRL_PAGE',"Page");
DEFINE ('_USRL_RESULTS',"Resultats");
DEFINE ('_USRL_OF_TOTAL',"sur un total");
DEFINE ('_USRL_NO_RESULTS',"Pas de resultat");
DEFINE ('_USRL_FIRST_PAGE',"premi�re page");
DEFINE ('_USRL_PREV_PAGE',"page pr�c�dente");
DEFINE ('_USRL_NEXT_PAGE',"page suivante");
DEFINE ('_USRL_END_PAGE',"derni�re page");
DEFINE ('_JIM_TITLE',"Messagerie priv�e");
DEFINE ('_JIM_INBOX',"Bo�te de r�ception");
DEFINE ('_JIM_NO_MSG',"Vous n'avez pas de nouveau message.");
DEFINE ('_JIM_DELETE',"Effacer");
DEFINE ('_JIM_STATUS',"Etat");
DEFINE ('_JIM_FROM',"De");
DEFINE ('_JIM_SENTDATE'," Date");
DEFINE ('_JIM_DELETE_SEL',"Effacer la s�lection");
DEFINE ('_JIM_READ',"Voir le message");
DEFINE ('_JIM_MESSAGE',"Message");
DEFINE ('_JIM_SENTTIME',"Heure d'envoi");
DEFINE ('_JIM_SUBJECT',"Sujet");
DEFINE ('_JIM_TO',"�");
DEFINE ('_JIM_REPLY',"Repondre");
DEFINE ('_JIM_REPLY_SENT',"Votre r�ponse a �t� envoy�e.");
DEFINE ('_JIM_MSG_DELETED',"Votre message a �t� effac�.");
DEFINE ('_JIM_NEW',"Nouveau Message");
DEFINE ('_JIM_NO_REC',"Veuillez choisir un destinataire");
DEFINE ('_JIM_MSG_SENT',"Votre message a �t� envoy�.");
DEFINE ('_JIM_SEND',"Envoyer le Message");
DEFINE ('_JIM_SELECT',"Ajouter un destinataire");
DEFINE ('_JIM_MUREAD',"Message non-lu");
DEFINE ('_JIM_MREAD',"Message read");
DEFINE ('_JIM_CLICK',"Clickez pour lire message");
DEFINE ('_JIM_NONE',"[aucun]");

DEFINE ('_JIM_PMS',"MESSAGERIE PRIVEE");
DEFINE ('_JIM_RE',"RE:");
DEFINE ('_JIM_ERROR',"Une erreur est survenue!");
DEFINE ('_JIM_SELECT_TO_DELETE',"Veuillez s�lectionner d'abord un message!");
DEFINE ('_JIM_VIEWMESSAGE',"Voir le Message");
DEFINE ('_JIM_REPLY_QUOTE',"%s a �crit:");
DEFINE ('_JIM_RE',"Re:");
DEFINE('_JIM_MAILMSG',"Bonjour %s,<br /> Vous avez re�u un nouveau message priv� de %s sur <a href=\"%s\">%s</a>. <br /> Pour lire ou r�pondre � ce message, veuillez vous connecter � votre messagerie. <br /> Cordialement, <br /> L'�quipe %s.<br />");
DEFINE('_JIM_MAILSUB',"%s : Vous avez un nouveau message priv�!");
DEFINE('_JIM_CONNECTING',"Connection");
DEFINE('_JIM_USERDOESNTEXIST',"Erreur lors de l'envoi du message : Le destinataire n'existe pas!");
// Admin component
DEFINE('_JIM_COMPNAME',"JIM Messagerie Interne pour Joomla");
DEFINE('_JIM_GENERALTAG',"G�n�ral");
DEFINE('_JIM_LICENSETAG',"Licence");
DEFINE('_JIM_EMAILNOTIFY',"Email d'avertissement");
DEFINE('_JIM_EMAILNOTIFY_MSG',"Active ou d�sactive l'envoi d'un mail d'avertissement � l'arriv�e d\un nouveau message.");
DEFINE('_JIM_REFRESHRATE',"Fr�quence de rafraichissement du module");
DEFINE('_JIM_REFRESHRATE_MSG',"Fixe le d�lai (en secondes) entre chaque v�rification de nouveaux messages par le module");
DEFINE('_JIM_TXTCOLUMNS',"Taille de la zone de texte : Colonnes");
DEFINE('_JIM_TXTCOLUMNS_MSG',"D�termine la taille de la zone de saisie des message - nombre de colonnes");
DEFINE('_JIM_TXTROWS',"Taille de la zone de texte : Lignes");
DEFINE('_JIM_TXTROWS_MSG',"D�termine la taille de la zone de saisie des message - nombre de lignes.");
DEFINE('_JIM_USERHIDDEN',"Utilisateur masqu� ");
DEFINE('_JIM_USERHIDDEN_MSG',"L'utilisateur que vous ne voulez pas voir apparaitre dans la liste, comme l'admin.");
DEFINE('_JIM_CBLINK',"Lier les utilisateurs CB");
DEFINE('_JIM_CBLINK_MSG',"Utlise les profils des utilisateurs de Community Builder.");
DEFINE('_JIM_ALLOWSEARCH',"Autoriser la recherche par nom");
DEFINE('_JIM_ALLOWSEARCH_MSG',"Active ou d�sactive la recherche du nom du destinataire (Autocomplete)");
DEFINE('_JIM_CONFIGSAVED',"Configuration sauvegard�e!");
DEFINE('_JIM_CONFIGERROR',"Impossible d'�crire dans le fichier de configuration!");
DEFINE('_JIM_MODCSS',"Utiliser des boutons ou des onglets?");//changed in RC1
DEFINE('_JIM_MODCSS_MSG',"Choisissez 'oui' pour les boutons ou 'non' pour les onglets");//changed in RC1
//Added after RC1
DEFINE('_JIM_READ_STATUS',"Lu");//read
DEFINE('_JIM_OUTBOX',"Envoy�s");//sent
//Added in 1.0 stable to manage language files in next releases. Not yet used
DEFINE('_JIM_LANG_AUTHOR',"Laurent Belloeil");
DEFINE('_JIM_LANG_URI',"http://www.comeonjoomla.net");
DEFINE('_JIM_LANG_MAIL',"lbelloeil@comeonjoomla.net");
DEFINE('_JIM_LANG_DATE',"06/25/2006");
// added in 1.0.1 to ensure security
DEFINE('_JIM_NOAUTH',"Veuillez vous connecter pour envoyer des messages");

?>
