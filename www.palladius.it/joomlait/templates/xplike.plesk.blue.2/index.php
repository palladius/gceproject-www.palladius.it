<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
$GLOBALS['sw_module_count'] = 0;
$GLOBALS['sw_no_spacing'] = true;
class sw_modules_html {
	var $mod_ = false;
	var $type = false;
	var $cls = 'moduletable';
	function sw_modules_html( &$module, &$params, $Itemid, $type = false ) {
		global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;
		global $mainframe, $database, $my;
		$this->mod_ = ((substr("$module->module",0,4))=="mod_");
		$this->type = $type;
		$onClick = $mod_id = '';
		$rssurl 			= $params->get( 'rssurl' );
		$rssitems 			= $params->get( 'rssitems', 5 );
		$rssdesc 			= $params->get( 'rssdesc', 1 );
		$rssimage 			= $params->get( 'rssimage', 1 );
		$rssitemdesc		= $params->get( 'rssitemdesc', 1 );
		$moduleclass_sfx 	= $params->get( 'moduleclass_sfx' );
		$words 				= $params->def( 'word_count', 0 );
		
    if ($type == 'leftmenu') {
			$gen_id = ($GLOBALS['sw_module_count']++);
			$mod_id = ' id="sw_n'.$gen_id.'"';
			$onClick = ' onClick="opentree(\'sw_n'.$gen_id.'\')"';
			if (strtoupper($moduleclass_sfx) == "-COLLAPSE")
			{
			  $this->cls = 'navClosed';
      }
      else
      {
			  $this->cls = 'navOpened';
			}
		}		

			?>
		<table cellspacing="0" cellpadding="0" align="center" class="<?php echo $this->cls ?>" width="100%"<?php echo $mod_id ?>>
			<?php if ($module->showtitle!=0) { ?>
  			<tr>
    			<th valign="top" <?php echo $onClick ?>><?php echo $this->title($module->title); ?></th>
    		</tr>
			<?php
			}
			?>
    		<tr>
    			<td class="modulecontent"><div class="modulecontent">
			<?php
			// check for custom language file
			if ($this->mod_) {
				if (file_exists( "modules/$module->module.$mosConfig_lang.php" )) {
					include( "modules/$module->module.$mosConfig_lang.php" );
				} else if (file_exists( "modules/$module->module.eng.php" )) {
					include( "modules/$module->module.eng.php" );
				}
				include( "modules/$module->module.php" );
				if (isset( $content)) {
					echo $content;
				}
			} else {
				echo $module->content;
			}
				?>
    	
			<?php 
      // feed output
  		if ( $rssurl ) {
  		  echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
  			$cacheDir 		= $mosConfig_absolute_path .'/cache/';
  			$LitePath 		= $mosConfig_absolute_path .'/includes/Cache/Lite.php';
  			require_once( $mosConfig_absolute_path .'/includes/domit/xml_domit_rss.php' );
  			$rssDoc =& new xml_domit_rss_document();
  			$rssDoc->useCacheLite(true, $LitePath, $cacheDir, 3600);
  			$rssDoc->loadRSS( $rssurl );
  			$totalChannels 	= $rssDoc->getChannelCount();
  
  			for ( $i = 0; $i < $totalChannels; $i++ ) {
  				$currChannel =& $rssDoc->getChannel($i);
  				$elements 	= $currChannel->getElementList();
  				$iUrl		= 0;
  				foreach ( $elements as $element ) {
  					//image handling
  					if ( $element == 'image' ) {
  						$image =& $currChannel->getElement( DOMIT_RSS_ELEMENT_IMAGE );
  						$iUrl	= $image->getUrl();
  						$iTitle	= $image->getTitle();
  					}
  				}
  
  				// feed title
  				?>
  				<tr>
  					<td>
  					<strong>
  					<a href="<?php echo $currChannel->getLink(); ?>" target="_blank">
  					<?php echo $currChannel->getTitle(); ?>
  					</a>
  					</strong>
  					</td>
  				</tr>
  				<?php
  				// feed description
  				if ( $rssdesc ) {
  					?>
  					<tr>
  						<td>
  						<?php echo $currChannel->getDescription(); ?>
  						</td>
  					</tr>
  					<?php
  				}
  				// feed image
  				if ( $rssimage ) {
  					?>
  					<tr>
  						<td align="center">
  						<img src="<?php echo $iUrl; ?>" alt="<?php echo $iTitle; ?>"/>
  						</td>
  					</tr>
  					<?php
  				}
  
  				$actualItems = $currChannel->getItemCount();
  				$setItems = $rssitems;
  
  				if ($setItems > $actualItems) {
  					$totalItems = $actualItems;
  				} else {
  					$totalItems = $setItems;
  				}
  
  				?>
  				<tr>
  					<td>
  					<ul class="newsfeed<?php echo $moduleclass_sfx; ?>">
  					<?php
  					for ($j = 0; $j < $totalItems; $j++) {
  						$currItem =& $currChannel->getItem($j);
  						// item title
  						?>
  						<li class="newsfeed<?php echo $moduleclass_sfx; ?>">
  						<strong>
  						<a href="<?php echo $currItem->getLink(); ?>" target="_blank">
  						<?php echo $currItem->getTitle(); ?>
  						</a>
  						</strong>
  						<?php
  						// item description
  						if ( $rssitemdesc ) {
  							// item description
  							$text 	= html_entity_decode( $currItem->getDescription() );
  
  							// word limit check
  							if ( $words ) {
  								$texts = explode( ' ', $text );
  								$count = count( $texts );
  								if ( $count > $words ) {
  									$text = '';
  									for( $i=0; $i < $words; $i++ ) {
  										$text .= ' '. $texts[$i];
  									}
  									$text .= '...';
  								}
  							}
  							?>
  							<div>
  							<?php echo $text; ?>
  							</div>
  							<?php
  						}
  						?>
  						</li>
  						<?php
  					}
  					?>
  					</ul>
  					</td>
  				</tr>
			   </tr>
			 </table></div></td>
  				<?php
  			}
  		}
      ?>
    </table>
  	<br />
	<?php
	}
	function title ($title) {
		global $mosConfig_live_site;
		if ($this->type == 'leftmenu') {
			return '<table border="0" cellspacing="0" cellpadding="0" width="100%" class="navTitle" onMouseOver="mover(this)" onMouseOut="mout(this)">
	<tr>
		<td class="titleLeft"><img src="'. $mosConfig_live_site .'/templates/xplike.plesk.blue.2/images/1x1.gif" border="0" alt="" valign="top" width="14" heigth="1"/></td>
		<td width="100%" class="titleText">'.$title.'</td>
		<td class="titleHandle"><img src="'. $mosConfig_live_site .'/templates/xplike.plesk.blue.2/images/1x1.gif" border="0" alt="" valign="top" width="20" heigth="1"/></td>
		<td class="titleRight"><img src="'. $mosConfig_live_site .'/templates/xplike.plesk.blue.2/images/1x1.gif" border="0" alt="" valign="top" width="3" heigth="1"/></td>
	</tr>
</table>
';
		} elseif ($this->type == 'top') {
			return '<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="moduleheaderleft"><img src="'.$mosConfig_live_site .'/templates/xplike.plesk.blue.2/images/comptitle_left.gif" width="3" height="19" border="0" alt=""/></td>
		<td class="moduleheadertext">'.$title.'</td>
	</tr>
</table>';
		} elseif ($this->type == 'main') {
			
		} elseif ($this->type == 'right') {
			return '<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="moduleheaderleft"><img src="'.$mosConfig_live_site.'/templates/xplike.plesk.blue.2/images/1x1.gif" width="3" height="19" border="0" alt=""/></td>
		<td class="moduleheadertext">'.$title.'</td>
	</tr>
</table>';
		} else {
			return $title;
		}
	}
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<?php global $my; if ($my->id) {
  include_once ("editor/editor.php");
  initEditor(); } ?>
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.2/css/template_css.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.2/css/left.css" />
<style type="text/css">
		.pollstableborder {
		border: 0px solid;
		padding: 0px;
		}
	</style>
<script language="javascript" type="text/javascript" src="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.2/javascript/leftframe.js"></script>
<?php mosShowHead(); ?>
<script type="text/javascript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.2/javascript/stylechanger.js"></script>
<?php
if ($my->id)
{
  initEditor();
}
?>
</head>
<body>
<a name="top"></a>
<div class="top">
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="topbody">
 <tr>
  <td valign="middle" width="80"><img src="<?php echo $mosConfig_live_site; ?>/templates/xplike.plesk.blue.2/images/logo.gif" border="0" alt="" /></td>
  <td valign="middle" class="hometitle"><?php echo $mosConfig_sitename; ?></td>
	  <td align="right" class="searchArea" valign="bottom"><form action='<?php echo sefRelToAbs("index.php"); ?>' method='post' name="search_form">
			<input class="searchbox" type="text" name="searchword" size="15" value="<?php echo _SEARCH_BOX; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';" />
			<input type="hidden" name="option" value="search" />
			<!-- <span class="commonButton" onClick="document.forms.search_form.submit();" id="bid-search">Search</span> -->
			<input type="submit" value="Go" class="" />
		</form></td>
 </tr>
</table>
</div>
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td class="left" valign="top"><?php sw_mosLoadModules ( 'left', false, 'leftmenu' ); ?><br />
  </td>
  <td class="main" valign="top">

  <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
		<td height="27" class="util">
			<div align="left">
			  <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="pathbar">
                <tr>
                  <td align="left" class="pathbar">
				<?php 
          $path_no_img = true;
          if ( $_GET['option'] != 'com_frontpage' && isset( $_GET['option'] ) && isset( $_GET['Itemid'] ) && substr($_SERVER['REQUEST_URI'],strlen($_SERVER['REQUEST_URI']) - 10) != '/index.php')
          {
          	ob_start();
            mosPathWay();
            $pathway = ob_get_contents();
            ob_end_clean();
            if (substr_count($pathway, 'Home') > 1) // remove duplicate home
            {
              $pathway = ereg_replace('<a href=.+>Home</a>','', $pathway);
            }
            echo $pathway;
            //if ($pathway != '<span class="pathway"><a href="' . sefRelToAbs("$mosConfig_live_site/index.php") . '" class="pathway">Home</a> <img src="' . $mosConfig_live_site . '/images/M_images/arrow.png" alt="arrow" />   Home </span>')
            //{
              
            //}
          }
				?></td>
				<td align="right"><span class="font-size-button"><a href="index.php" title="Increase size" onclick="changeFontSize(1);return false;"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $cur_template; ?>/images/css_larger.png" alt="Make Text Bigger" border="0" /></a></span><span class="font-size-button"><a href="index.php" title="Decrease size" onclick="changeFontSize(-1);return false;"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $cur_template; ?>/images/css_smaller.png" alt="Make Text Smaller" border="0" /></a></span><span class="font-size-button"><a href="index.php" title="Revert styles to default" onclick="revertStyles(); return false;"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $cur_template; ?>/images/css_reset.png" alt="Reset Text Size" border="0" /></a></span></td>
                </tr>
              </table>
	  </div></td>
   </tr>
   <tr>
    <td valign="top">


<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td valign="top" class="maincontent">
  <?php if (mosCountModules('top')) { ?>
        <?php mosLoadModules ( 'top', false, 'top' ); ?>
   <?php } ?>
   <?php
   //ob_start ();
   ?>
   <?php include_once ("mainbody.php"); ?>
   <?php
   ?>
  </td>
  <?php if (mosCountModules('right') > 0 || mosCountModules('user1') > 0 || mosCountModules('user2') > 0) { ?>
  <td width="160" valign="top" class="right">
   <?php 
   if (mosCountModules('right')) sw_mosLoadModules ( 'right', false, 'right' );
   if (mosCountModules('user1')) sw_mosLoadModules ( 'user1', false, 'right' );
   if (mosCountModules('user2')) sw_mosLoadModules ( 'user2', false, 'right' );
   ?>
  </td>
  <?php } else {
  echo "<td></td>";
  }?>
 </tr>
</table>

    </td>
   </tr>
  </table>
   
  </td>
 </tr>
</table>

<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
 <td>
  <?php mosLoadModules ( 'bottom' ); ?>
 </td>
</tr>
<tr>
  <td><?php mosLoadModules ( 'inset' ); ?></td>
</tr>
<tr style="background-image:url('<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.2/images/footer_bg.png');background-repeat:repeat-x;">
  <td><div align="center" style="padding:2px;margin-left:auto;margin-right:auto;color:#000099;font-size:0.9em">
    Joomla Template Supplied by <a href="http://www.netshinehosting.com">Netshine Hosting</a></div>
  </td>
</tr>
</table>

</body>
</html>

<?php
/* SWsoft extends */

function sw_mosLoadModules( $position='left', $horiz=false , $type = false ) {
	global $database, $my, $Itemid;
	
	require_once( "includes/frontend.php" );
	require_once( "includes/frontend.html.php" );

	$query = "SELECT id, title, module, position, content, showtitle, params"
	."\nFROM #__modules AS m, #__modules_menu AS mm"
	. "\nWHERE m.published='1' AND m.access <= '$my->gid' AND m.position='$position'"
	. "\nAND mm.moduleid=m.id"
	. "\nAND (mm.menuid = '$Itemid' OR mm.menuid = '0')"
	. "\nORDER BY ordering";
	
	$database->setQuery( $query );
	$modules = $database->loadObjectList();
	if($database->getErrorNum()) {
		echo "MA ".$database->stderr(true);
		return;
	}
	
	if (count( $modules ) < 1) {
		$horiz = false;
	}
	if ($horiz) {
		echo "<table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" width=\"100%\">";
		echo "\n<tr>";
	}
	foreach ($modules as $module) {
	   $params =& new mosParameters( $module->params );
		//$params = mosParseParams( $module->params );

		if ($horiz) {
			echo "<td valign=\"top\">";
		}
			
		if ($type) {
			$sw_mod = new sw_modules_html( $module, $params, $Itemid, $type );
		} elseif ((substr("$module->module",0,4))=="mod_") {
			modules_html::module2( $module, $params, $Itemid);
		} else {
			modules_html::module( $module, $params, $Itemid);
		}

		if ($horiz) {
			echo "</td>";
		}
	}
	if ($horiz) {
		echo "\n</tr>\n</table>";
	}
}

?>
