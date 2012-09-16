<?

#	Qua metteremo le funzioni che son state fatte ex novo e non vengono dalla precedente versione
#	quindi tutte le cose php-dependant (nuove bazze x date, post, immagini, eccetera...)





function debvar($var)
{
return;
echo "<br/>[DEBPHP: dbagghiamo la $<b>$var</b> che vale '".$$var."'\n";
echo "Mentre ANONIMO vale '$ANONIMO'\n";
echo "Mentre ISANONIMO vale '$ISANONIMO'\n";
echo "Mentre provaric vale '$provaric'\n";
}

function Form($str)
{
return Post($str);
}

function Post($str)
{
if (empty($_POST[$str])) return "";
return $_POST[$str];
}

function getMemozByChiave($str)
{
$rs=getRecordSetByQuery("select valore from xxx_memoz where chiave like '$str'");
if ($row = mysql_fetch_row($rs))
	if (isset($row[0]))
		return $row[0];

return "ERRORE";
}

/** in futuro qui mi darà facilità di debug e toglita di NOTICEs... */
function getRiga($result)
{
$riga=mysql_fetch_row($result);
return $riga;
}



function EOF($result,$arr="")
{
//$vuot= empty($arr[0]);
//$vuot =  (mysql_num_rows($result) < 1);
if((mysql_num_rows($result)))
	$vuot =  (mysql_num_rows($result) < 1);
else	
	$vuot= FALSE;

//echo $vuot ? "{e[".mysql_num_rows($result)."]}" : "{full}";
if ($vuot) echo "{e[".mysql_num_rows($result)."]}";
return $vuot;
}

function random($max)
{
// numero da 1 a max, o da 0 a max-1, boh!

$ret= ceil($max*srand());
echo "[rand($max) vale $ret]";
return $ret;
}

function setApplication($key,$val)
{ 

global $_SERVER;

#$pazApplication = "./_pvt_"; 
#//$fp =fopen($pazApplication,"a"); //credo sia append
#$fp =fopen("$pazApplication$key.txt","w"); 
#fputs($fp,"$val"); 
#fclose ($fp); 
#// in futuro potrei anche scrivere altri dati a un file _log_$APP
log2("appl(PAL_$key) settato a [$val (di tipo ".gettype($val)."]");
//INUTILE if (!isset($_SERVER["PAL_$key"])) 	$_SERVER["PAL_$key"] = "";
$_SERVER["PAL_$key"]=$val;

if (! isset($_SERVER["ric$key"]))
	$_SERVER["ric$key"]="";
$_SERVER["ric$key"].= "aggiunto[$val]<br>";
}

function getApplication($key)
{
global $_SERVER;

#$pazApplication="./_pvt_"; // x ora, poi lo cambierò
# NIENTE FILE; USO la $server
#// For reading, open the file which contains the base & height data
#$fp = fopen( "trianglenumbers.dat", "r") or die("No such file!\n");
#// Read in the first line, assigning the string to $b
#$b = fgets( $fp, 10 );
#// Print out the value of the base

#echo "b is $b.\n";
#// Read in the first line, assigning the string to $h
#$h = fgets( $fp, 10 );
#$fp =fopen("$pazApplication$key.txt","r"); 
#$temp=fgets($fp,"%s");
#fclose ($fp); 

if (!empty($_SERVER["PAL_$key"])) return ($_SERVER["PAL_$key"]);
return ""; // dflt val
}

function appendApplication($key,$valApp)
{
// speriamo sia stringa, altro che maschio!
$_SERVER["PAL_$key"] .= $valApp;
}




function escape($x)
{return urlencode($x);}


function visualizzaArrayMini($arr)
{
if (is_array($arr))
{
while(list($k,$v)=each($arr))
	{echo "<b>$k</b>: $v<br/>";}
}
else	{echo "<b>$arr</b>: non è un array.<br/>";}
}

function isAdmin()
{return Session("ADMIN");
}

function isGod(){
global $ISPAL;
	return $ISPAL;
}

function isAdminVip()
{if (! Session("powermode")) return FALSE;
 if (! isAdmin() ) return FALSE;
 if (isGod()) return TRUE;
 $user= Session("nickname") ;

 return ($user == "cavedano" || $user == "manolus" || $user == "gimmigod" || $user=="pariettus" || $user=="ophelia");
}


function debRiga($result,$row)
{
$lung=mysql_num_fields($result);

echo "<table>";
for ($i=0; $i<$lung; $i++)
	{
	echo "<tr><td>";
	$fieldname=mysql_field_name($result,$i);
	echo "$fieldname</td><td>".$row[$i];	
	echo "</td></tr>";
	}
echo "<table>";
}


function visualizzaFormz()
	{ visualizzaArrayTitolo($_POST,"FORMZ"); }

function QueryString($str)
{
if (empty($_GET[$str])) return "";
return $_GET[$str];
}


function log2($str,$fname="log2.txt")
{
global $GETUTENTE,$REMOTE_ADDR;

//$paz = "../logz/";
$paz = "./"; // così va anche a casa di venerdi' :-)))
$pazcompleto = $paz.$fname;

$now=dammiDataByJavaDate(time());

$_SERVER["riccardo"]="log2 at ".time()." by ".Session("nickname")."<br>";

$fp =fopen($pazcompleto,"a"); 
fputs($fp,"$now\t".str_pad($REMOTE_ADDR,17," ").str_pad($GETUTENTE,30," ")."$str\n"); 
fclose ($fp); 

}

function dammiDataByJavaDate($time)
{
return date("Y-m-d h:i:s",$time); // così piace a mysql
}

function visualizzaArrayTitolo($arr,$tit)
{
scrivib(rosso("<u>$tit</u><br>"));

echo"<table>";
while(list($k,$v)=each($arr))
	{
//	$chiave=$i;
	scrivi("<tr><td><b>".$k."</b></td><td>$v</td></tr>\n");
	}
echo"</table>";

//hline(20);
}

function setSession($str,$val)
{
$_SESSION["_SESS_$str"]=$val;
}

function issetSession($str)
{
return isset($_SESSION["_SESS_$str"]);
}


function replace($frase,$da,$a)
{ return ereg_replace($da,$a,$frase); }

function contiene($str,$substr)
{return ereg($substr,$str);
}

function Session($str)
{
if (empty($_SESSION["_SESS_$str"])) return "";
return $_SESSION["_SESS_$str"];
}


function visualizzaDebug()
{
 $_SERVER["riccardo"]="prova ciao da ric";

 echo "<table><tr><td valign='top'>";
	 visualizzaArrayTitolo($_POST,"POSTZ"); 
// echo "</td><td valign='top'>";
	 visualizzaArrayTitolo($_GET,"GETZ"); 
// echo "</td><td valign='top'>";
	 visualizzaArrayTitolo($_SESSION,"SESS"); 
 echo "</td><td valign='top'>";
	 visualizzaArrayTitolo($_SERVER,"SERVER"); 
 echo "</td></tR></table>";

}




















function FANCYPROVA1()
	{ echo "PROVA 1<br>"; }


function FANCYBEGIN($title)
{
$dir= "../immagini/fancyric/";

?>
<div align=left>

   <TABLE cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD vAlign=top width=2 bgColor=#339999><IMG alt="" 
            src="<?=$dir?>tealtab_topleft1.gif" 
            border=0><BR></TD>
          <TD vAlign=top width=18 bgColor=#339999><IMG alt="" 
            src="<?=$dir?>tealtab_topleft2.gif" 
            border=0><BR></TD>
          <TD vAlign=center align=left bgColor=#339999 height=20><FONT 
            face=Helvetica color=#ffffff size=+1>
	
			<B><?=$title?></B>

		</FONT></TD>
          <TD vAlign=top align=left width=14 bgColor=#339999><IMG alt="" 
            src="<?=$dir?>tealtab_topright.gif" 
            border=0><BR></TD></TR></TBODY>
	</TABLE><!-- End Title Tab --><!-- Main Page -->




    <TABLE cellSpacing=0 cellPadding=0 border=0>

        <TBODY>
        <TR vAlign=top>
          <TD colSpan=6><IMG height=2 alt="" 
            src="<?=$dir?>gradient-teal.gif"></TD></TR>
        <TR>
          <TD bgColor=#339999><IMG height=10 alt="" 
            src="<?=$dir?>spacer.gif" width=2></TD></TR>
        <TR>
          <TD bgColor=#339999><IMG alt="" 
            src="<?=$dir?>spacer.gif" width=2></TD>
          <TD colSpan=3>&nbsp;&nbsp;&nbsp;&nbsp;</TD>
          <TD>

	  <table border="0" width="500"><tr><td>

<?
}
function FANCYMIDDLE($tit="no_title_tbds")
{ 
$dir= "../immagini/fancyric/";
?>
	</td></tr></table>

           <IMG height=2 
            src="<?=$dir?>fade-teal.gif" align=bottom 
            border=0> 
	  
	
	<table border="0" width="500"><tr><td>
<?
}
function FANCYEND()
{
$dir= "../immagini/fancyric/";
?>

	</td></tr></table>


</TD></TR>
        <TR>

          <TD colSpan=6><IMG height=2 alt="" 
            src="<?=$dir?>gradient-teal.gif"></TD></TR>
        <TR>

          <TD colSpan=6>
            
	  </TD></TR>
	</TBODY></TABLE></P>
<?
}


?>