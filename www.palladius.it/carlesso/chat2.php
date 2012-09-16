<? 
function Session($str)
{
if (empty($_SESSION["_SESS_$str"])) return "";
return $_SESSION["_SESS_$str"];
}

 session_start();

if ("" == (Session("nickname"))) 
	{
	echo "MI SPIACE, _SESS_nickname vale ".$_SESSION["_SESS_nickname"];
	 //header("Location: login.php");  
	 exit;
	}
?>
<html>
<head>
  <title>Carlesso Prodaxions Chat!</title>
<link href="provaric.css" rel="stylesheet" type="text/css">

</head>




<?

if (! Session("antiprof"))
	{	// normale
?>	
<frameset rows="80,*,130"  frameborder="NO" border="2" framespacing="0"  class='bkg_chat'>
  <frame src="chatscrivi.php" scrolling="NO" noresize name="scrivi" class='bkg_chat'>
  <frame src="chatleggi.php" name="leggi" class='bkg_chat'>
  <frame src="chatculo.php" scrolling="NO" noresize name="footer" class='bkg_chat'>
</frameset>
<?
	}
else  
	{	// antiproffato

/*
<frameset rows="50,*"  frameborder="NO" border="2" framespacing="0" >
  <frame src="chatscrivi.php" scrolling="NO" noresize name="scrivi">
  <frame src="leggiprof.php" name="leggi">
</frameset>
*/
	echo h1("con l'antiprof la chat x ora non va, mi spiace.");

	}	
?>

<!---
	<noframes>
	<body bgcolor="#F0F8FF">
	</body>
	</noframes>
--->

</html>
