<?

include "setup.php";
include "skin/$skinPreferita/theme.php";
include "tmp_funzioncine.php";
include "header.php";



OpenTable();
echo "<h1>query generica inutile</h1>";
CloseTable();

$frase = "SELECT * \n FROM loginz\n WHERE m_snome like '%%'";



if (isset($hidden_1))
{
 echo "<h2>Risultato query </h2>('$querysql')<br/>";
 $res=mysql_query($querysql)
	or scrivib("mysql_error(): ".mysql_error());
 scriviRecordSetConTimeout($res,10);
 $frase=$querysql;
}

{
?>
<form method='post' action='tmp_paginozza.php'>
<textarea name='querysql' rows=10 cols=40 value='value'>
 <?=$frase?>
</textarea>
<br>
<input type=hidden name='hidden_1' value='42'>
<input type='submit' value='invia query'>
</form>
<?
}

//phpinfo();


include "footer.php";

?>


