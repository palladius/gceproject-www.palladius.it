<?php
// pagina di funzioni uguale x tutti

	require_once("funzioni.php");
	$TITOLODFLT = "SENZA TITOLO (ATTENTO RIC)";
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<HTML>
<HEAD>
   <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
   <META NAME="GENERATOR" CONTENT="Notepad e tanta pazienza">
   <meta name="Author" content="Riccardo 'zio 486 Palladius' Carlesso">
   <? if (isset($descrizione))
			echo "<META NAME=\"Description\" CONTENT=\"Pal-Description: $descrizione\">";
		 ?>
   <TITLE>
   		<? if (isset($titolo)) echo $titolo; else echo $TITOLODFLT; ?>
   </TITLE>

   </HEAD>
<?
if ($USASKIN)
		{echo "<link href=\"skin/$NOMESKIN/style/style.css\" rel=\"stylesheet\" type=\"text/css\">";	}
		
echo "<BODY";
if (isset($bgcolor))
	echo " bgcolor='$bgcolor";
if (isset($bgfototutto))
	echo " background='$bgfototutto' ";
echo"><div align='left'><table width='".($CONSTLARGEZZA600+10)."'><tr><td>";
		
 $arrHeader = array();
 $arrHeader[] = linkaViola("indexold.php","home");
 $arrHeader[] = linkaViola("indice.php", "chi sono"); //"chi sono");
 $arrHeader[] = linkaViola("mieopere.php","opere");
 $arrHeader[] = linkaViolaTarget("foto2.php","foto","_blank");
 $arrHeader[] = linkaViola("http://www.goliardia.it","goliardia");


// in futuro qui ci saranno degli indici ragionati delle sotto categorie...
// $arrHeader[] = linkaViola("comiche.php","comiche");
// $arrHeader[] = linkaViola("goliardia.php","goliardia");
// $arrHeader[] = linkaViola("hobbiez.php","hobbiez");
// $arrHeader[] = linkaViola("universita.php","universita");
// $arrHeader[] = linkaViola("php.php","php");

echo "<center>";
scriviHeader($arrHeader,"663399","000000","FFFFFF"); // viola_tiscali nero bianco

echo "<table width=\"$CONSTLARGEZZA600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"20\">";

if (isset($background))
	echo " <h1>erore!!! bgground vale $background!!!! </h1>";

?>
<tbody  
<?if (isset($bgfotobody))
	echo " background='$bgfotobody' ";
?>
><tr>
<td align="left">
