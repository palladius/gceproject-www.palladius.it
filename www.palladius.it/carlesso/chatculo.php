<? 


include "chatheader.php";





bragheInit();
$braghe=(getApplication("braghe"));
$arrbraghe=split("@",$braghe);
?>


<head>
  <meta http-equiv="refresh" content="30;URL=chatculo.php">
</head>


<center>
<table border="0" cellspacing="0" cellpadding="0" bgcolor=<?=coloresfondo?>>
<tbody>
<tr>
<td valign="top" colspan="2" class='bgviola'><img src="pixel.gif" width="<?=CONSTLARGEZZA600?>" height="1" alt="" border="0"></td>
</tr>
</tbody>
</table>

</center>

<? 



$paz_foto_persone = "../immagini/persone/"







$strFoto="\n<tr>";
$strNomi="\n<tr>";



$online = Application("online");
$stringa_utente = split("\$",$online);




for (i=0;i<stringa_utente.length;i++)
  if (stringa_utente[i]!="") 
  {
  nome = stringa_utente[i].substring(0,stringa_utente[i].indexOf("@"));
  $inbraghe=false;


 inbraghestr = "in braghe";


	//verifico se è in braghe
  for (j=0;j<arrbraghe.length;j++)
	{$arrarr=split("\$",$arrbraghe[$j]);
	 arrnomej=arrarr[0];
	 arrpxj=arrarr[1];
	if (nome==arrnomej) 
	{
		inbraghe=true;
	   if (parseInt(arrpxj) > 1000) inbraghestr="nudo";
	}
	}

  if (inbraghe)
	{
	nome += "</b><br><i>"+inbraghestr+"</i><b>"; ("");
	strFoto+="<td align=center width=50><img src='../immagini/braghe.jpg' alt='ha fatto il cattivo' align='Center' height='80'></td>";	
	}
	else try	{
			  strFoto+="<td align=center width=50>"+getFotoUtenteDimensionataRight(nome,80)+"</td>"
			}
		catch(e)
			{Response.Write("Errore "+e+": "+e.description);}


// nON FUNZIONA! VA CON LA TA SESSIONE NON LA N-MA!!!  
// if (String(Session("ADMIN"))=="true")		 nome += "<br><b>admin</b>";



  //strNomi+="<td valign=top width=50 align=center><center><b size='-1'><center>"+nome+"</center></b></center></td>"
  strNomi+="<center><td valign=top width=50><center>"+nome+"</center></td></center>"
  }
 Response.Write("<body class='bkg_chat'><table  align='center' border=0>")
 Response.Write(strFoto+"</tr>"+strNomi+"</tr></table>")







if (Session("nickname")=="palladius" && Session("DEBUG")==true)
{Response.Write("<bR>ONLINE: "+Application("online"));
 Response.Write("<br>MSG: "+Application("messaggi"));
}
?>





