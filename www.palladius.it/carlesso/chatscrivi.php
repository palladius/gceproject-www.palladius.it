<?



include "chatheader.php";

//echo "CIAO a (".$_SESSION["_SESS_nickname"].")"; 
//echo("CIAOOOOOO: (Session nickname)".Session("nickname"));

if (!(Session("nickname"))) exit;
//if (getApplication("messaggi")==null) 
//	setApplication("messaggi","provaric");

//visualizzaDebug();



if ((Form("operazione"))=="muori")
	{
?>
<body class='bkg_chat'>
<center>
<?
	echo ("<table width=$CONSTLARGEZZA600><tr><td>Grazie. Ho notificato agli altri che tu sei uscito e SO che non sei + in chat. ".
			"Un giorno questo pagherà: quando scade una sessione e uno è considerato in chat diminuirò drasticamente i suoi".
			" Goliard Pointz® x punizione. :) </td></tr></table>");
	setSession("chatVergine","diNuovoVergine");
	if ($PUBBL_MSG_ENTRA_ESCI)
		addMessaggio(getMessaggio(Session("nickname"),"__SPECIALE__"," è appena uscito dalla Chat"));
?>
<form name="f1" method="post" action="chatscrivi.php">
  <input type="button" value="MUORI DAVVERO, ORA." onClick="parent.close()">
</form>
</center>
</body>
<?
	exit;
	}



if (Session("chatVergine") != "sverginato")
	{
	if ($PUBBL_MSG_ENTRA_ESCI)
		addMessaggio(getMessaggio(Session("nickname"),"__SPECIALE__"," è appena entrato in Chat"));
	setSession("chatVergine","sverginato");
	}




function getMessaggio($nickname, $destinatario, $testo)
{
// $d1 = new Date();
//  ore1=d1.getHours();
//  orariuz = ""+ ((ore1)<10 ? " ":"")+ ore1 + ":" + (d1.getMinutes()<10 ? "0":"")+d1.getMinutes(); // spazio x le ore, zero x i minuti
 $orariuz = date("h:i"); 

 return  $orariuz ."@" . $nickname . "@" . $destinatario. "@" . $testo;
}

function addMessaggio($msg)
{
 global $MAXMESSAGGI;

  $messaggi = getApplication("messaggi");
  echo "messaggi valeva ($messaggi)";
//  if (empty($messaggi)) 	$messaggi="";

  $frase = explode("\$",$messaggi);
	
  echo "frase è lunga: (".sizeof($frase).")";

 $msg="";

  for ($i=0;$i<sizeof($frase) && $i<$MAXMESSAGGI-1;$i++)
    $msg .= "\$" . $frase[$i];

  echo "aggiungo a messaggi il valore di msg: ($msg)";


  setApplication("messaggi",$msg);
  echo "messaggi post setApp vale: ($messaggi)";
}

$isPalladius=((Session("nickname"))=="palladius");

$colori = array (



 	$isPalladius ?  "#000077" // blu scurito un pelo
			:  "#333333", // grigione
	"#FF0000", // rosso
	"#000000", // nero
	"#FF1493", // viola
	"#008800"  // verde


			);

$icone = array  (
		"../immagini/persone/palladius4.jpg",
		"../immagini/1.gif",
		"../immagini/2.gif",
		"../immagini/3.gif",
		"../immagini/4.gif",
		"../immagini/5.gif",
		"../immagini/cuorechepulsa.gif",
		"../immagini/ditone.gif",
		"../immagini/cesso.gif"
			);

$nickname = (Session("nickname"));
$testo = (Form("testo"));
$destinatario = (Form("destinatario"));
//if (destinatario=="undefined") destinatario = "";
$col = intval(Form("colore"));
//if (isNaN(col) || col<0 || col>=colori.length) col = 0;

echo "sto x scrivere il testo $testo...";

if (!empty($testo))	//($testo!="undefined" && $testo!="")
 {
  $testo = replace($testo,"@","&#64;");
  $testo = replace($testo,"\$","&#36;");
  $testo = replace($testo,"<","&lt;");
  $testo = replace($testo,">","&gt;");


  if ((Session("erremoscia"))) //sarebbe true
	{$testo = replace($testo,"r","<i>v</i>");
	 $testo = replace($testo,"R","<i>V</i>");
	}

  $testo = replace($testo,":\)","<img src='".$icone[1]."'>");
  $testo = replace($testo,":\(","<img src='".$icone[2]."'>");
  $testo = replace($testo,";\)","<img src='".$icone[3]."'>");
  $testo = replace($testo,":D","<img src='".$icone[4]."'>");
  $testo = replace($testo,":P","<img src='".$icone[5]."'>");
  $testo = replace($testo,"\(C\)","<img src='".$icone[6]."' height='20' align='Center'>");
  $testo = replace($testo,":dit","<img src='".$icone[7]."' height='20' align='Center'>");




  $testo = replace($testo,"scusa","vaffanculo (ma solo xchè scusa non si chiede)");
  $testo = replace($testo,"grazie","ti darò il culo x questo");
//   $testo = replace($testo,"grazie","denghiu");
    $testo = replace($testo,"prego","<i>of nothing, for you this and other®</i>");
  $testo = replace($testo,"cazzo","<b>turbominchia</b>");
  $testo = replace($testo,"merda","<b>Oca</b>");
//  $testo = replace($testo,"goliardia","<b>In questo sito non parleremo che di <i>goGliardia</i>: quella vera - invece - la faremo al bar!!!</b>");
  $testo = replace($testo,"buongiorno","<i>mittttticccccoooooo!!!! ... mabbbaaaaaffanculo!</i>");
  $testo = replace($testo,"palladius","<i>qgfd®</i> <b>Palladius®</b>");
//  $testo = replace($testo,"ciao","Serpide e Iceberg s'inseguono in un'eterna ghirlanda brillante di luci e colori");
//  $testo = replace($testo,"ciao","io amo Serpide e odio Palladius");
    $testo = replace($testo,"ciao","viva Palladius e i suoi schizzi creativi®");
  $testo = replace($testo,"a dopo","<i>Palladius è proprio un gran Figo, devo ammettere. Un saluto</i>");
//  $testo = replace($testo,"vado","<i>mi accingo ad andare</i>");

$balbuziente = FALSE; // true; //(String(Session("nickname")) == "lapalisse");

if ($balbuziente)
	{
	$testo= replace($testo,"ba","b-ba");
	$testo= replace($testo,"pe","p-pe");
	$testo= replace($testo,"da","d-da");
	$testo= replace($testo,"ci","c-ci");
	}

// sostituzione del /a
  if (contiene($testo,"/a"))
{
$testo=$testo.substring(3);
$destinatario="__SPECIALE__";
}	
else 
  $testo = "<font color='" .$colori[$col] . "'>" . $testo . "</font>";

  $nuova = getMessaggio($nickname,$destinatario,$testo);
  addMessaggio($nuova);
}

$per = (querystring("per"));
	//if (per=="undefined") per = "";

// gestione degli speciali...

$specialfrase = (querystring("speciale"));
if ($specialfrase == "svuotachat")
	if (isAdminVip())
		{scrivi("azzero le frasi scritte. Potere di zio Pal...");
		 setApplication("messaggi", "");
		}

// GESTIONE DELLE BRAGHE


bragheInit();

$bragheqs = (querystring("braghe"));

if (! empty($bragheqs))
	 	{bragheAdd($bragheqs);
		 echo ("<center><i>mandato in braghe quel turbominchione® di <b>$bragheqs</b></i></center>");
		}
$bragheqs = (querystring("surge"));
if (! empty($bragheqs))
		{bragheRemove($bragheqs);
		 echo("<center><i>fatto surgere quel mammalucco di <b>$bragheqs</b></i></center>");
		}





?>


<html>
<head>
  <title>qgfd Palladius' Prodaxions</title>
</head>
<body onLoad="document.f1.$testo.focus()" class='bkg_chat_cosinonva'>


<center><table cellspacing="0" cellpadding="0" width="<?=CONSTLARGEZZA600?>" height="20" border="0"><tbody><tr><td>

<form name="f1" method="post" action="chatscrivi.php">
	<center>
  <input type="text" name="testo" size="40">
  <select name="colore">
    <option value="0"<?=($col==0) ? " selected" : ""?>><?=($isPalladius? "blu Pal" : "grigino" )?></option>
    <option value="1"<?=($col==1) ? " selected" : ""?>>rosso</option>
    <option value="2"<?=($col==2) ? " selected" : ""?>>nero</option>
    <option value="3"<?=($col==3) ? " selected" : ""?>>viola</option>
    <option value="4"<?=($col==4) ? " selected" : ""?>>verde</option>
  </select>
  <? if ($per!="") { ?>
  <input type="hidden" name="destinatario" value="<?=per?>">
  <input type="submit" value="Invia a <?=strtoupper($per)?>">
  <? } else { ?>
  <input type="submit" value="Invia">
  <? } ?>
  <input type="button" value="Aggiorna" onClick="parent.leggi.location.reload();parent.footer.location.reload();">
<? //=(" ...    <i>(<b>"+Session("nickname")+"</b>)</i>")
?>
</form>
<form name="f2" method="post" action="chatscrivi.php">
  <input type="hidden" name="operazione" value="muori">
  <input type="hidden" name="nome" value="<?=Session("nickname")?>">
  <input type="submit" value="Esci dolcemente">
</form>

</td></tr></table>



<table width=<?=$CONSTLARGEZZA600 ?>><tr><td>
<font size="-1">

	<b>N.B. La chat è ora + veloce ma unreliable: potreste esperiezare frasi scritte ma NON visualizzate... in pratica d'ora in poi dei messaggi verran persi!</b><br>
	Questa è la chat di quel gran figo di Palladius. Ora c'è anche l'<i>autofocus</i>, se notate. 
	Attenzione, se siete nuovi: molte parole vengono trasformate in altre per il vostro 
	ma soprattutto MIO divertimento. A voi scoprire quali cambiamenti...
	
</font>
</tr></td></table>

<script>
document.f1.$testo.focus();
</script>


<table border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td valign="top" colspan="2" bgcolor="#663399"><img src="pixel.gif" width="<?=CONSTLARGEZZA600?>" height="1" alt="" border="0"></td>
</tr>
</tbody></table>



</body>
</html>