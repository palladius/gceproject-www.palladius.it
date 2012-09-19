<?php
/**
* AkoAutumnFog - A Mambo 4.5 template
* @version 2.0
* @package AkoAutumnFog
* @copyright (C) 2003, 2004 by Arthur Konze - All rights reserved!
* @license http://www.konze.de/content/view/8/26/ Copyrighted Commercial Software
*/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
$iso = split( '=', _ISO );
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <?php if ( $my->id ) initEditor(); ?>
    <meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
    <?php mosShowHead(); ?>
    <link rel="shortcut icon" href="<?php echo $mosConfig_live_site;?>/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/templates/akoautumnfog/css/template_css.css" />
  </head>

<body>
<a name="top" id="top"></a>

<table height="100%" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="42" bgcolor="#F0F0F0" height="43" background="templates/akoautumnfog/images/border_left_back.png"><img border="0" src="templates/akoautumnfog/images/shading_top_left.png" width="42" height="43"></td>
    <td width="716" height="43" bgcolor="#E0E0E0" background="templates/akoautumnfog/images/shading_top_middle.jpg">
    <font class="pathwaytext">&nbsp;&nbsp;<?php include $GLOBALS['mosConfig_absolute_path'] . '/pathway.php'; ?></font>
    </td>
    <td bgcolor="#F0F0F0" height="43" style="background-repeat:repeat-x;" background="templates/akoautumnfog/images/border_top_back.png"><img border="0" src="templates/akoautumnfog/images/shading_top_right.png" width="42" height="43"></td>
  </tr>
  <tr>
    <td width="42" bgcolor="#F0F0F0" height="120" background="templates/akoautumnfog/images/border_left_back.png"><img border="0" src="templates/akoautumnfog/images/shading_left.png" width="42" height="120"></td>
    <td width="716" bgcolor="#A0C0D0" height="120" background="templates/akoautumnfog/images/logo_back.jpg" align="left" valign="top">
    <font class="maintitletext"><?php echo $mosConfig_sitename; ?></font>
    </td>
    <td bgcolor="#F0F0F0" height="120" style="background-repeat:repeat-y;" background="templates/akoautumnfog/images/border_right_back.png"><img border="0" src="templates/akoautumnfog/images/shading_right.jpg" width="42" height="120"></td>
  </tr>
  <tr>
    <td width="42" bgcolor="#F0F0F0" height="42" background="templates/akoautumnfog/images/border_left_back.png"><img border="0" src="templates/akoautumnfog/images/shading_bottom_left.png" width="42" height="42"></td>
    <td width="716" bgcolor="#E0E0E0" height="42" background="templates/akoautumnfog/images/shading_bottom_middle.jpg">&nbsp;</td>
    <td bgcolor="#F0F0F0" height="42" style="background-repeat:repeat-x;" background="templates/akoautumnfog/images/border_bottom_back.png"><img border="0" src="templates/akoautumnfog/images/shading_bottom_right.jpg" width="42" height="42"></td>
  </tr>
  <tr>
    <td width="42" bgcolor="#F0F0F0" background="templates/akoautumnfog/images/border_left_back.png">&nbsp;</td>
    <td width="716" bgcolor="#E0E0E0" valign="top">
    <table border="0" cellpadding="5" cellspacing="0" width="100%">
      <tr>
        <td width="150" valign="top" style="border-right:1px dotted #ccc">
          <?php mosLoadModules ( "left" ); ?>
        </td>
        <td valign="top">
          <?php
            if (mosCountModules('top')>0) mosLoadModules('top','true');
            mosMainBody();
          ?>
        </td>
      </tr>
    </table>
    <hr />
    <?php include_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/footer.php' ); ?>
    </td>
    <td bgcolor="#F0F0F0" style="background-repeat:repeat-y;" background="templates/akoautumnfog/images/border_right_back.png">&nbsp;</td>
  </tr>
</table>

</body>
</html>