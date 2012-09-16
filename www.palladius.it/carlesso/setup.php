<?
# globali...

#=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- informazionni sulla base di dati
$dbusuario="root";     		# user del database
$dbpassword="";	       	# password del database
$db="goliardia";	      # nome del database
$dbhost="127.0.0.1";   		# Host della base di dati
$DOVE_SONO="casaric";		# dove è il server, a scopi mnemonici (x non confondere locale con remoto...)
#=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- personalizzazioni
#$dbusuario="root";     		# user del database
#$dbpassword="";	       	# password del database
#$db="goliardia";	      # nome del database
#$dbhost="127.0.0.1";   		# Host della base di dati
#$DOVE_SONO="casaric";		# dove è il server, a scopi mnemonici (x non confondere locale con remoto...)







#  
$lenguaje="italiano";   # Lenguaje de ADN (debe existir el archivo en el 


# PARA DEFINIR EL TIPO DE LETRA Y EL TAMAÑO EDITAR EL ARCHIVO CSS.

$imglogo="barratitulo.jpg";	# logo del sito (DEBE ESTAR UBICADO DENTRO DEL DIRECTORIO "IMG")
$color1="#000000"; 		# per lo sfondo dietro alla celle (centro pagina) tables
$color2="#C0D1DA"; 		# per lo sfondo della cella titolo
$color3="#EDEFF8"; 		# per lo sfondo della celle comuni
$pretab="goliardia";               # da cambiare per ogni sito
$skinPreferita="deepblueric";





#=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-	NON MODIFICARE !!!!


$conexion = mysql_connect($dbhost, $dbusuario, $dbpassword);
mysql_select_db($db, $conexion);




#$paz_db  = "../../database/"; // ci metto il .. xche vengo dalle pagine in /pagine/
#$nome_db = "goliardi.mdb";

$paz_foto_persone = "../immagini/persone/";
$paz_foto_ordini_tn = "../immagini/ordini/";
$paz_foto_ordini = "../immagini/ordini/";
$paz_foto = "../immagini/";
?>
