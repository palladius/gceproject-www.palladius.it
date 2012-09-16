<?php 
	// la paggina con tutte le mie funzioni...

 $CONSTLARGEZZA600 = 600;
 $NOMESKIN = "deepblueric";
 $USASKIN = 1; 
	
function getImg( $paz, $altezza)
{return "<img src='$paz' height='$altezza' border='0'>";}

function linkaViola($lnk,$frase,$altezza=30)
{
//$tagFoto= "\n".getImg("icone/$frase.gif",$altezza)."<br>";
$tagFoto= getImg ( "img/icone/$frase.jpeg",$altezza)."<br>";
return "<td align=\"center\" class=\"BGbianco\">$tagFoto<a href='$lnk'><font face=\"verdana,arial,".
		"geneva,sans-serif\" size=\"1\" class=\"fgviola\"><b>$frase</b></font></a></td>";
}

function linkaViolaTarget($lnk,$frase,$target,$altezza=30)
{
$tagFoto= getImg ( "img/icone/$frase.jpeg",$altezza)."<br>";
return "<td align=\"center\" class=\"BGbianco\">$tagFoto<a href='$lnk' target='$target'><font face=\"verdana,arial,".
		"geneva,sans-serif\" size=\"1\" class=\"fgviola\"><b>$frase</b></font></a></td>";
}


function h6($x)
{return "<h6>$x</h6>";}

function scrivi($frase="attenzione nisba da scrivere :(")
{echo $frase;}



function scriviHeader($arr,$viola,$nero,$bianco)
{
global $CONSTLARGEZZA600;
?>
<table cellspacing="0" cellpadding="0" width="<$ echo $CONSTLARGEZZA600; $>" height="20" border="0">
<tbody>
 <tr>
  <td colspan="3" class=bgviola"><img src="pixel.gif" height="1" width="<$ echo $CONSTLARGEZZA600; $>" border="0"><br clear="all">
  </td>
 </tr>
 <tr>
  <td width="1" class=bgviola">
	<img src="pixel.gif" height="20" width="1" border="0"><br clear="all">
  </td>
  <td width="<$ echo $CONSTLARGEZZA600-2; $>" class=bgviola">
<?
scrivi("<table width=\"$CONSTLARGEZZA600\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" height=\"20\">");
scrivi("<tbody><tr>");

foreach ($arr as $valore) 
	{
	 echo "\n".$valore;
	}
?>
</tr></tbody></table>
  <td width="1" class=bgviola>
	<img src="pixel.gif" height="20" width="1" border="0"><br clear="all">
  </td>
  </tr>
 <tr>
  <td colspan="3" class=bgviola><img src="pixel.gif" height="1" width="<? echo $CONSTLARGEZZA600; ?>" border="0"><br clear="all">
  </td>
 </tr>
 </tbody>
</table>
<?
}
?>
