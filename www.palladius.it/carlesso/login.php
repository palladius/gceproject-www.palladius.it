<?
include "setup.php";
include "skin/$skinPreferita/theme.php";
include "tmp_funzioncine.php";
include "header.php"; // er al quarto posto



$errore="";
$nickname = stripslashes(Post("nickname"));
$password = stripslashes(Post("password"));

echo "nik//pass: $nickname//$password";

$datalastcollegato="BOH";

$pwdDB="?!?!??!?!?";





if (! empty($_POST["nickname"])) // era if != "" && isset()
{
	// cerco nel db un match tra nick e pwd
 	// USA M_BATTIVO x vedere se può entrare...
	// e fai check su email case unsensitive x il NUOVO UTENTE...


 $autorizzato=0;
 $nick=strtolower($nickname);

 $sql= "select m_spwd,m_bAdmin,id_login,m_thumbnail,m_bIsMaschio,m_bGuest,m_bAttivo,m_bsingle,m_bserio,m_nPX,m_berremoscia,m_datalastcollegato,provincia from loginz where m_snome='$nick'";

 $result=mysql_query($sql);
 $riga = mysql_fetch_array($result);

// debRiga($result,$riga); // non consuma la riga


 $rigaTrovata = intval(!empty($riga[0])); // pwd vuota(impossibile) o riga vuota (ciò che voglio)

 scrivib("rigaTrovata: $rigaTrovata.");

	// if (! $rigaTrovata)	scrivi("errore teribbile con fetch row (dovrei dare errore nick non trovato mi sa...sorry): ".mysql_error());

 if (! $rigaTrovata)
	{$errore="Nome '$nick' non trovato nel myDB!!!";	
	}
 else
	{
	echo "Nome trovato nel db, assegno le variabili...<br/>";
//	echo "rs0 vale <b>".$riga[0]."</b>...<br/>";
//	echo "rs1 vale <b>".$riga[1]."</b>...<br/>";
//	echo "rs2 vale <b>".$riga[2]."</b>...<br/>";
		
	$pwdDB = $riga["m_spwd"]; 
	$isAdmin=$riga["m_bAdmin"];
	$user_id=String($riga["id_login"]);
	$thumby=($riga["m_thumbnail"]);
	$Sex=($riga["m_bIsMaschio"] ? "M" : "F");
	$isGuest=$riga["m_bGuest"];
	$PX=($riga["m_nPX"]);
	$PROVINCIA=strtolower($riga["provincia"]);
	$Rmoscia=$riga["m_berremoscia"];
	$isSingle=$riga["m_bsingle"];
	$isSerio=$riga["m_bserio"];
	$datalastcollegato = date($riga["m_datalastcollegato"]);
/*
		echo "PROVINCIA vale <b>$PROVINCIA</b><br>";
			echo "pwdDB vale <b>$pwdDB</b><br>";
			echo "isAdmin vale <b>$isAdmin</b><br>";
			echo "riga[\"m_spwd\"] vale <b>".$riga["m_spwd"]."</b><br>";
			echo "riga[m_spwd] vale <b>".$riga[m_spwd]."</b><br>";
		echo "datalastcollegato  vale <b>$datalastcollegato</b> <br>";
*/
	echo "cfr le pwd...[$pwdDB=?=$password]<br/>";

   if (strtolower($pwdDB)==strtolower($password))
	  {$autorizzato=1;
	   $errore="";
	  }
	else
	{
		$errore="passuorde invalida";
	 	log2("password invalida [$nick//$password]");
	}

   if ($riga["m_bAttivo"] != 1)
	{
	 scrivi("<b>Attenzione, il tuo account non è attivo (vale ".$riga["m_bAttivo"]."), prossimamente questo implicherà che tu non potrai entrare...<br>");
	 scrivi("Questo vuol dire che NON PUOI ENTRARE. Manda una mail a zio Pal per spiegazioni.</b>");
	 $autorizzato=0;
	 $errore="Account disabilitato...";
	}

	// qwerty qui fa il controllo che di nomi non ce ne siano due...
	}

  	 $STAIBARANDO = 0;

  if ($autorizzato) 
  {// metto la sessione giusta...
	echo "yes autorizzato!";
	log2("loggato [$nick]");


  	 if (Session("nickname") == strtolower($nickname))
  	 	$STAIBARANDO = 1; // si sta riloggando

	 $tipo = "sbur-user";
	 if ($isGuest)
	 	$tipo="ospite";

	 $_SESSION["_SESS_nickname"] = ($nickname);
		echo "<h1>altero il nick di sessione, che ora vale: ".Session("nickname")."</h1>";
	 $dd=time();
	 $_SESSION["_SESS_collegato_alle"]	= $dd;
	 $_SESSION["_SESS_ADMIN"]		= $isAdmin;
	 $_SESSION["_SESS_single"] 		= $isSingle;
	 $_SESSION["_SESS_serio"]  		= $isSerio;
	 $_SESSION["_SESS_SEX"] 		= $Sex;
	 //Session.Timeout=60; chiedi a venerdi' come si imposta la durata di una sessione (in mninuti)
	 $_SESSION["_SESS_erremoscia"]	= $Rmoscia;
	 $_SESSION["_SESS_PX"]			= $PX;
	 $_SESSION["_SESS_provincia"] 	= $PROVINCIA;
	 $_SESSION["_SESS_SESS_id_utente"]	= $user_id;
	 $_SESSION["_SESS_antiprof"]		= 0; 
	 $_SESSION["_SESS_foto"]		= strval($thumby); // inutile
	 $_SESSION["_SESS_nomecognome"]	= $thumby;
 	 $_SESSION["_SESS_livello"]=$tipo;
 	 $_SESSION["_SESS_powermode"] = 1;

	

	// aggiorno le variabili...
	$GETUTENTE = getUtente();
	$ISANONIMO = anonimo();



	// aggiorno la tabella degli indirizzi... IP, HOST, USER eccetera...
		 aggiornaIndirizzi();









	// aggiorno la data di LASTCOLLEGATO...
	//		rs=getRecordSetByQuery("update loginz set m_datalastcollegato=#".dammiDataByJavaDate(time())."# WHERE id_login=$user_id");
	echo " qua non ci arrivo... boh!";
//	$rs=query("update loginz set m_datalastcollegato=#".scambiaGiornoMese(dammiData())."# WHERE id_login=$user_id");
	$rs=query("update loginz set m_datalastcollegato=#".dammiDataByJavaDate(time())."# WHERE id_login=$user_id");
	echo " NON CAMBIO GIORNO E DATA CACCHIO! faccio tutto YYYY MM DD";

	// devo decidere se la data è cambiata o no, se SI aumento di uno, se NO non faccio nulla

	$daynow  = date("d");
	$daylast = date("d",$datalastcollegato);

		// 		ad esser + fini... ma freghiamocene del bug...
		//	monthlast=new String(datalastcollegato.getMonth());
		//	monthnow=new String(NOW.getMonth());
		//	nuovogiorno = (daynow != daylast || monthnow != monthlast); // 
	$nuovogiorno = ($daynow != $daylast ); // giorno diverso, ha il bug che se non ti colleghi da 1 mese esatto perdi quel GP... amen :-)

	if ($nuovogiorno)
		{echo "è l'alba di un nuovo giorno...";
		gestisciGoliardPointz($user_id,1,"incrementa"); // aumento di 1 i GP...
		}




//	echo "APPLICAZZONE MANCANTE!";
	


//	if(!(getApplication("UTENTI_ORA")))		setApplication("UTENTI_ORA", "");

	setApplication("UTENTI_ORA", getApplication("UTENTI_ORA")."\$".strtolower($nickname)."@".time() );




    echo "CIUCCIO OK!!!!!!!!!!!";
    ridirigi("index.php");
  } else echo "non autorizzato";
}


?>



<!--#include file="header.inc"--><div align="center">
<p><h3> Benvenuto nella pagina di login!!!</h3></p>

<?
if (($errore!=""))
{
	echo(htmlMessaggione($errore));

}
//else echo(htmlMessaggione("Nessun errore!!! fico! forte! :)"));

$visualizzaMsgLogin=1; // va ovviamente a 1 a dflt, l'ho messo x non vedermi sta merda in mezo a mare di debug...

if ($visualizzaMsgLogin)
{
?>
<p><b>[ <a href="nuovo_utente.php"><?=rosso("nuovo utente")?></a> | <a href="login_dimenticatapwd.php"><?=rosso("ho dimenticato la password")?></a> ]</b></p>
<br>
Se è la prima volta che vieni qui, devi sapere che x entrare devi prima 
<a href="nuovo_utente.php"><i>registrarti</i></a>. Questo è stato scelto 
da me e dalla maggioranza degli utenti per proteggere informazioni più o 
meno riservate e poichè crediamo che il nostro mondo sia qualcosa di 'iniziatico' 
e ci spiacerebbe vedere ogni pagina indicizzata in ogni motore di ricerca. L'iter è semplice:
ti registri e ti viene inviata una password alla email indicata da te. Da quel momento potrai
tornare qui, inserire il <i>nick</i> che avevi scelto e la <i>password</i> che ti era stata assegnata. <br>
<i>Non dare la password in giro!!!</i>: a fini legali ogni cosa fatta col tuo utente è TUA responsabilità. <br/>
Se hai dimenticato la password, clicca invece <a href="login_dimenticatapwd.php">qui</a> e se indovini la tua data di nascita
ti verrà rispedita alla mail originaria. Se hai cambiato mail o non riesci a leggerla... scrivimi.

<!---

<b>Sono <i>già</i> registrato <i>e</i> ricordo la password:</b><br>
<i>(ovvero appartengo a una ristretta élite di rodati navigatori)</i><br/>
<b>attenzione, ho modificato il sistema di attribuzione dei GP: incrementano al + una volta al giorno, quindi non rompete 
i coglioni e fate il login solo quando serve. Sempre vostro, Pal.</b>

--->
<? openTable2(); ?>
<form method="post" action="login.php">
inserisci l'username<br>
<input type="text" name="nickname" size="15"><br>
inserisci la password<br>
<input type="password" name="password" size="15" ><br>
<br>
<input type="submit" value="entra"></form>
<? closeTable2(); ?>
</div>
<?
}
	include "footer.php";

?>




