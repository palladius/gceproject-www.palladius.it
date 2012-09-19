<?php
###################################################################################################
#  Display News - Latest 1-3 [07 June 2004]
#  Rey Gigataras [stingrey]
#  www.stingrey.biz
#  mambo@stingrey.biz

#  Rework 1.0.9 - 04-Feb-06 by bkomraz1@yahoo.com

#  @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html

#  based on Latest News Module
#  $Id: mod_latestnews.php,v 1.14 2003/12/17 22:22:39 eddieajau Exp $
###################################################################################################

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
$params = mosParseParams( $module->params );
global $mosConfig_offset;
global $database;
global $mosConfig_lang, $mosConfig_mbf_content;

$website = "http://www.stingrey.biz";
$version = "Display News - Latest 1-3";
$moduleA = "dn";
$moduleB = "dn";
$now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );
$date = date( "Y-m-d", time()+$mosConfig_offset*60*60 );

// loads module function file
if ( !defined("__MOD_DN_FUNC__") )
{
	define("__MOD_DN_FUNC__", 1);
	/**---------------------------------------------------------------------**/
	// Initalisation of Y|N Parameter
	function dn_param_yn( &$param, $default, $value=NULL ){
		$param = $value <> NULL ? strval( $value ) : $default;
		$param = strtolower($param);
		if (($param <> "y") && ($param <> "n")) {  
			$param = $default; 
		}
	}
	//---------------------------------------------------------------------
	
	/**---------------------------------------------------------------------**/
	// Initalisation of Integer Range Parameter
	function dn_param_range( &$param, $default, $value=NULL, $min=NULL, $max=NULL ){
		$param = $value <> NULL ? intval( $value ) : $default;
		if (($param < $min) || ($param > $max)) {  
			$param = $default; 
		}
	}
	//---------------------------------------------------------------------
	
	/**---------------------------------------------------------------------**/
	// Function that allows user specification of date format
	function dn_date( $date, $format ){
			 // BK
			 return mosFormatDate( $date, $format );
	/* 	global $mosConfig_offset;
		if ( $date && ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})[ ]([0-9]{2}):([0-9]{2}):([0-9]{2})", $date, $regs ) ) {
			$date = mktime( $regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1] );
			$date = $date > -1 ? strftime( $format, $date + ($mosConfig_offset*3600) ) : '-';
		}
		return $date; */
	}
	//---------------------------------------------------------------------
	
	/**---------------------------------------------------------------------**/
	// Function to replace {mosimage} tag with image
	function dn_image( &$row ) {
		global $mosConfig_live_site, $mosConfig_absolute_path;
	
		$row->images = explode( "\n", $row->images );
		$images = array();
	
		foreach ($row->images as $img) {
			$img = trim( $img );
			if ($img) {
				$temp = explode( '|', trim( $img ) );
				if(!isset($temp[1]))
				$temp[1] = "left";
	
				if(!isset($temp[2]))
				$temp[2] = "Image";
	
				if(!isset($temp[3]))
				$temp[3] = "0";
				$size = '';
				if (function_exists( 'getimagesize' )) {
					$size = @getimagesize( "$mosConfig_absolute_path/images/stories/$temp[0]" );
					if (is_array( $size )) {
						$size = "width=\"$size[0]\" height=\"$size[1]\"";
					}
				}
				$images[] = "<img src=\"$mosConfig_live_site/images/stories/$temp[0]\" $size align=\"$temp[1]\"  hspace=\"6\" alt=\"$temp[2]\" border=\"$temp[3]\" />";
			}
		}
	
		$introtext = explode( '{mosimage}', $row->introtext );
		$fulltext = explode( '{mosimage}', $row->fulltext );
	
		$row->introtext = $introtext[0];
		$row->fulltext = $fulltext[0];
	
		for ($i=0, $n=count( $introtext )-1; $i < $n; $i++) {
			if (isset( $images[$i] )) {
				$row->introtext .= $images[$i];
			}
			if (isset( $introtext[$i+1] )) {
				$row->introtext .= $introtext[$i+1];
			}
		}
		for ($i=0, $n=count( $fulltext )-1; $i < $n; $i++) {
			if (isset( $images[$i] )) {
				$row->fulltext .= $images[$i];
			}
			if (isset( $fulltext[$i+1] )) {
				$row->fulltext .= $fulltext[$i+1];
			}
		}
		unset( $introtext );
		unset( $fulltext );
	}
	//---------------------------------------------------------------------
	
	/**---------------------------------------------------------------------**/
	// Function to filter html code and special characters from text
	function dn_filter( $text ) {
		$text = preg_replace("'<script[^>]*>.*?</script>'si","",$text);
		$text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $text);
		$text = preg_replace('/<!--.+?-->/','',$text);
		$text = preg_replace('/{.+?}/','',$text);
		$text = preg_replace('/&nbsp;/',' ',$text);
		// $text = preg_replace('/&amp;/',' ',$text);
		$text = preg_replace('/&quot;/',' ',$text);
		$text = strip_tags($text);
		// $text = htmlspecialchars($text);
		return $text;
	}
	
	function dnReplace( $text ) {
		if ( $GLOBALS['_VERSION']->PRODUCT == 'Mambo' ) {
			$text = str_replace( '&&', '*--*', $text );
			$text = str_replace( '&#', '*-*', $text );
			$text = str_replace( '&amp;', '&', $text );
			$text = preg_replace( '|&(?![\w]+;)|', '&amp;', $text );
			$text = str_replace( '*-*', '&#', $text );
			$text = str_replace( '*--*', '&&', $text );
	
			return $text;
		} else {
			return ampReplace($text);
		}
	}
	//---------------------------------------------------------------------
	
	/**---------------------------------------------------------------------**/
	//  Functinality to allow text_hover to be blank by use if special character "#" entered
	//  If not then space added to the end of the variables
	function dn_hovertext( &$text ) {
		if ($text == "#") { 
			$text = "";
		} else { 
			$text .= " "; 
		}
	}
	//---------------------------------------------------------------------
	
	/**---------------------------------------------------------------------**/
	//  Function required to create set of Names, '' added
	function dn_set_name( &$param ) {
		if ($param <> NULL) {
			$paramA = explode(",", $param);
			$a = "0";
			foreach ($paramA as $paramB) {
				$paramB = trim($paramB);
				$paramB = "'".$paramB."'";
				$paramA[$a] = $paramB;
				$a++;
			}
			$param = implode(",", $paramA);
		}
	}
	//---------------------------------------------------------------------
	
	/**---------------------------------------------------------------------**/
	// Function that limits title, intro or full to specified character or word length
	function dn_limit( &$text, $length_chars, $length_words ) {
		if ($length_chars <> NULL) {			
			$titletext = substr($text, 0, $length_chars); 
			if (strlen($text) > $length_chars) { 
				$titletext = chop($titletext);
				$titletext .= "..."; 
				$title = $titletext;
			} else { 
				$title = $titletext;
			} 
		} else if ($length_words <> NULL ){
			$text_array = split( " ", $text);
			$title = "";
			for ($a = 0; $a < $length_words; $a++) {
				@$title .= $text_array[$a]." "; 
			}
			if ( count($text_array) > $length_words ) {
				$title .= "...";
			}
		}
		$text = $title;	
	}
	//---------------------------------------------------------------------
	
	/**---------------------------------------------------------------------**/
	//  Functinality to convert Set Name to Set Id to be used by show_more
	function dn_name_id( $id, $name ) {
		global $database;
		if ( strchr($name, ",") ) {
			$id = "";
		} else {
			$database->setQuery("SELECT a.id"
			."\n  FROM #__sections AS a"
			."\n  WHERE a.name = '$name'");
			$id = $database->loadResult();
		}
		return $id;
	}
	//---------------------------------------------------------------------
}

//----- Parameters - Criteria ( 19 ) ------------------------------------------
dn_param_range( $set_count, 5, @$params->set_count, 1, 500 );

dn_param_yn( $set_date_today, "n", @$params->set_date_today );
dn_param_range( $set_date_range, NULL, @$params->set_date_range, 1, 500 );
dn_param_range( $set_date_month, NULL, @$params->set_date_month, 0, 12 );
dn_param_range( $set_date_year, NULL, @$params->set_date_year );

dn_param_yn( $set_auto, "n", @$params->set_auto );
dn_param_yn( $set_auto_author, "n", @$params->set_auto_author );
dn_param_yn( $set_auto_author_alias, "n", @$params->set_auto_author_alias );

// dn_param_yn( $show_frontpage, "y", @$params->show_frontpage );
// dn_param_yn( $show_frontpage_only, "n", @$params->show_frontpage_only );
$show_frontpage = @$params->show_frontpage ? strval( $params->show_frontpage ) : "y";

dn_param_yn( $access_public, "y", @$params->access_public );
dn_param_yn( $access_registered, "n", @$params->access_registered  );
dn_param_yn( $access_special, "n", @$params->access_special );

$set_category_id_extra = @$params->set_category_id_extra ? strval( $params->set_category_id_extra ) : "";
$set_category_id = @$params->set_category_id ? strval( $params->set_category_id ) : "";

$set_section_id_extra = @$params->set_section_id_extra ? strval( $params->set_section_id_extra ) : "";
$set_section_id = @$params->set_section_id ? strval( $params->set_section_id ) : "";

$set_author_id = @$params->set_author_id ? strval( $params->set_author_id ) : "";
$set_author_name = @$params->set_author_name ? strval( $params->set_author_name ) : "";
$set_author_alias = @$params->set_author_alias ? strval( $params->set_author_alias ) : "";

dn_param_range( $minus_leading, NULL, @$params->minus_leading, 0, $set_count );
//---------------------------------------------------------------------

//----- Parameters - Display ( 19 ) ------------------------------------------
$css_prefix = @$params->css_prefix ? strval( $params->css_prefix ) : "";
dn_param_yn( $use_css, "y", @$params->use_css );
dn_param_yn( $show_mosimage, "n", @$params->show_mosimage );

dn_param_yn( $scroll, "n", @$params->scroll );

dn_param_yn( $show_title_auto, "n", @$params->show_title_auto );

dn_param_yn( $show_leading, "n", @$params->show_leading );

dn_param_yn( $show_section, "n", @$params->show_section );
dn_param_yn( $show_category, "n", @$params->show_category );
dn_param_yn( $use_modify_date, "n", @$params->use_modify_date );
$created = @$params->use_modify_date ? ( strval( $params->use_modify_date ) == "y" ? "modified" : "created" ): "created";

dn_param_yn( $show_title, "y", @$params->show_title );
dn_param_yn( $show_author, "n", @$params->show_author );
dn_param_yn( $show_author_alias, "n", @$params->show_author_alias );

dn_param_yn( $show_intro, "n", @$params->show_intro );
dn_param_yn( $show_full, "n", @$params->show_full );

$show_readmore = @$params->show_readmore ? strval( $params->show_readmore ) : "n";

// dn_param_yn( $show_more_section, "n", @$params->show_more_section );
// dn_param_yn( $show_more_category, "n", @$params->show_more_category );
dn_param_yn( $show_more_auto, "n", @$params->show_more_auto );
//---------------------------------------------------------------------

//----- Parameters - Display Modifier ( 14 ) --------------------------------
dn_param_yn( $show_arrow, "y", @$params->show_arrow );
dn_param_yn( $show_list, "n", @$params->show_list );

dn_param_range( $set_leading_count, 2, @$params->set_leading_count, 1, $set_count );
dn_param_yn( $limit_leading, "y", @$params->limit_leading );
dn_param_yn( $show_leading_readmore, "y", @$params->show_leading_readmore );
dn_param_yn( $show_leading_date, "y", @$params->show_leading_date );

$scroll_direction = @$params->scroll_direction ? strval( $params->scroll_direction ) : "up";
	$scroll_direction = strtolower($scroll_direction);
	if (($scroll_direction <> "up") && ($scroll_direction <> "down") && ($scroll_direction <> "left") && ($scroll_direction <> "right")) {  $scroll_direction = "up"; }

dn_param_range( $scroll_height, 100, @$params->scroll_height, 10, 1000 );
dn_param_range( $scroll_speed, 1, @$params->scroll_speed, 0, 10 );
dn_param_range( $scroll_delay, 30, @$params->scroll_delay, 1, 500 );

dn_param_yn( $show_title_nextline, "n", @$params->show_title_nextline );

dn_param_yn( $limit_title, "n", @$params->limit_title );
dn_param_yn( $limit_intro, "n", @$params->limit_intro );
dn_param_yn( $limit_full, "n", @$params->limit_full );

dn_param_yn( $filter_title, "y", @$params->filter_title );
dn_param_yn( $filter_intro, "y", @$params->filter_intro );
dn_param_yn( $filter_full, "y", @$params->filter_full );

$length_chars_title = @$params->length_chars_title ? intval( $params->length_chars_title ) : "";
$length_chars_intro = @$params->length_chars_intro ? intval( $params->length_chars_intro ) : "";
$length_chars_full = @$params->length_chars_full ? intval( $params->length_chars_full ) : "";

$length_words_title = @$params->length_words_title ? intval( $params->length_words_title ) : "";
$length_words_intro = @$params->length_words_intro ? intval( $params->length_words_intro ) : "";
$length_words_full = @$params->length_words_full ? intval( $params->length_words_full ) : "";

$format_date = @$params->format_date ? strval( $params->format_date ) : "%d %b %y";

dn_param_yn( $show_date, "n", @$params->show_date );
dn_param_yn( $link_section, "n", @$params->link_section );
dn_param_yn( $link_category, "n", @$params->link_category );
dn_param_yn( $link_title, "y", @$params->link_title );
dn_param_yn( $link_intro, "n", @$params->link_intro );
dn_param_yn( $use_format, "n", @$params->use_format );
$format = @$params->format ? strval( $params->format ) : "%s%c%t<br>%d - %a<br>%i%f";
dn_param_yn( $notfound_message, "y", @$params->notfound_message );
$ordering = @$params->ordering ? strval( $params->ordering ) : "mostrecent";

//---------------------------------------------------------------------

//----- Parameters - Display Text ( 10 ) -------------------------------------
// Allows for multilingual customisation //
$text_module_title = @$params->text_module_title ? strval( $params->text_module_title ) : "";
$text_module_description = @$params->text_module_description ? strval( $params->text_module_description ) : "";
$text_readmore = @$params->text_readmore ? strval( $params->text_readmore ) : "- Read More -";
$text_more = @$params->text_more ? strval( $params->text_more ) : "- More -";

$text_title_auto_pre = @$params->text_title_auto_pre ? strval( $params->text_title_auto_pre ) : "Latest";
$text_title_auto_suf = @$params->text_title_auto_suf ? strval( $params->text_title_auto_suf ) : "News";

$text_hover_section = @$params->text_hover_section ? strval( $params->text_hover_section ) : "View Section ->";
$text_hover_category = @$params->text_hover_category ? strval( $params->text_hover_category ) : "View Category ->";
$text_hover_title = @$params->text_hover_title ? strval( $params->text_hover_title ) : "Read more of ->";

$text_hover_readmore = @$params->text_hover_readmore ? strval( $params->text_hover_readmore ) : "Read more of ->";

$text_hover_more_section = @$params->text_hover_more_section ? strval( $params->text_hover_more_section ) : "View more from Section ->";
$text_hover_more_category = @$params->text_hover_more_category ? strval( $params->text_hover_more_category ) : "View more from Category ->";

$text_module_link_text = @$params->text_module_link_text ? strval( $params->text_module_link_text ) : "";
$text_module_link_url = @$params->text_module_link_url ? strval( $params->text_module_link_url ) : "";
//---------------------------------------------------------------------

/**---------------------------------------------------------------------**/
//  Conflict Handler

// switches off show_arrow to enable show_list to work
if ( ($show_list == "y") && ($show_arrow == "y") ) {
	$show_arrow = "n";
}

// switches off filter to allow mosimages to be displayed
if ($show_mosimage == "y") {
	$filter_intro = "n";
	$filter_full = "n";
}

//  Determines which limit to be used, either a specified number or a date range
// if ( ($set_date_today == "y") || ($set_date_range <> NULL) || ($set_date_month <> NULL) || ($set_date_year <> NULL)) {
if ( $set_count == 0) {
	$limit = "";
} else {
	if ( $minus_leading <> NULL ) {
		$limit = "\n LIMIT $minus_leading, $set_count";
	} else {
		$limit = "\n LIMIT $set_count";
	}
}

/**---------------------------------------------------------------------**/
//
if ($set_section_id) {
	if ( $set_section_id_extra ) {
		$set_section_id_extra = $set_section_id.",".$set_section_id_extra;
	} else {
		$set_section_id_extra = $set_section_id;
	}
}

if ($set_category_id) {
	if ( $set_category_id_extra ) {
		$set_category_id_extra = $set_category_id.",".$set_category_id_extra;
	} else {
		$set_category_id_extra = $set_category_id;
	}
}

//---------------------------------------------------------------------

/**---------------------------------------------------------------------**/
//  Special parameter handling of $css_prefix, adds an '_' to the end of the prefix
if ($css_prefix <> NULL) {
	$css_prefix = trim($css_prefix);
	$css_prefix .= "_";
}
//---------------------------------------------------------------------

/**---------------------------------------------------------------------**/
//  Functinality to allow text_hover to be blank by use if special character "#" entered
//  If not then space added to the end of the variables
dn_hovertext( $text_hover_section );
dn_hovertext( $text_hover_category );
dn_hovertext( $text_hover_title );
dn_hovertext( $text_hover_readmore );
dn_hovertext( $text_hover_more_section );
dn_hovertext( $text_hover_more_category );
dn_hovertext( $text_title_auto_pre );
dn_hovertext( $text_title_auto_suf );
//---------------------------------------------------------------------

/**---------------------------------------------------------------------**/
// If { set_auto = y } then Module will automatically determine section/category id of current page and use this to control what news is dsiplayed
if ($set_auto == "y") {
	$task = trim( mosGetParam( $_REQUEST, 'task', null ) );

	if (($task == "section") || ($task == "blogsection") || ($task == "archivesection")) {
		$zsectionid = intval( mosGetParam( $_REQUEST, 'id', null ) );
		$set_section_id_extra = $zsectionid;
	}

	if (($task == "category") || ($task == "blogcategory") || ($task == "archivecategory")) {
		$zcategoryid = intval( mosGetParam( $_REQUEST, 'id', null ) );
		$set_category_id_extra = $zcategoryid;
	}

	if ($task == "view") {
		$zcontentid = intval( mosGetParam( $_REQUEST, 'id', null ) );
		$database->setQuery("SELECT a.catid"
		."\n  FROM #__content AS a"
		."\n  WHERE a.id = '$zcontentid'");
		$set_category_id_extra = $database->loadResult();
	}
}

// If { set_auto_author = y } then Module will automatically determine Author id of current page and use this to control what news is dsiplayed
if ($set_auto_author == "y") {
	$task = trim( mosGetParam( $_REQUEST, 'task', null ) );

	if ($task == "view") {
		$zcontentid = intval( mosGetParam( $_REQUEST, 'id', null ) );
		$database->setQuery("SELECT a.created_by"
		."\n  FROM #__content AS a"
		."\n  WHERE a.id = '$zcontentid'");
		$set_author_id = $database->loadResult();
	} else {
		# BK
		return;
	}
}
//---------------------------------------------------------------------

// If { set_auto_author = y } then Module will automatically determine Author id of current page and use this to control what news is dsiplayed
if ($set_auto_author_alias == "y") {
	$task = trim( mosGetParam( $_REQUEST, 'task', null ) );

	if ($task == "view") {
		$zcontentid = intval( mosGetParam( $_REQUEST, 'id', null ) );
		$database->setQuery("SELECT a.created_by_alias"
		."\n  FROM #__content AS a"
		."\n  WHERE a.id = '$zcontentid'");
		$set_author_alias = $database->loadResult();
	} else {
		# BK
		return;
	}
}
//---------------------------------------------------------------------


/**---------------------------------------------------------------------**/
//  Special variable used for management of different access levels
// 7 combinations of access (ynn, nyn, nny, yyn, nyy, yny, yyy)
$access_control = $access_public.$access_registered.$access_special;
switch($access_control) {
	case "ynn" :
		$access = "AND (a.access = '0')";
		break;
	case "nyn" :
		$access = "AND (a.access = '1')";
		break;
	case "nny" :
		$access = "AND (a.access = '2')";
		break;
	case "yyn" :
		$access = "AND (a.access = '0' OR a.access = '1')";
		break;
	case "nyy" :
		$access = "AND (a.access = '1' OR a.access = '2')";
		break;
	case "yny" :
		$access = "AND (a.access = '0' OR a.access = '2')";
		break;
	case "yyy" :
		$access = "AND (a.access = '0' OR a.access = '1' OR a.access = '2')";
		break;
}	//---------------------------------------------------------------------

/**---------------------------------------------------------------------**/
//  Handling required to create set Names, '' added
// dn_set_name( $set_section_id );
// dn_set_name( $set_category_id );
dn_set_name( $set_author_name );
//---------------------------------------------------------------------

/**---------------------------------------------------------------------**/
//  Special Handling to get $set_date_month to work correctly
if ($set_date_month <> NULL) {
	if ($set_date_month == "0") {
		$set_date_month = $date;
	} else {
		if (strlen($set_date_month) == 1) {
			$set_date_month = "0".$set_date_month;
		}
		$set_date_month = "00-".$set_date_month."-00";
	}
}
//---------------------------------------------------------------------

/**---------------------------------------------------------------------**/
//  Special Handling to get $set_date_year to work correctly
if ($set_date_year <> NULL) {
	if ($set_date_year == "0") {
		$set_date_year = $date;
	} else {
		$set_date_year = $set_date_year."-00-00";
	}
}
//---------------------------------------------------------------------

/**---------------------------------------------------------------------**/
//  Special Handling to ensure show_front_page_only works correctly
// if ($show_frontpage_only == "y") {
//	$show_frontpage = "y";
//}
//---------------------------------------------------------------------

######################################################################################################################################

/**---------------------------------------------------------------------**/
//  Main Query & Array
switch ( $ordering ) {
case "mostread":
	$order_by = "a.hits DESC";
	break;
case "ordering":
	$order_by = "a.ordering ASC";
	break;
case "title":
	$order_by = "a.title ASC";
	break;
case "mostold":
	$order_by = "created ASC";
	break;
case "random":
	$order_by = "RAND()";
	break;
case "mostrecent":
default:
	$order_by = "created DESC";
}


$query = "SELECT a.id, a.title, a.introtext, a.fulltext, a.sectionid, a.catid, a.$created as created, a.created_by, a.created_by_alias, a.images"
	. "\n  FROM #__content AS a"
	. "\n  LEFT JOIN #__content_frontpage AS b ON b.content_id = a.id"
	. "\n  LEFT JOIN #__users AS c ON c.id = a.created_by"
	. "\n  LEFT JOIN #__sections AS d ON d.id = a.sectionid"
	. "\n  LEFT JOIN #__categories AS e ON e.id = a.catid"
    . "\n  WHERE (a.state = '1')"
//	. "\n  AND (a.checked_out = '0')" ### BK
	. "\n  AND (a.publish_up = '0000-00-00 00:00:00' OR a.publish_up <= '$now')"
	. "\n  AND (a.publish_down = '0000-00-00 00:00:00' OR a.publish_down >= '$now')"
	. "\n	AND (d.published = '1')"
	. "\n	AND (e.published = '1')"
	. ($set_section_id_extra ? "\n   AND (a.sectionid IN ($set_section_id_extra) )" : '')
//	. ($set_section_id ? "\n   AND (d.name IN ($set_section_id) )" : '')
	. ($set_category_id_extra ? "\n   AND (a.catid IN ($set_category_id_extra) )" : '')
//	. ($set_category_id ? "\n   AND (e.name IN ($set_category_id) )" : '')
	. ($show_frontpage == "n" ? "\n  AND (b.content_id IS NULL)" : '')
//	. ($show_frontpage_only == "y" ? "\n  AND (b.content_id = a.id)" : '')
	. ($show_frontpage == "only" ? "\n  AND (b.content_id = a.id)" : '')
	. ($set_author_id ? "\n  AND (a.created_by IN ($set_author_id) )" : '')
	. ($set_author_name ? "\n  AND (c.name IN ($set_author_name))" : '')
	. ($set_author_alias ? "\n  AND (a.created_by_alias IN ('$set_author_alias'))" : '') #BK
	. ($set_date_range <> NULL ? "\n  AND ((TO_DAYS('$date') - TO_DAYS(created)) <= '$set_date_range')" : '')
	. ($set_date_today == "y" ? "\n  AND (TO_DAYS(created) = TO_DAYS('$date'))" : '')
	. ($set_date_month <> NULL ? "\n  AND (MONTH(created) = MONTH('$set_date_month'))" : '')
	. ($set_date_year <> NULL ? "\n  AND (YEAR(created) = YEAR('$set_date_year'))" : '')
	. "\n $access"
#******************************************#
//  This Controls the fact that this module displayes the Latest News first
	. "\n  ORDER BY $order_by"
#******************************************#
	. "\n $limit"
;
$database->setQuery( $query );
$rows = $database->loadObjectList();

######################################################################################################################################

/**---------------------------------------------------------------------**/
//  Error checker, that tests whether any data has resulted from the query
//  If not an Error message is displayed
if ($rows <> NULL) {

	echo "\n <!-- A 'stingrey MOS-Solutions' module '".$website."' -->";
	echo "\n\n <!-- START   '".$version."'   -->\n";

	/**---------------------------------------------------------------------**/
	// if show_css is yes css file loaded
	if ($use_css == "y") {
		echo "\n <link href='".$mosConfig_live_site."/modules/".$moduleA."/".$moduleB.".css' rel='stylesheet' type='text/css'>";
	}
	//---------------------------------------------------------------------

	/**---------------------------------------------------------------------**/
	// If autotitle set to yes, displays an Auto Title preffix with the name of the section/category
	if (($set_auto == "y") && ($show_title_auto == "y")) {
		# BK
		if ($set_author_id) {
			$database->setQuery("SELECT a.name "
			."\n  FROM #__users AS a"
			."\n  WHERE a.id=".$set_author_id);
			$text_title_auto_mid = $database->loadResult();
			$title_text = $text_title_auto_pre.$text_title_auto_mid.$text_title_auto_suf;
		} else if ( $set_author_alias ) {
			$text_title_auto_mid = $set_author_alias;
			$title_text = $text_title_auto_pre.$text_title_auto_mid.$text_title_auto_suf;
		} else if (($task == "section") || ($task == "blogsection") || ($task == "archivesection")) {
			$database->setQuery("SELECT a.name "
			."\n  FROM #__sections AS a"
			."\n  WHERE a.id=".$set_section_id_extra);
			$text_title_auto_mid = $database->loadResult();
			$title_text = $text_title_auto_pre.$text_title_auto_mid.$text_title_auto_suf;
		} else if (($task == "category") || ($task == "blogcategory") || ($task == "archivecategory") || ($task == "view")) {
			$database->setQuery("SELECT a.name "
			."\n  FROM #__categories AS a"
			."\n  WHERE a.id=".$set_category_id_extra);
			$text_title_auto_mid = $database->loadResult();
			$title_text = $text_title_auto_pre.$text_title_auto_mid.$text_title_auto_suf;
		} else {
			$title_text = $text_title_auto_pre.$text_title_auto_suf;
		}
		echo "\n \n";
		echo "<div class='".$css_prefix."dn-title_auto'>";
		echo $title_text;
		echo "</div>";
	}	//---------------------------------------------------------------------

	/**---------------------------------------------------------------------**/
	//Div that surrounds whole Module (excluding Title)
	echo "\n \n";
	echo "<div class='".$css_prefix."dn-whole'>";

	if (strlen($text_module_title) > "0") {
		echo "\n \n";
		echo "<div class='".$css_prefix."dn-module_title'>";
		echo "\n";
		echo $text_module_title;
		echo "\n </div>";
	}

	if (strlen($text_module_description) > "0") {
		echo "\n \n";
		echo "<div class='".$css_prefix.".dn-module_description'>";
		echo "\n";
		echo $text_module_description;
		echo "\n </div>";
	}

	if ($show_arrow == "y") { 	echo "\n <ul  class='".$css_prefix."dn'>";	}
	if ($show_list == "y") { 	echo "\n <ol  class='".$css_prefix."dn'>";	}
	//---------------------------------------------------------------------

	/**---------------------------------------------------------------------**/
	// Activates scrolling text ability
	if ($scroll == 'y') {
		echo "\n \n";
		echo "<marquee behavior='scroll' align='center'  direction='".$scroll_direction."'  height='".$scroll_height."' scrollamount='".$scroll_speed."' scrolldelay='".$scroll_delay."' truespeed onmouseover=this.stop() onmouseout=this.start() >";
		# echo "<marquee align='center'  direction='".$scroll_direction."'  height='".$scroll_height."' scrollamount='".$scroll_speed."' scrolldelay='".$scroll_delay."' onmouseover=this.stop() onmouseout=this.start() >";
//		echo "<img src=\"modules/dn/arrowl.png\" height=\"$scroll_height\">";

	}	//---------------------------------------------------------------------

	/************************************************************************************************************************************/

	/**---------------------------------------------------------------------**/
	// Start of Loop //
	foreach ($rows as $row) {
		/**---------------------------------------------------------------------**/
		//  Mambelfish Support
	   if( $mosConfig_mbf_content ) {
			$row = MambelFish::translate( $row, 'content', $mosConfig_lang);
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// To show mosimages, modified mosimage mambot called
		// if images have been set to be visible, it runs the mambot which converst all {mosimage} tags to their configured image and show_s them with the text
		// if images are set to invisible, simply removes all {mosimage} tags from text
		if ($show_mosimage == "y") {
			dn_image( $row );
		} else {
			$row->introtext = str_replace( '{mosimage}', '', $row->introtext );
			$row->fulltext = str_replace( '{mosimage}', '', $row->fulltext );
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Removes instances of {mospagebreak} from being displayed
		if ($show_intro == "y") {
			$row->introtext = str_replace( '{mospagebreak}', '', $row->introtext );
		}
		if ($show_full == "y") {
			$row->fulltext = str_replace( '{mospagebreak}', '', $row->fulltext );
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Find out correct Itemid for items
		// (can not just use global because of items on the frontpage)
                  // BK

		global $mainframe;
		if ($option="com_content" /* && $task="view" */)
		{
				$_Itemid = $mainframe->getItemid($row->id);
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Blank itemid checker
		if ($_Itemid == NULL) {
			$_Itemid = "";
		} else {
			$_Itemid = "&amp;Itemid=".$_Itemid;
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Loads the section information into variable $section
		if ( $use_format == "y" || ($show_section == "y") || ($show_category == "y") ) {
			$section = new mosSection( $database );
			$section->load( $row->sectionid );
			//  Mambelfish Support
		   if( $mosConfig_mbf_content ) {
				$section = MambelFish::translate( $section, 'sections', $mosConfig_lang);
			}
		}

		// loads the category information into variable $category
		if ($use_format == "y" || $show_category == "y") {
			$category = new mosCategory( $database );
			$category->load( $row->catid );
			//  Mambelfish Support
		   if( $mosConfig_mbf_content ) {
				$category = MambelFish::translate( $category, 'categories', $mosConfig_lang);
			}
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		//To show date item created, date mambot called
		if ( $use_format == "y" || ($show_date == "y") && (intval( $row->created ) <> NULL) || (($show_leading == "y") && ($set_leading_count > "0") && ($show_leading_date == "y")) ) {
			$create_date = dn_date( $row->created, $format_date );
		}
		//---------------------------------------------------------------------


		/** BK ---------------------------------------------------------------------*
		// Converts the user id number of the author to their name and loads this into the $author variable
		#if ( ($show_author == "y") || (($show_tooltip == "y") && ($tooltip_date == "y")) ) {
		if ($show_author == "y") {
			$database->setQuery("SELECT a.name"
			."\n  FROM #__users AS a"
			."\n  LEFT JOIN #__content AS b ON a.id=b.created_by"
			."\n  WHERE a.id=".$row->created_by);
			$author = $database->loadResult();
		}
		// Will check to see if item uses a created by alias, if it does, it loads this into the $author variable
		// however, if the item only has a created by value, it converts the user id number of the author to their name and loads this into the $author variable
		if ($show_author_alias == "y") {
			$countcreated_by_alias = strlen($row->created_by_alias);
			if ($countcreated_by_alias == 0) {
				$database->setQuery("SELECT a.name"
				."\n  FROM #__users AS a"
				."\n  LEFT JOIN #__content AS b ON a.id=b.created_by"
				."\n  WHERE a.id=".$row->created_by);
				$author = $database->loadResult();
			} else {
				$author = $row->created_by_alias;
			}
		}
 */
		//---------------------------------------------------------------------

		/** BK  ---------------------------------------------------------------------*/
		// Converts the user id number of the author to their name and loads this into the $author variable
		#if ( ($show_author == "y") || (($show_tooltip == "y") && ($tooltip_date == "y")) ) {
		if ($use_format == "y" || $show_author == "y") {
			$database->setQuery("SELECT a.name"
			."\n  FROM #__users AS a"
			."\n  LEFT JOIN #__content AS b ON a.id=b.created_by"
			."\n  WHERE a.id=".$row->created_by);
			$author = $database->loadResult();
		}
		// Will check to see if item uses a created by alias, if it does, it loads this into the $author variable
		// however, if the item only has a created by value, it converts the user id number of the author to their name and loads this into the $author variable
		if ( $show_author_alias == "y") { #BK
			$countcreated_by_alias = strlen($row->created_by_alias);
			if ($countcreated_by_alias == 0) {
				$database->setQuery("SELECT a.name"
				."\n  FROM #__users AS a"
				."\n  LEFT JOIN #__content AS b ON a.id=b.created_by"
				."\n  WHERE a.id=".$row->created_by);
				$author = $database->loadResult();
			} else {
				$author = $row->created_by_alias;
			}
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Start of Module Display	for each News Item
		echo "\n \t";
		echo "<div class='".$css_prefix."dn-each'>";// Div that surrounds each News entry

		/**---------------------------------------------------------------------**/
		// Code for displaying of individual items Section

		$section_out = $category_out = $date_out = $author_out = $title_out = $intro_out = $fulltext_out = $readmore_out = "";

		if ($use_format == "y" || $show_section == "y") {
			$section_out .= "\n \t\t";
			$section_out .=  "<span class='".$css_prefix."dn-section'>";
			if ($link_section == "y") {
				if ($section->published == "1") {
					$section_out .=  "\n \t\t\t";
					$section_out .=  "<a href='".sefRelToAbs("index.php?option=com_content&task=section&id=$section->id".$_Itemid."")."' class='".$css_prefix."dn-section' title='".$text_hover_section.$section->name."'>".$section->name."</a>";
				} else {
					$section_out .=  "\n \t\t\t";
					$section_out .=  $section->name;
				}
			} else {
				$section_out .=  "\n \t\t\t";
				$section_out .=  $section->name;
			}
			$section_out .=  "\n \t\t";
			$section_out .=  "</span>";
			# echo $section_out;
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Code for displaying of individual items Category
		if ($use_format == "y" || $show_category == "y") {
			$category_out .= "\n \t\t";
			$category_out .= "<span class='".$css_prefix."dn-category'>";
			if ($link_section == "y") {
				if ($category->published == "1") {
					$category_out .= "\n \t\t\t";
					$category_out .= "<a href='".sefRelToAbs("index.php?option=com_content&task=category&sectionid=$section->id&id=$category->id".$_Itemid."")."' class='".$css_prefix."dn-category' title='".$text_hover_category.$category->name."'>".$category->name."</a>";
				} else {
					$category_out .= "\n \t\t\t";
					$category_out .= $category->name;
				}
			} else {
				$category_out .= "\n \t\t\t";
				$category_out .= $category->name;
			}
			$category_out .= "\n \t\t";
			$category_out .= "</span>";
			# echo $category_out;
		} 	//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Code for displaying of individual items Date
		if ( $use_format == "y" || (($show_date == "y") || (($show_leading == "y") && ($set_leading_count > "0") && ($show_leading_date == "y"))) ) {
			$date_out .= "\n \t\t";
			$date_out .= "<span class='".$css_prefix."dn-date'>";
			$date_out .= "\n \t\t\t";
			$date_out .= $create_date;
			$date_out .= "\n \t\t";
			$date_out .= "</span>";
			# echo $date_out;
			if ( $use_format == "n" ) {
				$date_out .= "<br/>";
			}
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Code for displaying of individual items Author
		if ($use_format == "y" || ($show_author == "y") || ($show_author_alias == "y"))  {
			$author_out .= "\n \t\t";
			$author_out .= "<span class='".$css_prefix."dn-author'>";
			$author_out .= "\n \t\t\t";
			$author_out .= $author;
			$author_out .= "\n \t\t";
			$author_out .= "</span>";
			# echo $author_out;
			if ( $use_format == "n" ) {
				$author_out .= "<br/>";
			}
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Code for displaying of individual items Title
		if ($use_format == "y" || $show_title == "y") {
			$row->title = dnReplace( $row->title );
			if ($filter_title == "y") {
				$row->title = dn_filter( $row->title );
			}
			if ($limit_title == "y" ) {
				dn_limit( $row->title, $length_chars_title, $length_words_title );
				$title = $row->title;
			} else if ($show_title_nextline == "y" ) {
				$length = strlen($row->title);
				if ($length > $length_chars_title) {
					$titlefirstline = strtok($row->title, " ");
					$length = strlen($titlefirstline);
					while ($length < $length_chars_title) {
						$titlefirstline .= " ";
						$titlefirstline .= strtok(" ");
						$length = strlen($titlefirstline);
					}
					$lengthfull = strlen($row->title);
					$titlesecondline = substr($row->title, $length, $lengthfull);
					$title = $titlefirstline."<br />".$titlesecondline;
				} else {
					$title = $row->title;
				}
			} else {
				$title = $row->title;
			}
			//  HTML for outputing of Title
			$title_out .= "\n \t\t";
			$title_out .= "<span class='".$css_prefix."dn-title'>";
			$title_out .= "\n \t\t\t";
			if ($show_arrow == "y") { 	$title_out .= "<li class='".$css_prefix."arrow-dn'>";	}
			if ($show_list== "y") { 	$title_out .= "<li class='".$css_prefix."list-dn'>";	}
			if ($link_title == "y") {
				$title_out .= "<a href='".sefRelToAbs("index.php?option=com_content&amp;task=view&amp;id=$row->id".$_Itemid."")."' class='".$css_prefix."dn-title' title='".$text_hover_title.$row->title."'>".$title."</a>";
			} else {
				$title_out .= $title;
			}
			if (($show_arrow == "y") || ($show_list == "y")) { 	$title_out .= "</li>";	}
			$title_out .= "\n \t\t";
			$title_out .= "</span>";
			if ( $use_format == "n" ) {
				$title_out .= "<br/>";
			}
			# echo $title_out;
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Code for displaying of individual items Intro Text
		if (($use_format == "y") || (($show_intro == "y") || (($show_leading == "y") && ($set_leading_count > "0"))) ) {
			$row->introtext = dnReplace($row->introtext);
		    if ($filter_intro == "y") {
				$row->introtext = dn_filter( $row->introtext );
			}
			if ( ($limit_intro == "y") || (($show_leading == "y") && ($limit_leading == "y")) ) {
				dn_limit( $row->introtext, $length_chars_intro, $length_words_intro );
				$introtext = $row->introtext;
			} else {
				$introtext = $row->introtext;
			}

			//  HTML for outputing of Intro Text
			$intro_out .= "\n \t\t";
			$intro_out .= "<span class='".$css_prefix."dn-introtext'>";
			if ($link_intro == "y") {
				$intro_out .= "\n \t\t";
				$intro_out .= "<a href='".sefRelToAbs("index.php?option=com_content&amp;task=view&amp;id=$row->id".$_Itemid."")."' class='".$css_prefix."dn-introtext-link' title='".$text_hover_title.$row->title."'>";
			}
			$intro_out .= "\n \t\t\t";
			$intro_out .= $introtext;
			if ($link_intro == "y") {
				$intro_out .= "\n \t\t";
				$intro_out .= "</a>";
			}
			$intro_out .= "\n \t\t";
			$intro_out .= "</span>";
			# echo $intro_out;
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Code for displaying of individual items Full Tet
		if ($use_format == "y" || $show_full == "y") {
			$row->fulltext = dnReplace($row->fulltext);
			// Code that cleans Full Text of html code
			if ($filter_full == "y") {
				$row->fulltext = dn_filter( $row->fulltext );
			}
			if ($limit_full == "y" ) {
				dn_limit( $row->fulltext, $length_chars_full, $length_words_full );
				$fulltext = $row->fulltext;
			 } else {
				$fulltext = $row->fulltext;
			 }
			// HTML for outputing of Full Text
			$fulltext_out .= "\n \t\t";
			$fulltext_out .= "<span class='".$css_prefix."dn-fulltext'>";
			$fulltext_out .= "\n \t\t\t";
			$fulltext_out .= $fulltext;
			$fulltext_out .= "\n \t\t";
			$fulltext_out .= "</span>";
			# echo $fulltext_out;
		}
		//---------------------------------------------------------------------

		/**---------------------------------------------------------------------**/
		// Code for displaying of individual items Read More link
        if (($show_readmore == "y") || (($show_readmore == "auto") && ( strlen( trim( $row->fulltext ) ) && (trim( $row->fulltext ) != "<br />")) ) /* || (($show_leading == "y") && ($set_leading_count > "0") && ($show_leading_readmore == "y"))*/) {
			$readmore_out .= "<span class='".$css_prefix."dn-read_more'>";
			$readmore_out .= "\n \t\t\t";
			$readmore_out .= "<a href='".sefRelToAbs("index.php?option=com_content&amp;task=view&amp;id=$row->id".$_Itemid."")."' class='".$css_prefix."dn-read_more' title='".$text_hover_readmore.$row->title."'>".$text_readmore."</a>";
			$readmore_out .= "\n \t\t";
			$readmore_out .= "</span>";
			# echo $readmore_out;
		}
		//---------------------------------------------------------------------

		if ( $use_format == "n" ) {
			echo $section_out.$category_out.$title_out.$date_out.$author_out.$intro_out.$fulltext_out.$readmore_out;
		} else {
			$out = "";
			$pf =0;
			for ( $i=0; $i < strlen( $format); $i += 1 ) {
				if ( $format[$i] == "%" ) {
					$pf = 1;
				} else {
					if ( $pf==1 ) {
						$pf = 0;
						switch ( $format[$i] ) {
						case "s":
							echo $section_out;
							break;
						case "c":
							echo $category_out;
							break;
						case "d":
							echo $date_out;
							break;
						case "t":
							echo $title_out;
							break;
						case "a":
							echo $author_out;
							break;
						case "i":
							echo $intro_out;
							break;
						case "f":
							echo $fulltext_out;
							break;
						case "%":
							echo "%";
							break;
						default:
						} // switch
					} else {
						echo $format[$i];
					} // if ( pf
				} // if ( $format[i] == "%" )
				// echo $format[$i].$pf;
				echo $out;
			} // for
			echo $out;

			echo $readmore_out; // read more is not element of format, but should be printed at the end of each content entry
		} //if

		echo "\n \t";
		echo "</div>";

		//  variable for tracking whether to display a leading article
		$set_leading_count--;

	}

	// End of Loop //
	/************************************************************************************************************************************/

	/**---------------------------------------------------------------------**/
	if ($scroll == 'y') {
		?>
			</marquee>
	<?php
	}
	//---------------------------------------------------------------------

	echo "\n";
	if ($show_arrow == "y") { 	echo "</ul>";	}
	if ($show_list == "y") { 	echo "</ol>";	}

//	/**---------------------------------------------------------------------**/
//	//  Convert Section or Category Name to Section or Category ID, which will be used by show_more parameters
//	if ($set_section_id <> NULL) {
//		$set_section_id_extra = dn_name_id( $set_section_id_extra, $set_section_id );
//	}
//
//	if ($set_category_id <> NULL) {
//		$set_category_id_extra = dn_name_id( $set_category_id_extra, $set_category_id );
//	}
	//---------------------------------------------------------------------

	// Error check if more than one Sectionid entered (searches for , in parameter)
	if ( strchr($set_section_id_extra, ",") ) {
		$set_section_id_extra = "";
	}
	// Error check if more than one Categoryid entered (searches for , in parameter)
	if ( strchr($set_category_id_extra, ",") ) {
		$set_category_id_extra = "";
	}

//	if (($show_more_section == "y") && (($set_section_id_extra <> NULL) || ($set_section_id <> NULL)) ) {
//		$more_section = new mosSection( $database );
//		$more_section->load( $set_section_id_extra );
//		echo "\n \t";
//		echo "<div class='".$css_prefix."dn-more'>";
//		echo "\n \t\t";
//		echo "<a href=".sefRelToAbs("index.php?option=com_content&task=section&id=".$more_section->id."".$_Itemid."")."  class='".$css_prefix."dn-more' title='".$text_hover_more_section.$more_section->name."'>".$text_more."</a>";
//		echo "\n \t";
//		echo "</div>";
//	} 	//---------------------------------------------------------------------

//	/**---------------------------------------------------------------------**/
//	if ( ($show_more_category == "y") && (($set_category_id_extra <> NULL) || ($set_category_id <> NULL)) ) {
//		$more_category = new mosCategory( $database );
//		$more_category->load( $set_category_id_extra );
//		echo "\n \t";
//		echo "<div class='".$css_prefix."dn-more'>";
//		echo "\n \t\t";
//		echo "<a href=".sefRelToAbs("index.php?option=com_content&task=category&sectionid=".$more_category->section."&id=".$more_category->id."".$_Itemid."")."  class='".$css_prefix."dn-more' title='".$text_hover_more_category.$more_category->name."'>".$text_more."</a>";
//		echo "\n \t";
//		echo "</div>";
//	}
	//---------------------------------------------------------------------

	/**---------------------------------------------------------------------**/
	if ($show_more_auto == "y") {
		if  (($set_section_id_extra <> NULL) && ($set_category_id_extra == NULL))  {
			$more_section = new mosSection( $database );
			$more_section->load( $set_section_id_extra );
			echo "\n \t";
			echo "<div class='".$css_prefix."dn-more'>";
			echo "\n \t\t";
			echo "<a href='".sefRelToAbs("index.php?option=com_content&task=section&id=$more_section->id".$_Itemid."")."' class='".$css_prefix."dn-more' title='".$text_hover_more_section.$more_section->name."'>".$text_more."</a>";
			echo "\n \t";
			echo "</div>";
		} else if (($set_category_id_extra <> NULL) && ($set_section_id_extra == NULL)) {
			$more_category = new mosCategory( $database );
			$more_category->load( $set_category_id_extra );
			echo "\n \t";
			echo "<div class='".$css_prefix."dn-more'>";
			echo "\n \t\t";
			echo "<a href='".sefRelToAbs("index.php?option=com_content&task=category&sectionid=$more_category->section&id=$more_category->id".$_Itemid."")."' class='".$css_prefix."dn-more' title='".$text_hover_more_category.$more_category->name."'>".$text_more."</a>";
			echo "\n \t";
			echo "</div>";
		}
	}
	//---------------------------------------------------------------------

	echo "\n </div>";
	//---------------------------------------------------------------------

	/**---------------------------------------------------------------------**/
	//
	if ( ($text_module_link_text <> NULL) && ($text_module_link_url <> NULL) ){
		echo "\n";
		echo "<div class='".$css_prefix."dn-module_link'>";
		echo "\n <a href='".$text_module_link_url."' class='".$css_prefix."dn-module_link' title='".$text_module_link_text."'>";
		echo $text_module_link_text;
		echo "\n </a>";
		echo "\n";
		echo "</div>";
	}
	//---------------------------------------------------------------------

	echo "\n <!-- END   module '".$version."'   --> \n\n\n";
	//---------------------------------------------------------------------

/************************************************************************************************************************************/

} else {
	if ( $notfound_message == "y" ) {
		echo "\n <br />";
		echo "\n$query";
		echo "\n The parameters you have activated";
		echo "\n <br />";
		echo "\n do not correspond with any content items.";
		echo "\n <br />";
		echo "\n Please reconfigure your parameters";
		echo "\n";
	}
}


?>
