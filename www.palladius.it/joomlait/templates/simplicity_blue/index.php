<?php echo "<?xml version=\"1.0\"?>";
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
/**
* YourTemplatesName -  Simplicity templates Series for Mambo 4.5.1 template
* @version 1.1
* @package simplicity
* @copyright (C) 2004 by peekmambo.com 
* @license GPL License
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
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['mosConfig_live_site']; ?>/templates/<?php echo $cur_template; ?>/css/template_css.css" />
<link rel="shortcut icon" href="<?php echo $GLOBALS['mosConfig_live_site']; ?>/images/favicon.ico"/>
<?php 
          /*  ###TEMPLATE CONFIGURATION###  */

$x_footer = "1"  ; 	  /* show mambocopyright footer 1=on, 0=off */
$x_width = "100%"  ;   /* use "770"  for fixed width or "100%" for full width */

?>
<body><div align="center"><div style="width:<?php echo $x_width; ?>;">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="260"><img src="templates/<?php echo $cur_template; ?>/images/header_logo.png" width="260" height="102" /></td>
    <td valign="bottom" background="templates/<?php echo $cur_template; ?>/images/header_bg.png"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr><td valign="top" height="20px"><div align="right"  class="small"><?php echo mosCurrentDate(); ?></div></td></tr>
    <tr>
      <td height="50"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="75%" height="40">&nbsp;</td>
            <td width="5%" valign="top"><img src="templates/<?php echo $cur_template; ?>/images/mag_glass.png" width="32" height="26" align="top" /></td>
            <td width="20%" valign="middle">
	        <form action='<?php echo sefRelToAbs("index.php"); ?>' method='post'>
            <input class="inputbox" type="text" name="searchword"  size="20" value="<?php echo _SEARCH_BOX; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';" />
            <input type="hidden" name="option" value="search" />
       		</form>			</td>
          </tr>
        </table></td>
    </tr>
    <tr>
<td align="right"><?php mosLoadModules ( 'user3' ); ?>
</td>
</tr>
         </table></td>
    <td width="22"><img src="templates/<?php echo $cur_template; ?>/images/header_right_corner.png" width="22" height="102" /></td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="21">&nbsp;</td>
	<td align="left"><img src="templates/<?php echo $cur_template; ?>/images/read.png" width="14" height="13" /><?php mosPathWay(); ?></td>
	<td width="250"><div align="right" style="font:Arial, Helvetica, sans-serif; font-size:9px; color: #bbbbbb; ">template designed by <a href="http://www.peekmambo.com" target="_blank">peekmambo.com</a></div></td>
	<td width="21">&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr><?php if (mosCountModules( "user1" )) { ?>
    <td width="50%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="templates/<?php echo $cur_template; ?>/images/left_box_1.png" width="19" height="10" /></td>
        <td background="templates/<?php echo $cur_template; ?>/images/left_box_2.png"></td>
        <td width="21"><img src="templates/<?php echo $cur_template; ?>/images/left_box_3.png" width="21" height="10" /></td>
      </tr>
      <tr>
        <td background="templates/<?php echo $cur_template; ?>/images/left_box_4.png"></td>
        <td valign="top" background="templates/<?php echo $cur_template; ?>/images/left_box_5.png"><?php mosLoadModules ( 'user1' ); ?></td>
        <td background="templates/<?php echo $cur_template; ?>/images/left_box_6.png"></td>
      </tr>
      <tr>
        <td width="19" height="10"><img src="templates/<?php echo $cur_template; ?>/images/left_box_7.png" width="19" height="10" /></td>
        <td background="templates/<?php echo $cur_template; ?>/images/left_box_8.png"></td>
        <td><img src="templates/<?php echo $cur_template; ?>/images/left_box_9.png" width="21" height="10" /></td>
      </tr>
    </table></td><?php } ?><?php if (mosCountModules( "user2" )) { ?>
    <td width="50%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="22" height="10"><img src="templates/<?php echo $cur_template; ?>/images/right_box_1.png" width="22" height="10" /></td>
        <td background="templates/<?php echo $cur_template; ?>/images/right_box_2.png"></td>
        <td width="20" height="10"><img src="templates/<?php echo $cur_template; ?>/images/right_box_3.png" width="20" height="10" /></td>
      </tr>
      <tr>
        <td background="templates/<?php echo $cur_template; ?>/images/right_box_4.png"></td>
        <td valign="top" background="templates/<?php echo $cur_template; ?>/images/right_box_5.png"><?php mosLoadModules ( 'user2' ); ?></td>
        <td background="templates/<?php echo $cur_template; ?>/images/right_box_6.png"></td>
      </tr>
      <tr>
        <td width="22" height="10"><img src="templates/<?php echo $cur_template; ?>/images/right_box_7.png" width="22" height="10" /></td>
        <td background="templates/<?php echo $cur_template; ?>/images/right_box_8.png"></td>
        <td><img src="templates/<?php echo $cur_template; ?>/images/right_box_9.png" width="20" height="10" /></td>
      </tr>
    </table></td><?php } ?>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="8" cellpadding="0">
  <tr>
    <td><table width="100%"  border="0" cellspacing="10" cellpadding="0">
      <tr valign="top">
        <?php if (mosCountModules( "left" )) { ?><td width="160"><?php mosLoadModules ( 'left' ); ?></td><?php } ?>
        <td><div align="center"><?php mosLoadModules( 'banner', -1 ); ?></div><?php mosMainBody(); ?></td>
        <?php if (mosCountModules( "right" )) { ?><td width="160"><?php mosLoadModules ( 'right' ); ?></td><?php } ?>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="8" cellpadding="0">
  <tr>
    <td height="1" background="templates/<?php echo $cur_template; ?>/images/horizontal_dots.png"></td>
  </tr>
  <tr>
    <td align="center"><?php mosLoadModules ( 'bottom' ); ?><br><?php if ($x_footer==1) {include_once "includes/footer.php";} ?><br><div align="center" style="font-size:9px; color:white ">Get The Best Free Mambo Templates at www.peekmambo.com</div></td>
  </tr>
</table>
</div>
</div>
</body>
</html>
