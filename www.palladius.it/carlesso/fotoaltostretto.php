<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <meta name="GENERATOR" content="Mozilla/4.7 [en] (Win98; I) [Netscape]">
   <meta name="Microsoft Border" content="none">
   <title>SiteBrowser example: color blending</title>
</head>
<body >
<?

function rigaPadre($nome,$paz="NOLINK",$target="frame_dx_foto")
{
?>
<tr valign="top"> 
    <td width="13%"><img SRC="img/icon_folder_open.gif" width="21" height="21" align="absmiddle" NOSAVE></td>
    <td width="87%">
	
	<? 
	$stringa = "<strong><font size=\"-1\">$nome</font></strong>";
	if (! eregi("NOLINK",$paz))
		$stringa= "	<a href=\"$paz\" target=\"$target\">".$stringa."</a>";
	echo $stringa;
	?>
</td>
  </tr>
<?
}

function rigaFiglio($nome,$paz,$target="frame_dx_foto")
{
?>
<tr valign="top"> 
	<td width="13%">
	</td>
	<td width="87%">
<font size="-1">
<img src="img/icon_bar.gif" width="12" height="12" align="absmiddle" nosave>
<a href="<? echo $paz; ?>" target="<? echo $target; ?>"><? echo $nome; ?>
</a></font>
	</td>
<?
}



echo "<table>";
rigaPadre("HOME","foto_direi3.php");

rigaPadre("2002");
rigaFiglio("Laurea","img/2002/laurea/foto.html");
rigaFiglio("Croazia '01","img/2002/croazia/foto.html");
rigaFiglio("Brisighella","img/2002/brisighella/foto.html");
rigaFiglio("Perugia","img/2002/perugia/foto.html");
rigaFiglio("Varie","img/2002/varie/foto.html");

rigaPadre("Famiglia","fotofamily.php");

rigaPadre("Opere mamma");
rigaFiglio("Opera Omnia","mamma/index.htm");
rigaFiglio("Acquerelli","fotoquadri.php");
rigaFiglio("Pasta di sale","mammasale.php");

rigaPadre("Vecchie");
rigaFiglio("università","fotouni.php");
rigaFiglio("Fede","fotofede.php");
rigaFiglio("quand'ero magro","fotomie.php");
rigaFiglio("al liceo","fotoliceo.php");
rigaFiglio("note sul diario","fotonote.php");


echo "</table>";
?>
<!---



 


      <param name="AppletHomePage" value="http://go.to/javabase">
      <param name="delay" value="10">
      <param name="fgcolor" value="FFFF00">
      <param name="bgcolor" value="00AAFF">
      <param name="font" value="Times">
      <param name="fontsize" value="22">
      <param name="fontstyle" value="b">
      <param name="highlight" value="0000FF">
      <param name="highlightFade" value="right">
      <param name="inFade" value="leftright">
      <param name="mouse" value="FF0000">
      <param name="rounding" value="80">
      <param name="steps" value="40">
      <param name="switchSteps" value="8">
      <param name="background" value="./img/capodanno2000-ric&fede3mini.jpg">
      <param name="host" value="javabase">
      <param name="key" value="cacowcbu">
    </applet>

--->
<!--
<applet width="200" height="300" code="SiteBrowser.class" archive="./java/SiteBrowser.jar"><param name="author" value="Mark S. Novojilov (http://www.lordmark.de/SB)"><param name="bgcolor" value="a3693b"><param name="bgimage" value="./img/sfondomarmostupendo.jpg"><param name="font1" value="ComicSans 1 24"><param name="font2" value="ComicSans 3 15"><param name="font3" value="ComicSans 5 12"><param name="icon1" value="oafaf00ffff00"><param name="key" value="082E0399C397B1"><param name="shape1" value="p0fafffff00ff"><param name="shape2" value="vffffff000000"><param name="target" value="frame_dx_foto"><param name="text" value="ffff007f0000"><param name="highlight" value="601f00ffb0ffff00"><param name="ralign" value="full"><param name="autocollapse" value="yes"><param name="tree" value="foto1.txt"></applet>
-->
 <p>

</body>
</html>
