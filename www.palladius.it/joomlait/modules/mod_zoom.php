<?php
######################################################################################
# Name:                   mod_zoom.php
# Version:                2b230
# Date:                   2005|12|xx
# Requirements:			  com_zoom 2.5 rc1
# PLEASE READ THE README.txt INCLUDED IN THIS PACKAGE
#
# mod_zoom is a module for Mambo Open Source using the
# component zoom gallery 
#
# Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
# Per Lasse Baasch
#
# Earlier based on the module by by Elaine Tang - happy@dragonly.com
#
# DEAR ALL WHO LIKES THIS CODE AND OR WANT TO CHANGE SOMETHING
# PLEASE INFORM ME DIRECLY OVER YOUR WHICHS OR CHANGES THAT YOU HAD DONE;
# CAUSE THAN I WILL BE ABLE TO PUBLISH IT FOR ALL // GPL
#
# Per Lasse Baasch
# mail: use contact form on www.skycube.net
#
# DOWNLOAD at:	http://www.skycube.net 
# DEMO at:		http://www.bsekrank.de
######################################################################################

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

##########################
#Global Config Variables
##########################
require($mosConfig_absolute_path.'/configuration.php');
require($mosConfig_absolute_path.'/components/com_zoom/etc/zoom_config.php');

// From zoom_config.php
$BaseImagePath  	= ($mosConfig_live_site."/".$zoomConfig['imagepath']);
$order				= $zoomConfig['orderMethod'];
$maxpagesize		= $zoomConfig['PageSize'];
$order				= $zoomConfig['orderMethod'];
$usepopup			= $zoomConfig['popUpImages'];
$popupmaxsize   	= $zoomConfig['maxsize']; // New

// from modules table
$zoomModule			= $params->def( 'zoomModule', 000 );
$showcount	 		= $params->def( 'showcount', 000 );
$showupdate	 		= $params->def( 'showupdate', 000 );
$showcatnames		= $params->def( 'showcatnames', 000 );
$showmeth			= $params->def( 'showmeth', 000 );
$date_format		= $params->def( 'date_format', 000 );
$showhits			= $params->def( 'showhits', 000 );
$showrates			= $params->def( 'showrates', 000 );
$onlythiscat		= $params->def( 'onlythiscat', 000 );
$counttoshow		= $params->def( 'counttoshow', 000 );
$directmenue		= $params->def( 'directmenue', 000 );
$directmenuedisc	= $params->def( 'directmenuedisc', 000 );
$directmenuecut 	= $params->def( 'directmenuecut', 000 );

$zoomMLang_count	= $params->def( 'zoomMLang_count', 000 );
$zoomMLang_lastup	= $params->def( 'zoomMLang_lastup', 000 );
$zoomMLang_hits		= $params->def( 'zoomMLang_hits', 000 );
$zoomMLang_rates	= $params->def( 'zoomMLang_rates', 000 );
$zoomMLang_votes	= $params->def( 'zoomMLang_votes', 000 );
$zoomMLang_newest	= $params->def( 'zoomMLang_newest', 000 );
$zoomMLang_random	= $params->def( 'zoomMLang_random', 000 );
$zoomMLang_directm	= $params->def( 'zoomMLang_directm', 000 );


// other
$modtable1			=	"zoomfiles";
$modtable2			= 	"zoom";
$modzoomfiles		=	"$mosConfig_dbprefix$modtable1";
global $modzoomcats;
$modzoomcats		=	"$mosConfig_dbprefix$modtable2";
$anfrage = mysql_connect($mosConfig_host,$mosConfig_user,$mosConfig_password); // needed for difficultly error handling

// Method selection		
#1=all 2=random 3=newest 4=hits 5=votes
$method =  @$params->method ? $params->method : $zoomModule;

// Ordering selection
if ($order == 5){ $myorder = 'imgname ASC'; } //ok
if ($order == 6){ $myorder = 'imgname DESC'; } //ok
if ($order == 3){ $myorder = 'imgfilename ASC'; } //ok
if ($order == 4){ $myorder = 'imgfilename DESC'; } //ok
if ($order == 1){ $myorder = 'imgdate ASC'; } //ok
if ($order == 2){ $myorder = 'imgdate DESC'; } //ok

##########################
#Language
##########################
if (file_exists($mosConfig_absolute_path."/components/com_zoom/lib/language/".$mosConfig_lang.".php")){ 
	include_once($mosConfig_absolute_path."/components/com_zoom/lib/language/".$mosConfig_lang.".php");
}else{ 
	include_once($mosConfig_absolute_path."/components/com_zoom/lib/language/english.php");
}

##########################
#Pop-Up sizes
##########################
if ($popupmaxsize < 550) 
{
  $popupmaxsizeW = "550";
  $popupmaxsizeH = "650";
}
elseif ($popupmaxsize > 550)
{
  $popupmaxsizeW = $popupmaxsize+50;
  $popupmaxsizeH = $popupmaxsize+150;
}

##########################
#Encryption for Pop-Up
##########################
function encrypt($string) {
		$convert = '';
		if (isset($string) && substr($string,1,4) != 'obfs') {
			for ($i=0; $i < strlen($string); $i++) {
				$dec = ord(substr($string,$i,1));
				if (strlen($dec) == 2) $dec = 0 . $dec;
				$dec = 324 - $dec;
				$convert .= $dec;
			}
			$convert = '{obfs:' . $convert . '}';
			return ($convert);
		} else {
		    return $string;
		}
	}

##########################
#Readout all cats for ALL
##########################
function lese_unterurls(&$anfrage, &$replies, $vorgaenger_id, $ebene)
{
  global $modzoomcats;
  $sql = "select catname, catid, subcat_id from $modzoomcats where subcat_id = $vorgaenger_id and published=1 and catpassword='' order by catname asc";
  $erg=mysql_query($sql,$anfrage);
  while($zeile=mysql_fetch_assoc($erg))
  {
	$zeile["ebene"]=$ebene;
	$replies[]=$zeile;
	lese_unterurls(&$anfrage,&$replies, $zeile["catid"], $ebene+1);
  }
}

function lese_urls(&$anfrage, $vorgaenger_id)
{
  $thread = array();
  lese_unterurls(&$anfrage, &$thread, $vorgaenger_id,0);
  return $thread;
}

##########################
#Catch ERRORS I
##########################
$sql = mysql_query("SELECT COUNT(*) as zeilenanzahl FROM $modzoomfiles where published=1 and imgmembers=1");
$m_fetch = mysql_fetch_object($sql);
if ($m_fetch->zeilenanzahl < 10)
{ 
  echo "<center><font class=small>NOT enough media for Module!</font></center><br>\n"; 
}

else 
{
  ##########################
  #Get catid for selcted directories and catch errors II
  ##########################
  if ((bool)$onlythiscat) {
  	$takethiscat = " and catid=$onlythiscat";
  } else {
      $takethiscat = "";
  }
  $anfrage = mysql_connect($mosConfig_host,$mosConfig_user,$mosConfig_password);

  if (!$anfrage)die("<br>ERROR<br>");
  if (!mysql_select_db($mosConfig_db, $anfrage))die("<br>ERROR<br>");

  if ((bool)$onlythiscat) {
  	$allebeitraege = lese_urls(&$anfrage, $onlythiscat); // 0 is die oberste Ebene
  }

  if (is_array($allebeitraege) && !empty($allebeitraege)) {
      foreach($allebeitraege as $beitrag)
      {
        $thetemp = $beitrag['catid'];
        $takethiscat = "$takethiscat or catid=$thetemp";
      }
  }
  if (!(bool)$onlythiscat) {
  	$where = "";
  } else {
      $where = "catid=$onlythiscat$takethiscat and ";
  }
  $where2 = " AND (imgfilename LIKE '%jpg%' OR imgfilename LIKE '%jpeg%' OR imgfilename LIKE '%gif%' OR imgfilename LIKE '%png%')"; //make sure we only select images from the database!
  $sql = mysql_query("SELECT COUNT(*) as zeilenanzahl FROM $modzoomfiles where $where imgmembers=1");
  $m_fetch = mysql_fetch_object($sql);
  $myfilescount = $m_fetch->zeilenanzahl;
  if ($myfilescount < 10) 
  { 
	echo "<center><font class=small>NOT enough media for Module!</font></center><br>\n"; 
  }

  else 
  {
    ##########################
    #Catch ERRORS III
    ##########################
	
	if(($method=='1')&&($counttoshow > 1))
	{
	  echo "<center><font class=small>NOT allowed! Please reduce the number of media to show or change method!</font></center><br>\n";
	}
	else
	{
	echo "<div align=\"center\">";
	##########################
	#Gallery Informations
	##########################
	$sql = mysql_query("SELECT COUNT(*) as zeilenanzahl FROM $modzoomfiles where published=1");
	$m_fetch = mysql_fetch_object($sql);
	
	if ($showcount == 2){
	  echo "<font class=small>";
	  echo $zoomMLang_count;
	  echo "<br>\n";
	  echo $m_fetch->zeilenanzahl;
	  echo "</font>";
	  echo "<br>\n";
	}
	
	$query4="SELECT max(imgid) as imgid FROM $modzoomfiles where published=1 and imgmembers=1$where2";
	$database->setQuery($query4);
	$row4=$database->loadObjectList();
	$row4=$row4[0];
	
	$query="SELECT imgid,imgname,imgfilename,imgdate,catid FROM $modzoomfiles WHERE imgid=$row4->imgid AND published=1 and imgmembers=1$where2 LIMIT 1";
	$database->setQuery($query);
	$row1=$database->loadObjectList();
	$row1=$row1[0];
	
	// Select Catname and Catdir for link to last update
	$query3="SELECT catname,catdir from $modzoomcats WHERE catid=$row1->catid AND published=1";
	$database->setQuery($query3);
	$row3=$database->loadObjectList();
	$row3=$row3[0];
	
	if ($showupdate == 2){
	  echo "<br><font class=small>";
	  echo $zoomMLang_lastup;
	  echo "<br>\n";
	  echo date($date_format, strtotime($row1->imgdate));
	  echo "<br>\n";
	  if ($showcatnames == 2){ 
	    echo "<a href='index.php?option=com_zoom&Itemid=$Itemid&catid=$row1->catid'>".stripslashes($row3->catname)."</a>";
	  }
	  echo "</font><br>\n";
	}
	
	##########################
    #Direct Access Menue
    ##########################
    if($directmenue ==2)
    {
      ?>
      <script LANGUAGE="JavaScript">
      function zoomgoto()
      { var URL = document.zoomdirect1.zommdirect2.options[document.zoomdirect1.zommdirect2.selectedIndex].value; window.location.href = URL; }
      </script>
      <?php

      if (!$anfrage)die("<br>ERROR<br>");
      if (!mysql_select_db($mosConfig_db, $anfrage))die("<br>ERROR<br>");

      $allebeitraege = lese_urls(&$anfrage, 0); // 0 is die oberste Ebene
      if(!$allebeitraege){echo "";}
      asort($allebeitraege);

      if($directmenuedisc==2)
      {
        echo "<br><div align=\"center\"><font class=small>\n";
        echo $zoomMLang_directm;
        echo "</font>\n";
      }
	  else echo "<br><div align=\"center\">";
	  
      echo "<form name=\"zoomdirect1\">\n";
      echo "<select name=\"zommdirect2\" size=\"1\" onChange=\"zoomgoto()\">\n";
      echo "<option value=\"\"> V V V V V V V V </option>\n";
      foreach($allebeitraege as $beitrag)
      {
        $thetemp1 = $beitrag['catid'];
    	$thetemp2 = $beitrag['catname'];
      $mystring=$thetemp2;
		if ($directmenuecut>=1)
		{ 
  		  if(strlen($mystring)>$directmenuecut)
   		  {                
    		$mystring = substr($mystring,0,$directmenuecut);
			$mystring=$mystring."...";           
		  };
		};
		echo "<option value=\"index.php?option=com_zoom&Itemid=$Itemid&catid=$thetemp1\">$mystring</option>\n";
      



      }
      echo "</select>\n";
      echo "</form></div>\n";
    }

	##########################
	#Show by RANDOM
	##########################
	if (($method=='1') || ($method=='2'))
	{
	  for($myi=0; $myi<$counttoshow;$myi++)
	  {
		// Select one CATID from zoomfiles
		$query="SELECT catid FROM $modzoomfiles WHERE $where published=1 and imgmembers=1$where2 ORDER BY rand() LIMIT 1";
		$database->setQuery($query);
		$row1=$database->loadObjectList();
		$row1=$row1[0];
		
		// Count Images in zommfiles with last CATID, published=1
		$sql = mysql_query("SELECT COUNT(*) as zeilenanzahl FROM $modzoomfiles where catid=$row1->catid and imgmembers=1$where2");
		$m_fetch = mysql_fetch_object($sql);
		$myfilescount = $m_fetch->zeilenanzahl;
		
		// Rand the count and select file(count)
		srand((double)microtime()*1000000);
		$selfile = rand(1,$myfilescount);
		
		// Select fileinforamtions in zoomfiles
		$query="SELECT imgid,imgname,imgfilename,imghits,votenum,catid,imgdate FROM $modzoomfiles WHERE published=1 and catid=$row1->catid and imgmembers=1$where2 ORDER BY $myorder LIMIT $myfilescount";
		$database->setQuery($query);
		$row66=$database->loadObjectList();
		$row66=$row66[($selfile-1)];
		
		// Select catinformations in zoom
		$query3="SELECT catname,catdir from $modzoomcats WHERE catid=$row66->catid";
		$database->setQuery($query3);
		$row77=$database->loadObjectList();
		$row77=$row77[0];
		
		// Select the page
		$pagecount = 1;
		$maxpagesize = $maxpagesize -1;
		$mzaehler = $selfile;
		$mteiler  = $maxpagesize;
		while ($mzaehler > $mteiler)
		{
		  $pagecount++;
		  $mzaehler = ($mzaehler - $mteiler);
		}
		
		// Correct the file (count starts with 1, but zoom with 0)
		$selfile = ($selfile - 1);
		// Show method of displaying?
		if ($showmeth == 2) 
		{
		  echo "<br>\n<font class=small>";
		  echo $zoomMLang_random;
		  echo ":</font><br>\n";
		}
		// Display picture
		if ($usepopup == 1){
		  $mycrypt = encrypt("catid=".$row66->catid."&key=$selfile&isAdmin=false&hit=1");
		  echo "<a href=\"javascript:void(0)\" onClick=\"window.open('components/com_zoom/www/view.php?popup=1&q=".$mycrypt."', 'win1', 'width=$popupmaxsizeW, height=$popupmaxsizeH, scrollbars=1').focus()\">";
		}
		else{   
		  echo "<a href=\"index.php?option=com_zoom&Itemid=$Itemid&page=view&catid=$row66->catid&PageNo=$pagecount&key=$selfile&hit=1\">";
		}
		echo "<img src='$BaseImagePath$row77->catdir/thumbs/$row66->imgfilename' border='0'></a><br>\n";
		// Show hits of the picture
		if ($showhits == 2){
		  echo "<font class=small>";
		  echo $zoomMLang_hits;
		  echo ": $row66->imghits</font><br>\n";
		}
		// Show rates of the picture
		if ($showrates == 2){
		  echo "<font class=small>";
		  echo $zoomMLang_rates;
		  echo ": $row66->votenum</font><br>\n";
		}
		// Show catname of displayed picture?
		if ($showcatnames ==2){ 
		  echo "<font class=small><a href='index.php?option=com_zoom&Itemid=$Itemid&catid=$row66->catid'>".stripslashes($row77->catname)."</a></font><br>\n";
		}
	  }
	}
	##########################
	#Show by NEWEST
	##########################
	if (($method=='1') || ($method=='3'))
	{
	  for($myi=0; $myi<$counttoshow; $myi++)
	  {
		// Select newest, published picture
		$query4="SELECT DISTINCT imgid as imgid FROM $modzoomfiles where published=1 and imgmembers=1$where2 ORDER BY imgid DESC LIMIT 10";
		$database->setQuery($query4);
		$row4=$database->loadObjectList();
		$row4=$row4[$myi];
		$selfileid = $row4->imgid;
		
		// Select one CATID from zoomfiles
		$query="SELECT catid FROM $modzoomfiles WHERE published=1 and imgid=$row4->imgid$where2 and imgmembers=1 LIMIT 1";
		$database->setQuery($query);
		$row1=$database->loadObjectList();
		$row1=$row1[0];
		
		// Count Images in zommfiles with last CATID, published=1
		$sql = mysql_query("SELECT COUNT(*) as zeilenanzahl FROM $modzoomfiles where catid=$row1->catid$where2 and imgmembers=1");
		$m_fetch = mysql_fetch_object($sql);
		$myfilescount = $m_fetch->zeilenanzahl;
		
		// Select fileinforamtions in zoomfiles
		$query="SELECT imgid,imgname,imgfilename,imghits,votenum,catid,imgdate FROM $modzoomfiles WHERE published=1 and catid=$row1->catid and imgmembers=1$where2 ORDER BY $myorder LIMIT $myfilescount";
		$database->setQuery($query);
		$row66=$database->loadObjectList();
		
		// Find the Position
		$mykey = '';
		$i = 0;
		while ($mykey == '')
		{
		  $mytemp2 = $row66[$i]->imgid;
		  if ($mytemp2 == $selfileid)
		  {
			$mykey = $i;
			break;
		  }
		  $i++;
		}
		$selfile = $mykey;
		$row66=$row66[$mykey];
	
		// Select catinformations in zoom
		$query3="SELECT catname,catdir from $modzoomcats WHERE catid=$row66->catid";
		$database->setQuery($query3);
		$row77=$database->loadObjectList();
		$row77=$row77[0];
		
		// Select the page
		$pagecount = 1;
		$maxpagesize = $maxpagesize -1;
		$mzaehler = $selfile;
		$mteiler  = $maxpagesize;
		while ($mzaehler > $mteiler)
		{
		  $pagecount++;
		  $mzaehler = ($mzaehler - $mteiler);
		}
		
		// Correct the file (count starts with 1, but zoom with 0)
		// Show method of displaying?
		if ($showmeth == 2) 
		{
		  echo "<br>\n<font class=small>";
		  echo $zoomMLang_newest;
		  echo ":</font><br>\n";
		}
		// Display picture
		if ($usepopup == 1){
		  $mycrypt = encrypt("catid=".$row66->catid."&key=$selfile&isAdmin=false&hit=1");
		  echo "<a href=\"javascript:void(0)\" onClick=\"window.open('components/com_zoom/www/view.php?popup=1&q=".$mycrypt."', 'win1', 'width=$popupmaxsizeW, height=$popupmaxsizeH, scrollbars=1').focus()\">";
		  
		  //echo "<a href=\"javascript:void(0)\" onClick=\"window.open('components/com_zoom/view.php?popup=1&catid=$row66->catid&key=$selfile&isAdmin=false&hit=1', 'win1', 'width=650, height=700, scrollbars=1').focus()\">";
		}
		else{
		  echo "<a href=\"index.php?option=com_zoom&Itemid=$Itemid&page=view&catid=$row66->catid&PageNo=$pagecount&key=$selfile&hit=1\">";
		}
		echo "<img src='$BaseImagePath$row77->catdir/thumbs/$row66->imgfilename' border='0'></a><br>\n";
		// Show hits of the picture
		if ($showhits == 2){
		  echo "<font class=small>";
		  echo $zoomMLang_hits;
		  echo ": $row66->imghits</font><br>\n";
		}
		// Show rates of the picture
		if ($showrates == 2){
		  echo "<font class=small>";
		  echo $zoomMLang_rates;
		  echo ": $row66->votenum</font><br>\n";
		}
		// Show catname of displayed picture?
		if ($showcatnames ==2){ 
		  echo "<font class=small><a href='index.php?option=com_zoom&Itemid=$Itemid&catid=$row66->catid'>".stripslashes($row77->catname)."</a></font><br>\n";
		}
	  }
	}
	
	##########################
	#Show by HITS
	##########################
	if (($method=='1') || ($method=='4'))
	{
	  for($myi=0; $myi<$counttoshow; $myi++)
	  {
		//SELECT DISTINCT imgid AS imgid FROM $modzoomfiles where published=1 and imgmembers=1 ORDER BY imghits DESC LIMIT 10
		// Select max hits
		$query99="SELECT DISTINCT imgid AS imgid FROM $modzoomfiles where published=1 and imgmembers=1$where2 ORDER BY imghits DESC LIMIT 10";
		//$query99="SELECT max(imghits) as imghits FROM $modzoomfiles where published=1 and imgmembers=1";
		$database->setQuery($query99);
		$row99=$database->loadObjectList();
		$row99=$row99[$myi];
		
		// Select imgid as imgid picture
		$query4="SELECT imgid FROM $modzoomfiles where imgid=$row99->imgid and imgmembers=1";
		$database->setQuery($query4);
		$row4=$database->loadObjectList();
		$row4=$row4[0];
		$selfileid = $row4->imgid;
		
		// Select one CATID from zoomfiles
		$query="SELECT catid FROM $modzoomfiles WHERE published=1 and imgid=$row4->imgid and imgmembers=1 LIMIT 1";
		$database->setQuery($query);
		$row1=$database->loadObjectList();
		$row1=$row1[0];
		
		// Count Images in zommfiles with last CATID, published=1
		$sql = mysql_query("SELECT COUNT(*) as zeilenanzahl FROM $modzoomfiles where catid=$row1->catid and imgmembers=1$where2");
		$m_fetch = mysql_fetch_object($sql);
		$myfilescount = $m_fetch->zeilenanzahl;
		
		// Select fileinforamtions in zoomfiles
		$query="SELECT imgid,imgname,imgfilename,imghits,votenum,catid,imgdate FROM $modzoomfiles WHERE published=1 and catid=$row1->catid and imgmembers=1$where2 ORDER BY $myorder LIMIT $myfilescount";
		$database->setQuery($query);
		$row66=$database->loadObjectList();
		
		// Find the Position
		$mykey = '';
		$i = 0;
		while ($mykey == '')
		{
		  $mytemp2 = $row66[$i]->imgid;
		  if ($mytemp2 == $selfileid)
		  {
			$mykey = $i;
			break;
		  }
		  $i++;
		}
		$selfile = $mykey;
		$row66=$row66[$mykey];
	
		// Select catinformations in zoom
		$query3="SELECT catname,catdir from $modzoomcats WHERE catid=$row66->catid";
		$database->setQuery($query3);
		$row77=$database->loadObjectList();
		$row77=$row77[0];
		
		// Select the page
		$pagecount = 1;
		$maxpagesize = $maxpagesize -1;
		$mzaehler = $selfile;
		$mteiler  = $maxpagesize;
		while ($mzaehler > $mteiler)
		{
		  $pagecount++;
		  $mzaehler = ($mzaehler - $mteiler);
		}
		
		// Correct the file (count starts with 1, but zoom with 0)
		//$selfile = ($selfile - 1);
		// Show method of displaying?
		if ($showmeth == 2) 
		{
		  echo "<br>\n<font class=small>";
		  echo $zoomMLang_hits;
		  echo ":</font><br>\n";
		}
		// Display picture
		if ($usepopup == 1){
		  $mycrypt = encrypt("catid=".$row66->catid."&key=$selfile&isAdmin=false&hit=1");
		  echo "<a href=\"javascript:void(0)\" onClick=\"window.open('components/com_zoom/www/view.php?popup=1&q=".$mycrypt."', 'win1', 'width=$popupmaxsizeW, height=$popupmaxsizeH, scrollbars=1').focus()\">";
		  
		  //echo "<a href=\"javascript:void(0)\" onClick=\"window.open('components/com_zoom/view.php?popup=1&catid=$row66->catid&key=$selfile&isAdmin=false&hit=1', 'win1', 'width=650, height=700, scrollbars=1').focus()\">";
		}
		else{
		  echo "<a href=\"index.php?option=com_zoom&Itemid=$Itemid&page=view&catid=$row66->catid&PageNo=$pagecount&key=$selfile&hit=1\">";
		}
		echo "<img src='$BaseImagePath$row77->catdir/thumbs/$row66->imgfilename' border='0'></a><br>\n";
		// Show hits of the picture
		if ($showhits == 2){
		  echo "<font class=small>";
		  echo $zoomMLang_hits;
		  echo ": $row66->imghits</font><br>\n";
		}
		// Show rates of the picture
		if ($showrates == 2){
		  echo "<font class=small>";
		  echo $zoomMLang_rates;
		  echo ": $row66->votenum</font><br>\n";
		}
		// Show catname of displayed picture?
		if ($showcatnames ==2){ 
		  echo "<font class=small>\n<a href='index.php?option=com_zoom&Itemid=$Itemid&catid=$row66->catid'>".stripslashes($row77->catname)."</a></font><br>\n";
		}
	  }
	}
	
	##########################
	#Show by VOTES
	##########################
	if (($method=='1') || ($method=='5'))
	{
	  for($myi=0; $myi<$counttoshow; $myi++)
	  {
		// Select max votenum
		$query99="SELECT DISTINCT imgid AS imgid, votenum, votesum, (votesum/votenum) AS rating FROM $modzoomfiles WHERE votesum > 0 AND votenum > 0 AND published = 1 and imgmembers=1$where2 ORDER BY rating desc, votenum DESC LIMIT 10";
		$database->setQuery($query99);
		$row99=$database->loadObjectList();
		$row99=$row99[$myi];
		//$row99=$row99[0];
		
		// Select imgid as imgid picture
		$query4="SELECT imgid FROM $modzoomfiles where imgid=$row99->imgid and imgmembers=1";
		$database->setQuery($query4);
		$row4=$database->loadObjectList();
		$row4=$row4[0];
		$selfileid = $row4->imgid;
		
		// Select one CATID from zoomfiles
		$query="SELECT catid FROM $modzoomfiles WHERE published=1 and imgid=$row4->imgid and imgmembers=1 LIMIT 1";
		$database->setQuery($query);
		$row1=$database->loadObjectList();
		$row1=$row1[0];
		
		// Count Images in zommfiles with last CATID, published=1
		$sql = mysql_query("SELECT COUNT(*) as zeilenanzahl FROM $modzoomfiles where catid=$row1->catid and imgmembers=1$where2");
		$m_fetch = mysql_fetch_object($sql);
		$myfilescount = $m_fetch->zeilenanzahl;
		
		// Select fileinforamtions in zoomfiles
		$query="SELECT imgid,imgname,imgfilename,imghits,votenum,catid,imgdate FROM $modzoomfiles WHERE published=1 and catid=$row1->catid and imgmembers=1$where2 ORDER BY $myorder LIMIT $myfilescount";
		$database->setQuery($query);
		$row66=$database->loadObjectList();
		
		// Find the Position
		$mykey = '';
		$i = 0;
		while ($mykey == '')
		{
		  $mytemp2 = $row66[$i]->imgid;
		  if ($mytemp2 == $selfileid)
		  {
			$mykey = $i;
			break;
		  }
		  $i++;
		}
		$selfile = $mykey;
		$row66=$row66[$mykey];
	
		// Select catinformations in zoom
		$query3="SELECT catname,catdir from $modzoomcats WHERE catid=$row66->catid";
		$database->setQuery($query3);
		$row77=$database->loadObjectList();
		$row77=$row77[0];
		
		// Select the page
		$pagecount = 1;
		$maxpagesize = $maxpagesize -1;
		$mzaehler = $selfile;
		$mteiler  = $maxpagesize;
		while ($mzaehler > $mteiler)
		{
		  $pagecount++;
		  $mzaehler = ($mzaehler - $mteiler);
		}
		
		// Correct the file (count starts with 1, but zoom with 0)
		// Show method of displaying?
		if ($showmeth == 2) 
		{
		  echo "<br>\n<font class=small>";
		  echo $zoomMLang_votes;
		  echo ":</font><br>\n";
		}
		// Display picture
		if ($usepopup == 1){
		  $mycrypt = encrypt("catid=".$row66->catid."&key=$selfile&isAdmin=false&hit=1");
		  echo "<a href=\"javascript:void(0)\" onClick=\"window.open('components/com_zoom/www/view.php?popup=1&q=".$mycrypt."', 'win1', 'width=$popupmaxsizeW, height=$popupmaxsizeH, scrollbars=1').focus()\">";
		}
		else{
		  echo "<a href=\"index.php?option=com_zoom&Itemid=$Itemid&page=view&catid=$row66->catid&PageNo=$pagecount&key=$selfile&hit=1\">";
		}
		echo "<img src='$BaseImagePath$row77->catdir/thumbs/$row66->imgfilename' border='0'></a><br>\n";
		// Show hits of the picture
		if ($showhits == 2){
		  echo "<font class=small>";
		  echo $zoomMLang_hits;
		  echo ": $row66->imghits</font><br>\n";
		}
		// Show rates of the picture
		if ($showrates == 2){
		  echo "<font class=small>";
		  echo $zoomMLang_rates;
		  echo ": $row66->votenum</font><br>\n";
		}
		// Show catname of displayed picture?
		if ($showcatnames ==2){ 
		  echo "<font class=small><a href='index.php?option=com_zoom&Itemid=$Itemid&catid=$row66->catid'>".stripslashes($row77->catname)."</a></font><br>\n";
		}
	  }
	}
	echo "</div>";
	} // END CATCH ERRORS III
  } // END catch errors II
} // END catch errors II
?>
