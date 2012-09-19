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
		if ($type == 'leftmenu') {
			$gen_id = ($GLOBALS['sw_module_count']++);
			$mod_id = ' id="sw_n'.$gen_id.'"';
			$onClick = ' onClick="opentree(\'sw_n'.$gen_id.'\')"';
			$this->cls = 'navOpened';
		}
		$rssurl 			= $params->get( 'rssurl' );
		$rssitems 			= $params->get( 'rssitems', 5 );
		$rssdesc 			= $params->get( 'rssdesc', 1 );
		$rssimage 			= $params->get( 'rssimage', 1 );
		$rssitemdesc		= $params->get( 'rssitemdesc', 1 );
		$moduleclass_sfx 	= $params->get( 'moduleclass_sfx' );
		$words 				= $params->def( 'word_count', 0 );

			?>
		<table cellspacing="0" cellpadding="0" align="center" class="<?= $this->cls ?>" width="100%"<?= $mod_id ?>>
			<?php if ($module->showtitle!=0) { ?>
  			<tr>
    			<th valign="top" <?= $onClick ?>><?php echo $this->title($module->title); ?></th>
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
		<td class="titleLeft"><img src="'. $mosConfig_live_site .'/templates/xplike.plesk.blue.rss/images/1x1.gif" border="0" alt="" valign="top" width="14" heigth="1"/></td>
		<td width="100%" class="titleText">'.$title.'</td>
		<td class="titleHandle"><img src="'. $mosConfig_live_site .'/templates/xplike.plesk.blue.rss/images/1x1.gif" border="0" alt="" valign="top" width="20" heigth="1"/></td>
		<td class="titleRight"><img src="'. $mosConfig_live_site .'/templates/xplike.plesk.blue.rss/images/1x1.gif" border="0" alt="" valign="top" width="3" heigth="1"/></td>
	</tr>
</table>
';
		} elseif ($this->type == 'top') {
			return '<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="moduleheaderleft"><img src="'.$mosConfig_live_site .'/templates/xplike.plesk.blue.rss/images/comptitle_left.gif" width="3" height="19" border="0" alt=""/></td>
		<td class="moduleheadertext">'.$title.'</td>
	</tr>
</table>';
		} elseif ($this->type == 'main') {
			
		} elseif ($this->type == 'right') {
			return '<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="moduleheaderleft"><img src="'.$mosConfig_live_site.'/templates/xplike.plesk.blue.rss/images/1x1.gif" width="3" height="19" border="0" alt=""/></td>
		<td class="moduleheadertext">'.$title.'</td>
	</tr>
</table>';
		} else {
			return $title;
		}
	}
}

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php include ("editor/editor.php"); ?>
<?php initEditor(); ?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<?php include ("includes/metadata.php"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.rss/css/template_css.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.rss/css/top.css">-->
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.rss/css/left.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.rss/css/main.css">-->
<link rel="shortcut icon" href="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.rss/favicon.ico" />
<script language="javascript" type="text/javascript" src="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.rss/javascript/leftframe.js"></script>
<style>
		.pollstableborder {
		border: 0px solid;
		padding: 0px;
		}
</style>
<title><?php echo $mosConfig_sitename; ?></title>
</head>
<script language="javascript">
<!--
	function setH() {
		var s = document.getElementById ('stick');
		var y;
		if (self.innerHeight) {// all except Explorer
			y = self.innerHeight;
		} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
			y = document.documentElement.clientHeight;
		} else if (document.body) { // other Explorers
			y = document.body.clientHeight;
		}
		s.style.height = (y-100) + 'px';
	}

//-->
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onResize="setH();">
<div class="top">
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="topbody">
 <tr>
  <td><?php echo $mosConfig_sitename; ?></td>
	  <td align="right" class="searchArea" valign="bottom"><form action='<?php echo sefRelToAbs("index.php"); ?>' method='post' name="search_form">
			<input class="searchbox" type="text" name="searchword" height="16" size="15" value="<?php echo _SEARCH_BOX; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';" />
			<input type="hidden" name="option" value="search" />
			<!-- <span class="commonButton" onClick="document.forms.search_form.submit();" id="bid-search">Search</span> -->
			<input type="submit" value="Go" class="">
		</form></td>
 </tr>
</table>
</div>
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td class="left" valign="top"><?php sw_mosLoadModules ( 'left', false, 'leftmenu' ); ?>
  </td>
 <script language="javascript">
 <!--
	var y;
	if (self.innerHeight) {// all except Explorer
		y = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		y = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		y = document.body.clientHeight;
	}
	document.write ('<td id="stick" style="height: '+(y-100)+'px; width: 1px; background-color: #cbcbd5" valign="top"><img src="<?php echo $mosConfig_live_site;?>/templates/xplike.plesk.blue.rss/images/1x1.gif" width="1" height="1" border="0" alt=""/></td>');

 //-->
 </script>
  <td class="main" valign="top">

  <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
		<td  height="27" class="util">
			<div align="left">
			  <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="pathbar">
                <tr>
                  <td align="left" class="pathbar">
				<?php 
          $path_no_img = true;
          mosPathWay();
				?></td>
                </tr>
              </table>
	  </div></td>
   </tr>
   <tr>
    <td valign="top">


<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" class="maincontent">
   <?php 
    if (mosCountModules('top')) 
    {
      sw_mosLoadModules ( 'top', false, 'top' );
    }
    if (mosCountModules('user1') || mosCountModules('user2'))
    {
      echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"\"><tr>";
      if (mosCountModules('user1'))
      {
        echo "<td>";
        sw_mosLoadModules( 'user1', false, 'top');
        echo "</td>";
      }
      if (mosCountModules('user2'))
      {
        echo "<td>";
        sw_mosLoadModules( 'user2', false, 'top');
        echo "</td>";
      }
      echo "</tr></table>";
    }
    ob_start ();
    include_once ("mainbody.php");
    $cnt = ob_get_contents ();
    ob_end_clean ();
    $cnt = preg_replace ("'(<table cellpadding=\"0\" cellspacing=)\"1(\" border=\"0\" width=\"100%\" class=\")contentpaneopen(\">\s*<tr>)\s*(<td class=\"contentheading\" width=\"100%\">\s*.*?\s*</td>\s*(<td align=\"right\">.*?</td>\s*)?</tr>\s*</table>)'si", "<div class=\"content-header\">\\1\"0\\2contentpaneopentitle\\3<td class=\"moduleheaderleft\"><img src=\"".$mosConfig_live_site."/templates/xplike.plesk.blue.rss/images/1x1.gif\" width=\"3\" height=\"19\" border=\"0\" alt=\"\"/></td>\\4</div>", $cnt);
    echo $cnt;
   ?>
  </td>
  <td<?php if (mosCountModules('right')) echo " width=\"170\""; ?> valign="top" class="right">
   
   <?php 
   if (mosCountModules('right')) sw_mosLoadModules ( 'right', false, 'right' );
   ?>
  </td>
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
<tr>
  <td align="center" width="100%" style="background:url('<?php echo $mosConfig_live_site; ?>/templates/xplike.plesk.blue.rss/images/footer_bg.png');background-repeat:repeat-x;"><a href="http://www.netshinesoftware.com/">Mambo Template Supplied by Netshine Software Limited</a></td></tr>
</tr>
</table>

</body>
</html>

<?php
/* SWsoft extends */

/**
* @param string The position
* @param int The style.  0=normal, 1=horiz, -1=no wrapper
*/
function sw_mosLoadModules( $position='left', $horiz=false , $type = false, $style=0 ) {
	global $mosConfig_gzip, $mosConfig_absolute_path, $database, $my, $Itemid, $mosConfig_caching;

	$tp = mosGetParam( $_GET, 'tp', 0 );
	if ($tp) {
	    echo '<div style="height:50px;background-color:#eee;margin:2px;padding:10px;border:1px solid #f00;color:#700;">';
		echo $position;
		echo '</div>';
		return;
	}
	$style = intval( $style );
	$cache =& mosCache::getCache( 'com_content' );

	require_once( $mosConfig_absolute_path . '/includes/frontend.html.php' );

	$allModules =& initModules();
	if (isset( $GLOBALS['_MOS_MODULES'][$position] )) {
	    $modules = $GLOBALS['_MOS_MODULES'][$position];
	} else {
		$modules = array();
	}

	if (count( $modules ) < 1) {
		$style = 0;
	}
	if ($style == 1) {
		echo "<table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n";
		echo "<tr>\n";
	}
	$prepend = ($style == 1) ? "<td valign=\"top\">\n" : '';
	$postpend = ($style == 1) ? "</td>\n" : '';

	$count = 1;
	foreach ($modules as $module) {
		$params =& new mosParameters( $module->params );

		echo $prepend;
    
    if ($type) {
			$sw_mod = new sw_modules_html( $module, $params, $Itemid, $type );
		} else if ((substr("$module->module",0,4))=="mod_") {
			if ($params->get('cache') == 1 && $mosConfig_caching == 1) {
				$cache->call('modules_html::module2', $module, $params, $Itemid, $style );
			} else {
				modules_html::module2( $module, $params, $Itemid, $style, $count );
			}
		} else {
			if ($params->get('cache') == 1 && $mosConfig_caching == 1) {
				$cache->call('modules_html::module', $module, $params, $Itemid, $style );
			} else {
				modules_html::module( $module, $params, $Itemid, $style );
			}
		}

		echo $postpend;
		$count++;
	}
	if ($style == 1) {
		echo "</tr>\n</table>\n";
	}
}
?>
