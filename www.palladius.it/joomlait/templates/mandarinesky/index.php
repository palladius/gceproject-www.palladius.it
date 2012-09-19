<?php
/**
* MandarineSky - A Mambo 4.5.1 template
* @version 1.0
* @package MandarineSky
* @copyright (C) 2004 by PixelBunyiP.com - This template is released under the GNU/GPL License
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
</head>

<body>

<div align="center">
	<table border="0" width="780" cellspacing="0" cellpadding="0" id="table8">
		<tr>
			<td>
			<img border="0" src="templates/mandarinesky/images/butterflies.png" width="780" height="120"></td>
		</tr>
	</table>
</div>
<div align="center">
	<table border="0" width="780" cellspacing="0" cellpadding="0" id="table4" background="templates/mandarinesky/images/menu.gif" height="58">
		<tr>
			<td><img hspace="4" src="<?php echo $mosConfig_live_site;?>/images/M_images/arrow.png" border="0" alt="arrow" /><?php include $GLOBALS['mosConfig_absolute_path'] . '/pathway.php'; ?></td>
		</tr>
	</table>
</div>
<div align="center">
	<table border="0" width="780" cellspacing="0" cellpadding="0" height="400" id="table1" background="templates/mandarinesky/images/bkgr.gif">
		<tr>
			<td valign="top" width="180">&nbsp;<div align="center">
				<table border="0" width="90%" cellspacing="0" cellpadding="10" id="table2">
					<tr>
						<td valign="top"><?php mosLoadModules ( "left" ); ?>
						</td>
					</tr>
				</table>
			</div>
			<p>&nbsp;</td>
			<td valign="top">&nbsp;<div align="center">
				<table border="0" width="95%" cellspacing="0" cellpadding="10" id="table5">
					<tr>
						<td>
							<?php mosMainBody(); ?></td>
					</tr>
				</table>
			</div>
			<p>&nbsp;</td>
			<?php
          if (mosCountModules('right')>0) {
            ?>
            <td width="150" valign="top">
            
              <br>
              <?php mosLoadModules ( "right" ); ?>
            </td>
            <?php
          }
        ?></td>

		</tr>
	</table>
</div>

<div align="center">
	<table border="0" width="780" cellpadding="0" bgcolor="#FF9D5B" id="table7" height="30" cellspacing="0">
		<tr>
			<td align="center"><font size="1" face="Arial">
			<a target="_blank" href="http://www.pixelbunyip.com">
			<font color="#CC0000">Templage design by PixelBunyiP</font></a></font><br>
			<?php include_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/footer.php' ); ?></td>
		</tr>
	</table>
</div>

<p>
&nbsp;</p>

</body>

</html>