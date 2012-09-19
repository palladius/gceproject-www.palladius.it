<?php
######################################################################################
# Name:                   mod_zoom.php
# Version:                1b001
# Date:                   2005|12|xx
# Requirements:			  com_zoom_2.5rc1
#
# mod_zoom_menue is a module for Mambo Open Source using the
# component zoom gallery 
#
# Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
# Per Lasse Baasch
#
# DEAR ALL WHO LIKES THIS CODE AND OR WANT TO CHANGE SOMETHING
# PLEASE INFORM ME DIRECLY OVER YOUR WHICHS OR CHANGES THAT YOU HAD DONE;
# CAUSE THAN I WILL BE ABLE TO PUBLISH IT FOR ALL // GPL
#
#####################################################################################
# Spezial thanks to Andreas Mastny (Weilheim, Germany)
#####################################################################################
#
# Per Lasse Baasch
# mail: use contact form on www.skycube.net
#
# DOWNLOAD at:	http://www.skycube.net 
#
######################################################################################
# Filename: mod_zoom_menue.php
######################################################################################

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );
global $mosConfig_offset;

##########################
#Global Config
##########################
require($mosConfig_absolute_path.'/configuration.php');
include($mosConfig_absolute_path.'/components/com_zoom/etc/zoom_config.php');

$zoomMenueReplaceIcon1 = $mosConfig_live_site.'/components/com_zoom/www/images/folder.png';
$zoomMenueReplaceIcon2 = $mosConfig_live_site.'/components/com_zoom/www/images/folder_small.gif';

$BaseImagePath = ($mosConfig_live_site."/".$zoomConfig['imagepath']);

// Main
$zoomMenueTOPspacer			=  $params->def( 'zoomMenueTOPspacer', 40 );				// Spacer on TOP for varius Templates
$zoomMenueImageW 			=  $params->def( 'zoomMenueImageW', 40 );					// Menue Image Width 4:3
$zoomMenueImageH 			=  $params->def( 'zoomMenueImageH', 30 );					// Menue Image Hight 4:3
$zoomMenueRoot 				=  $params->def( 'zoomMenueRoot', 0 );						// catid of root for menue
$zoomMenueRootRand 			=  $params->def( 'zoomMenueRootRand', 0 );					// Random Menue yes/no !using also before configured root!
$zoomMenueDCut 				=  $params->def( 'zoomMenueDCut', 18 );						// Max Stringlen until YOUR design crashes!
// Sub
$zoomMenueSub 				=  $params->def( 'zoomMenueSub', 0 );						// Enable Submenue
$zoomMenueSubDCut 			=  $params->def( 'zoomMenueSubDCut', 18 );					// Max Stringlen until YOUR design crashes!
$zoomMenueSubImageW 		=  $params->def( 'zoomMenueSubImageW', 24 );				// SubMenue Image Width 4:3
$zoomMenueSubImageH 		=  $params->def( 'zoomMenueSubImageH', 18 );				// SubMenue Image Hight 4:3
// Style
$zoomMenueStyleWidth		=  $params->def( 'zoomMenueStyleWidth', '160px' );			// Width of the Module
$zoomMenueStyleFont			=  $params->def( 'zoomMenueStyleFont', 'arial' );			// Fontface for the strings
$zoomMenueStyleFontSize		=  $params->def( 'zoomMenueStyleFontSize', '12px' );		// Fontsize for the strings
$zoomMenueStyleFontColorA	=  $params->def( 'zoomMenueStyleFontColorA', '#c0c0c0' );	// Fontcolor normal
$zoomMenueStyleFontColorB	=  $params->def( 'zoomMenueStyleFontColorB', '#ff6600' );	// Fontcolor hover
$zoomMenueStyleBgColorA		=  $params->def( 'zoomMenueStyleBgColorA', '#000000' );		// Backgroundcolor normal
$zoomMenueStyleBgColorB		=  $params->def( 'zoomMenueStyleBgColorB', '#c0c0c0' );		// Backgroundcolor hover
$zoomMenueStyleBgImageA		=  $params->def( 'zoomMenueStyleBgImageA', '' );			// Backgroundimage normal
$zoomMenueStyleBgImageB		=  $params->def( 'zoomMenueStyleBgImageB', '' );			// Backgroundimage hover

#######################################################################
# HTML head script and styles
#######################################################################
?>
<script type="text/javascript">
sfHover = function() {
	var sfEls = document.getElementById("zoomMenueStyles").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
</script>

<style type="text/css">
#zoomMenueStyles ul{
	margin: 0;
	padding: 0;
	width: <?php echo "$zoomMenueStyleWidth"; ?>;
	font-family: <?php echo "$zoomMenueStyleFont"; ?>;
	background-color: <?php echo "$zoomMenueStyleBgColorA"; ?>; 	/* Hintergrundfarbe des kompletten bums */
	background-image : url(<?php echo "$zoomMenueStyleBgImageA"; ?>);
}
#zoomMenueStyles ul li{
	list-style-type: none;
	list-style-image: none;
	display: inline;
}
#zoomMenueStyles img{
	border: 0;
	vertical-align: middle;
	padding: 0 5px 0 0; /* Abstand der Bilder zum Text */
}
#zoomMenueStyles li a{
	display: block;
	height: 1%;
	padding: 4px;
	border-top: 2px solid orange; /* Dicke und farbe der Trennlinien auf erster Ebene ( und drunter wenn nix andres definiert ) */
	font-size: 12px;
	text-decoration: none;
	color: <?php echo "$zoomMenueStyleFontColorA"; ?>; /* Schriftfarbe auf erster Ebene ( und drunter wenn nix andres definiert ) */
}
#zoomMenueStyles li ul{
	display: none;
}
#zoomMenueStyles li ul li a{
	padding: 4px 4px 5px 20px;
	font-size: 12px;
	border-top: 1px solid orange; /* Dicke und farbe der Trennlinien auf zweiter Ebene */
}
#zoomMenueStyles li:hover ul, 
#zoomMenueStyles li.sfhover ul{
	display: block;
}
#zoomMenueStyles li a:hover, #zoomMenueStyles li ul li a:hover
{
    color: <?php echo "$zoomMenueStyleFontColorB"; ?>;
	background-color: <?php echo "$zoomMenueStyleBgColorB"; ?>;
	background-image : url(<?php echo "$zoomMenueStyleBgImageB"; ?>);
}
#zoomMenueStyles ul li{
	display: inline;
}
#zoomMenueStyles a{
	height: 1%;
}
</style>

<?php
#######################################################################
# Creating Output
#######################################################################

// Random Menue Selction
if($zoomMenueRootRand == 1)
{
  $zoomMenueRootValid = 0;
  while($zoomMenueRootValid !== 1)
  {
    $database->setQuery("SELECT catid from #__zoom WHERE published=1 and subcat_id='$zoomMenueRoot' order by rand()");
    $rowX=$database->loadObjectList();
    $tzoomMenueRoot=$rowX[0]->catid;
	
	$database->setQuery("SELECT COUNT(*) as mycount FROM #__zoom where published=1 and subcat_id='$tzoomMenueRoot'");
    $rowY=$database->loadObjectList();
	if($rowY[0]->mycount > 0) 
	{
	  $zoomMenueRootValid = 1;
	  $zoomMenueRoot = $tzoomMenueRoot;
	}
  }
}

// Spacer
if($zoomMenueTOPspacer > 0)
  echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td height=\"$zoomMenueTOPspacer\">&nbsp;</td></tr></table>\n";

// Last Security Check -> Does Subcats realy exists?
$database->setQuery("SELECT COUNT(*) as mycount FROM #__zoom where published=1 and subcat_id='$zoomMenueRoot'");
$row0=$database->loadObjectList();
if ($row0[0]->mycount < 1)
{
  echo "<center><font class=small>NOT enought Cathegoeries for Module!</font></center><br>\n";
}
else 
{
  $database->setQuery("SELECT catname,catid,catdir,catimg from #__zoom WHERE published=1 and subcat_id='$zoomMenueRoot'");
  $row1=$database->loadObjectList();
  
  echo "<div id=\"zoomMenueStyles\"><ul>\n"; // new
  
  for($i=0; $i<$row0[0]->mycount; $i++)
  {
	if($row1[$i]->catimg != '')
	{
	  $database->setQuery("SELECT imgid,catid,imgfilename from #__zoomfiles WHERE imgid=".$row1[$i]->catimg." limit 1");
      $row2=$database->loadObjectList();
	  
	  $database->setQuery("SELECT catid,catdir from #__zoom WHERE catid=".$row2[0]->catid." limit 1");
      $row3=$database->loadObjectList();
	  
	  $catimage = "<img style=\"vertical-align: middle;\" src=\"$BaseImagePath".$row3[0]->catdir."/thumbs/".$row2[0]->imgfilename."\" border=\"0\" width=\"$zoomMenueImageW\" height=\"$zoomMenueImageH\">";
	}
	else
	  $catimage = "<img style=\"vertical-align: middle;\" src=\"$zoomMenueReplaceIcon1\" border=\"0\" width=\"$zoomMenueImageW\" height=\"$zoomMenueImageH\">";
	
	$ItemDiscription = $row1[$i]->catname;
	if(strlen($ItemDiscription)>$zoomMenueDCut)
   	{
      $ItemDiscription = substr($ItemDiscription,0,$zoomMenueDCut);
	  $ItemDiscription=$ItemDiscription."...";
	};
    
    $database->setQuery("SELECT COUNT(*) as subcount FROM #__zoom where published=1 and subcat_id='".$row1[$i]->catid."'");
    $row4=$database->loadObjectList();
	
	if($row4[0]->subcount==0 || $zoomMenueSub==0)  //if($zoomMenueSub==1)
	{
      echo "<li><a href=\"index.php?option=com_zoom&Itemid=$Itemid&catid=".$row1[$i]->catid."\">".$catimage.$ItemDiscription."</a></li>\n";
    }
	else
	{
      if($row4[0]->subcount!=0)
      { 
	    echo "<li><a href=\"index.php?option=com_zoom&Itemid=$Itemid&catid=".$row1[$i]->catid."\">".$catimage.$ItemDiscription."</a>\n";
	    echo "<ul>\n";
	  }
	  for($ii=0; $ii<$row4[0]->subcount; $ii++)
 	  {
	    $database->setQuery("SELECT catname,catid,catdir,catimg from #__zoom WHERE published=1 and subcat_id='".$row1[$i]->catid."'");
  	    $row5=$database->loadObjectList();
	  
	    if($row5[$ii]->catimg != 0)
	    {
          $database->setQuery("SELECT imgid,catid,imgfilename from #__zoomfiles WHERE imgid=".$row5[$ii]->catimg." limit 1");
          $row6=$database->loadObjectList();
		
          $database->setQuery("SELECT catid,catdir from #__zoom WHERE catid=".$row6[0]->catid." limit 1");
          $row7=$database->loadObjectList();
		
	      $subcatimage = "<img src=\"$BaseImagePath".$row7[0]->catdir."/thumbs/".$row6[0]->imgfilename."\" border=\"0\" width=\"$zoomMenueSubImageW\" height=\"$zoomMenueSubImageH\">";
	    }
	    else
		  $subcatimage = "<img src=\"$zoomMenueReplaceIcon2\" border=\"0\" width=\"$zoomMenueSubImageW\" height=\"$zoomMenueSubImageH\">";
	  
	    $SubItemDiscription = $row5[$ii]->catname;
   	    if(strlen($SubItemDiscription)>$zoomMenueSubDCut)
   	    {
    	  $SubItemDiscription = substr($SubItemDiscription,0,$zoomMenueSubDCut);
		  $SubItemDiscription=$SubItemDiscription."...";
	    };
	  
	    echo "<li><a href=\"index.php?option=com_zoom&Itemid=$Itemid&catid=".$row5[$ii]->catid."\">".$subcatimage.$SubItemDiscription."</a></li>\n";
	  }// for sub cats
	  if($row4[0]->subcount!=0) echo "</ul></li>\n";
	} // subcats
  } // for root cats
  echo "</ul></div>\n";
} // end general else
?>  
  
  
  
