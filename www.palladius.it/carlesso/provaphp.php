<?php





$dbusuario="root";     		# user del database
$dbpassword="";	       	# password del database
$db="goliardia";	      # nome del database
$dbhost="127.0.0.1";   		# Host della base di dati
$DOVE_SONO="casaric";		# dove è il server, a scopi mnemonici (x non confondere locale con remoto...)
#=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- personalizzazioni


//$conexion = mysql_connect($dbhost, $dbusuario, $dbpassword);
//mysql_select_db($db, $conexion);




// Active assert and make it quiet
assert_options (ASSERT_ACTIVE, 1);
assert_options (ASSERT_WARNING, 0);
assert_options (ASSERT_QUIET_EVAL, 1);

// Create a handler function
function my_assert_handler ($file, $line, $code) {
   echo "<hr>Assertion Failed:
       File '$file'<br>
       Line '$line'<br>
       Code '$code'<br><hr>";
}
// Set up the callback
assert_options (ASSERT_CALLBACK, 'my_assert_handler');



function faquery($query)
{
$dbname = "palladius";
$user   = "Palladius";
$pass   = "iPsCIFai9";
$dbhost = "62.149.225.173";

if (!isset($query) || empty($query))
	{$query = "select * from users";}
$query = stripslashes($query);

assert(mysql_connect($dbhost,$user,$pass))
	or die("errore di CONNECT con dati ($dbhost,$user,****)");
	
assert(mysql_select_db($dbname))
	or die("errore di select DB x il DB '$dbname'");

$result= mysql_query($query) 
	or die("err di query: ...".mysql_error());
$number_cols = mysql_num_fields($result);

echo "<b>query: $query</b>";
echo "<table border='1'>\n";
	// intestazione
echo "<tr align='center'>\n";
for ($i=0;$i<$number_cols;$i++)
	{echo "<th>".mysql_field_name($result,$i)."</th>\n";}
echo "</tr>";
echo "</table>";

phpinfo();

}




?>
<h1>TITOLONE</h1>
<form action="<? echo $PHP_SELF?>" method="get">
 <input type="text" name="query" size="50"><br>
 <input type="submit">
</form>
<?php echo $_SERVER["HTTP_USER_AGENT"]; ?>
 <?

 
  echo "prova 1 2 3<br/>";
//  faquery("select * from loginz");

  faquery($query);

 ?>