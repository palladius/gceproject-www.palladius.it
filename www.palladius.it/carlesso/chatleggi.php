<?
include "chatheader.php";

global $MAXMESSAGGI;

if (! Session("nickname")) exit;
	


$nickname = Session("nickname");

//if (Application("messaggi")==null) Application("messaggi") = "";
//if (Application("online")==null) Application("online") = "";


$messaggi = getApplication("messaggi");
$frase = explode("\$",$messaggi);

$d = date("y-m-d h:i:s");
$t = time();

$online = getApplication("online");
$stringa_utente = explode("\$",$online);
$cisono = false;

visualizzaArrayMini($stringa_utente);

for ($i=0;$i<sizeof($stringa_utente);$i++) {
  $aux = split("@",$stringa_utente[$i]);
  visualizzaArrayMini($aux);

  if ($aux[0]==$nickname) {
    $stringa_utente[$i] = $nickname . "@" . time();
    $cisono = TRUE;
  } else 
	if (isset($aux[1]))
	{
	    $delta = $t - intval($aux[1]);
	    if ($delta>60000) $stringa_utente[$i] = ""; // aumentato delta t da 60000 a 600'000 (un minuto a 10 minuti...)
		//php VENERDI speriamo sian millisecondi, se son secondi diventa ENORME!
	  }
}
if (!$cisono)
  $stringa_utente[sizeof($stringa_utente)] = $nickname . "@" . $t;

$online = "";

echo "stringa_utente vale $stringa_utente ed è lungo: ".sizeof($stringa_utente).".";
 visualizzaArrayMini($stringa_utente);
 
for ($i=0;$i<sizeof($stringa_utente);$i++)
{ if ($stringa_utente[$i]!="") 
	{
    	if ($online!="") $online .= "\$";
    		$online .= $stringa_utente[$i];
	}
} 
setApplication("online",$online);

?>
<html>
<head>
  <title>Carlessoèunfigo® Chat</title>
  <meta http-equiv="refresh" content="10">


<style>
    a {text-decoration: none; color: navy}
    a:hover {color: red}
</style>

  </head>
<body class='bkg_chat'>

<center><table cellspacing="0" cellpadding="0" width="<?=$CONSTLARGEZZA600?>" height="20" border="0"><tbody><tr><td>



<table border="0" width="150" align="right">

<? 
	if (isAdminVip())	// x i soli superadmin
{
?>	
	<tr><td  align='right' class=bkg_chat><b>
	<i>admin:</i>


	 <a href="chatscrivi.php?speciale=svuotachat" target="scrivi">
	 <font size='-4'>CLEARCHAT!</font></a>

	</b>&nbsp;</td></tr>
<?
}

for ($i=0;$i<sizeof($stringa_utente);$i++)
  if ($stringa_utente[$i]!="") {
	$tmppp = split("@",$stringa_utente[$i]);
	$nome = $tmppp[0];
	// da togliere
	$nome .= " ($tmppp[1])";
?>

	<tr><td  align='right' class=bkg_chat><b>
	<a href="chatscrivi.php?per=<?=escape($nome)?>" target="scrivi" class="InizialeMaiuscola">
	<?=$nome?></a>
<? if ((Session("livello"))=="sbur-user")
{
?>	
	<a href="chatscrivi.php?braghe=<?=escape($nome)?>" target="scrivi" >
	 <font size='-4'><img src="../immagini/giu(inbraghe).gif" border="0"></font></a>
	<a href="chatscrivi.php?surge=<?=escape($nome)?>" target="scrivi" class="InizialeMaiuscola">
	<font size='-4'><img src="../immagini/su(surge).gif" border="0"></font></a>

<? } ?>
	</b>&nbsp;</td></tr>
	
<?
  }
?>
<!---	<center><tr><td>
	  <img src="../immagini/icone/nobarplaying.gif" height="110">
	</td></tr></center>
--->
</table>

<?
// Stampo i messaggi correnti

for ($i=0;$i<sizeof($frase);$i++) {
  $aux = split("@",$frase[$i]);

  if (sizeof($aux)>3 && ($aux[2]=="" || $aux[1]==$nickname || $aux[2]==$nickname ||  $aux[2]=="__SPECIALE__")) {
			
				//  if (aux.length>3 && (aux[2]=="" || aux[1]==nickname || aux[2]==nickname || nickname=="palladius" || aux[2]=="__SPECIALE__")) {

    if (contiene(strval($aux[3]),"/a"))
	{
	 $aux[2]="__SPECIALE__" ;
	}

    if ($aux[3] && $aux[2] != "__SPECIALE__" && $aux[2] != "") // msg x qualcuno, non speciale
	{
    ?>
		<font size='-1'><?=$aux[0]?></font> 
	    <font color='blue'><b class=inizialemaiuscola><?=$aux[1]?></b></font>
	    <font color='green' size='-1'><i>(per <b class=inizialemaiuscola><?=$aux[2]?></b>)</i></font>
         - <?=$aux[3]?><br>
	<?
	}
	else
    if ($aux[2]=="__SPECIALE__" || $aux[3]) // tipo il /a di energy....
	{
	?>
		<font size='1'><?=$aux[0]?></font>
		<font color='blue'> <i class=inizialemaiuscola><?=$aux[1]?></i> <i><?=$aux[3]?></i></font>.<br>
	<?
	}
	else
	{
     	echo("<font size='1'>" .$aux[0] . "</font> ");
    	echo("<font color='blue'><b class=inizialemaiuscola>" .$aux[1] . "</b></font>");
    	if ($aux[2]!="") 
		echo(" <font color='green' size='-1'><i>(per <b>" .$aux[2] ."</b>)</i></font>");	
    	echo(" - ");
    	echo($aux[3] + ".<br>");




	}
  }
}




?>
</td>
</tr>
</tbody></table>




