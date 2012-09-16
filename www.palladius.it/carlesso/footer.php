</td></tr></table>

<center>
  <table width='<%=CONSTLARGEZZA600%>'>
    <tr>
<td width='100' valign='top'>
	<div align=left> <img src="img/tn_ric_accappatoio.jpg" width="160"  height="103"> 
        </div>
</td>
<td  valign='top'>
	<center>
          <h6> [ <a href="indiceframez.php">Home</a> | <a href="#top">Top</a> 
            | <a href="mandamiunamail.php">contattami</a> ]</h6>
          <h6><img src="img/powered_mini.jpg"></h6>
	</center>
</td>
      <td  valign='top'> <div align=right> <img src="img/figodoro.jpg" width="257" height="104"> </right> 
      </td>
</tr>
</table>
  <font size="-1">Sito realizzato da Riccardo Carlesso. Tutte le destre riservate.</font><br>
    <script>
	
<!--

bello();

function mancano(date,Giorno,Mese)
{ // i mesi vanno da 0 a 11....
seconda=new Date();
seconda.setMonth(Mese-1);
seconda.setDate(Giorno);
delta=seconda.getTime()-date.getTime();
delta=Math.floor(delta/86400000);
return delta;
}

function mancanoConAnno(date,Giorno,Mese,Anno)
{ // i mesi vanno da 0 a 11....
seconda=new Date();
seconda.setMonth(Mese-1);
seconda.setDate(Giorno);
seconda.setYear(Anno);
delta=seconda.getTime()-date.getTime();
delta=Math.floor(delta/86400000);
return delta;
}

function mancanoDaOggi(Giorno,Mese)
{today=new Date();
 return mancano(today,Giorno,Mese);
}
function mancanoDaOggiConAnno(Giorno,Mese,Anno)
{today=new Date();
 return mancanoConAnno(today,Giorno,Mese,Anno);
}

function bello()
{var famose=[
	1,1,"Capodanno",
	6,1,"la befana",
	3,2,"il compleanno di mia mamma",
	7,2,"il compleanno di <a href=\"http://www.geocities.com/CollegePark/Field/6323/\">Montecristo!</a>",
	25,4,"la Liberazione",
	28,4,"il compleanno del mio <a href=\"http://www.goliardia.it/\">sito</a>!!",
	1,5,"la festa dei lavoratori",
	15,8,"Ferragosto",
	9,10,"il compleanno del mio nipotino Alessio",
	31,10,"Halloween",
	1,11,"Ognissanti",
	2,11,"Ognimmorti",
	11,11,"S.Martino",
	25,12,"Natale",
	26,12,"S.Stefano",
	29,12,"il mio compleanno",
	31,12,"S.Silvestro"
];
var x,i=0;
var giorno,mese,ricorrenza;

do 
{giorno=famose[i++]
 mese=famose[i++]
 ricorrenza=famose[i++]

 //document.writeln("<&nbsp> verifico "+giorno+"/"+mese+", "+ricorrenza+"...");
 x=mancanoDaOggi(giorno,mese);
}
while (x<0)

if (x==0) {testo="Oggi è"}
else if (x==1) {testo="Domani è"}
	else if (x==2) {testo="Dopodomani è"}
		else {testo="Tra "+x+" giorni è"}

// DATA AGGIORNAMENTO, DA TENERE CAMBIATA!!!!!!!!!
G_creaz=4;
M_creaz=1;
A_creaz=2004;

n= - mancanoDaOggiConAnno(G_creaz,M_creaz,A_creaz);

document.write("<center><i><font size=-2>aggiornata il "+G_creaz+"/"+M_creaz+"/00, ");
if (n>1) {document.write(n+" giorni fa!"); }
	else if (n==1) {document.write("<B>IERI!</b>"); }
		else if (n==0) {document.write("proprio <font color=\"#FF6300\">OGGI</font>!!!!"); }
document.write(testo+" "+ricorrenza+"!</font></i>");

//netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserAccess")
//netscape.security.PrivilegeManager.enablePrivilege("UniversalFileRead")
//alert("CIAO")
//f=new java.awt.File(".")
//alert(f+"")

}

//-->
</script>
</center>
</td></tr></table>
</body>
</html>