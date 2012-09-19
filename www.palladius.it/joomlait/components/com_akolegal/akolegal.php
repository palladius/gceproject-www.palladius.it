<?php
/**
* AkoLegal - A Mambo Disclaimer Component
* @version 2.0
* @package AkoLegal
* @copyright (C) 2003, 2004 by Arthur Konze - All rights reserved!
* @license http://www.konze.de/content/view/8/26/ Copyrighted Commercial Software
**/

# Don't allow direct linking
  defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
  $akoversion = "V2.0";
  require($mosConfig_absolute_path."/administrator/components/com_akolegal/config.akolegal.php");

# Get the right language if it exists
  if (file_exists($mosConfig_absolute_path.'/components/com_akolegal/languages/'.$mosConfig_lang.'.php')) {
    include($mosConfig_absolute_path.'/components/com_akolegal/languages/'.$mosConfig_lang.'.php');
  } else {
    include($mosConfig_absolute_path.'/components/com_akolegal/languages/english.php');
  }

# Start with the header
  echo "<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='2' BORDER='0' class='contentpaneopen'>";
  echo "<TR><TD>";

# Main switch for certain pages
  switch ($func) {
    #########################################################################################
    case 'privacy':
      $mainframe->appendPathWay(_PPTOPTEXT);
      echo "<p class='componentheading'>"._PPTOPTEXT."</p>\n"
          ."<p><strong>"._PPTITLEINTRO."</strong><br />"._PPTEXTINTRO."</p>\n"
          ."<p><strong>"._PPTITLE1."</strong><br />"._PPTEXT1."</p>\n"
          ."<p><strong>"._PPTITLE2."</strong><br />"._PPTEXT2."</p>\n"
          ."<p><strong>"._PPTITLE3."</strong><br />"._PPTEXT3."</p>\n"
          ."<p><strong>"._PPTITLE4."</strong><br />"._PPTEXT4."</p>\n"
          ."<p><strong>"._PPTITLE5."</strong><br />"._PPTEXT5."</p>\n"
          ."<p><strong>"._PPTITLE6."</strong><br />"._PPTEXT6."</p>\n"
          ."<p><strong>"._PPTITLE7."</strong><br />"._PPTEXT7."</p>\n"
          ."<p><strong>"._PPTITLE8."</strong><br />"._PPTEXT8."</p>\n";
      break;
    #########################################################################################
    case 'terms':
      $mainframe->appendPathWay(_TOUTOPTEXT);
      echo "<p class='componentheading'>"._TOUTOPTEXT."</p>\n"
          ."<p><strong>"._TOUTITLE1."</strong><br />"._TOUTEXT1."</p>\n"
          ."<p><strong>"._TOUTITLE2."</strong><br />"._TOUTEXT2."</p>\n"
          ."<p><strong>"._TOUTITLE3."</strong><br />"._TOUTEXT3."</p>\n"
          ."<p><strong>"._TOUTITLE4."</strong><br />"._TOUTEXT4."</p>\n"
          ."<p><strong>"._TOUTITLE5."</strong><br />"._TOUTEXT5."</p>\n"
          ."<p><strong>"._TOUTITLE6."</strong><br />"._TOUTEXT6."</p>\n"
          ."<p>"._TOUTEXT6MORE."</p>\n"
          ."<p><strong>"._TOUTITLE7."</strong><br />"._TOUTEXT7."</p>\n"
          ."<p><strong>"._TOUTITLE8."</strong><br />"._TOUTEXT8."</p>\n"
          ."<p><strong>"._TOUTITLE9."</strong><br />"._TOUTEXT9."</p>\n"
          ."<p><strong>"._TOUTITLE10."</strong><br />"._TOUTEXT10."</p>\n"
          ."<p>"._TOUTEXT10MORE."</p>\n"
          ."<p>"._TOUTEXT10MORE1."</p>\n"
          ."<p><strong>"._TOUTITLE11."</strong><br />"._TOUTEXT11."</p>\n"
          ."<p>"._TOUTEXT11MORE."</p>\n"
          ."<p><strong>"._TOUTITLE12."</strong><br />"._TOUTEXT12."</p>\n"
          ."<p><strong>"._TOUTITLE13."</strong><br />"._TOUTEXT13."</p>\n"
          ."<p><strong>"._TOUTITLE14."</strong><br />"._TOUTEXT14."</p>\n"
          ."<p><strong>"._TOUTITLE15."</strong><br />"._TOUTEXT15."</p>\n";
      break;
    #########################################################################################
    default:
      $database->setQuery("SELECT name from #__menu WHERE id='$Itemid'");
      $menuname = $database->loadResult();
      echo "<p class='componentheading'>$menuname</p>";

      # Company Informations
      echo "<img src='$mosConfig_live_site/components/com_akolegal/images/home.png' hspace='10' border='0'><strong>"._ALCOMPANY_INFO."</strong><hr>";
      echo "<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='2' BORDER='0'>";
      echo "<tr><td width='50%' valign='top'>";
      if ($al_company_name) echo $al_company_name."<br />";
      if ($al_personal_name) echo $al_personal_name."<br />";
      if ($al_address01) echo $al_address01."<br />";
      if ($al_address02) echo $al_address02."<br />";
      if ($al_address03) echo $al_address03."<br />";
      if ($al_country) echo $al_country."<br />";
      echo "</td><td width='50%' valign='top'>";
      if ($al_phone) echo _ALPHO." $al_phone<br />";
      if ($al_fax)   echo _ALFAX." $al_fax<br />";
      if ($al_mobil) echo _ALMOB." $al_mobil<br />";
      if ($al_url) {
        if (substr($al_url,0,7)!="http://") $al_url="http://$al_url";
        echo _ALURL." <a href='$al_url' target='_blank'>$al_url</a><br />";
      }
      if ($al_email) echo _ALEMA." <a href='mailto:$al_email'>$al_email</a><br />";
      echo "</table><p />";

      # Bank Informations
      if ($al_bankaccount OR $al_bankname OR $al_bankcode OR $al_bankiban OR $al_bankswift) {
        echo "<img src='$mosConfig_live_site/components/com_akolegal/images/bank.png' hspace='10' border='0'><strong>"._ALBANK_INFO."</strong><hr>";
        echo "<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='2' BORDER='0'>";
        echo "<tr><td width='50%' valign='top'>";
        if ($al_bankaccount) echo _ALBANACC." ".$al_bankaccount."<br />";
        if ($al_bankname)    echo _ALBANNAM." ".$al_bankname."<br />";
        if ($al_bankcode)    echo _ALBANCOD." ".$al_bankcode."<br />";
        echo "</td><td width='50%' valign='top'>";
        if ($al_bankiban)    echo _ALBANIBA." ".$al_bankiban."<br />";
        if ($al_bankswift)   echo _ALBANBIC." ".$al_bankswift."<br />";
        echo "</table><p />";
      }

      # Legal Informations
      if ($al_contentname OR $al_contentemail OR $al_techname OR $al_techemail OR $al_compnumber OR $al_taxnumber) {
        echo "<img src='$mosConfig_live_site/components/com_akolegal/images/note.png' hspace='10' border='0'><strong>"._ALLEGAL_NOTES."</strong><hr>";
        echo "<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='2' BORDER='0'>";
        echo "<tr><td width='50%' valign='top'>";
        if ($al_contentname)  echo _ALCONNAM."<br />".$al_contentname."<br />";
        if ($al_contentemail) echo "<a href='mailto:$al_contentemail'>$al_contentemail</a>";
        echo "<p />";
        if ($al_techname)     echo _ALTECNAM."<br />".$al_techname."<br />";
        if ($al_techemail)    echo "<a href='mailto:$al_techemail'>$al_techemail</a>";
        echo "</td><td width='50%' valign='top'>";
        if ($al_compnumber)   echo _ALCOMNUM." ".$al_compnumber."<br />";
        if ($al_taxnumber)    echo _ALTAXNUM." ".$al_taxnumber."<br />";
        echo "</table><p />";
      }

      # Further Informations
      echo "<img src='$mosConfig_live_site/components/com_akolegal/images/star.png' hspace='10' border='0'><strong>"._ALFURTHER_INFO."</strong><hr>";
      echo "<ul>";
      echo "<li><a href='index.php?option=com_akolegal&Itemid=$Itemid&func=terms'>"._TOUTOPTEXT."</a></li>";
      echo "<li><a href='index.php?option=com_akolegal&Itemid=$Itemid&func=privacy'>"._PPTOPTEXT."</a></li>";
      echo "</ul><p />";
      break;
  }

  # STOP! THE REMOVAL OF THE POWERED BY LINE IS NOT ALLOWED.
  # IF YOU WANT TO REMOVE IT, CONTACT ME AT www.konze.de FOR DETAILS!
  echo "</TD></TR></TABLE><center><span class='small'>Powered by <a href='http://www.konze.de/' target='_blank'>AkoLegal $akoversion</a></span></center>";
?>