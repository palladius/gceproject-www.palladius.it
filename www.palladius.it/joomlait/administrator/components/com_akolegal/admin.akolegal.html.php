<?php
/**
* AkoLegal - A Mambo Disclaimer Component
* @version 2.0
* @package AkoLegal
* @copyright (C) 2003, 2004 by Arthur Konze - All rights reserved!
* @license http://www.konze.de/content/view/8/26/ Copyrighted Commercial Software
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
class HTML_legal {
  function showAbout() {
  ?>
      <table cellpadding="4" cellspacing="0" border="0" width="100%">
      <tr>
        <td width="100%">
          <img src="components/com_akolegal/images/logo.png">
        </td>
      </tr>
      <tr>
        <td>
          <p><b>Program</b><br>
          AkoLegal is the first tool for Mambo, which lets you handle legal information about
          your website service. It provides you with the possibility to show and imprint and
          comes with ready to run 'Terms of Use' and 'Privacy Policy'. At last it also lets
          you edit the standard MOS footer. If you have any wishes or have found a bug, please
          contact the author by mail: <a href="mailto:webmaster@mamboportal.com">
          webmaster@mamboportal.com</a></p>
          <p><b>Author</b><br>
          Arthur Konze is one of the early eighties home computer hackers. He started with
          assembler coding on homecomputers like the Apple 2 and the Commodore C16. A few
          years later he get in touch with modem based computer networks like fido. He
          started with Internet in 1989 and concentrated on webdesign after the boom years.
          Currently he is the publisher of Mamboportal.com, which is one of the biggest
          Mambo communities worldwide.</p>
          <p><b>Warranty</b><br>
          This program is distributed in the hope that it will be useful, but WITHOUT ANY
          WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
          PARTICULAR PURPOSE.<P>
        </td>
      </tr>
      </table>
  <?php
    }

  function showFile($file, $option, $useeditor) {
    $file = stripslashes($file);
    $f=fopen($file,"r");
    $content = fread($f, filesize($file));
    $content = htmlspecialchars($content);
    ?>
    <form action="index2.php?" method="post" name="adminForm" class="adminForm" id="adminForm">
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
      <tr>
        <td width="100%">
          <img src="components/com_akolegal/images/logo.png">
        </td>
      </tr>
    </table>
    <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
       <tr>
         <th colspan="4">Path: <?php echo $file; ?></td> </tr>
       <tr>
         <td>
           <textarea cols="80" rows="20" name="filecontent"><?php echo $content; ?></textarea>
         </td>
       </tr>
       <tr>
         <td class="error">Please note: The file must be writable to save your changes.</td>
       </tr>
    </table>
    <input type="hidden" name="file" value="<?php echo $file; ?>" />
    <input type="hidden" name="option" value="<?php echo $option; ?>">
    <input type="hidden" name="task" value="">
    <input type="hidden" name="boxchecked" value="0">
    </form>
    <?php
  }

}
?>