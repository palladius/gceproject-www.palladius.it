<?

 require_once("funzioniphpnuove.php");

 session_start();

$PUBBL_MSG_ENTRA_ESCI = FALSE; // dice se mettere XXX è entrato, e cosi' via...
$NOMESKIN = "deepblueric";
$CONSTLARGEZZA600 = 650;
$MAXMESSAGGI  = 40;
$coloresfondo = "\"#DDFFFF\"";
$ANONIMO = "anonimo";

?>
	<link href="skin/<?=NOMESKIN?>/style/style.css" rel="stylesheet" type="text/css">
	<body bgcolor="#EEFFFF" onLoad="" >
<?
// background='../immagini/sfondofeluchina2.jpg'




	// funzioni comuni





function bragheInit()
{
$braghe=(getApplication("braghe"));
//if (braghe=="undefined" ) {Application("braghe")="";}
}



function bragheAdd($nome)
	{appendApplication("braghe", $nome."\$". Session("PX"). "@");}




function bragheRemoveSEMPLICIOTTA($nome)
{
$brarr=split("\@",getApplication("braghe"));

$brnew="";

for ($i=0;$brarr[$i];$i++)
{if (($brarr[$i]) != ($nome) && $brarr[$i] != "") 
		$brnew .= $brarr[$i] . "@";
 else
{// è lui
$brarrarr=split("\$",$brarr[$i]);
  $CHI=$brarrarr[0];
  $PX=$brarrarr[1];
$vincoio= (intval(Session("PX")) >= intval($PX));
if (! $vincoio) return; // rimozione NON consentita
}
}
setApplication("braghe",$brnew);
}




function bragheRemove($nome)
{
$brarr=split("@",getApplication("braghe"));
$ispal= (Session("nickname")=="palladius");
	
$brnew="";
for ($i=0;$i<$brarr[$i];$i++)
{
  $brarrarr=split("\$",$brarr[i]);
  $CHI=$brarrarr[0];
  $PX=$brarrarr[1];

if ($CHI != $nome && $CHI != "") 
		$brnew += $brarr[$i] + "@";
 else if ($CHI == $nome)
{// è lui
$vincoio= (intval(Session("PX")) >= intval($PX));
if (! $vincoio) 
	{$brnew .= $brarr[$i] . "@";}
}
}
setApplication("braghe",$brnew);
}





/*
function wind(str)
{
//return "</i><font face='wingdings'><big><big><b>"+str+"</b></big></big></font><i>";
return "</i><font face='wingdings' class='wingdingchat'>"+str+"</font><i>";
}

function windn(n)
{return wind(String.fromCharCode(n));
}

function web(str)
{
//return "</i><font face='webdings'><big><big><b>"+str+"</b></big></big></font><i>";
return "</i><font face='webdings' class='wingdingchat'>"+str+"</font><i>";
}

function webn(n)
{return web(String.fromCharCode(n));
}
*/





 
?>
