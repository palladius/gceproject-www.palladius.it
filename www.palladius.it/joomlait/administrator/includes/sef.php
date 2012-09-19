<?php
/**
* @version $Id: sef.php 2546 2006-02-22 23:25:28Z stingrey $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

if ($mosConfig_sef) {
	$url_array = explode('/', $_SERVER['REQUEST_URI']);

	if (in_array('content', $url_array)) {

		/**
		* Content
		* http://www.domain.com/$option/$task/$sectionid/$id/$Itemid/$limit/$limitstart
		*/

		$uri 				= explode('content/', $_SERVER['REQUEST_URI']);
		$option 			= 'com_content';
		$_GET['option'] 	= $option;
		$_REQUEST['option'] = $option;
		$pos 				= array_search ('content', $url_array);

		// language hook for content
		$lang = '';
		foreach($url_array as $key=>$value) {
			if ( !strcasecmp(substr($value,0,5),'lang,') ) {
				$temp = explode(',', $value);
				if (isset($temp[0]) && $temp[0]!='' && isset($temp[1]) && $temp[1]!='') {
					$_GET['lang'] 		= $temp[1];
					$_REQUEST['lang'] 	= $temp[1];
					$lang 				= $temp[1];
				}
				unset($url_array[$key]);
			}
		}

		if (isset($url_array[$pos+6]) && $url_array[$pos+6]!='') {
		// $option/$task/$sectionid/$id/$Itemid/$limit/$limitstart
			$task 					= $url_array[$pos+1];
			$sectionid				= $url_array[$pos+2];
			$id 					= $url_array[$pos+3];
			$Itemid 				= $url_array[$pos+4];
			$limit 					= $url_array[$pos+5];
			$limitstart 			= $url_array[$pos+6];

			// pass data onto global variables
			$_GET['task'] 			= $task;
			$_REQUEST['task'] 		= $task;
			$_GET['sectionid'] 		= $sectionid;
			$_REQUEST['sectionid'] 	= $sectionid;
			$_GET['id'] 			= $id;
			$_REQUEST['id'] 		= $id;
			$_GET['Itemid'] 		= $Itemid;
			$_REQUEST['Itemid'] 	= $Itemid;
			$_GET['limit'] 			= $limit;
			$_REQUEST['limit'] 		= $limit;
			$_GET['limitstart'] 	= $limitstart;
			$_REQUEST['limitstart'] = $limitstart;

			$QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart";
		} else if (isset($url_array[$pos+5]) && $url_array[$pos+5]!='') {
		// $option/$task/$id/$Itemid/$limit/$limitstart
			$task 					= $url_array[$pos+1];
			$id 					= $url_array[$pos+2];
			$Itemid 				= $url_array[$pos+3];
			$limit 					= $url_array[$pos+4];
			$limitstart 			= $url_array[$pos+5];

			// pass data onto global variables
			$_GET['task'] 			= $task;
			$_REQUEST['task'] 		= $task;
			$_GET['id'] 			= $id;
			$_REQUEST['id'] 		= $id;
			$_GET['Itemid'] 		= $Itemid;
			$_REQUEST['Itemid'] 	= $Itemid;
			$_GET['limit'] 			= $limit;
			$_REQUEST['limit'] 		= $limit;
			$_GET['limitstart'] 	= $limitstart;
			$_REQUEST['limitstart'] = $limitstart;

			$QUERY_STRING = "option=com_content&task=$task&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart";
		} else if (isset($url_array[$pos+4]) && $url_array[$pos+4]!='' && ( in_array('archivecategory', $url_array) || in_array('archivesection', $url_array) )) {
			// $option/$task/$Itemid/$year/$month/$module
			$task 					= $url_array[$pos+1];
			$year 					= $url_array[$pos+2];
			$month 					= $url_array[$pos+3];
			$module 				= $url_array[$pos+4];
			
			// pass data onto global variables
			$_GET['task'] 			= $task;
			$_REQUEST['task'] 		= $task;
			$_GET['year'] 			= $year;
			$_REQUEST['year'] 		= $year;
			$_GET['month'] 			= $month;
			$_REQUEST['month'] 		= $month;
			$_GET['module'] 		= $module;
			$_REQUEST['module']		= $module;
			
			$QUERY_STRING = "option=com_content&task=$task&year=$year&month=$month&module=$module";
		} else if (!(isset($url_array[$pos+5]) && $url_array[$pos+5]!='') && isset($url_array[$pos+4]) && $url_array[$pos+4]!='') {
		// $option/$task/$sectionid/$id/$Itemid
			$task 					= $url_array[$pos+1];
			$sectionid 				= $url_array[$pos+2];
			$id 					= $url_array[$pos+3];
			$Itemid 				= $url_array[$pos+4];

			// pass data onto global variables
			$_GET['task'] 			= $task;
			$_REQUEST['task'] 		= $task;
			$_GET['sectionid'] 		= $sectionid;
			$_REQUEST['sectionid'] 	= $sectionid;
			$_GET['id'] 			= $id;
			$_REQUEST['id'] 		= $id;
			$_GET['Itemid'] 		= $Itemid;
			$_REQUEST['Itemid'] 	= $Itemid;

			$QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid";
		} else if (!(isset($url_array[$pos+4]) && $url_array[$pos+4]!='') && (isset($url_array[$pos+3]) && $url_array[$pos+3]!='')) {
		// $option/$task/$id/$Itemid
			$task 					= $url_array[$pos+1];
			$id 					= $url_array[$pos+2];
			$Itemid 				= $url_array[$pos+3];

			// pass data onto global variables
			$_GET['task'] 			= $task;
			$_REQUEST['task'] 		= $task;
			$_GET['id'] 			= $id;
			$_REQUEST['id'] 		= $id;
			$_GET['Itemid'] 		= $Itemid;
			$_REQUEST['Itemid'] 	= $Itemid;

			$QUERY_STRING = "option=com_content&task=$task&id=$id&Itemid=$Itemid";
		} else if (!(isset($url_array[$pos+3]) && $url_array[$pos+3]!='') && (isset($url_array[$pos+2]) && $url_array[$pos+2]!='')) {
		// $option/$task/$id
			$task 					= $url_array[$pos+1];
			$id 					= $url_array[$pos+2];

			// pass data onto global variables
			$_GET['task'] 			= $task;
			$_REQUEST['task'] 		= $task;
			$_GET['id'] 			= $id;
			$_REQUEST['id'] 		= $id;

			$QUERY_STRING = "option=com_content&task=$task&id=$id";
		} else if (!(isset($url_array[$pos+2]) && $url_array[$pos+2]!='') && (isset($url_array[$pos+1]) && $url_array[$pos+1]!='')) {
		// $option/$task
			$task = $url_array[$pos+1];

			$_GET['task'] 			= $task;
			$_REQUEST['task'] 		= $task;

			$QUERY_STRING = 'option=com_content&task='. $task;
		}

		if ($lang!='') {
			$QUERY_STRING .= '&lang='. $lang;
		}

		$_SERVER['QUERY_STRING'] 	= $QUERY_STRING;
		$REQUEST_URI 				= $uri[0].'index.php?'.$QUERY_STRING;
		$_SERVER['REQUEST_URI'] 	= $REQUEST_URI;

	} else if (in_array('component', $url_array)) {

		/*
		Components
		http://www.domain.com/component/$name,$value
		*/
		$uri = explode('component/', $_SERVER['REQUEST_URI']);
		$uri_array = explode('/', $uri[1]);
		$QUERY_STRING = '';
		
		// needed for check if component exists
		$path 		= $mosConfig_absolute_path .'/components';
		$dirlist 	= array();
		if ( is_dir( $path ) ) {
			$base = opendir( $path );	
			while (false !== ( $dir = readdir($base) ) ) {
				if (is_dir($path .'/'. $dir) && $dir !== '.' && $dir !== '..' && strtolower($dir) !== 'cvs' && strtolower($dir) !== '.svn') {
					$dirlist[] = $dir;
				}
			}
			closedir($base);
		}

		foreach($uri_array as $value) {
			$temp = explode(',', $value);
			if (isset($temp[0]) && $temp[0]!='' && isset($temp[1]) && $temp[1]!='') {
				$_GET[$temp[0]] 	= $temp[1];
				$_REQUEST[$temp[0]] = $temp[1];
				
				// check to ensure component actually exists
				if ( $temp[0] == 'option' ) {
					$check = '';
					if (count( $dirlist )) {
						foreach ( $dirlist as $dir ) {
							if ( $temp[1] == $dir ) {
								$check = 1;
								break;
							}
						}
					}
					// redirect to 404 page if no component found to match url
					if ( !$check ) {
						header( 'HTTP/1.0 404 Not Found' );
						require_once( $mosConfig_absolute_path . '/templates/404.php' );
						exit( 404 );
					}
				}
				
				if ( $QUERY_STRING == '' ) {
					$QUERY_STRING .= "$temp[0]=$temp[1]";
				} else {
					$QUERY_STRING .= "&$temp[0]=$temp[1]";
				}
			}
		}
		
		$_SERVER['QUERY_STRING'] 	= $QUERY_STRING;
		$REQUEST_URI 				= $uri[0].'index.php?'.$QUERY_STRING;
		$_SERVER['REQUEST_URI'] 	= $REQUEST_URI;

		if (defined('RG_EMULATION') && RG_EMULATION == 1) {
			// Extract to globals
			while(list($key,$value)=each($_GET)) {
				if ($key!="GLOBALS") {
					$GLOBALS[$key]=$value;
				}
			}
			// Don't allow config vars to be passed as global
			include( 'configuration.php' );
		}

	} else {

		/*
		Unknown content
		http://www.domain.com/unknown
		*/
		$jdir = str_replace( 'index.php', '', $_SERVER['PHP_SELF'] );
		$juri = str_replace( $jdir, '', $_SERVER['REQUEST_URI'] );
		
		if ($juri != '' && $juri != '/' && !eregi( "index\.php", $_SERVER['REQUEST_URI'] ) && !eregi( "index2\.php", $_SERVER['REQUEST_URI'] ) && !eregi( "/\?", $_SERVER['REQUEST_URI'] ) && $_SERVER['QUERY_STRING'] == '' ) {
			header( 'HTTP/1.0 404 Not Found' );
			require_once( $mosConfig_absolute_path . '/templates/404.php' );
			exit( 404 );
		}
	}

}

/**
 * Converts an absolute URL to SEF format
 * @param string The URL
 * @return string
 */
function sefRelToAbs( $string ) {
	global $mosConfig_live_site, $mosConfig_sef, $mosConfig_mbf_content;
	global $iso_client_lang;

	//multilingual code url support
	if( $mosConfig_mbf_content && $string!='index.php' && !eregi("^(([^:/?#]+):)",$string) && !strcasecmp(substr($string,0,9),'index.php') && !eregi('lang=', $string) ) {
		$string .= '&lang='. $iso_client_lang;
	}

	// SEF URL Handling
	if ($mosConfig_sef && !eregi("^(([^:/?#]+):)",$string) && !strcasecmp(substr($string,0,9),'index.php')) {

		// Replace all &amp; with &
		$string = str_replace( '&amp;', '&', $string );

		/*
		Home
		index.php
		*/
		if ($string=='index.php') {
			$string='';
		}

		$sefstring = '';
		if ( (eregi('option=com_content',$string) || eregi('option=content',$string) ) && !eregi('task=new',$string) && !eregi('task=edit',$string) ) {
			// Handle fragment identifiers (ex. #foo)
			$fragment = '';
			if (eregi('#', $string)) {
				$temp = split('#', $string, 2);
				$string = $temp[0];
				// ensure fragment identifiers are compatible with HTML4
				if (preg_match('@^[A-Za-z][A-Za-z0-9:_.-]*$@', $temp[1])) {
					$fragment = '#'. $temp[1];
				}
			}
			
			/*
			Content
			index.php?option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart&year=$year&month=$month&module=$module
			*/
			$sefstring .= 'content/';
			if (eregi('&task=',$string)) {
				$temp = split('&task=', $string);
				$temp = split('&', $temp[1]);

				$sefstring .= $temp[0].'/';
			}
			if (eregi('&sectionid=',$string)) {
				$temp = split('&sectionid=', $string);
				$temp = split('&', $temp[1]);

				$sefstring .= $temp[0].'/';
			}
			if (eregi('&id=',$string)) {
				$temp = split('&id=', $string);
				$temp = split('&', $temp[1]);

				$sefstring .= $temp[0].'/';
			}
			if (eregi('&Itemid=',$string)) {
				$temp = split('&Itemid=', $string);
				$temp = split('&', $temp[1]);

				if ( $temp[0] !=  99999999 ) {
					$sefstring .= $temp[0].'/';
				}
			}
			if (eregi('&limit=',$string)) {
				$temp = split('&limit=', $string);
				$temp = split('&', $temp[1]);

				$sefstring .= $temp[0].'/';
			}
			if (eregi('&limitstart=',$string)) {
				$temp = split('&limitstart=', $string);
				$temp = split('&', $temp[1]);

				$sefstring .= $temp[0].'/';
			}
			if (eregi('&lang=',$string)) {
				$temp = split('&lang=', $string);
				$temp = split('&', $temp[1]);

				$sefstring .= 'lang,'.$temp[0].'/';
			}
			if (eregi('&year=',$string)) {
				$temp = split('&year=', $string);
				$temp = split('&', $temp[1]);
				
				$sefstring .= $temp[0].'/';
			}
			if (eregi('&month=',$string)) {
				$temp = split('&month=', $string);
				$temp = split('&', $temp[1]);
				
				$sefstring .= $temp[0].'/';
			}
			if (eregi('&module=',$string)) {
				$temp = split('&module=', $string);
				$temp = split('&', $temp[1]);
				
				$sefstring .= $temp[0].'/';
			}
			
			$string = $sefstring . $fragment;
		} else if (eregi('option=com_',$string) && !eregi('task=new',$string) && !eregi('task=edit',$string)) {
			/*
			Components
			index.php?option=com_xxxx&...
			*/
			$sefstring 	= 'component/';
			$temp 		= split("\?", $string);
			$temp 		= split('&', $temp[1]);

			foreach($temp as $key => $value) {
				$sefstring .= $value.'/';
			}
			$string = str_replace( '=', ',', $sefstring );
		}

		// comment line below if you dont have mod_rewrite
		return $mosConfig_live_site .'/'. $string;

		// allows SEF without mod_rewrite
		// uncomment Line 348 and comment out Line 354	
	
		// uncomment line below if you dont have mod_rewrite
		//return $mosConfig_live_site.'/index.php/'.$string;
		// If the above doesnt work - try uncommenting this line instead
		// return $mosConfig_live_site.'/index.php?/'.$string;
	} else {
	// Handling for when SEF is not activated
		// Relative link handling
		if ( !(strpos( $string, $mosConfig_live_site ) === 0) ) {
			// if URI starts with a "/", means URL is at the root of the host...
			if (strncmp($string, '/', 1) == 0) {
				// splits http(s)://xx.xx/yy/zz..." into [1]="htpp(s)://xx.xx" and [2]="/yy/zz...":
				$live_site_parts = array();
				eregi("^(https?:[\/]+[^\/]+)(.*$)", $mosConfig_live_site, $live_site_parts);
				
				$string = $live_site_parts[1] . $string;
			} else {
				// URI doesn't start with a "/" so relative to the page (live-site):
			$string = $mosConfig_live_site .'/'. $string;
			}
		}
		
		return $string;
	}
}
?>