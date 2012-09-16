<?

include "funzioniphpnuove.php";





function h1($x) {return "<h1>$x</h1>";}



function formBegin($pagina,$nome="")
{
global $AUTOPAGINA;
echo "<form method='post' action='$pagina' name='$nome'>\n";
formhidden("hidden_tornaindietroAUTOMATICOFORM",$AUTOPAGINA);
}



function lineaViola($larg=200)
{
//echo "linea viola lunga $pixel..";
?>
<table border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td valign="top" colspan="2" class="bkg_viola"><img src="pixel.gif" width="<?=$larg?>" height="2" border="0"></td>
</tr>
</tbody></table>
<?
return 42;
}

function setMessaggioSuccessivo($s)
{
scrivi("\n<input type=hidden name='QWERTY_MSG_PRECEDENTE' value='".$s."'>\n");
}

function invio(){echo "<br/>\n";}

function String($x) {return strval($x);}

function bona()
{
$disabilitaIlBona = 0;

invio();
invio();
scrivi("\n<br><i>Termineiting greisfulli ze peig prosessing by chiaming ze mitic fancsion <b>bona()</b>...<br>That for inchais always resolves it all!For a second inchais it uos inizialli progected in order tu cop uiz disorder (don nou if iu ghet ze dabbolsens!!!) bat rait nau it bicams an integrant partof ze control flou (zet dasent min iu'v gat tu control iour eiaculescion, its giast a 'uei of seing' betuin as informatix)</i>");
if ($disabilitaIlBona)
	{echo "<h2>E il terzo giorno lo script è resuscitato e va avanti a esgeuire. Più graceful di così!</h2>"; return;}
include "footer.php";
exit();
}

function scriviTabellaInscatolataBellaEnd()
{
global $SKIN;

if ($SKIN)
{
	CloseTable();
	return;
}
scrivi("</td></tr></table>");
scrivi("</td>\n </tr>\n</table>");
}


function stampaMessaggi($n, $grand,$INSICURO)
{

$sql="SELECT * FROM messaggi m,loginz l"
 ." WHERE m.id_login = l.id_login"
 ." AND m.id_figliodi_msg = 0"
 ." ORDER BY data_creazione DESC";





$res=getRecordSetByQuery($sql);


for ($i=0; $i<$n;$i++)
 if ($rs=mysql_fetch_array($res))
  {
   $msgprivato =  ($rs["pubblico"]);
   $linkami= (!$msgprivato);
   scriviReport_Messaggio($rs,1,0,$i%2);
  }










}


function scriviRecordSetConTimeout($rs,$righemax)
{
$COLORETITOLO  = "#CCFFCC";
$COLORERECORD1 = "#FFCCFF" ;
$COLORERECORD2 = "#CCCCFF" ;
$heightFotoPersone = 28;



$EOF = ! $rs;
if ($EOF)
	 {scrivib("vuoto");return;}

$row = mysql_fetch_row($rs);

if (! isset ($row))
	{
	 scrivib("Errore in scriviRecordSetConTimeout, secondo me la query non è di select");
	 return 0;
	}


$ncolonne=mysql_num_fields($rs);

$encoded= array($ncolonne);

scrivi("<table border='0' >");
scrivi("<tr bgcolor='".$COLORETITOLO."' bordercolordark='#000000'>");

 for ($i=0; $i<$ncolonne; $i++)
    	{$nome=String(mysql_field_name($rs,$i));

	 if (contiene($nome,"encoded"))
		{$nome.=corsivoBluHtml(" (decodificato)");
		 $encoded[$i]=TRUE;
		}
	 else
		 $encoded[$i]=FALSE;

		 scrivi("<td><b><small>".$nome." </small></b></td>");
	}

// CORPO
scrivi("</tr>");
$j=0;
while (($row)  && $j != $righemax || $j<5)
{$j++;
 $EOF = ! $row;

   $TAGBGCOLOR= " bgcolor='".($j%2 ? $COLORERECORD1  : $COLORERECORD2 )."'";
   scrivi("<tr ".$TAGBGCOLOR.">");



 for ($i=0;$i<$ncolonne;$i++)
    {$campo=String($row[$i]);
	 $fieldname_i = String(mysql_field_name($rs,$i));
	scrivi("<td>");

		// foto
	 if (contiene($fieldname_i,"_fotoutente"))
		scrivi("<center><a href='utente.php?nomeutente=".$campo."' border='0'><img src='../immagini/persone/".$campo.".jpg' height='$heightFotoPersone' border='0'></a></center>");
	 else
	 if (contiene($fieldname_i,"_email"))
		scrivi("<a href='mailto:".$campo."' border='0'>".$campo."</a>");
	 else
	 if (contiene($fieldname_i,"_fotoordine"))
		scrivi("<center><a href='modifica_ordine.php?nomeord=".$campo."' border='0'><img src='../immagini/ordini/".$campo."' height='$heightFotoPersone' border='0'></a></center>");
	 else
	 if (contiene($fieldname_i,"_guest"))
		{
		if ($campo=="1")
			scrivi("<center><img src='../immagini/userombrososembraguest.gif' height='$heightFotoPersone'></center>");
		}









	 else
	 if (contiene($fieldname_i,"_data"))
		scrivi($campo);
	 else	// SINGLENESS
	 if (contiene($fieldname_i ,"_single"))
		{if ($campo=="TRUE") 
			 scrivi("<img src='../immagini/semaforoverde.gif' height='$heightFotoPersone '>");
		 else
			 scrivi("<img src='../immagini/semafororosso.gif' height='$heightFotoPersone '>");








		}	
	 else	// SERIO FACETO
	 if (contiene($fieldname_i,"_serio"))
		{if ($campo=="TRUE") // è serio
			 scrivi("<img src='../immagini/serio.gif' height='$heightFotoPersone '>");
		 else
			 scrivi("<img src='../immagini/faceto.gif' height='$heightFotoPersone '>");
		}	
	else // default


		scrivi($campo);

		
		
	if ($encoded[$i])
	{
		scrivi("<br>".corsivoBluHtml(unescape(String($campo))));
	}

	scrivi("</td>");
	}
scrivi("</tr>");
$row=mysql_fetch_row($rs);
}


scrivi("</table>");
scrivi("(Totale: <b>".$j."</b> righe)<br/>");

}

function ridirigi($pag)
{
//header("Location: $pag");
 for ($i=0;$i<2;$i++)
	echo "<h1>Anzichè stupirti con effetti speciali, ti rimando a <a href='$pag'>$pag</a>, venerdì.</h1><br/>";
?>
finchè qualcuno non mi insegna come CAZZO si fa un redirect in PHP a metà pagina, che non è banalmente l'uso di hedaer("location.."); 
o si fa così bufferizzando l'output  e rimangiandosi tuttol'output prima di header(...) o altrimenti esisterà pure un altro modo... AIUTATEMI!

<?
 // come cacchio si fa a ridirigere la gente?!? in asp è banale... fare un GOTO a un'altra pagina...
bona(); // mi sembra d'uopo! dopo posson esserci merdate.
}

function gestisciGoliardPointz($id,$n,$frase)
{echo "dovrei gestire i GP dell'utente $id, con numero $n, e frase $frase. Ma non lo faccio.\n";}



function scriviErroreSpapla($msg,$tornaa)
{
?>
<table bgcolor="#ddddff">
<tr>
 <td><img src="../immagini/ricarrabbiato.jpg" height="100"></td>
 <td><center><?=$msg?><br>torna <a href='<?=$tornaa?>'>indietro</a></center></td>
</tr>
</table>
<?
}


function scrivi($a) {echo $a;}
function scrivib($a) {echo "<b>$a</b>";}

function deltat($titoloEventuale="dflt")
{
//echo "/\\";
//return;
}


function formGiocoCoppie($verboso,$eventualeIdUtente="",$eventualeSesso="")
{
scrivib("FormGiocoCoppie TBDS<br>");
}



function unescape($x)
{return urldecode($x);}



function corsivoBluHtml($msg)
{
	return "<font color=\"blue\"><i>".$msg."</i></font>";
}





function htmlMessaggione($msg)
{
	return "<p><big><font color=\"red\"><b>".$msg."</b></font></big></p>";
}

function rossone($msg)
{
	return "<font color=\"red\"><p>".$msg."</p></font>";
}

function hline($percent="")
{
scrivi("<hr width='".$percent."%' size='2' align='center'/>");
}

function query($q) {return getRecordSetByQuery($q);}

function getRecordSetByQuery($sql)
{

if ($sql == -1)
	{echo "<h1>La query che mi hai dato è '$sql': scommetto che nasce da somma di stringhe alla ASP (+ anzichè .). Guardaci, Ric</h1>";
	}

$result = mysql_query($sql)
	or scrivi("Errore mysql_error: <i>".mysql_error()."</i> nella query '$sql'. Ricorda, ho ucciso (<b>die()</b>) x molto meno.<br/>");

if (! $result)	
	 {echo "mysql query error sulla query <i>'$sql'</i>, so ben me";}

//echo "<br/>Queri: <i>$sql</i><br>Errno: <i>".mysql_errno($conexion)."</i>";
//echo "<br/>righe affette: <i>".mysql_affected_rows($conexion)."</i><br>";
return $result ;
}


function getIdLogin()
{
$nick=Session("SESS_id_utente");
if ($nick=="undefined" || $nick=="")
	return -1;
else
	return intval($nick); // falla ottimizzare a venerdi'
}

function parseInt($x)
{return 2+$x-2;}




function aggiornaIndirizzi()
{
echo "non li aggiorno gli indirizzi x ora, venerdi'. non offenderti. ciao";
}






function formEnd()
{
?></form><?
}

function getFoto($paz,$alt,$h=80)
{

 if (Session("antiprof"))
	return "[antiprof]"; 

 $temp = "<img src='".$paz."' alt='".$alt."' align='Center' ";
 if ($h>0)


	$temp.= "height=$h";

return $temp.">";
}


function getImg($foto,$altezza=0)
{
$paz_foto = "../immagini/";
return getFoto($paz_foto.$foto,$foto,$altezza);
}

function img($foto,$altezza="")
{
scrivi(getImg($foto,$altezza));
}

function tableEnd(){
	scrivi("</table>\n");
}	

function scriviUtentiAttivi()
{
echo "scriviUtentiAttivi: tbds, esempio bello di Application()<br/>";
}


function scriviHeader($arr,$viola,$nero,$bianco)
{
global $CONSTLARGEZZA600;
?>
<table cellspacing="0" cellpadding="0" width="<?=CONSTLARGEZZA600?>" height="20" border="0">
<tbody>
 <tr>
  <td colspan="3" class=bgviola"><img src="pixel.gif" height="1" width="<?=$CONSTLARGEZZA600?>" border="0"><br clear="all">

  </td>
 </tr>
 <tr>
  <td width="1" class=bgviola">
	<img src="pixel.gif" height="20" width="1" border="0"><br clear="all">
  </td>
  <td width="<?=$CONSTLARGEZZA600-2?>" class=bgviola">
<?
scrivi("<table width=\"$CONSTLARGEZZA600\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" height=\"20\">");
scrivi("<tbody><tr>");

for ($i=0;isset($arr[$i]);$i++)
	{echo $arr[$i]."\n";	}


?>
</tr></tbody></table>
  <td width="1" class=bgviola>
	<img src="pixel.gif" height="20" width="1" border="0"><br clear="all">
  </td>
  </tr>
 <tr>
  <td colspan="3" class=bgviola><img src="pixel.gif" height="1" width="<?=CONSTLARGEZZA600?>" border="0"><br clear="all">
  </td>
 </tr>
 </tbody>
</table>
<?
}



function visualizzaReport_PollTitolo($idpoll,$veloce)
{
$res1=getRecordSetByQuery("select * from polls_titoli t, polls_domande d,loginz l where t.id_poll="
				.$idpoll." AND l.id_login=id_utente_creatore");

$rs1=mysql_fetch_array($res1);

if ($veloce)
	scrivi("<i>".$rs1["Descrizione"]."</i>");
else
{
scriviTabellaInscatolataBellaBeginVariante($rs1["titolo"],"sondaggi");
scrivib($rs1["descrizione"]."</td></tr>");
scrivi("<tr><td><i>Creato da <b class=inizialemaiuscola>".$rs1["m_snome"].
	 "</b> il ".toHumanDate(time($rs1["dataCreazione"])).
	 "; scade il ".toHumanDate(time($rs1["datafine"]))."</i></td></tr>"
	);
}

}








function visualizzaReport_PollCorpo($idpoll,$veloce)
	{ scrivib("visualizzaReport_PollCorpo($idpoll,$veloce): se l'hai già fatto TU (venerdi') bene, se no lo faccio io domani 5-1. ciao!"); }


function flashTesto($titolo,$w,$h)
{
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0" width="<?=$w?>" height="<?=$h?>">
      <param name=movie value="<?=$titolo?>.swf">
      <param name=quality value=high>
      <param name="BASE" value=".">
      <param name="BGCOLOR" value="">
      <param name="SCALE" value="exactfit">
      <embed src="<?=$titolo?>.swf" base="."  quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" scale="exactfit" width="<?=$w?>" height="<?=$h?>" bgcolor="">
      </embed>
    </object>
<?
}


function scriviTabellaInscatolataBellaBeginVariante($titolo="undefined",$variante="undefined")
{
global $SKIN,$NOMESKIN;

if ($SKIN)
{ if ($titolo != "undefined")

	{	// HA un titolo
	OpenTable();
?>
	<IMG src="skin/<?=$NOMESKIN?>/images/pixel.gif">
	<b><?=$titolo?></b><br>
<?
	return;
	}
	OpenTable();
	return;
}
}


function getUtente()
{
$nick=Session("nickname");
 if ($nick=="undefined" || $nick=="")
	return "ANONIMO";
else
	return $nick;
}



function scriviLogUtentiConOra()
{
global $GETUTENTE;

if (! isAdmin())
	return;
$nickname=$GETUTENTE;
$d = date("h:i");
$t = time();


$online=getApplication("UTENTI_ORA");

scrivid("STRINGA DEBUG: '$online'<br>");
$stringa_utente = explode("\$",$online);
$cisono = FALSE;
for ($i=0;$i<sizeof($stringa_utente);$i++) {
  $aux = explode("@",$stringa_utente[$i]);

  if ($aux[0]==$nickname) 
     	$cisono = TRUE;
   else 
	if (isset($aux[1]))
	{
	//echo "aux vale: $aux[0]-:-$aux[1]...";
    	$delta = $t - intval($aux[1]);
    	scrivi("<b>$aux[0]</b>, da ".intval($delta/60000)."'<br>\n");
    	if ($delta>600000) 
		$stringa_utente[$i] = ""; // aumentato delta t da 60000 a 600'000 (un minuto a 10 minuti...)
  	}
}
if (! $cisono)
	{}//  stringa_utente[stringa_utente.length] = nickname + "@" + t;
$online = "";

for ($i=0;$i<sizeof($stringa_utente);$i++)
  if ($stringa_utente[$i]!="") 
	{
    	if ($online!="") 
		$online .= "$";
    $online .= $stringa_utente[$i];  
	}
setApplication("UTENTI_ORA",$online);


}



//function scriviLogUtentiConOra()
//	{ echo "utenti con ora: TBDS venerdi'<br/>"; }

function tabled()
{
	global $DEBUG;
	scrivi("<table border=".($DEBUG ? 3 : 0).">\n");
}	



function getFotoUtenteDimensionata($utente,$dim)


{
	global $paz_foto,$paz_foto_persone;

	$foto="$utente.jpg";

//echo "getFoto2($paz_foto_persone+$foto,$foto,$dim,$paz_foto-serie/tiposerio.jpg-,$dim).";

	return "\n".
		"<a href='utente.php?nomeutente=$utente'>".
		getFoto2($paz_foto_persone.$foto,$foto,$dim,$paz_foto."serie/tiposerio.jpg",$dim).
		"</a>\n";



}

function freccizzaFrase($frase)

{

	 tabled();
	 scrivi("<tr><td>");
	 img("next.gif");
	 scrivi("</td><td>");
	 scrivi($frase);
	 scrivi("</td></tr>");
	 tableEnd();


}

function getHHMM()
	{return date("H:i");}




//function Application($arg) { echo "<small>App[$arg]</small>"; }

function rosso($msg)
{
	return "<font color='red'>$msg</font>";
}
function scriviSmall($s)
{scrivi("<small>".$s."</small>");
}
function whois($persona)
{
return "<a href='utente.php?nomeutente=".$persona."' border='0'><img src='../immagini/whois.gif' height='12' align='Center'  border=\"0\"></a>";
}

function getFoto2($paz,$alt,$h,$paz2,$h2)
{
if (Session("antiprof"))
	{$temp = "<img src='$paz2' alt='EQUAZ.$alt' align='Center' border='0' ";
	 if ($h2>0)

		$temp .= "height=$h2";
	 return $temp.">";
	}

 $temp = "<img src='$paz' alt='$alt' align='Center' border='0' ";
 if ($h>0)
	$temp.="height=$h";
return $temp.">";
}

function getOrdineGraficoById($id,$h)
{
global $ISPAL;

//echo "getOrdineGraficoById($id,$h)";

$sql= "SELECT * FROM ordini WHERE id_ord=$id";
$res=getRecordSetByQuery($sql);
$rs = mysql_fetch_array($res);

$seriuz = $rs["m_bSerio"];

if (! isset ($seriuz)) return "seriuz-not-set (sql vale $sql)";

$tmp = getOrdineConFotoStringByNameThumb($rs,$h);

if (! $seriuz)
	$tmp = " <i><b>:)</b></i>".$tmp;


if ($ISPAL) 
	$tmp = rosso($tmp);

return $tmp;
}


function getTagFotoOrdineTnGestisceNull($foto,$h=50)
{
global $FOTO_NONDISPONIBILE,$paz_foto_ordini_tn;

	$thumb=strval($foto);

	 if ($thumb=="null")

		$thumb=$FOTO_NONDISPONIBILE;



	 return getFotoNoBorder($paz_foto_ordini_tn.$thumb,($foto=="notfound.gif" ? "?!?" : $foto),$h);

}

function getFotoNoBorder($paz,$alt,$h)
{ if (Session("antiprof"))
	return "PUF";


$temp ="<img src='$paz' alt='$alt' align='Center'  border=\"0\" ";
if ($h>0)
	$temp .= "height=".$h;
return $temp.">";

}


function getOrdineConFotoStringByNameThumb($rsCitta,$h)
{
 if (! isset($rsCitta["Nome_veloce"])) return "getOrdineConFotoStringByNameThumb SCHIF";





	$nome  = $rsCitta["Nome_veloce"];
	$thumb = $rsCitta["m_fileImmagineTn"];

	 $tmp = "   <a href=\"modifica_ordine.php?idord=".$rsCitta["ID_ORD"]."\">";
	 $tmp .= getTagFotoOrdineTnGestisceNull($thumb,$h);
	 $tmp .= "</a>\n"; // e nome

return $tmp;
}

function getMessaggioPrecedente()
{
//	return stripslashes($_POST["QWERTY_MSG_PRECEDENTE"]);
 if (empty($_POST["QWERTY_MSG_PRECEDENTE"]))
	return "";
 else
	return strval($_POST["QWERTY_MSG_PRECEDENTE"]);
//	return ($QWERTY_MSG_PRECEDENTE);
}

function autoInserisci($tabella,$msg,$pagina) //"Messaggio buttato su con successo!","pag_messaggi.php")
{$ok=autoInserisciTabella($tabella);
if (! $ok)
	{scrivi(rossone("problemi durante l'inserimento. L'um spies di mondi :-("));
	 bona();
	}
}



function autoInserisciTabella($NOMETABELLA)
{
	global $ISPAL,$DEBUG;

	$sqlForm="";
	$sqlForm = "INSERT INTO $NOMETABELLA ";
	$separatore="BOH";
	$cont=0;
	$CAMPI="";
	$VALORI="";
	$skippa=FALSE;
	scrivid("<table border=3>\n");
 	while(list($chiave,$valore)=each($_POST))
		{
		scrivid("<tr>");
		if ($cont==0)
				$separatore = "( ";
		 	else 
				$separatore = ", ";
		scrivid("<td>$chiave</td><td>$valore</td><td>");
		$TIPO=getTipo($chiave);
		scrivid($TIPO."</td><td>");
			// tipi veri e propri
		if ($TIPO=="data")
		 	if ($valore == "") //QWERTY se la data è nulla inserisci un valore nullo secondo me...
				{
		 		 scrivid("[NON MOVONEXT nè brekko!!!]</td></tr>");
				 $skippa=TRUE;
				}
		if (! $skippa)
			{
			 $valore=getNuovoValoreByTipo($valore,$TIPO);
	 		 if ($TIPO != "nascosto")
				 {//sqlForm += separatore + "[".$chiave+"]=".$valore+" " // ci van lòe quadre x parole doppie in asp, in php invece le backquotez...
   				  $CAMPI  .= $separatore . "`$chiave`";
				  $VALORI .= $separatore . $valore;
				  $cont++;
				 }
			}
		$skippa=FALSE;
		scrivid("</td></tr>");
		}
	$sqlForm .= $CAMPI . ") values $VALORI)";
	scrivi("<br><br>La form SQL è: ".$sqlForm);

		/////////////// adesso ho la query sql giusta!!!

	$erore=FALSE;
	echo "eseguo mysql inserimento...";
	mysql_query($sqlForm)
		or $erore=TRUE;
	echo "fatto.";
	
	if ($erore)
			{$e=mysql_error();
			if ($ISPAL)
				scrivi(rossone("PAL ONLY) errore a mandare la queri3 ($sqlForm): '$e'."));
			 else
				scrivi(rossone("errore DBstico: $e."));
			 $erore=TRUE;
			}

	if (! $erore)
		{messaggioOkSql("autoinserimento","nihil dictu");
		 scrivid("<br>PS IN MODALItà debug NON ti ridirigo automaticamente, fallo a mano! ");
		 scrivid("QUERYSTRING VECCHIA che serve x la redirezione: <br> ".Form("hidden_mia_query_string"));
		 if ($DEBUG)
				scrivid(rosso("<b>ciucciook, dovrei reidirigerti ma ti dico che la modifica è andata ok</b>"));
			else
				scrivid(rosso("stavi x essere ridiretto all'index ma attento... in un ciclo for non te lo puoi permettere! Make it case..."));			
		}
	else
	 	bona();

return (! $erore);
}

function getTipo($key)
{
$s=strtolower($key);
$tmp="testo";

if (iniziaPer($s,"data") || iniziaPer($s,"m_data"))
	$tmp="data";

if (iniziaPer($s,"id")  || contiene($s,"_id") || contiene($s,"cardinalit") || iniziaPer($s,"m_n"))
	$tmp="numero";

if (iniziaPer($s,"privacy") || iniziaPer($s,"sovrano") || $s=="pubblico" || $s=="attiva"|| $s=="hc" || iniziaPer($s,"m_b"))
	$tmp="bool";

if ($s=="messaggio")
	$tmp="memo";

if (ereg("hidden",$s))
	$tmp="nascosto";

return $tmp;
}




function bigg($str)
{return "<big><big>$str</big></big>";}



function messaggioOkSql($tipo,$msg)
{
global $GODNAME;

tabled(); trtd();
scrivi(getFotoUtenteDimensionata($GODNAME,100));
tdtd(); //?!?!?
scrivi(bigg("Ciuccio benei (come diceva Madonna),<br> la query di <i>$tipo</i> è andata a buon fine!!!"));

if ($msg != "nihil dictu")
	scrivi(big("<br/>Ti volevo dire: <i>$msg</i>"));

if ((Form("hidden_tornaindietroapagina")) != "")
	scrivi(bigg("<br><a href='".Form("hidden_tornaindietroapagina")."'>Auto-Torna indietro</a> (manuale via hidden, soccia che figo che sono!)"));
else if ((Form("hidden_tornaindietroAUTOMATICOFORM")) != "")
	scrivi(bigg("<br><a href='".Form("hidden_tornaindietroAUTOMATICOFORM")."'>Auto-Torna indietro</a> (automatico da formBegin()) "));
else scrivib("<br>PS. non so come farti tornare indietro... è un problema concettuale?<br>Se si', scrivimi dove ti compare sto problema... che cerco di correggerlo.<br>");
trtdEnd();
tableEnd();
}

function iniziaPer($str,$iniz)
{
$pos= strstr($str,$iniz);
//echo "Mi chiedo se $str inizi per <b>$iniz</b>, il responso è <b>".$pos."=?=0</b>.. ".($pos == $str)."<br/>";
if (($pos == $str))
	echo "SI<br>";
return ($pos == $str);
}

function getNuovoValoreByTipo($valore,$TIPO)
{
	if ($TIPO=="data")
		{				 //scrivid(rosso("<br>valore: ".$valore));
						 //scrivid(rosso("<br>new Date(v): ".$new Date(valore)));
						 //scrivid(rosso("<br>new Date(str(v)): ".$new Date(String(valore))));
						 //valore=dammiDataByJavaDate(new Date(valore))

						 //scrivid(rosso("<br>DAmmiDataByJava: ".$valore));
			// Se la trasformo ho casini, allora non la trasformo!!! Una data del tipo
		 if ($valore=="")
			$valore="1-1-70";
		}

	if ($TIPO=="testo" || $TIPO=="memo")
		{if ($valore=="")
			$valore="null"; // venerdi' in pohp questa la toglierei, che dici? 
		 else
			$valore=encodeApostrofi($valore);
		} 			// trafsormo apostrofi semplici in doppi

	if ($TIPO=="numero" && $valore=="")
		$valore=-1;

	if ($TIPO=="testo"  || $TIPO=="memo" || $TIPO=="numero")
		$valore = "'$valore'";

	if ($TIPO=="data" )
		{// se il valore è del tipo
		 scrivid(rosso("DATA VALEVA: ".$valore));

		 if (contiene($valore,"UTC"))
			{scrivi(rossone("errore poiché la data è incompatibile. questo NON dovrebbe succedere. quindi di' a Riccardo"
				." magari via mail che è successo. Grazie."));
			}
		 else{
			 //valore=scambiaGiornoMese(valore); NON VOGLIO USARLO!
			 //$valore = "#$valore#"; IN ASP ERA COSI!!!
			 $valore = "'$valore'";
			}
		 scrivid(rosso("E ORA DATA VALE: $valore<br>"));
		}

return $valore;
}

function encodeApostrofi($testo)
{ //return  raddoppiaCarattere($testo,"'");
 return  ereg_replace("'","''",$testo);
}


function errore2002($msg)
{

?>
<table><tr>
<td bgcolor=white>RIC DICE:</td>
<td><font class='erore' size=2><?=$msg?></font></td>
</tr></table>
<?
}


function scrivid($s)
{global $DEBUG,$POST_DEBUG;
 if ($DEBUG) 
	$POST_DEBUG .= $s;
}

function formtextConCheckbox($Tlabel,$Tvalore_iniziale,$Clabel,$Cvalore_iniziale,$msg)
{scrivi("<tr><td><div align='Right'>");

 formtext($Tlabel,$Tvalore_iniziale);

 scrivi("</div></td><td><center> ".$msg.": ");

 scrivi("\n<input type=\"radio\" ");
 if ($Cvalore_iniziale=="TRUE")
	scrivi("checked"); // checka la checkbox
 scrivi(" name=\"".$Clabel."\" value='TRUE'>si");

 scrivi("\n<input type='radio' ");
 if ($Cvalore_iniziale=="FALSE")
	scrivi("checked"); // checka la checkbox
 scrivi(" name=\"".$Clabel."\" value=\"FALSE\">no</center></td></tr>");
}

function formtextarea($label,$valore_iniziale="",$rig,$col)
{
if ($valore_iniziale=="null")
	$valore_iniziale="";
scrivi("\n".$label."<br>\n");
scrivi("\n<textarea name='".$label."' rows=".$rig." cols=".$col." >".$valore_iniziale."\n</textarea>\n\n");
}



function formtext($label,$valore_iniziale=TRUE)
{
//inutile if ($valore_iniziale=="null") $valore_iniziale="";

scrivi($label.": \n<input type='text' name='".$label."'  value='".$valore_iniziale."'>\n");
}





function anonimo()
	{global $GETUTENTE,$ANONIMO;
// 	echo "anonimità: ut-$GETUTENTE =?= an-$ANONIMO"; 


	return ($GETUTENTE == $ANONIMO);
	}

function htmlSinistra($s)
{return "<div align='Left'>$s</div>\n ";}

function isGuest()
{
if (Session("livello") == "ospite")
	return 1;
return 0;
}

function isMsgPubblico($rs)
{
 return $rs["pubblico"] ||  (! isGuest());

}

function linkautente($nome,$frase)
{
return "<a href=\"utente.php?nomeutente=".$nome."\">".$frase."</a>\n";
}

function formquery($titolo,$query)
{
scrivi("<form method='post' valign='top' action='powerquerysql.php'>\n");
scrivi("<input type=hidden name='querysql' value=\"$query\">");
scrivi("<input type=hidden name='hidden_1' value='42'>\n");
scrivi("<input type='submit' value='$titolo'>\n</form>\n");
}


function tri($n)
{global $tabellacoloriblu;
 if ($n<=2 || $n>=0)  // tabella a 2 colori
{
?>
 <tr bgcolor="#<?=$tabellacoloriblu[$n]?>" width="900">
<?
}
		else
{
?>
 <tr bgcolor="#DDDDDD" width="900">
<?
}
}

function scrivii($x) {echo "<i>$x</i>";}

function formbottoneinvia($label)
{
scrivi("<input type='submit' value=\"".$label."\">\n");
}


function autoCancellaTabella($NOMETABELLA,$NOME_ID_da_modificare,$pag_in_cui_andare)
{
  global $ISPAL,$DEBUG;

  $sql="DELETE FROM $NOMETABELLA WHERE `$NOME_ID_da_modificare`=".getHiddenId();

	// devo correggere la possibilità che sia: DELETE ... FROM ... WHERE [45]=IDSTICAZZI... checko la numericità...


  $ttemp = strval($NOME_ID_da_modificare);
  $iniz= $ttemp[0];
  if ($iniz >= '0' && $iniz <= '9') 
	{
	if ($ISPAL) scrivi("nome id sbagliato: inverto automaticamente la bazza ;)");
	$sql="DELETE FROM $NOMETABELLA WHERE [".getHiddenId()."]=".$NOME_ID_da_modificare;
	}
 else if ($ISPAL) scrivi("nome id corretto: '".$NOME_ID_da_modificare+"' inizia per il non-numerico '".$iniz+"'");

 

if ($ISPAL)
	{
	scrivi(rosso("NOME_ID_da_modificare: <b>".$NOME_ID_da_modificare+"</b>."));
	invio();
	scrivi(rosso("getHiddenId: <b>".getHiddenId()+"</b>."));
	invio();
	scrivi(rosso("pagina in cui andare: <b>".$pag_in_cui_andare+"</b>."));
	invio();
	scrivi(rosso("LA DELETE è del tipo: '".$sql+"'. vedi se va bene"));
	}
log2("CANCTABELLA: ".$sql);

$erore=FALSE;

$res=getRecordSetByQuery($sql);

	if (! $erore)
		{messaggioOkSql("autoDELETE","nihil dictu");
		 if ($DEBUG)
			{ scrivi("<br>PS IN MODALItà debug NON ti ridirigo automaticamente, fallo a mano! QUERYSTRING VECCHIA che serve x la redirezione");
			  scrivi(": <br>".$Request.Form("hidden_mia_query_string"));
			}
  	        else {
			  if (isset($pag_in_cui_andare))
				{scrivib("<a href='$pag_in_cui_andare'>");
				 scrivib(rosso("<br><big>torna a $pag_in_cui_andare</big></a><br>"));
				}
			}
		}
	else
		 bona();
}

function getHiddenId()
{
$myhiddenid=Form("my_hidden_id");
if (empty($myhiddenid)) //=="undefined" || myhiddenid=="null")
		$myhiddenid="'".Form("my_hidden_id_testuale")."'"; 	
				// valuto se è testuale o numeri co l'id... a seconda
return $myhiddenid;	
									// della stringa che mi hai dato in form..
}



function formhidden($label,$val)
{
global $valore_iniziale;
if ($valore_iniziale=="null")
	$valore_iniziale="";
scrivi("\n<input type=hidden name='".$label."' value='".$val."'>\n");
}

function tdtd() {echo "</td><td>";}
function trtd() {echo "<tr><td>";}
function trtdEnd() {echo("</td></tr>");}


function scriviReport_Messaggio($rs,$linkami,$ancheBody,$ii=0)
{//if (EOF($rs)) 	{scrivib("ERORE");bona();}
 global $ISSERIO,$DEBUG;

 $linkami = isMsgPubblico($rs); // lo cambio automaticamente...

 $puoCancellare=isAdminVip(); //(ISPAL);



	scrivi("<table width='100%'>");
	if (! $ancheBody)
		tri($ii);


	else

		scrivi("<tr>");
	scrivi("<td>");



if ($puoCancellare)
{
	formBegin("pag_messaggi.php");
	formhidden("my_hidden_id",$rs["id_msg"]);
	formhidden("ID_MSG",$rs["id_msg"]);
	formhidden("OPERAZIONE","CANCELLA");
	formbottoneinvia("X");
	formEnd();
	tdtd();

}


if ($ancheBody)
	{ scrivi("<table border=0><tr><td valign=top>"); // era qui la link foto utente vecchia
	  scrivi("</td><td><table border=0><tr><td>");
	}

if ($linkami)
	scrivi("<a href='pag_messaggi.php?ID_MSG=".$rs["id_msg"]."'>");


if ($ancheBody)
	{	scrivi("<b>".$rs["titolo"]."</b>"); if (! $linkami) scrivi(" <i>(privato)</i>");

	if ($linkami && $rs["id_figliodi_msg"] != 0)
		scrivi("</a> <a href='pag_messaggi.php?ID_MSG=".
			$rs["id_figliodi_msg"].
			"' alt=\"Leggi Messaggio Padre, ovvero colui che ha originato il Thread (utile quando becchi un msg isolato, x es col motore di ricerca)\">"
			.getImg("up.gif"));
	}
	else
		scrivi(htmlSinistra($rs["titolo"]));


  if ($linkami)
	scrivi("</a>");

  if ($ancheBody)
	{scrivi("</td><td>");}

	 {$strData= strval($rs["data_creazione"]);
	  //if ($DEBUG) scrivi(rosso("strData vale $strData, il suo time: ".time($strData).".."));
	  if ($strData=="" || $strData=="null" )
			$strData="???";
//	 	 else 	$strData=dammiDataByJavaDate(time($strData));

		// N FIGLI
		if (! $ancheBody) // se no non serve  
			if (isset($rs["quantifigli"]))
				if (strval($rs["quantifigli"]) !="0") 
					$strData .= "; <b>".$rs["quantifigli"]."</b> reply"; // se son 0, non metto nulla
	  }


	if ($ancheBody) // quindi + grande
		 	scrivi(htmlDestra("(<i class='InizialeMaiuscola'>".$rs["m_sNome"]."</i>, $strData)"));
		 else
			scriviSmall(htmlDestra("(<i class='InizialeMaiuscola'>".$rs["m_sNome"]."</i>, $strData)"));

if ($ancheBody)
	{  scrivi("</td></tr></table>");
 	   scrivi("<center><table ><tr><td width='800'>");

	    if (! $ISSERIO)
		  scrivi(getFotoUtenteDimensionataRight($rs["m_sNome"],60));



	  if ($linkami)
		scriviSmall(ripulisciMessaggio($rs["messaggio"],TRUE));
	  else
		scriviSmall(rosso("<i>mi spiace, non sei abilitato a vedere questo messaggio</i>"));

	  scrivi("</td></tr></table></center>");
	  scrivi("</td></tr></table>");
	}



scrivi("</td></tr></table>");

}


function ripulisciMessaggio($msggio,$trasformaInvio=TRUE)
{
$tmp=strval($msggio);
$tmp= replace($tmp,"<","&lt;");
$tmp= replace($tmp,">","&gt;");


if ($trasformaInvio)
	$tmp= replace($tmp,"\n","<br/>");
$tmp= replace($tmp,"cazzo","<b>turbominchia</b>");
$tmp= replace($tmp,":\)","<img src='../immagini/1.gif'>");
$tmp= replace($tmp,":\(","<img src='../immagini/2.gif'>");
$tmp= replace($tmp,";\)","<img src='../immagini/3.gif'>");
return $tmp;
}



function htmlDestra($s)
{return "<div align=\"Right\">$s</div>\n ";}


function getFotoUtenteDimensionataRight($utente,$dim,$togliestensione=FALSE)
{
global $paz_foto_persone;


if($togliestensione) // comportamento anomalo
	$foto=$utente;
  else
	$foto=$utente.".jpg";

$temp = "\n<img src='".$paz_foto_persone.$foto."' alt='".$foto."' align='right' border=0 ";

 if ($dim>0)
	$temp.="height=".$dim;

return    "<a href='utente.php?nomeutente=".$utente."'>".$temp.">\n</a>\n";
}

?>