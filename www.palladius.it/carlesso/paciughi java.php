<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <meta name="GENERATOR" content="Mozilla/4.7 [en] (Win98; I) [Netscape]">
</head>
<body>
Festario di Riccardo Carlesso
<p><script>
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

function mancanoDaOggi(Giorno,Mese)
{today=new Date();
 return mancano(today,Giorno,Mese);
}

function bello()
{var famose=[
	1,1,"Capodanno",
	6,1,"la befana",
	3,2,"compleanno di mia mamma",
	25,4,"la Liberazione",
	1,5,"la festa dei lavoratori",
	15,8,"Ferragosto",
	31,10,"Halloween",
	1,11,"Ognissanti",
	2,11,"i morti",
	11,11,"S.Martino",
	20,12,"il mio anniversario con la Fede",
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
document.writeln(testo+" "+ricorrenza+"!<p>");

//netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserAccess")
//netscape.security.PrivilegeManager.enablePrivilege("UniversalFileRead")

//alert("CIAO")
//f=new java.awt.File(".")
//alert(f+"")

}

//-->
</script>

<p><script>
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

function mancanoDaOggi(Giorno,Mese)
{today=new Date();
 return mancano(today,Giorno,Mese);
}

function bello()
{var famose=[
	1,1,"Capodanno",
	6,1,"la befana",
	3,2,"compleanno di mia mamma",
	25,4,"la Liberazione",
	1,5,"la festa dei lavoratori",
	15,8,"Ferragosto",
	31,10,"Halloween",
	1,11,"Ognissanti",
	2,11,"i morti",
	11,11,"S.Martino",
	20,12,"il mio anniversario con la Fede",
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
document.writeln(testo+" "+ricorrenza+"!<p>");

//netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserAccess")
//netscape.security.PrivilegeManager.enablePrivilege("UniversalFileRead")

//alert("CIAO")
//f=new java.awt.File(".")
//alert(f+"")

}

//-->
</script>

</body>
</html>
