<?

include "setup.php";
include "skin/$skinPreferita/theme.php";
include "tmp_funzioncine.php";
include "header.php";


log2("logout  [".Session("nickname")."]");

session_unset();

scrivi(h1("logout riuscito, nessuno sai più chi sei, caro il mio '$nickname'. To'! Manco io. ;)"));


if (! (getUtente()=="palladius"))
{ridirigi("login.php");}
else
{
echo "al futuro i ciappini pal-only BIS...<br>";
/*
scrivi("Ora che è abbandonata::<br>\n")

scrivib("SESSION CONTENTS:<br>\n")
visualizzaArrayGenerico(Session.Contents)

scrivib("SESSION StaticObjects:<br>\n")
visualizzaArrayGenerico(Session.StaticObjects)
*/
}
?>
<?


scrivib("fatto. Sessione abbandonata<br>qui c'è il <a href='login.php'>LOGIN</a>...");

include "footer.php";

?>

