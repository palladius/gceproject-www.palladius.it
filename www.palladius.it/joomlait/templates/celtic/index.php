<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// needed to seperate the ISO number from the language file constant _ISO
$iso = split( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
if ( $my->id ) {
        initEditor();
}
?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<?php mosShowHead(); ?>
<link rel="shortcut icon" href="<?php echo $mosConfig_live_site;?>/images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/templates/celtic/css/template_css.css" />
</head>
<body>

<br>



<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/hg1.jpg" height="60" width="100%">
<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/titel.jpg" height="60" width="468">
<font class=title><?php echo $mosConfig_sitename; ?></font></td><td valign="center" align="right"><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/blind.gif" width="100%" height=60 border="0" align=left> <br>
<?php mosLoadModules('user4');?></td><td align="right"><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/hg2.jpg" width="101" height="60" border="0"></td></tr></table>
</td></tr></table>
<br>
<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/blind.gif" width="5" border="0"></td><td valign="top" width="120">

<table cellpadding="0" cellspacing="0" border="0"><tr>
<td border=0><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/rund_1.gif" width="26" height="26" border="0"></td><td border=0><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ecke_o_l.gif" width="23" height="26" border="0"></td><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/back_o.gif" height="26" width="100%"><div align="center"><b>Navigation</b></div></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ecke_o_r.gif" width="23" height="26" border="0"></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/rund_2.gif" width="26" height="26" border="0"></td></tr>
<tr>
<td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_oben.gif" width="26" height="23" border="0"></td><td colspan="3">
</td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_oben.gif" width="26" height="23" border="0"></td></tr>

<tr><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/back_vert.gif" width="26"></td><td colspan=3><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/blind.gif" width="100" height="1" border="0"><br>
<?php mosLoadModules('left'); ?></td><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/back_vert.gif" width="26"></td></tr>

<tr><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_unten.gif" width="26" height="23" border="0"></td><td colspan="3"></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_unten.gif" width="26" height="23" border="0"></td></tr>

<tr><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/rund_3.gif" width="26" height="26" border="0"></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_links.gif" width="23" height="26" border="0"></td><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/back_horz.gif" height="26">&nbsp;</td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_rechts.gif" width="23" height="26" border="0"></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/rund_4.gif" width="26" height="26" border="0"></td></tr>
</table>

</td><td valign="top">

<table cellpadding=0 cellspacing=0>
<tr width=100%>
<td border=0><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/rund_1.gif" width="26" height="26" border="0"></td><td border=0><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ecke_o_l.gif" width="23" height="26" border="0"></td><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/back_o.gif" height="26" width=75%><b><?php include "pathway.php";?></b></td><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/back_o.gif" height="26" width=25%><?php echo (strftime ("%d %B %Y", time()+($mosConfig_offset*60*60))); ?></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ecke_o_r.gif" width="23" height="26" border="0"></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/rund_2.gif" width="26" height="26" border="0"></td></tr></table>

<table cellpadding=5><tr><td valign="top">
<?php include_once("mainbody.php"); ?></td></tr></table>

</td><td valign="top" width="120">

 <?php if ( mosCountModules( 'right' ) > 0 ) { ?>
<table cellpadding="0" cellspacing="0" border="0"><tr>
<td border=0><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/rund_1.gif" width="26" height="26" border="0"></td><td border=0><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ecke_o_l.gif" width="23" height="26" border="0"></td><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/back_o.gif" height="26" width="100%"><div align="center"><b>Features</b></div></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ecke_o_r.gif" width="23" height="26" border="0"></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/rund_2.gif" width="26" height="26" border="0"></td></tr>
<tr>
<td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_oben.gif" width="26" height="23" border="0"></td><td colspan="3">
</td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_oben.gif" width="26" height="23" border="0"></td></tr>

<tr><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/back_vert.gif" width="26"></td><td colspan=3><?php  mosLoadModules('right'); ?></td><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/back_vert.gif" width="26"></td></tr>

<tr><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_unten.gif" width="26" height="23" border="0"></td><td colspan="3"></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_unten.gif" width="26" height="23" border="0"></td></tr>

<tr><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/rund_3.gif" width="26" height="26" border="0"></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_links.gif" width="23" height="26" border="0"></td><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/back_horz.gif" height="26">&nbsp;</td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/ende_rechts.gif" width="23" height="26" border="0"></td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/rund_4.gif" width="26" height="26" border="0"></td></tr>
</table><?php } ?>

</td><td><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/blind.gif" width="5" border="0"></td></tr></table>
<br>
<table cellpadding="1" cellspacing="0" width=100% align=center><tr><td background="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/hg1.jpg" height="60" width="100%" align=center><img src="<?php echo $mosConfig_live_site; ?>/templates/celtic/images/blind.gif" width="100%" height=1 border="0"><?php include_once("./includes/footer.php");?></td></tr></table>

<br>

<?php mosLoadModules( 'debug', -1 );?>
</body>
</html>