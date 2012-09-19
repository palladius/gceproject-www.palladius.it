<?
/**
* AkoLegal - A Mambo Disclaimer Component
* @version 2.0
* @package AkoLegal
* @copyright (C) 2003, 2004 by Arthur Konze - All rights reserved!
* @license http://www.konze.de/content/view/8/26/ Copyrighted Commercial Software
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once( $mainframe->getPath( 'admin_html' ) );

switch ($task) {
  case "config":
    showConfig( $option );
    break;

  case "savesettings":
    saveConfig ($option, $al_company_name, $al_personal_name, $al_address01, $al_address02, $al_address03, $al_country, $al_phone, $al_fax, $al_mobil, $al_url, $al_email, $al_bankaccount, $al_bankname, $al_bankcode, $al_bankiban, $al_bankswift, $al_compnumber, $al_taxnumber, $al_contentname, $al_contentemail, $al_techname, $al_techemail);
    break;

  case "about":
    showAbout();
    break;

  case "language":
    showFile($option, 'language');
    break;

  case "footer":
    showFile($option, 'footer');
    break;

  case "savefile":
    saveFile($file, $filecontent, $option);
    break;

  default:
    showConfig( $option );
    break;
}
echo "<p><font class='small'>&copy; Copyright 2003, 2004 by <a href='http://www.konze.de/' target='_blank'>Arthur Konze</a><br />Version: 2.0</font></p>";

############################################################################
############################################################################

function showConfig( $option ) {
  global $mosConfig_absolute_path;
  require($mosConfig_absolute_path."/administrator/components/com_akolegal/config.akolegal.php");
?>
    <script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
      var form = document.adminForm;
      if (pressbutton == 'cancel') {
        submitform( pressbutton );
        return;
      }
      submitform( pressbutton );
    }
    </script>

  <form action="index2.php" method="post" name="adminForm" id="adminForm">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
  <tr>
    <td width="100%" class="sectionname">
      <img src="components/com_akolegal/images/logo.png">
    </td>
  </tr>
  </table>
  <?php
  $akogbtabs = new mosTabs( 0 );
  $akogbtabs->startPane( "ako_guestbook" );
    $akogbtabs->startTab("Address","Address-page");
    ?>
    <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Company name:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_company_name" value="<? echo "$al_company_name"; ?>"></td>
        <td align="left" valign="top">Name of your company.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Personal name:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_personal_name" value="<? echo "$al_personal_name"; ?>"></td>
        <td align="left" valign="top">Your personal name.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Address line 1:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_address01" value="<? echo "$al_address01"; ?>"></td>
        <td align="left" valign="top">Your address with street, town or state.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Address line 2:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_address02" value="<? echo "$al_address02"; ?>"></td>
        <td align="left" valign="top">Your address with street, town or state.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Address line 3:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_address03" value="<? echo "$al_address03"; ?>"></td>
        <td align="left" valign="top">Your address with street, town or state.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Country name:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_country" value="<? echo "$al_country"; ?>"></td>
        <td align="left" valign="top">The country you are located in.</td>
      </tr>
    </table>
    <?php
    $akogbtabs->endTab();
    $akogbtabs->startTab("Contact","Contact-page");
    ?>
    <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Telephone number:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_phone" value="<? echo "$al_phone"; ?>"></td>
        <td align="left" valign="top">Number of your telephone.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Telefax number:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_fax" value="<? echo "$al_fax"; ?>"></td>
        <td align="left" valign="top">Number of your fax.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Mobile number:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_mobil" value="<? echo "$al_mobil"; ?>"></td>
        <td align="left" valign="top">Number of your mobile phone.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Website URL:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_url" value="<? echo "$al_url"; ?>"></td>
        <td align="left" valign="top">Your companies website.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Email address:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_email" value="<? echo "$al_email"; ?>"></td>
        <td align="left" valign="top">Your companies email address.</td>
      </tr>
    </table>
    <?php
    $akogbtabs->endTab();
    $akogbtabs->startTab("Bank","Bank-page");
    ?>
    <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Account Number:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_bankaccount" value="<? echo "$al_bankaccount"; ?>"></td>
        <td align="left" valign="top">The number of your bank account.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Bank name:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_bankname" value="<? echo "$al_bankname"; ?>"></td>
        <td align="left" valign="top">The name of your bank.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Bank code:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_bankcode" value="<? echo "$al_bankcode"; ?>"></td>
        <td align="left" valign="top">Your bank code number.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>IBAN number:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_bankiban" value="<? echo "$al_bankiban"; ?>"></td>
        <td align="left" valign="top">Your international bank account number (IBAN).</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>SWIFT-BIC number:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_bankswift" value="<? echo "$al_bankswift"; ?>"></td>
        <td align="left" valign="top">Your bank identifier code (SWIFT-BIC).</td>
      </tr>
    </table>
    <?php
    $akogbtabs->endTab();
    $akogbtabs->startTab("Legal","Legal-page");
    ?>
    <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Company number:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_compnumber" value="<? echo "$al_compnumber"; ?>"></td>
        <td align="left" valign="top">Your company identification number.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Tax number:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_taxnumber" value="<? echo "$al_taxnumber"; ?>"></td>
        <td align="left" valign="top">Your companies tax number.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Content responsibilty:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_contentname" value="<? echo "$al_contentname"; ?>"></td>
        <td align="left" valign="top">Person, who is responsible for the websites content.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Content email:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_contentemail" value="<? echo "$al_contentemail"; ?>"></td>
        <td align="left" valign="top">Email address of the above person.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Technical responsibilty:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_techname" value="<? echo "$al_techname"; ?>"></td>
        <td align="left" valign="top">Person, who is responsible for the websites technology.</td>
      </tr>
      <tr align="center" valign="middle">
        <td align="left" valign="top"><strong>Technical email:</strong></td>
        <td align="left" valign="top"><input type="text" name="al_techemail" value="<? echo "$al_techemail"; ?>"></td>
        <td align="left" valign="top">Email address of the above person.</td>
      </tr>
    </table>
    <?php
    $akogbtabs->endTab();
  $akogbtabs->endPane();
  ?>
  <input type="hidden" name="id" value="">
  <input type="hidden" name="task" value="">
  <input type="hidden" name="option" value="<?php echo $option; ?>">
</form>
<?php
}

############################################################################

function saveConfig ($option, $al_company_name, $al_personal_name, $al_address01, $al_address02, $al_address03, $al_country, $al_phone, $al_fax, $al_mobil, $al_url, $al_email, $al_bankaccount, $al_bankname, $al_bankcode, $al_bankiban, $al_bankswift, $al_compnumber, $al_taxnumber, $al_contentname, $al_contentemail, $al_techname, $al_techemail) {
  $configfile = "components/com_akolegal/config.akolegal.php";
  @chmod ($configfile, 0766);
  $permission = is_writable($configfile);
  if (!$permission) {
    mosRedirect("index2.php?option=$option&task=config", "Config file not writeable!");
    break;
  }

  $config = "<?php\n";
  $config .= "\$al_company_name = \"$al_company_name\";\n";
  $config .= "\$al_personal_name = \"$al_personal_name\";\n";
  $config .= "\$al_address01 = \"$al_address01\";\n";
  $config .= "\$al_address02 = \"$al_address02\";\n";
  $config .= "\$al_address03 = \"$al_address03\";\n";
  $config .= "\$al_country = \"$al_country\";\n";
  $config .= "\$al_phone = \"$al_phone\";\n";
  $config .= "\$al_fax = \"$al_fax\";\n";
  $config .= "\$al_mobil = \"$al_mobil\";\n";
  $config .= "\$al_url = \"$al_url\";\n";
  $config .= "\$al_email = \"$al_email\";\n";
  $config .= "\$al_bankaccount = \"$al_bankaccount\";\n";
  $config .= "\$al_bankname = \"$al_bankname\";\n";
  $config .= "\$al_bankcode = \"$al_bankcode\";\n";
  $config .= "\$al_bankiban = \"$al_bankiban\";\n";
  $config .= "\$al_bankswift = \"$al_bankswift\";\n";
  $config .= "\$al_compnumber = \"$al_compnumber\";\n";
  $config .= "\$al_taxnumber = \"$al_taxnumber\";\n";
  $config .= "\$al_contentname = \"$al_contentname\";\n";
  $config .= "\$al_contentemail = \"$al_contentemail\";\n";
  $config .= "\$al_techname = \"$al_techname\";\n";
  $config .= "\$al_techemail = \"$al_techemail\";\n";
  $config .= "?>";

  if ($fp = fopen("$configfile", "w")) {
    fputs($fp, $config, strlen($config));
    fclose ($fp);
  }
  mosRedirect("index2.php?option=$option&task=config", "Settings saved");
}

############################################################################

function showAbout() {
  HTML_legal::showAbout();
}

############################################################################

function showFile($option, $ftype) {
  global $mosConfig_absolute_path, $mosConfig_lang;
  # Which file should be changed
  switch ($ftype) {
    case "footer":
      $useeditor = true;
      $file = $mosConfig_absolute_path.'/includes/footer.php';
      break;
    default:
      $useeditor = false;
      if (file_exists($mosConfig_absolute_path.'/components/com_akolegal/languages/'.$mosConfig_lang.'.php')) {
        $file = $mosConfig_absolute_path.'/components/com_akolegal/languages/'.$mosConfig_lang.'.php';
      } else {
        $file = $mosConfig_absolute_path.'/components/com_akolegal/languages/english.php';
      }
      break;
  }
  # Check for file rights
  @chmod ($file, 0766);
  $permission = is_writable($file);
  if (!$permission) {
    echo "<center><h1><font color=red>Warning...</FONT></h1><BR>";
    echo "<B>You need to chmod the file to 766 in order for the footer to be updated</B></center><BR><BR>";
  }
  HTML_legal::showFile($file,$option,$useeditor);
}

############################################################################

function saveFile($file, $filecontent, $option) {
  @chmod ($file, 0766);
  $permission = is_writable($file);
  if (!$permission) {
    mosRedirect("index2.php?option=$option", "File not writeable!");
    break;
  }
  if ($fp = fopen( $file, "w")) {
    fputs($fp,stripslashes($filecontent));
    fclose($fp);
    mosRedirect( "index2.php?option=$option", "File has been saved." );
  }
}

?>